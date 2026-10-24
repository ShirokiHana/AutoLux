<?php
    namespace middleware;

    use core\Database;
    use core\payment\PaymentMethod;
    use core\SessionHelper;
    use core\PartHelper;
    use DateTime;
    use lib\FnArray;
    use lib\Validate;

    // TODO: Major cleanup, separate concerns, too much duplication

    function intInRange( mixed $value, int $min, int $max ) : int | false {
        return filter_var( $value, FILTER_VALIDATE_INT, [ 'options' => [ 'min_range' => $min, 'max_range' => $max ] ] );
    }

    function sanitizeClient( array $request, string $redirect = 'order/new' ) : array {

        $name = Validate::sanitize( $request[ 'new-client-name' ] ?? '' );
        $email = strtolower( trim( $request[ 'new-client-email' ] ?? '' ) );
        $phone = trim( $request[ 'new-client-phone' ] ?? '' );

        $errors = array_filter( [
            'new-client-name' => Validate::name( $name ) ? null : 'Enter a valid name.',
            'new-client-email' => Validate::email( $email ) ? null : 'Enter a valid e-mail.',
            'new-client-phone' => Validate::phone( $phone ) ? null : 'Enter a valid phone number.',
        ] );

        //--------SEPARATE TODO: carefully test
        if ( !isset( $errors[ 'new-client-email' ] ) ) {
            $taken = Database::fetch(
                'Single',
                'SELECT 1 FROM clients WHERE email = :email AND client_id <> :id',
                [ 'email' => $email, 'id' => $request[ 'id' ] ?? 0 ]
            );
            if ( $taken )
                $errors[ 'new-client-email' ] = 'This e-mail is already registered.';
        }
        //--------SEPARATE

        if ( !empty( $errors ) ) {
            // error warning for HTML labels
            SessionHelper::flashInit( 'errors', $errors );
            // reset on new $request
            SessionHelper::flashInit( 'old', [ 'new-client-name' => $name, 'new-client-email' => $email, 'new-client-phone' => $phone ] );
            postRedirectGet( $redirect );
        }

        return [
            ...$request,
            'new-client-name' => $name,
            'new-client-email' => $email,
            'new-client-phone' => preg_replace( '/[\s.\-()]/', '', $phone ),
        ];
    }

    function sanitizeClientEdit( array $request ) : array {
        return sanitizeClient( $request, "admin/clients/{$request[ 'id' ]}" );
    }

    function sanitizeSearch( array $request ) : array {

        $filter = $request[ 'inventory-filter' ] ?? 'brand';
        $search = Validate::sanitize( $request[ 'input-search' ] ?? '' );
        $search = $search === '' ? null : $search; // safe 'query all'
        $range = intInRange( $request[ 'inventory-filter-range' ] ?? 300, 0, 300 );

        $page = intInRange( $request[ 'page' ] ?? 1, 1, PHP_INT_MAX );

        $limit = intInRange( $request[ 'view-limit' ] ?? 12, 1, PHP_INT_MAX ) ?: 12;

        $validFilter = PartHelper::isOptionColumn( $filter );
        $match = $search !== null && $validFilter
            ? PartHelper::match( $filter, $search )
            : null;

        $errors = array_filter( [
            'inventory-filter' => $validFilter ? null : 'Pick a valid filter.',
            'input-search' => $search === null || !$validFilter || $match !== null
                ? null
                : formatStringLabel( $filter ) . ' not available.',
            'inventory-filter-range' => $range !== false
                ? null
                : 'Invalid price range.',
            'page' => $page !== false ?
                null :
                'Invalid page.',
        ] );

        if ( !empty( $errors ) ) {
            SessionHelper::flashInit( 'errors', $errors );
            SessionHelper::flashInit( 'old', [ ...$request, 'input-search' => $search ?? '' ] );
            postRedirectGet( 'inventory' );
        }

        return [
            ...$request,
            'inventory-filter' => $filter,
            'input-search' => $match,
            'inventory-filter-range' => $range,
            'page' => $page,
            'view-limit' => $limit,
        ];
    }

    function sanitizeRestock( array $request ) : array {
        $items = array_map(
            fn( array $item ) => [
                'part_id' => intInRange( $item[ 'part_id' ] ?? null, 1, PHP_INT_MAX ),
                'quantity' => intInRange( $item[ 'quantity' ] ?? null, 1, 1000 ),
            ],
            array_values( SessionHelper::get( 'restockCart' ) )
        );

        $invalid = array_filter(
            $items,
            fn( array $item ) => $item[ 'part_id' ] === false
                || $item[ 'quantity' ] === false
        );

        if ( $items === [] || $invalid !== [] ) {
            SessionHelper::flashInit( 'errors', [
                'quantity' => 'Add at least one valid part to restock.',
            ] );
            postRedirectGet(
                'management/order/cart?supplier_id=' . $request[ 'supplier_id' ]
            );
        }

        return [ ...$request, 'restock' => $items ];
    }

    function sanitizePayment( array $request ) : array {
        $id = $request[ 'method-id' ] ?? null;

        $class = PaymentMethod::output( (string) $id );

        if ( $class === null ) {
            SessionHelper::flashInit( 'errors', [ 'payment' => 'Select a valid payment method.' ] );
            postRedirectGet( 'order/payment' );
        }

        $values = FnArray::removeKey( $request, 'method-id' );

        if ( !$class->validateForm( $values ) ) {
            SessionHelper::flashInit( 'errors', [ 'payment' => 'Invalid payment details.' ] );
            postRedirectGet( 'order/payment?payment_method=' . urlencode( $class->getPaymentName() ) );
        }

        return [
            ...FnArray::removeKey( $request, 'payment-method' ),
            'method-id' => ( int ) $id,
            'method-name' => $class->getPaymentName(),
        ];
    }

    function sanitizeOrderFilter( array $request ) : array {
        $validDate = function ( string $value ) : bool {
            $date = DateTime::createFromFormat( 'Y-m-d', $value );
            return $date !== false && $date->format( 'Y-m-d' ) === $value;
        };
        //--------Order filters
        // Select
        $client = $request[ 'client-id' ] ?? '';
        $clientId = $client === ''
            ? null
            : intInRange( $client, 1, PHP_INT_MAX );
        // Time frame
        $from = $request[ 'date-from' ] ?? '';
        $to = $request[ 'date-to' ] ?? '';
        //--------Pagination -- Technical debt, separate
        $page = intInRange( $request[ 'page' ] ?? 1, 1, PHP_INT_MAX );
        $limit = intInRange( $request[ 'view-limit' ] ?? 12, 1, 100 ) ?: 12;
        $index = strtoupper( substr( ( string ) ( $request[ 'index' ] ?? '' ), 0, 1 ) );
        //--------List comprehension, prepare error flashes
        $errors = array_filter( [
            'client-id' => $clientId === false ? 'Pick a valid client.' : null,
            'date-from' => $from !== '' && !$validDate( $from ) ? 'Invalid start date.' : null,
            'date-to' => $to !== '' && !$validDate( $to ) ? 'Invalid end date.' : null,
            'page' => $page === false ? 'Invalid page.' : null,
        ] );

        if ( !$errors && $from !== '' && $to !== '' && $from > $to )
            $errors[ 'date-to' ] = 'End date must not be before the start date.';
        //--------Flash errors
        if ( $errors ) {
            SessionHelper::flashInit( 'errors', $errors );
            //--Retain data
            SessionHelper::flashInit( 'old', [ 'date-from' => $from, 'date-to' => $to ] );
            postRedirectGet( 'admin' );
        }

        return [
            ...$request,
            'client-id' => $clientId,
            'date-from' => $from ?: null,
            'date-to' => $to ?: null,
            'index' => ctype_alpha( $index ) ? $index : null,
            'page' => $page,
            'view-limit' => $limit,
        ];
    }

    function sanitizeClientFilter( array $request ) : array {
        $page = intInRange( $request[ 'page' ] ?? 1, 1, PHP_INT_MAX );
        $limit = intInRange( $request[ 'view-limit' ] ?? 12, 1, 100 ) ?: 12;
        $index = strtoupper( substr( ( string ) ( $request[ 'index' ] ?? '' ), 0, 1 ) );

        if ( $index !== '' && !ctype_alpha( $index ) ) {
            SessionHelper::flashInit( 'errors', [ 'index' => 'Invalid letter.' ] );
            postRedirectGet( 'admin/clients' );
        }
        if ( $page === false ) {
            SessionHelper::flashInit( 'errors', [ 'page' => 'Invalid page.' ] );
            postRedirectGet( 'admin/clients' );
        }

        return [ ...$request, 'page' => $page, 'view-limit' => $limit, 'index' => $index ];
    }

    function sanitizeSupplier( array $request ) : array {
        $rawName = $request[ 'supplier_name' ] ?? '';
        $name = is_string( $rawName ) ? trim( $rawName ) : '';

        if ( $name === '' ) {
            SessionHelper::flashInit( 'errors', [ 'supplier_name' => 'Enter a supplier name.' ] );
            SessionHelper::flashInit( 'old', [ 'supplier_name' => $name ] );
            postRedirectGet( 'admin/suppliers' );
        }

        return [ ...$request, 'supplier_name' => $name ];
    }