<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class SpecialistCollection extends PostCollection {

    protected static $postType = 'specialist';

    protected static $postClass = 'Rokit\Controllers\Types\Specialist';

    var $_bottom;

    var $_specialists;

    var $_treatment_type;

    public function bottom() {

        if( ! $this->_bottom ) {
            $this->_bottom =  get_field( static::$postType . '_archive_bottom', 'option');
        }

        return $this->_bottom;

    }

    public function specialists() {

        if( ! $this->_specialists ) {
            $args = [
                'meta_query'    => [
                    [
                        'relation' => 'AND',
                        'first_name' => [
                            'key'       => 'specialist_first_name',
                            'compare'   => 'EXISTS',
                        ],
                        'last_name' => [
                            'key'       => 'specialist_last_name',
                            'compare'   => 'EXISTS',
                        ],
                    ]
                ],
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ];

            $this->_specialists =  self::query($args);
        }

        return $this->_specialists;

    }

    public function treatment_type() {

        if( ! $this->_treatment_type ) {
            $this->_treatment_type = get_query_var('treatment_type');
        }

        return $this->_treatment_type;

    }

    public static function treatment_types() {

        $specialists = $treatment_types = [];
        $specialists = self::query();

        if(!empty($specialists) && is_iterable($specialists)) {

            foreach ($specialists as $specialist) {
                $treatment_types = array_merge($treatment_types,$specialist->treatment_types());
            }

            // Remove duplicates and sort bij term order
            $treatment_types = rokit_array_unique($treatment_types);
            usort($treatment_types, function($a, $b){return strcmp($a->term_order, $b->term_order);});

        }

        return $treatment_types;
    }

    public static function by_treatment_type($treatment_type_id) {

        $args = [
            'meta_query'    => [
                [
                    'relation' => 'AND',
                    'first_name' => [
                        'key'       => 'specialist_first_name',
                        'compare'   => 'EXISTS',
                    ],
                    'last_name' => [
                        'key'       => 'specialist_last_name',
                        'compare'   => 'EXISTS',
                    ],
                ]
            ],
            'orderby' => [
                'first_name'    => 'ASC',
                'last_name'     => 'ASC',
            ]
        ];

        $specialists = self::query($args);

        $specialists = array_filter($specialists, function($specialist) use ($treatment_type_id) {
            return array_key_exists($treatment_type_id,$specialist->treatment_types());
        });
        return $specialists;
    }

    public static function single_default() {

        return [
            'related'   => get_field( static::$postType . '_detail_related_intro', 'option'),
            'cta'       => get_field( static::$postType . '_detail_cta', 'option')
        ];

    }

    public static function filter_url_base($filter_slug) {
        return self::url() . pll__('soort') . '/' . $filter_slug. '/';
    }

    public static function filter() {

        $options = array_map(function($option) {
            $option->link = static::filter_url_base($option->slug);
            return $option;
        }, static::treatment_types());
        $newArray = [];
        foreach($options as $key => $value){
            $newArray[$value->term_order] = $value; 
        }

        ksort($newArray);

        return [
            'all' => [
                'name'   => pll__('Alles'),
                'url'    => self::url(),
                'active' => empty(get_query_var('treatment_type'))
            ],
            'options' => $newArray
        ];
    }

}
