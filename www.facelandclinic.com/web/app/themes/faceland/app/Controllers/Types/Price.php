<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\TreatmentCollection;

class Price extends PostDetail {

    protected static $postType = 'price';

    protected static $termClass = 'Rokit\Controllers\Terms\PriceTypeTerm';

    var $_thumbnail;

    var $_below_title_text;

    var $_label;

    var $_lowest_main_prices;
    
    var $_lowest_main_prices_facecard;

    var $_lowest_prices;

    var $_lowest_price_prefix;

    var $_lowest_price_facecard;

    var $_lowest_price_facecard_trainer;

    var $_lowest_price_trainer;

    var $_lowest_price_doctor;

    var $_offer;

    var $_blocks;

    var $_prices;

    var $_talent_prices;

    var $_doctor_prices;

    var $_doctor_plus_prices;

    var $_cta;

    var $_bottom;

    var $_replacable_vars;

    var $_treatment;

    var $_primary_term;

    var $_christmas_price_list;

    public function panorama(){
        if( ! $this->_panorama ) {

            $panorama = parent::panorama();
            $panorama['image'] = $this->thumbnail();

            $this->_panorama = $panorama;
        }

        return $this->_panorama;
    }

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail = $this->get_field(static::$postType . '_panorama_thumbnail');
        }
        return $this->_thumbnail;
    }

    public function label(){
        if( ! $this->_label ) {
            $this->_label = $this->get_field(static::$postType . '_overview_label');
        }
        return $this->_label;
    }

    public function below_title_text(){
        if( ! $this->_below_title_text ) {
            $this->_below_title_text = $this->get_field(static::$postType . '_below_title_text');
        }
        return $this->_below_title_text;
    }

    public function lowest_prices(){

        if( ! $this->_lowest_prices ) {

            $this->_lowest_prices  = [
                'facecard'          => $this->lowest_price_facecard(),
                'trainer'           => $this->lowest_price_trainer(),
                'doctor'            => $this->lowest_price_doctor(),
                'facecard_premium' => $this->lowest_price_facecard_trainer(),
                'main_facecard_premium' => $this->lowest_main_prices_facecard(),
                'main_price' =>  $this->lowest_main_prices(),
                'christmas_price_list' =>  $this->christmas_price_list(),
            ];

        }

        return $this->_lowest_prices;

    }

    public function lowest_main_prices($format=null){

        if( ! $this->_lowest_main_prices ) {
            if(!empty($price = $this->get_field( static::$postType . '_lowest_practitioner'))) {
                $price_url = $this->get_field( static::$postType . '_lowest_practitioner_url');
                $price_external = $this->get_field( static::$postType . '_lowest_practitioner_external');
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_main_prices = [
                    "price_lowest_practitioner" => $price,
                    "price_lowest_practitioner_url" => $price_url,
                    "price_lowest_practitioner_external" => $price_external,
                ];      
            }
        }
        return (array) $this->_lowest_main_prices;

    }

    public function lowest_main_prices_facecard($format=null){

        if( ! $this->_lowest_main_prices_facecard ) {
            if(!empty($price = $this->get_field(static::$postType . '_lowest_practitioner_facecard'))) {
                $price_url = $this->get_field( static::$postType . '_lowest_practitioner_url_facecard');
                $price_external = $this->get_field( static::$postType . '_lowest_practitioner_external_facecard');
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_main_prices_facecard = [
                    "price_lowest_main_price_facecard" => $price,
                    "price_lowest_main_price_facecard_url" => $price_url,
                    "price_lowest_practitioner_external_facecard" => $price_external,
                ];
            }
        }
        return (array) $this->_lowest_main_prices_facecard;

    }

    public function christmas_price_list($format=null){

        if( ! $this->_christmas_price_list ) {
            //if() {

                $christmas_behandelaar_price = $this->get_field('christmas_behandelaar_price'); 
                $christmas_behandelaar_price_discount = $this->get_field('christmas_behandelaar_price_discount');
                $behandelaar_price = $this->get_field('behandelaar_price');
                $behandelaar_price_discount = $this->get_field('behandelaar_price_discount'); 
                $premium_price = $this->get_field('premium_price');
                $premium_price_discount = $this->get_field('premium_price_discount');
                $facecard_price = $this->get_field('facecard_price'); 
                $facecard_price_discount = $this->get_field('facecard_price_discount');
                $huidspecialist_price = $this->get_field('huidspecialist_price');
                $huidspecialist_price_discount = $this->get_field('huidspecialist_price_discount');
                $plastisch_chirurg_price = $this->get_field('plastisch_chirurg_price');
                $plastisch_chirurg_price_discount = $this->get_field('plastisch_chirurg_price_discount');

                $christmas_behandelaar_price_striketrough = $this->get_field('christmas_behandelaar_price_striketrough');
                $christmas_behandelaar_price_discount_striketrough = $this->get_field('christmas_behandelaar_price_discount_striketrough');
                $behandelaar_price_striketrough = $this->get_field('behandelaar_price_striketrough');
                $behandelaar_price_discount_striketrough = $this->get_field('behandelaar_price_discount_striketrough');
                $premium_price_striketrough = $this->get_field('premium_price_striketrough');
                $premium_price_discount_striketrough = $this->get_field('premium_price_discount_striketrough');
                $facecard_price_striketrough = $this->get_field('facecard_price_striketrough');
                $facecard_price_discount_striketrough = $this->get_field('facecard_price_discount_striketrough');


                $christmas_behandelaar_price_url = $this->get_field('christmas_behandelaar_price_url');
                $christmas_behandelaar_price_external = $this->get_field('christmas_behandelaar_price_external');

                $christmas_behandelaar_price_url_discount = $this->get_field('christmas_behandelaar_price_url_discount');
                $christmas_behandelaar_price_external_discount = $this->get_field('christmas_behandelaar_price_external_discount');

                $behandelaar_price_url = $this->get_field('behandelaar_price_url');
                $behandelaar_price_external = $this->get_field('behandelaar_price_external');

                $behandelaar_price_url_discount = $this->get_field('behandelaar_price_url_discount');
                $behandelaar_price_external_discount = $this->get_field('behandelaar_price_external_discount');

                $premium_price_url = $this->get_field('premium_price_url');
                $premium_price_external = $this->get_field('premium_price_external');

                $premium_price_url_discount = $this->get_field('premium_price_url_discount');
                $premium_price_external_discount = $this->get_field('premium_price_external_discount');

                $facecard_price_url = $this->get_field('facecard_price_url');
                $facecard_price_external = $this->get_field('facecard_price_external');

                $facecard_price_url_discount = $this->get_field('facecard_price_url_discount');
                $facecard_price_external_discount = $this->get_field('facecard_price_external_discount');

                $huidspecialist_price_url = $this->get_field('huidspecialist_price_url');
                $huidspecialist_price_external = $this->get_field('huidspecialist_price_external');

                $huidspecialist_price_url_discount = $this->get_field('huidspecialist_price_url_discount');
                $huidspecialist_price_external_discount = $this->get_field('huidspecialist_price_external_discount');

                $plastisch_chirurg_price_url = $this->get_field('plastisch_chirurg_price_url');
                $plastisch_chirurg_price_external = $this->get_field('plastisch_chirurg_price_external');

                $plastisch_chirurg_price_url_discount = $this->get_field('plastisch_chirurg_price_url_discount');
                $plastisch_chirurg_price_external_discount = $this->get_field('plastisch_chirurg_price_external_discount');

                if(is_numeric($christmas_behandelaar_price)){
                    $christmas_behandelaar_price = rokit_format_money($christmas_behandelaar_price, $format);
                }else{
                    $christmas_behandelaar_price;
                }

                if(is_numeric($christmas_behandelaar_price_discount)){
                    $christmas_behandelaar_price_discount = rokit_format_money($christmas_behandelaar_price_discount, $format);
                }else{
                    $christmas_behandelaar_price_discount;
                }

                if(is_numeric($behandelaar_price)){
                    $behandelaar_price = rokit_format_money($behandelaar_price, $format);
                }else{
                    $behandelaar_price;
                }

                if(is_numeric($behandelaar_price_discount)){
                    $behandelaar_price_discount = rokit_format_money($behandelaar_price_discount, $format);
                }else{
                    $behandelaar_price_discount;
                }

                if(is_numeric($premium_price)){
                    $premium_price = rokit_format_money($premium_price, $format);
                }else{
                    $premium_price;
                }

                if(is_numeric($premium_price_discount)){
                    $premium_price_discount = rokit_format_money($premium_price_discount, $format);
                }else{
                    $premium_price_discount;
                }

                if(is_numeric($facecard_price)){
                    $facecard_price = rokit_format_money($facecard_price, $format);
                }else{
                    $facecard_price;
                }

                if(is_numeric($facecard_price_discount)){
                    $facecard_price_discount = rokit_format_money($facecard_price_discount, $format);
                }else{
                    $facecard_price_discount;
                }

                if(is_numeric($huidspecialist_price)){
                    $huidspecialist_price = rokit_format_money($huidspecialist_price, $format);
                }else{
                    $huidspecialist_price;
                }

                if(is_numeric($huidspecialist_price_discount)){
                    $huidspecialist_price_discount = rokit_format_money($huidspecialist_price_discount, $format);
                }else{
                    $huidspecialist_price_discount;
                }

                if(is_numeric($plastisch_chirurg_price)){
                    $plastisch_chirurg_price = rokit_format_money($plastisch_chirurg_price, $format);
                }else{
                    $plastisch_chirurg_price;
                }

                if(is_numeric($plastisch_chirurg_price_discount)){
                    $plastisch_chirurg_price_discount = rokit_format_money($plastisch_chirurg_price_discount, $format);
                }else{
                    $plastisch_chirurg_price_discount;
                }


                $this->_christmas_price_list = [
                    "christmas_behandelaar_price" => $christmas_behandelaar_price,
                    "christmas_behandelaar_price_url" => $christmas_behandelaar_price_url,
                    "christmas_behandelaar_price_external" => $christmas_behandelaar_price_external,
                    "christmas_behandelaar_price_discount" => $christmas_behandelaar_price_discount,
                    "christmas_behandelaar_price_url_discount" => $christmas_behandelaar_price_url_discount,
                    "christmas_behandelaar_price_external_discount" => $christmas_behandelaar_price_external_discount,
                    "christmas_behandelaar_price_striketrough" => $christmas_behandelaar_price_striketrough,
                    "christmas_behandelaar_price_discount_striketrough" => $christmas_behandelaar_price_discount_striketrough,
                    "behandelaar_price" => $behandelaar_price,
                    "behandelaar_price_url" => $behandelaar_price_url,
                    "behandelaar_price_external" => $behandelaar_price_external,
                    "behandelaar_price_discount" => $behandelaar_price_discount,
                    "behandelaar_price_url_discount" => $behandelaar_price_url_discount,
                    "behandelaar_price_external_discount" => $behandelaar_price_external_discount,
                    "behandelaar_price_striketrough" => $behandelaar_price_striketrough,
                    "behandelaar_price_discount_striketrough" => $behandelaar_price_discount_striketrough,
                    "premium_price" => $premium_price,
                    "premium_price_url" => $premium_price_url,
                    "premium_price_external" => $premium_price_external,
                    "premium_price_discount" => $premium_price_discount,
                    "premium_price_url_discount" => $premium_price_url_discount,
                    "premium_price_external_discount" => $premium_price_external_discount,
                    "premium_price_striketrough" => $premium_price_striketrough,
                    "premium_price_discount_striketrough" => $premium_price_discount_striketrough,
                    "facecard_price" => $facecard_price,
                    "facecard_price_url" => $facecard_price_url,
                    "facecard_price_external" => $facecard_price_external,
                    "facecard_price_discount" => $facecard_price_discount,
                    "facecard_price_url_discount" => $facecard_price_url_discount,
                    "facecard_price_external_discount" => $facecard_price_external_discount,
                    "facecard_price_striketrough" => $facecard_price_striketrough,
                    "facecard_price_discount_striketrough" => $facecard_price_discount_striketrough,
                    "huidspecialist_price" => $huidspecialist_price,
                    "huidspecialist_price_url" => $huidspecialist_price_url,
                    "huidspecialist_price_external" => $huidspecialist_price_external,
                    "huidspecialist_price_discount" => $huidspecialist_price_discount,
                    "huidspecialist_price_url_discount" => $huidspecialist_price_url_discount,
                    "huidspecialist_price_external_discount" => $huidspecialist_price_external_discount,
                    "plastisch_chirurg_price" => $plastisch_chirurg_price,
                    "plastisch_chirurg_price_url" => $plastisch_chirurg_price_url,
                    "plastisch_chirurg_price_external" => $plastisch_chirurg_price_external,
                    "plastisch_chirurg_price_discount" => $plastisch_chirurg_price_discount,
                    "plastisch_chirurg_price_url_discount" => $plastisch_chirurg_price_url_discount,
                    "plastisch_chirurg_price_external_discount" => $plastisch_chirurg_price_external_discount,
                ];
            //}
        }
        return (array) $this->_christmas_price_list;

    }

    public function lowest_price_prefix($format=null){

        if( ! $this->_lowest_price_prefix ) {
            $this->_lowest_price_prefix = $this->get_field( static::$postType . '_lowest_price_prefix' );
        }

        return $this->_lowest_price_prefix;

    }

    public function lowest_price_facecard($format=null){

        if( ! $this->_lowest_price_facecard ) {

            if(!empty($price = $this->get_field( static::$postType . '_lowest_price_facecard'))) {
                $price_url = $this->get_field( static::$postType . '_lowest_price_facecard_url');
                $price_external = $this->get_field( static::$postType . '_lowest_price_facecard_url_external');
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_price_facecard = [
                    "price_lowest_price_facecard" => $price,
                    "price_lowest_price_facecard_url" => $price_url,
                    "price_lowest_price_facecard_url_external" => $price_external,
                ];
            }
        }

        return $this->_lowest_price_facecard;

    }

    public function lowest_price_facecard_trainer($format=null){

        if( ! $this->_lowest_price_facecard_trainer ) {

            if(!empty($price = $this->get_field( static::$postType . '_lowest_price_facecard_trainer'))) {
                $price_url = $this->get_field( static::$postType . '_lowest_price_facecard_trainer_url');
                $price_external = $this->get_field( static::$postType . '_lowest_price_facecard_trainer_external');
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_price_facecard_trainer = [
                    "price_lowest_price_facecard_trainer" => $price,
                    "price_lowest_price_facecard_trainer_url" => $price_url,
                    "price_lowest_price_facecard_trainer_external" => $price_external,
                ];
            } else {
                //return $this->lowest_price_facecard();
            }

        }

        return $this->_lowest_price_facecard_trainer;

    }

    public function lowest_price_trainer($format=null){

        if( ! $this->_lowest_price_trainer ) {

            if(!empty($price = $this->get_field( static::$postType . '_lowest_price_trainer' ))) {
                $price_url = $this->get_field( static::$postType . '_lowest_price_trainer_url');
                $price_external = $this->get_field( static::$postType . '_lowest_price_trainer_external');
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_price_trainer = [
                    "lowest_price_trainer" => $price,
                    "lowest_price_trainer_url" => $price_url,
                    "lowest_price_trainer_external" => $price_external,
                ];
            }

        }

        return $this->_lowest_price_trainer;

    }

    public function lowest_price_doctor($format=null){

        if( ! $this->_lowest_price_doctor ) {

            if(!empty($price = $this->get_field( static::$postType . '_lowest_price_doctor' ))) {
                $price_url = $this->get_field( static::$postType . '_lowest_price_doctor_url' );
                $price_external = $this->get_field( static::$postType . '_lowest_price_doctor_external' );
                if(is_numeric($price)){
                    $price = rokit_format_money($price, $format);
                }else{
                    $price;
                }
                $this->_lowest_price_doctor = [
                    "price_lowest_price_doctor" => $price,
                    "price_lowest_price_doctor_url" => $price_url,
                    "price_lowest_price_doctor_external" => $price_external,
                ];
            }

        }

        return $this->_lowest_price_doctor;

    }


    public function offer() {
        if( ! $this->_offer ) {
            if ($this->get_field( static::$postType .'_show_offer' )) {
                $this->_offer = $this->get_field(static::$postType . '_offer');
            }
        }

        return $this->_offer;
    }

    public function blocks() {
        if( ! $this->_blocks ) {
            $this->_blocks = $this->get_field(static::$postType . '_blocks');
        }

        return $this->_blocks;
    }

    public function prices($format=null){

        if( ! $this->_prices ) {

            $this->_prices = [
                'talent' => [
                    'title'     =>  $this->get_field( static::$postType . '_talent_title' ),
                    'prices'    => $this->talent_prices($format)
                ],
                'dockter' => [
                    'title'     => $this->get_field( static::$postType . '_doctor_title' ),
                    'prices'    => $this->doctor_prices($format)
                ],
                'dockter_plus' => [
                    'title'     => $this->get_field( static::$postType . '_doctor_plus_title' ),
                    'prices'    => $this->doctor_plus_prices($format)
                ]
            ];
        }

        return $this->_prices;
    }

    public function talent_prices($format=null){

        if( ! $this->_talent_prices ) {

            if($this->get_field( static::$postType . '_talent_show')){

                $prices = $this->get_field( static::$postType . '_talent_prices' );

                if(!empty($format) && !empty($prices)) {
                    $prices = filter_prices_format($prices);
                }

                $this->_talent_prices = $prices;
            }
        }

        return $this->_talent_prices;
    }

    public function doctor_prices($format=null){
        if( ! $this->_doctor_prices ) {

            if($this->get_field( static::$postType . '_doctor_show')){

                $prices = $this->get_field( static::$postType . '_doctor_prices' );

                if(!empty($format) && !empty($prices)) {
                    $prices = filter_prices_format($prices);
                }

                $this->_doctor_prices = $prices;
            }
        }

        return $this->_doctor_prices;
    }

    public function doctor_plus_prices($format=null){
        if( ! $this->_doctor_plus_prices ) {

            if($this->get_field( static::$postType . '_doctor_plus_show')){

                $prices = $this->get_field( static::$postType . '_doctor_plus_prices' );

                if(!empty($format) && !empty($prices)) {
                    $prices = filter_prices_format($prices);
                }

                $this->_doctor_plus_prices = $prices;
            }
        }

        return $this->_doctor_plus_prices;
    }

    public function cta(){
        if( ! $this->_cta ) {
            $cta = $this->get_field( static::$postType . '_cta_overwrite', 'option') ? $this->get_field( static::$postType . '_cta') : $this->defaults('cta');

            if(!empty($cta['text'])) {
                $cta['text'] = self::compile($cta['text']);
            }

            $this->_cta = $cta;

        }

        return $this->_cta;
    }

    public function bottom(){
        if( ! $this->_bottom ) {
            if ($this->get_field( static::$postType . '_bottom_show') ){
                if ($this->get_field( static::$postType . '_bottom_overwrite')){
                    $bottom = [
                        'titles'  => [
                            'title' => $this->get_field( static::$postType . '_bottom_intro_title'),
                            'intro' => $this->get_field( static::$postType . '_bottom_intro_intro')
                        ],
                        'button'  => $this->get_field( static::$postType . '_bottom_button')
                    ];

                } else {
                    $bottom =  $this->defaults('bottom');
                }

                $this->_bottom = $bottom;
            }

        }

        return $this->_bottom;
    }

    public function replacable_vars() {

        if( ! $this->_replacable_vars ) {
            $this->_replacable_vars = [
                'priceTitle'        => strtolower($this->title()),
                'phone'             => rokit_get_a_tag_aen_code(get_field('contact_online_phone', 'option')),
                'treatmentTitle'    => !empty($this->treatment()) ? strtolower($this->treatment()->title()) : ''
            ];
        }

        return $this->_replacable_vars;

    }

    public function treatment(){

        if(!$this->_treatment) {
            $treatment_id = $this->get_field(static::$postType . '_treatment_relation');

            if(!empty($id = rokit_get_lang_id($treatment_id))) {
                $this->_treatment = TreatmentCollection::post($id);
            }
        }

        return $this->_treatment;
    }

    /**
     * Check if primary term is defined (Yoast functionality)
     * If no primary term is defined use first assinged term in array
     *
     * @return string
     */
    public function primary_term(){
        if( ! $this->_primary_term ) {

            $primary_term = get_post_meta($this->ID, '_yoast_wpseo_primary_' . static::$postType .'_type');

            if(!empty($primary_term[0])) {
                $this->_primary_term = new static::$termClass($primary_term[0]);
            } else {
                $terms = $this->terms(static::$postType . '_type');
                if(!empty($terms[0])) {
                    $this->_primary_term = $terms[0];
                }
            }
        }

        return $this->_primary_term;
    }

    public function seo_description() {

        if( ! $this->_seo_description ) {
            $description = $this->panorama()['subtitle'] ? $this->panorama()['subtitle'] : $this->cta()['intro'];
            if (!empty($description)){
                $this->_seo_description = strip_tags( rokit_truncate( $description, '156' ) );
            }
        }

        return $this->_seo_description;

    }
}
