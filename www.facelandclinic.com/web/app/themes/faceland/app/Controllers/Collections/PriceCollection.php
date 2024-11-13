<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class PriceCollection extends PostCollection {

    protected static $postType = 'price';

    protected static $postClass = 'Rokit\Controllers\Types\Price';

    public static function single_default() {

        return [
            'cta' => get_field( static::$postType . '_detail_cta', 'option'),
            'bottom' => [
                'titles'  => [
                    'title' => get_field( static::$postType . '_detail_bottom_intro_title', 'option'),
                    'intro' => get_field( static::$postType . '_detail_bottom_intro_intro', 'option')
                ],
                'button'  =>get_field( static::$postType . '_detail_bottom_button', 'option')
            ]
        ];
    }
}
