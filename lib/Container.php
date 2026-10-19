<?php

namespace lib;

final class Container {
    public function __construct( private $obj ) {}

    public static function of( $obj ) {
        return new self( $obj );
    }
}