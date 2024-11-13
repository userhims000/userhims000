<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\TreatmentCollection;
use Rokit\Controllers\Collections\SpecialistCollection;

class Specialist extends PostDetail {

    protected static $postType = 'specialist';

    var $_thumbnail;

    var $_fullname;

    var $_first_name;

    var $_last_name;

    var $_gender;

    var $_job_function;

    var $_big_number;

    var $_avatar;

    var $_general;

    var $_message;

    var $_cta;

    var $_treatment_ids;

    var $_treatments;

    var $_treatment_types;

    var $_locations;

    var $_related;

    var $_replacable_vars;

    var $_fallback;

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail = $this->get_field( static::$postType . '_thumbnail');
        }

        return $this->_thumbnail;
    }

    public function fullname(){
        if( ! $this->_fullname ) {
            $this->_fullname = sprintf('%s %s', $this->first_name(), $this->last_name());
        }

        return $this->_fullname;
    }

    public function first_name(){
        if( ! $this->_first_name ) {
            $this->_first_name = $this->get_field( static::$postType . '_first_name');
        }

        return $this->_first_name;
    }

    public function last_name(){
        if( ! $this->_last_name ) {
            $this->_last_name = $this->get_field( static::$postType . '_last_name');
        }

        return $this->_last_name;
    }

    public function gender(){
        if( ! $this->_gender ) {
            $this->_gender = $this->get_field( static::$postType . '_gender');
        }

        return $this->_gender;
    }

    public function job_function(){
        if( ! $this->_job_function ) {
            $this->_job_function = $this->get_field( static::$postType . '_function');
        }

        return $this->_job_function;
    }


    public function big_number(){
        if( ! $this->_big_number ) {
            $this->_big_number = [
                'prefix' => $this->get_field( static::$postType . '_prefix_big_number'),
                'number' => $this->get_field( static::$postType . '_big_number')
            ];
        }

        return $this->_big_number;
    }

    public function avatar(){
        if( ! $this->_avatar ) {
            $this->_avatar = $this->get_field( static::$postType . '_avatar');
        }

        return $this->_avatar;
    }

    public function general(){
        if( ! $this->_general ) {
            $this->_general = [
                'name'          => [
                    'fullname'      => $this->fullname(),
                    'first'         => $this->first_name(),
                    'last'          => $this->last_name()
                ],
                'function'      => $this->job_function(),
                'big_number'    => $this->big_number(),
                'avatar'        => $this->avatar(),
                'media'          => $this->media()
            ];
        }

        return $this->_general;
    }

    public function message(){
        if( ! $this->_message ) {
            if(empty($this->get_field( static::$postType . '_message_show'))){ return false; }
            $today = date('U');
            $messageDateBegin = date('U', strtotime($this->get_field( static::$postType . '_message_start_date')));
            $messageDateEnd = date('U', strtotime($this->get_field( static::$postType . '_message_end_date')));

            if (($today >= $messageDateBegin) && ($today <= $messageDateEnd)){
                $this->_message = [
                    'titles'    => $this->get_field( static::$postType . '_message_titles')
                ];
            }
        }

        return $this->_message;
    }

    public function cta(){
        if( ! $this->_cta ) {

            $cta = $this->get_field( static::$postType . '_cta_overwrite', 'option') ? $this->get_field( static::$postType . '_cta') : $this->defaults('cta');

            if(!empty($cta['text'])) {
                $cta['text'] = (new Specialist())->compile($cta['text']);
            }

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public function treatment_ids(){

        if( ! $this->_treatment_ids ) {
            return $this->get_field('specialist_treatment_relation');
        }

        return $this->_treatment_ids;
    }

    public function treatments(){

        if( ! $this->_treatments ) {
            $this->_treatments = TreatmentCollection::organize_by_terms('treatment_type', ['posts_per_page' => -1, 'post__in' => $this->treatment_ids()]);
        }

        return $this->_treatments;
    }

    public function treatment_types(){

        if( ! $this->_treatment_types ) {

            $treatments = $treatment_types = [];
            $treatments = $this->treatments();

            array_walk($treatments, function($object) use (&$treatment_types){
                if(!empty($object['term']) && !empty($object['posts'])){
                    $treatment_types[$object['term']->slug] = $object['term'];
                }
            });

            $this->_treatment_types = $treatment_types;
        }

        return $this->_treatment_types;
    }

    public function locations(){

        if( ! $this->_locations ) {

            $locations = $this->get_field('specialist_location_relation');

            if(!empty($locations)) {

                $args = [
                    'post__in' => $locations,
                    'meta_query'    => [
                        [
                            'title' => [
                                'key'       => 'location_panorama_titles_title',
                                'compare'   => 'EXISTS',
                            ],
                        ]
                    ],
                    'orderby' => [
                        'title'    => 'ASC',
                    ]
                ];

                $this->_locations = LocationCollection::query($args);

            }

        }

        return $this->_locations;
    }

    public function related(){

        if( ! $this->_related ) {

            $cta = $this->get_field( static::$postType . '_related_overwrite', 'option') ? $this->get_field( static::$postType . '_related') : $this->defaults('related');

            return [
                'title_tag'         => (new Specialist())->compile($cta['title_tag']),
                'title'         => (new Specialist())->compile($cta['title']),
                'subtitle'      => (new Specialist())->compile($cta['intro']),
                'locations'     => $this->locations(),
                'treatments'    => $this->treatments(),
                'cta'           => $this->cta()
            ];

        }

        return $this->_related;
    }

    public function replacable_vars() {
        if( ! $this->_replacable_vars ) {
            $this->_replacable_vars = [
                'specialist'        => $this->first_name(),
                'phone'             => get_field('contact_online_phone', 'option'),
                'genderNotitation'  => ($this->gender() == 'man') ? pll__("hij") : pll__("zij")
            ];
        }

        return $this->_replacable_vars;

    }

    public function search_title() {
        if(!$this->_search_title) {
            $this->_search_title = $this->fullname();
        }

        return $this->_search_title;
    }

    public static function fallback($treatment_type) {

        if(!empty($treatment_slug = $treatment_type['term']->slug()) && $treatment_type['term']->count > 0) {
            $specialist_url = sprintf('%s/%s/%s/%s', rtrim(pll_home_url(), '/'), pll__('over-ons/specialisten'), pll__('soort'), $treatment_slug);
        } else {
            $specialist_url = SpecialistCollection::url();
        }

        if(empty($fallback_text = get_field('specialist_detail_fallback', 'option'))) {
            $fallback_text = pll__('{{specialist}} verzorgt dit type behandeling op dit moment niet. Op zoek naar een behandelaar?');
        }

        return [
            'text' => (new Specialist())->compile($fallback_text),
            'button' => [
                'label' => pll__('Bekijk specialisten'),
                'url' => $specialist_url
            ]
        ];

    }

}
