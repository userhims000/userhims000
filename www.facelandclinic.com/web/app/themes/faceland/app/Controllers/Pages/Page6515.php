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

class Page6515 extends Page {

    protected static $postType = 'page';

    var $_items;

    var $_cta;

    public function items() {

        if( ! $this->_items ) {
            $this->_items = $this->get_field( static::$postType .'_items' );
        }

        return $this->_items;
    }

    public function cta() {

        if( ! $this->_cta ) {
            $cta = $this->get_field( static::$postType .'_cta' );

            $this->_cta = [
                'title'     => !empty($cta['title']) ? $cta['title'] : false,
                'subtitle'  => !empty($cta['subtitle']) ? $cta['subtitle'] : false,
                'button'    => [
                    'label' => !empty($cta['button_label']) ? $cta['button_label'] : false
                ],
            ];
        }

        return $this->_cta;
    }

}
