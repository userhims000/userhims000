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

class Page7158 extends Page
{
protected static $postType = 'page';

    var $_video;

    var $_panorama_type;

    var $_image;

    var $_slider;

    var $_panorama;

    var $_first_deal_label;

    var $_first_deal_banner;

    var $_first_deal_behandelaar;
    
    var $_first_cta_section;
    
    var $_first_deal_images;

    var $_terms_and_conditions_list;

    var $_second_deal_label;

    var $_second_deal_banner;

    var $_second_deal_behandelaar;
    
    var $_second_cta_section;
    
    var $_second_deal_images;

    var $_second_terms_and_conditions_list;

    var $_third_deal_label;

    var $_third_deal_banner;

    var $_third_deal_behandelaar;
    
    var $_third_cta_section;
    
    var $_third_deal_images;

    var $_third_terms_and_conditions_list;

    var $_fourth_deal_label;

    var $_fourth_deal_banner;

    var $_fourth_deal_behandelaar;
    
    var $_fourth_cta_section;
    
    var $_fourth_deal_images;

    var $_fourth_terms_and_conditions_list;

    var $_show_deals_list;

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

    public function slider(){
        
        if (!$this->_slider) {
            $this->_slider = $this->get_field($this->post_type . '_luckyrshot_slider');
        }

        return $this->_slider;
    }

    public function first_deal_label()
    {
        if (!$this->_first_deal_label) {

            $first_deal_label = $this->get_field($this->post_type . '_deal_first_lable');
               
            $this->_first_deal_label = $first_deal_label;

        }

        return $this->_first_deal_label;
    }

    public function first_deal_banner()
    {
        if (!$this->_first_deal_banner) {

            $first_deal_banner = $this->get_field($this->post_type . '_first_deal_banner');
               
            $this->_first_deal_banner = $first_deal_banner;

        }

        return $this->_first_deal_banner;
    }

    public function first_deal_behandelaar()
    {

        if (!$this->_first_deal_behandelaar) {
        
            $first_deal_behandelaar = $this->get_field($this->post_type . '_behandelaar_information');
               
            $this->_first_deal_behandelaar = $first_deal_behandelaar;            
        }

        return $this->_first_deal_behandelaar;
    }

    public function first_cta_section()
    {

        if (!$this->_first_cta_section) {

            $title = $this->get_field($this->post_type . '_discount_facecard_title');
            $button_url = $this->get_field($this->post_type . '_discount_button_url');
            $button_lable = $this->get_field($this->post_type . '_discount_button_lable');
            $button_external = $this->get_field($this->post_type . '_discount_button_external');
              
            $discount_facecard_section = [
                $title,
                $button_url,
                $button_lable,
                $button_external
            ];   
            
            $this->_first_cta_section = $discount_facecard_section;      
        }

        return $this->_first_cta_section;
    }

    public function first_deal_images()
    {

        if (!$this->_first_deal_images) {
            $title = $this->get_field($this->post_type . '_deal_images_section_title');
            $description = $this->get_field($this->post_type . '_deal_images_description');
            $images = $this->get_field($this->post_type . '_deal_images');
            $deal_images_section = [
                "title" => $title,
                "description" => $description,
                "images" => $images,
            ];
            $this->_first_deal_images = $deal_images_section;      
        }

        return $this->_first_deal_images;
    }

    public function terms_and_conditions()
    {
        if (!$this->_terms_and_conditions_list) {

            $lable = $this->get_field($this->post_type . '_terms_and_condition_lable');
            $description = $this->get_field($this->post_type . '_terms_and_condition_desc');
            $terms_condition_list = $this->get_field($this->post_type . '_terms_and_condition_list');
            $list = [
                "lable" => $lable,
                "description" => $description,
                "terms_condition_list" => $terms_condition_list,
            ]; 
            $this->_terms_and_conditions_list = $list;

        }

        return $this->_terms_and_conditions_list;
    }

    public function second_deal_label()
    {
        if (!$this->_second_deal_label) {

            $second_deal_label = $this->get_field($this->post_type . '_deal_second_lable');
               
            $this->_second_deal_label = $second_deal_label;

        }

        return $this->_second_deal_label;
    }
    
    public function second_deal_banner()
    {
        if (!$this->_second_deal_banner) {

            $second_deal_banner = $this->get_field($this->post_type . '_sc_deal_banner');
               
            $this->_second_deal_banner = $second_deal_banner;

        }

        return $this->_second_deal_banner;
    }

    public function second_deal_behandelaar()
    {

        if (!$this->_second_deal_behandelaar) {
        
            $second_deal_behandelaar = $this->get_field($this->post_type . '_sc_deal_behandelaar_information');
               
            $this->_second_deal_behandelaar = $second_deal_behandelaar;            
        }

        return $this->_second_deal_behandelaar;
    }

    public function second_cta_section()
    {

        if (!$this->_second_cta_section) {

            $title = $this->get_field($this->post_type . '_sc_discount_facecard_title');
            $button_url = $this->get_field($this->post_type . '_sc_discount_button_url');
            $button_lable = $this->get_field($this->post_type . '_sc_discount_button_lable');
            $button_external = $this->get_field($this->post_type . '_sc_discount_button_external');
              
            $discount_facecard_section = [
                $title,
                $button_url,
                $button_lable,
                $button_external
            ];   
            
            $this->_second_cta_section = $discount_facecard_section;      
        }

        return $this->_second_cta_section;
    }

    public function second_deal_images()
    {

        if (!$this->_second_deal_images) {
            $title = $this->get_field($this->post_type . '_sc_deal_images_section_title');
            $description = $this->get_field($this->post_type . '_sc_deal_images_description');
            $images = $this->get_field($this->post_type . '_sc_deal_images');
            $deal_images_section = [
                "title" => $title,
                "description" => $description,
                "images" => $images,
            ];
            $this->_second_deal_images = $deal_images_section;      
        }

        return $this->_second_deal_images;
    }

    public function second_terms_and_conditions()
    {
        if (!$this->_second_terms_and_conditions_list) {

            $lable = $this->get_field($this->post_type . '_sc_terms_and_condition_lable');
            $description = $this->get_field($this->post_type . '_sc_terms_and_condition_desc');
            $terms_condition_list = $this->get_field($this->post_type . '_sc_terms_and_condition_list');
            $list = [
                "lable" => $lable,
                "description" => $description,
                "terms_condition_list" => $terms_condition_list,
            ]; 
            $this->_second_terms_and_conditions_list = $list;

        }

        return $this->_second_terms_and_conditions_list;
    }

    public function third_deal_label()
    {
        if (!$this->_third_deal_label) {

            $third_deal_label = $this->get_field($this->post_type . '_deal_third_lable');
               
            $this->_third_deal_label = $third_deal_label;

        }

        return $this->_third_deal_label;
    }
    
    public function third_deal_banner()
    {
        if (!$this->_third_deal_banner) {

            $third_deal_banner = $this->get_field($this->post_type . '_th_deal_banner');
               
            $this->_third_deal_banner = $third_deal_banner;

        }

        return $this->_third_deal_banner;
    }

    public function third_deal_behandelaar()
    {

        if (!$this->_third_deal_behandelaar) {
        
            $third_deal_behandelaar = $this->get_field($this->post_type . '_th_deal_behandelaar_information');
               
            $this->_third_deal_behandelaar = $third_deal_behandelaar;            
        }

        return $this->_third_deal_behandelaar;
    }

    public function third_cta_section()
    {

        if (!$this->_third_cta_section) {

            $title = $this->get_field($this->post_type . '_th_discount_facecard_title');
            $button_url = $this->get_field($this->post_type . '_th_discount_button_url');
            $button_lable = $this->get_field($this->post_type . '_th_discount_button_lable');
            $button_external = $this->get_field($this->post_type . '_th_discount_button_external');
              
            $discount_facecard_section = [
                $title,
                $button_url,
                $button_lable,
                $button_external
            ];   
            
            $this->_third_cta_section = $discount_facecard_section;      
        }

        return $this->_third_cta_section;
    }

    public function third_deal_images()
    {

        if (!$this->_third_deal_images) {
            $title = $this->get_field($this->post_type . '_th_deal_images_section_title');
            $description = $this->get_field($this->post_type . '_th_deal_images_description');
            $images = $this->get_field($this->post_type . '_th_deal_images');
            $deal_images_section = [
                "title" => $title,
                "description" => $description,
                "images" => $images,
            ];
            $this->_third_deal_images = $deal_images_section;      
        }

        return $this->_third_deal_images;
    }

    public function third_terms_and_conditions()
    {
        if (!$this->_third_terms_and_conditions_list) {

            $lable = $this->get_field($this->post_type . '_sc_terms_and_condition_lable');
            $description = $this->get_field($this->post_type . '_sc_terms_and_condition_desc');
            $terms_condition_list = $this->get_field($this->post_type . '_sc_terms_and_condition_list');
            $list = [
                "lable" => $lable,
                "description" => $description,
                "terms_condition_list" => $terms_condition_list,
            ]; 
            $this->_third_terms_and_conditions_list = $list;

        }

        return $this->_third_terms_and_conditions_list;
    }

    public function fourth_deal_label()
    {
        if (!$this->_fourth_deal_label) {

            $fourth_deal_label = $this->get_field($this->post_type . '_deal_fourth_lable');
               
            $this->_fourth_deal_label = $fourth_deal_label;

        }

        return $this->_fourth_deal_label;
    }
    
    public function fourth_deal_banner()
    {
        if (!$this->_fourth_deal_banner) {

            $fourth_deal_banner = $this->get_field($this->post_type . '_ft_deal_banner');
               
            $this->_fourth_deal_banner = $fourth_deal_banner;

        }

        return $this->_fourth_deal_banner;
    }

    public function fourth_deal_behandelaar()
    {

        if (!$this->_fourth_deal_behandelaar) {
        
            $fourth_deal_behandelaar = $this->get_field($this->post_type . '_ft_deal_behandelaar_information');
               
            $this->_fourth_deal_behandelaar = $fourth_deal_behandelaar;            
        }

        return $this->_fourth_deal_behandelaar;
    }

    public function fourth_cta_section()
    {

        if (!$this->_fourth_cta_section) {

            $title = $this->get_field($this->post_type . '_ft_discount_facecard_title');
            $button_url = $this->get_field($this->post_type . '_ft_discount_button_url');
            $button_lable = $this->get_field($this->post_type . '_ft_discount_button_lable');
            $button_external = $this->get_field($this->post_type . '_ft_discount_button_external');
              
            $discount_facecard_section = [
                $title,
                $button_url,
                $button_lable,
                $button_external
            ];   
            
            $this->_fourth_cta_section = $discount_facecard_section;      
        }

        return $this->_fourth_cta_section;
    }

    public function fourth_deal_images()
    {

        if (!$this->_fourth_deal_images) {
            $title = $this->get_field($this->post_type . '_ft_deal_images_section_title');
            $description = $this->get_field($this->post_type . '_ft_deal_images_description');
            $images = $this->get_field($this->post_type . '_ft_deal_images');
            $deal_images_section = [
                "title" => $title,
                "description" => $description,
                "images" => $images,
            ];
            $this->_fourth_deal_images = $deal_images_section;      
        }

        return $this->_fourth_deal_images;
    }

    public function fourth_terms_and_conditions()
    {
        if (!$this->_fourth_terms_and_conditions_list) {

            $lable = $this->get_field($this->post_type . '_ft_terms_and_condition_lable');
            $description = $this->get_field($this->post_type . '_ft_terms_and_condition_desc');
            $terms_condition_list = $this->get_field($this->post_type . '_ft_terms_and_condition_list');
            $list = [
                "lable" => $lable,
                "description" => $description,
                "terms_condition_list" => $terms_condition_list,
            ]; 
            $this->_fourth_terms_and_conditions_list = $list;

        }

        return $this->_fourth_terms_and_conditions_list;
    }

    public function show_deals()
    {
        if(!$this->_show_deals_list) {
            $this->_show_deals_list = $this->get_field($this->post_type . '_show_deals');
        }
        
        return $this->_show_deals_list;
    }
}
