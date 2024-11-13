<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

use Rokit\Controllers\Collections\ArticleCollection;
use Rokit\Controllers\Collections\BlogArticleCollection;
use Rokit\Controllers\Collections\BrandCollection;
use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\ReviewCollection;
use Rokit\Controllers\Collections\SpecialistCollection;
use Rokit\Controllers\Collections\TreatmentCollection;
use Rokit\Controllers\Collections\AcademyCollection;
use Rokit\Controllers\Collections\LastMinuteCollection;

class Page2 extends Page
{

    protected static $postType = 'page';

    var $_video;

    var $_panorama_type;

    var $_image;

    var $_slider;
    
    var $_mobile_slider;

    var $_panorama;

    var $_facts;

    var $_action;

    var $_treatments;

    var $_highlighted;

    var $_action_list;
    
    var $_barometer;

    var $_brands;

    var $_reviews;

    public function video()
    {

        if (!$this->_video) {
            $video['url'] = $this->get_field($this->post_type . '_panorama_video_url');
            $video['thumbnail'] = $this->get_field($this->post_type . '_panorama_video_thumbnail');
            $this->_video = $video;
        }

        return $this->_video;
    }

    public function panorama_type()
    {

        if (!$this->_panorama_type) {
            $this->_panorama_type = $this->get_field($this->post_type . '_panorama_type');
        }

        return $this->_panorama_type;
    }

    public function image()
    {

        if (!$this->_image) {
            $this->_image = $this->get_field($this->post_type . '_panorama_image');
        }

        return $this->_image;
    }

    public function panorama()
    {

        if (!$this->_panorama) {
            $panorama = [
                'title' => $this->get_field($this->post_type . '_panorama_titles_title'),
                'subtitle' => $this->get_field($this->post_type . '_panorama_titles_subtitle'),
                'type' => $this->panorama_type(),
                'image' => $this->image(),
                'video' => $this->video()
            ];

            $this->_panorama = $panorama;

        }

        return $this->_panorama;
    }

    public function facts()
    {
        if (!$this->_facts) {

            $args = [
                'lang' => 'nl'
            ];

            $locations = LocationCollection::query($args);
            $specialists = SpecialistCollection::query($args);

            $facts[] = [
                'name' => pll__('Klinieken'),
                'amount' => is_iterable($locations) ? count($locations) : 0
            ];

            $facts[] = [
                'name' => pll__('Specialisten'),
                'amount' => is_iterable($specialists) ? count($specialists) : 0
            ];

            if (!empty($dynamic_facts = $this->get_field($this->post_type . '_facts'))) {
                if (is_array($dynamic_facts)) {
                    $facts = array_merge($facts, $dynamic_facts);
                }
            }

            $this->_facts = $facts;

        }

        return $this->_facts;
    }

    public function action()
    {

        if (!$this->_action) {
            $this->_action = [
                'titles' => $this->get_field($this->post_type . '_action_titles'),
                'item' => [
                    "title" => $this->get_field($this->post_type . '_action_block_title'),
                    "image" => $this->get_field($this->post_type . '_action_block_image'),
                    "button" => $this->get_field($this->post_type . '_action_block_button')
                ]
            ];
        }

        return $this->_action;
    }

    public function treatments()
    {

        if (!$this->_treatments) {
            $this->_treatments = [
                'titles' => $this->get_field($this->post_type . '_treatments_titles'),
                'terms' => TreatmentCollection::organize_by_terms('treatment_type', ['posts_per_page' => -1], false)
            ];
        }

        return $this->_treatments;
    }

    public function highlighted()
    {

        if (!$this->_highlighted) {
            if (!$this->get_field($this->post_type . '_highlighted_show')) {
                return;
            }

            $button = $this->get_field($this->post_type . '_highlighted_button_show');

            if ($button) {
                $button = [
                    'label' => $this->get_field($this->post_type . '_highlighted_button_label'),
                    'url' => $this->get_field($this->post_type . '_highlighted_button_url')
                ];
            }

            $this->_highlighted = [
                'titles' => $this->get_field($this->post_type . '_highlighted_titles'),
                'items' => $this->get_field($this->post_type . '_highlighted_items'),
                'button' => $button
            ];
        }

        return $this->_highlighted;
    }

    public function action_list()
    {
        if (!$this->_action_list) {

            $action_list = [];
            $academy_items = AcademyCollection::items(['posts_per_page' => 4]);
            $last_minutes_items = LastMinuteCollection::items(['posts_per_page' => 4]);

            $academy = [
                'title' => $this->get_field($this->post_type . '_actions_academy_title'),
                'subtitle' => $this->get_field($this->post_type . '_actions_academy_subtitle')
            ];

            $last_minutes = [
                'title' => $this->get_field($this->post_type . '_actions_last_minutes_title'),
                'subtitle' => $this->get_field($this->post_type . '_actions_last_minutes_subtitle')
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
                    'url' => LastMinuteCollection::url(),
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

        }

        return $this->_action_list;
    }

    public function barometer() 
    {
        if (!$this->_barometer) {
            $this->_barometer = $this->get_field($this->post_type . '_barometer');
        }

        return $this->_barometer;   
    }

    public function brands()
    {

        if (!$this->_brands) {

            $this->_brands = [
                'title' => $this->get_field($this->post_type . '_brands_title'),
                'items' => BrandCollection::query(['orderby' => 'post__in', 'post__in' => $this->get_field($this->post_type . '_brands')])
            ];
        }

        return $this->_brands;
    }

    public function slider(){
        
        if (!$this->_slider) {
            $this->_slider = $this->get_field($this->post_type . '_slider');
        }

        return $this->_slider;
    }

    public function mobile_slider(){
        
        if (!$this->_mobile_slider) {
            $this->_mobile_slider = $this->get_field($this->post_type . '_mobile_slider');
        }

        return $this->_mobile_slider;
    }

    public function reviews()
    {

        if (!$this->_reviews) {
            if ($this->get_field($this->post_type . '_reviews_show')) {
                $this->_reviews = [
                    'grades' => $this->get_field($this->post_type . '_reviews_grade_overwrite') && !empty($this->get_field($this->post_type . '_reviews_grade')) ? $this->get_field($this->post_type . '_reviews_grade') : get_option('rokit_review_average'),
                    'titles' => $this->get_field($this->post_type . '_reviews_titles'),
                    'image' => $this->get_field($this->post_type . '_reviews_image'),
                    'buttons' => [
                        'left' => $this->get_field($this->post_type . '_reviews_left_button'),
                        'right' => $this->get_field($this->post_type . '_reviews_right_button')
                    ]
                ];
            }
        }

        return $this->_reviews;
    }

    public function seo_description()
    {

        if (!$this->_seo_description) {
            if (!empty($this->panorama()['subtitle'])) {
                $this->_seo_description = strip_tags(rokit_truncate($this->panorama()['subtitle'], '156'));
            }
        }

        return $this->_seo_description;

    }
}
