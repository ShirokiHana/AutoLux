<?php require_once basePath( 'view/components/header.php' ) ?>

    <h1>New client</h1>
    <form action="/order/new" method="POST">
        <label for="">
            Name
            <input type="text" name="new-client-name" id="">
        </label>
        <br>
        <label for="">
            Phone #
            <input type="text" name="new-client-phone" id="">
        </label>
        <br>
        <label for="">
            E-mail
            <input type="text" name="new-client-email" id="">
        </label>
        <br>
        <input type="submit" value="Add this client!">
    </form>

<?php require_once basePath( 'view/components/footer.php' ) ?>