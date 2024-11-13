<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class CampaignCollection extends PostCollection {

    protected static $postType = 'campaign';

    protected static $postClass = 'Rokit\Controllers\Types\Campaign';

    var $_campaigns;

    var $_action_list;

    var $_cta;

    public function panorama() {
        if( ! $this->_panorama ) {
            $this->_panorama = parent::panorama();
        }

        return $this->_panorama;
    }

    public function campaigns(){

        if (!$this->_campaigns) {
            $args = [
                'posts_per_page' => -1,
                'order_by' => 'menu_order',
                'order' => 'asc',
            ];

            $this->_campaigns = self::query($args);
        }

        return $this->_campaigns;

    }

    public function action_list(){
        if( ! $this->_action_list ) {

            $action_list = $last_minutes = $academy = [];
            $list_data = get_field( static::$postType . '_archive_lists', 'option');
            $academy_items = AcademyCollection::items(['posts_per_page' => 4]);
            $last_minutes_items = LastMinuteCollection::items(['posts_per_page' => 4]);

            if (!empty($list_data)){

                $academy = $list_data['academy'];
                $last_minutes = $list_data['last_minutes'];

                if(!empty($academy_items)) {
                    $academy['items'] = $academy_items;
                    $academy['button'] = [
                        'url' => AcademyCollection::url(),
                        'label' => pll__('Bekijk alle academy dagen')
                    ];
                }

                if(!empty($last_minutes_items)) {
                    $last_minutes['items'] = $last_minutes_items;
                    $last_minutes['button'] = [
                        'url' => LastMinuteCollection::url(),
                        'label' => pll__('Bekijk alle last minutes')
                    ];
                }

                $show_settings = rokit_get_language_settings()['general'];

                if ($show_settings['last-minute']){
                    $action_list['titles'] = $list_data['titles'];
                    $action_list['lists']['last-minute'] = $last_minutes;
                }

                if ($show_settings['academy']){
                    $action_list['lists']['academy'] = $academy;
                }
            } else {
                $action_list = false;
            }

            $this->_action_list = $action_list;

        }

        return $this->_action_list;
    }

    public function cta(){
        if( ! $this->_cta ) {
            $cta = get_field( static::$postType . '_archive_cta', 'option');

            if(!empty($cta['button_label'])) {
                $cta['button'] = [
                    'label' => $cta['button_label'],
                    'url' => '#'
                ];

                unset($cta['button_label']);
            }

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

}
