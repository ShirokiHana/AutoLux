<?php

namespace lib;

class Validate {
    public static function email( string $email ) : bool {
        return filter_var( trim( $email ), FILTER_VALIDATE_EMAIL ) !== false;
    }

    // rejects HTML special characters
    public static function text( string $text ) : bool {
        return $text === strip_tags( $text ) && $text === htmlspecialchars( $text, ENT_QUOTES );
    }

    // Letters (any language), spaces, apostrophes and hyphens, e.g. "Mary-Jane O'Neil"
    public static function name( string $name ) : bool {
        return preg_match( "/^\p{L}+(?:[ '\-]\p{L}+)*$/u", trim( $name ) ) === 1;
    }

    // Optional leading +, then 7-15 digits (spaces, dots, dashes and brackets allowed)
    public static function phone( string $phone ) : bool {
        $clean = preg_replace( '/[\s.\-()]/', '', $phone );
        return preg_match( '/^\+?\d{7,15}$/', $clean ) === 1;
    }

    // Trims, collapses repeated whitespace, strips tags and capitalizes each word
    public static function sanitize( string $input ) : string {
        $input = strip_tags( $input );
        $input = preg_replace( '/\s+/u', ' ', trim( $input ) );
        return mb_convert_case( $input, MB_CASE_TITLE, 'UTF-8' );
    }
}