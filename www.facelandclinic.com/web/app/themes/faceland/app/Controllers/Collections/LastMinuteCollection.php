<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Collections\AcademyCollection;

class LastMinuteCollection extends AcademyCollection {

    protected static $postType = 'last_minute';

    protected static $postClass = 'Rokit\Controllers\Types\LastMinute';

    var $_video;

    var $_items_by_location;

    var $_terms;

    var $_action_list;

    public function video() {
        if( ! $this->_video ) {
            if (get_field( static::$postType .'_archive_show_video', 'option' )){
                $this->_video = get_field( static::$postType .'_archive_video', 'option' );
            }
        }

        return $this->_video;
    }

    public function items_by_location() {

        $items = static::items();

        $data = [];

        if(!empty($items) && is_iterable($items)) {
            foreach ($items as $item) {
                if (!array_key_exists($item->location()->slug, $data)) {
                    $data[$item->location()->slug]['location'] = $item->location();
                }
                $data[$item->location()->slug]['items'][] = $item;
            }
        }

        return $data;

    }

    public function terms() {
        if( ! $this->_terms ) {
            $this->_terms = get_field( static::$postType .'_archive_terms', 'option' );
        }

        return $this->_terms;
    }

    public function action_list(){
        $homepage_id = get_option( 'page_on_front' );

        $action_list = [];
        $academy_items = AcademyCollection::items(['posts_per_page' => 4]);
        $last_minutes_items = self::items(['posts_per_page' => 4]);

        $academy = [
            'title' => get_field('page_actions_academy_title',$homepage_id),
            'subtitle' => get_field('page_actions_academy_subtitle',$homepage_id)
        ];

        $last_minutes = [
            'title' => get_field('page_actions_last_minutes_title',$homepage_id),
            'subtitle' => get_field('page_actions_last_minutes_subtitle',$homepage_id)
        ];

        if (!empty($academy_items)) {
            $academy['items'] = $academy_items;
            $academy['button'] = [
                'url' => AcademyCollection::url(),
                'label' => pll__('Bekijk alle academy dagen')
            ];
        }

        if (!empty($last_minutes_items)) {
            $last_minutes['items'] = $last_minutes_items;
            $last_minutes['button'] = [
                'url' => self::url(),
                'label' => pll__('Bekijk alle last minutes')
            ];
        }

        $show_settings = rokit_get_language_settings()['general'];

        if (pll_current_language('slug') != 'nl') {
            if ($show_settings['last-minute']) {
                $action_list['lists']['last-minute'] = $last_minutes;
            }
        }

        if ($show_settings['academy']) {
            $action_list['lists']['academy'] = $academy;
        }

        $this->_action_list = $action_list;
        
        return $this->_action_list;
    }

}
