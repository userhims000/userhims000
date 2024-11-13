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

class Page12325 extends Page
{

    protected static $postType = 'page';

    var $_video;

    var $_panorama_type;

    var $_image;

    var $_slider;
    
    var $_mobile_slider;

    var $_panorama;

    var $_facts;

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
