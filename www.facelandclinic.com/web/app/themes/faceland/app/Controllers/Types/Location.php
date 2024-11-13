<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\SpecialistCollection;
use Rokit\Controllers\Collections\TreatmentCollection;

class Location extends PostDetail {

    protected static $postType = 'location';

    var $_image;

    var $_street;

    var $_zipcode;

    var $_city;

    var $_country;

    var $_latitude;

    var $_longitude;

    var $_op_stucture_data;

    var $_email;

    var $_phone;

    var $_general;

    var $_availability;

    var $_openinghours;

    var $_cta;

    var $_mapslink;

    var $_treatment_ids;

    var $_treatments;

    var $_specialists;

    var $_related;

    var $_replacable_vars;

    var $_fallback;

    public function image(){
        if( ! $this->_image ) {
            $this->_image = $this->get_field( static::$postType . '_image');
        }

        return $this->_image;
    }

    public function street(){
        if( ! $this->_street ) {
            $this->_street = $this->get_field( static::$postType . '_street');
        }

        return $this->_street;
    }

    public function zipcode(){
        if( ! $this->_zipcode ) {
            $this->_zipcode = $this->get_field( static::$postType . '_zipcode');
        }

        return $this->_zipcode;
    }

    public function city(){
        if( ! $this->_city ) {
            $this->_city = $this->get_field( static::$postType . '_city');
        }

        return $this->_city;
    }

    public function country(){
        if( ! $this->_country ) {
            $this->_country = $this->get_field( static::$postType . '_country');
        }

        return $this->_country;
    }

    public function latitude(){
        if( ! $this->_latitude ) {
            $this->_latitude = $this->get_field( static::$postType . '_latitude');
        }

        return $this->_latitude;
    }

    public function longitude(){
        if( ! $this->_longitude ) {
            $this->_longitude = $this->get_field( static::$postType . '_longitude');
        }

        return $this->_longitude;
    }

    public function op_stucture_data(){
        if( ! $this->_op_stucture_data ) {
            $this->_op_stucture_data = $this->get_field( static::$postType . '_op_stucture_data');
        }

        return $this->_op_stucture_data;
    }

    public function email(){
        if( ! $this->_email ) {
            $this->_email = $this->get_field( static::$postType . '_email');
        }

        return $this->_email;
    }

    public function phone(){
        if( ! $this->_phone ) {
            $this->_phone = $this->get_field( static::$postType . '_phone');
        }

        return $this->_phone;
    }

    public function general(){
        if( ! $this->_general ) {
            $this->_general = [
                'image'     => $this->image(),
                'street'    => $this->street(),
                'zipcode'   => $this->zipcode(),
                'city'      => $this->city(),
                'country'   => $this->country(),
                'email'     => $this->email(),
                'phone'     => $this->phone(),
                'mapslink'     => $this->mapslink(),
            ];
        }

        return $this->_general;
    }

    public function availability(){
        if( ! $this->_availability ) {
            $this->_availability = [
                'title'     => $this->get_field( static::$postType . '_availability_title'),
                'items'   => $this->get_field( static::$postType . '_availability_moments'),
            ];
        }

        return $this->_availability;
    }

    public function openinghours(){
        if( ! $this->_openinghours ) {
            $formatted_schedules = [];
            $openingDays = $this->get_schedule_for_today_and_next_days($this->get_field( static::$postType . '_openinghours_moments'));
            if ($openingDays !== false) {
                foreach ($openingDays as $schedule) {
                    $formatted_schedules[] = [
                        'text' => $schedule['text'], 
                        'label' => $schedule['label'], 
                        'select_day' => $schedule['select_day'] 
                    ]; 
                }
            }
            
            if($_GET['debug'] == 'development'){
                $items = $this->addMissingDays($this->get_field( static::$postType . '_openinghours_moments'));
            }else{
                $items = $this->get_field( static::$postType . '_openinghours_moments');
            }
            
            date_default_timezone_set('Europe/Amsterdam');
            $currentTimeNetherlands = date('H:i');
            
            $current_day = strtolower(date_i18n('l'));
            
            $fetchCloseTimeOfclinic = $this->getCloseTimeOfclinicForTheDay($this->get_field( static::$postType . '_openinghours_moments'));
            $fetchNextDayOpenTimeOfclinic = $this->getNexDayOpeningTimeOfClinic($this->get_field( static::$postType . '_openinghours_moments'));
            
            $this->_openinghours = [
                'title'    => $this->get_field( static::$postType . '_openinghours_title'),
                'location_information' => [ 
                    'location_title_heading' => $this->get_field( static::$postType . '_title_tag'), 
                    'location_title' => $this->get_field( static::$postType . '_section_openinghours_title'), 
                    'default_title' => $this->get_field('location_panorama_titles_title'), 
                    'map_below_text' => $this->get_field(static::$postType . '_map_below_text'), 
                    'open_hours_lable' =>  \get_field('view_opening_hours_label','option'), 
                    'exception_close_time' =>  \get_field('chat_available_time','option'), 'chat_button' => [
                    'label' => \get_field('chat_button_label','option'),
                    'url' => \get_field('chat_button_url','option'),
                    'external' => \get_field('chat_button_external ','option')
                ], 'appointment_button' => [
                    'label' => \get_field('appointment_button_label','option'),
                    'url' => \get_field('appointment_button_url','option'),
                    'external' => \get_field('appointment_button_external','option')
                ], 'location_title_content_heading_tag' =>  $this->get_field('location_title_content_tag'), 'location_title_content' =>  $this->get_field('location_title_content'), 'location_content_info' =>  $this->get_field('location_content'), 
                    'location_image_with_content_section' => $this->get_field('image_with_content_section'),
                    'hide_map_section' => $this->get_field('hide_map_section'),
                    'right_icon_with_info' => $this->get_field('right_icon_with_info'),
                    'taggbox_review_shortcode' => $this->get_field('taggbox_shortcode')
                  ] ,
                'items'  => $items,
                'opening_days'  => $openingDays,
                'current_time'  => $currentTimeNetherlands,
                'current_day'  => $current_day,
                'open_time'  => $fetchCloseTimeOfclinic['open_time'],
                'close_time'  => $fetchCloseTimeOfclinic['close_time'],
                'next_day_open_time'  => $fetchNextDayOpenTimeOfclinic,
            ];
        }

        return $this->_openinghours;
    }

    public function cta(){
        if( ! $this->_cta ) {

            $cta = $this->get_field( static::$postType . '_cta_overwrite', 'option') ? $this->get_field( static::$postType . '_cta') : $this->defaults('cta');

            if(!empty($cta['text'])) {
                $cta['text'] = (new Location())->compile($cta['text']);
            }

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public function mapslink(){
        if( ! $this->_mapslink ) {
            if ($this->street()){
                $this->_mapslink     = 'https://www.google.com/maps/place/'.$this->street();
            }
        }

        return $this->_mapslink;
    }

    public function treatment_ids(){

        if( ! $this->_treatment_ids ) {
            return $this->get_field('location_all_treatment_relation');
        }

        return $this->_treatment_ids;
    }

    public function treatments(){

        if( ! $this->_treatments ) {
            $this->_treatments = TreatmentCollection::organize_by_terms('treatment_type', ['posts_per_page' => -1, 'post__in' => $this->treatment_ids()]);
        }

        return $this->_treatments;
    }

    public function specialists(){

        if( ! $this->_specialists ) {

            $specialists = $this->get_field('location_specialist_relation');

            if(!empty($specialists)) {
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
                $this->_specialists = SpecialistCollection::posts_by_id($specialists, $args);
            }

        }

        return $this->_specialists;
    }

    public function related(){

        if( ! $this->_related ) {

            $cta = $this->get_field( static::$postType . '_related_overwrite', 'option') ? $this->get_field( static::$postType . '_related') : $this->defaults('related');

            return [
                'title'         => (new Location())->compile($cta['title']),
                'subtitle'      => (new Location())->compile($cta['intro']),
                'specialists'   => $this->specialists(),
                'treatments'    => $this->treatments()
            ];
        }

        return $this->_related;
    }

    public function replacable_vars() {

        if( ! $this->_replacable_vars ) {
            $this->_replacable_vars = [
                'location'  => $this->title(),
                'phone'     => rokit_get_a_tag_aen_code(get_field('contact_online_phone', 'option'))
            ];
        }

        return $this->_replacable_vars;

    }

    public static function fallback($treatment_type) {

        if(empty($fallback_text = get_field('location_detail_fallback', 'option'))) {
            $fallback_text = pll__('{{location}} verzorgt dit type behandeling op dit moment niet. Op zoek naar een kliniek?');
        }

        return [
            'text' => (new Location())->compile($fallback_text),
            'button' => [
                'label' => pll__('Bekijk klinieken'),
                'url' => LocationCollection::url().'nederland'
            ]
        ];

    }


    public function get_schedule_based_on_today() {
        // Get today's day index (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
        $today_index = date('w');

        // Define an array of days
        $days = array('Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag');

        // Get the current day name
        $current_day = $days[$today_index];

        // Check if the current day exists in the provided schedule array
        foreach ($schedule_array as $item) {
            if ($item['text'] === $current_day) {
                return $item;
            }
        }

        // If the current day is not found in the schedule array, return false or handle as needed
        return false;
    }

   public function get_schedule_for_today_and_next_days($schedule_array) {
        // Get the current day in Dutch
        $current_day = strtolower(date_i18n('l'));
        $next_day = strtolower(date_i18n('l', strtotime('+1 day')));

        // Define your array of days and corresponding values
        $working_hours = $schedule_array;

        // Find the index of the current day or the next day in the array
        $current_day_index = -1;
        $flag = false;

        foreach ($working_hours as $index => $working_hour) {
            if ($working_hour["select_day"] === $current_day) {
                $flag = true;
                $current_day_index = $index;
                break;
            } elseif ($working_hour["select_day"] === $next_day) {
                $current_day_index = $index;
                break;
            }
        }

        $result = array();

        // If the current day or next day is found
        if ($flag === true || $current_day_index !== -1) {
            // Output the working hours for the current week starting from the current or next available day
            for ($i = $current_day_index; $i < count($working_hours); $i++) {
                $result[] = ['text' => $working_hours[$i]["text"], 'label' => $working_hours[$i]["label"], 'select_day' => $working_hours[$i]["select_day"]];
                if ($i == count($working_hours) - 1) { // If it's the last day in the array, start from the first day
                    $i = -1; // Reset $i to -1 so that it becomes 0 in the next iteration
                }
                if ($i + 1 == $current_day_index) { // Break the loop if we've reached the day just before the current day
                    break;
                }
            }
        }

        return $result;
    }

    function addMissingDays($original_array) {
        // Days of the week
        $days = array('maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag');

        // Loop through each day
        foreach ($days as $day) {
            $found = false;
            // Check if the day exists in the original array
            foreach ($original_array as $item) {
                if (strtolower($item['select_day']) === $day) {
                    $found = true;
                    break;
                }
            }
            // If the day doesn't exist, add it with 'Closed' label
            if (!$found) {
                $original_array[] = array(
                    'text' => ucfirst($day),
                    'label' => pll__('Gesloten'),
                    'select_day' => $day
                );
            }
        }

        // Sort the array by select_day
        usort($original_array, function($a, $b) use ($days) {
            return array_search($a['select_day'], $days) - array_search($b['select_day'], $days);
        });

        return $original_array;
    }

    function getCloseTimeOfclinicForTheDay($openinghours_array) {
        $current_day = strtolower(date_i18n('l'));
        // Iterate through the array
        foreach ($openinghours_array as $item) {
            // Check if current day matches select_day
            if ($current_day === $item['select_day']) {
                // Extract the last value after the dash in the label
                $label_parts = explode(' - ', $item['label']);
                $result['open_time'] = $label_parts[0]; // First value
                $result['close_time'] = end($label_parts); // Last value

                // Return the last value
                return $result;
            }
        }

        // If the current day doesn't match any select_day, return null or handle it according to your needs
        return null;
    }

    function getNexDayOpeningTimeOfClinic($openinghours_array) {
        $current_day = strtolower(date_i18n('l'));

        // Get the next day
        $next_day = strtolower(date_i18n('l', strtotime('+1 day')));

        $next_day_found = false;
        $next_day_open_time = "";

        // Check if tomorrow is available
        foreach ($openinghours_array as $item) {
            if ($next_day === $item['select_day']) {
                // Extract the start time for tomorrow
                $label_parts = explode(' - ', $item['label']);
                $next_day_open_time = "Nu gesloten. morgen open vanaf " . $label_parts[0]; // First value
                $next_day_found = true;
                break;
            }
        }

        // If tomorrow is not available, find the next available day
        if (!$next_day_found) {
            foreach ($openinghours_array as $item) {
                if (strtotime($item['select_day']) > strtotime($current_day)) {
                    // Extract the start time for the next available day
                    $next_day_open_time = "De kliniek gaat open " . $item['text'] . ' op ' . explode(' - ', $item['label'])[0]; // Day name and start time
                    $next_day_found = true;
                    break;
                }
            }
        }

        // If still not found, default to the first day of the week
        if (!$next_day_found) {
            $next_day_open_time = "De kliniek gaat open " . $openinghours_array[0]['text'] . ' op ' . explode(' - ', $openinghours_array[0]['label'])[0]; // Day name and start time
        }

        return $next_day_open_time;
    }
}
