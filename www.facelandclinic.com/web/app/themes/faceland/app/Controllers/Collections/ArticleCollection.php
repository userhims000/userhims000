<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class ArticleCollection extends PostCollection {

    protected static $postType = 'article';

    protected static $postClass = 'Rokit\Controllers\Types\Article';

    protected static $termClass = 'Rokit\Controllers\Terms\ArticleTaxonomyTerm';

    var $_cta;

    var $_items;

    var $_news_overview;

    var $_tag;

    var $_is_overview;

    var $_is_tag;

    static function author() {
        return get_field( static::$postType . '_archive_author', 'option');
    }

    public function cta(){
        if( ! $this->_cta ) {
            $cta = get_field( static::$postType . '_archive_cta', 'option');

            if(!empty($cta['button_label'])) {
                $cta['button'] = [
                    'label' => $cta['button_label'],
                    'url' => $cta['button_url'],
                    'external' => $cta['external']
                ];

                unset($cta['button_label']);
            }

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public function items(){
        if( ! $this->_items ) {
            if(is_user_logged_in()){
                $tag = static::$postType . '_tag';
            }else{
                $tag = static::$postType . '_taxonomy';
            }
            $this->_items = empty(get_query_var($tag)) ? self::all() : $this->posts();
        }

        return $this->_items;
    }

    public static function terms() {

        $types = [];
        $tag = static::$postType . '_tag';
        $terms = get_terms($tag);

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new static::$termClass($term->term_id);
            }
        }

        return $types;

    }

    public static function filter() {
        $tag = static::$postType . '_tag';
        return [
            'all' => [
                'name'   => pll__('Alles'),
                'url'    => self::url(),
                'active' => empty(get_query_var($tag))
            ],
            'options' => static::terms()
        ];

    }

    public function news_overview(){

        if( ! $this->_news_overview ) {
            $args = [
                'posts_per_page'=>3,
                'order'=>'ASC',
                'orderby' => 'menu_order'
            ];

            $this->_news_overview =  [
                'panorama' => [
                    'title'     => get_field('news_archive_panorama_titles_title', 'option'),
                    'subtitle'  => get_field('news_archive_panorama_titles_subtitle', 'option'),
                    'show'      => get_field('news_archive_panorama_show_image', 'option'),
                    'image'     => get_field('news_archive_panorama_image', 'option'),
                ],
                'blog' => [
                    'titles' => [
                        'title' => get_field('news_archive_blog_title', 'option'),
                        'intro' => get_field('news_archive_blog_subtitle', 'option')
                    ],
                    'button' => [
                        'url'   => BlogArticleCollection::url(),
                        'label' => pll__('Alle blogposts')
                    ],
                    'posts' => BlogArticleCollection::query($args)
                ],
                'article' => [
                    'titles' => [
                        'title' => get_field('news_archive_article_title', 'option'),
                        'intro' => get_field('news_archive_article_subtitle', 'option')
                    ],
                    'button' => [
                        'url'   => ArticleCollection::url(),
                        'label' => pll__('Alle updates')
                    ],
                    'posts' => !empty($posts = get_field('news_archive_article_items', 'option')) ? $posts : ArticleCollection::query($args)
                ],
                'video' => [
                    'titles' => [
                        'title' => get_field('news_archive_video_title', 'option'),
                        'intro' => get_field('news_archive_video_subtitle', 'option')
                    ],
                    'button' => [
                        'url'   => VideoCollection::url(),
                        'label' => pll__("Alle video's")
                    ],
                    'posts' => VideoCollection::query([
                        'posts_per_page'=>5,
                        'order'=>'ASC',
                        'orderby' => 'menu_order'
                    ])
                ],
                'cta' => get_field('news_archive_cta', 'option')
            ];

            if(!empty($button_label = get_field('news_archive_cta_button_label', 'option'))) {
                $this->_news_overview['cta']['button'] = [
                    'label' => $button_label,
                    'url' => get_field('news_archive_cta_button_url', 'option'),
                    'external' => get_field('news_archive_cta_button_external', 'option')
                ];
            }
        }

        return $this->_news_overview;
    }

    public function tag(){

        if( ! $this->_tag ) {
            if (!empty( $term = rokit_exists_taxonomy_by_name(get_query_var('name'), get_query_var('term_name')))){
                $args = [
                    'posts_per_page'=> -1,
                    'tax_query' => [
                        [
                            'taxonomy'  => get_query_var('term_name'),
                            'field'     => 'term_id',
                            'terms'     => $term->term_id,
                        ]
                    ],
                    'order'=>'ASC',
                    'orderby' => 'menu_order'
                ];

                $this->_tag =  [
                    'panorama' => [
                        'title'     => sprintf('%s %s', pll__('Blogpost'), $term->name),
                        'is_tag'    => true,
                        'button'    => [
                            'url'       => get_query_var('type') == 'article' ? ArticleCollection::url() : BlogArticleCollection::url(),
                            'label'     => pll__('TERUG NAAR ALLE BLOGPOSTS')
                        ]
                    ],
                    'items' =>   get_query_var('type') == 'article' ? ArticleCollection::query($args) : BlogArticleCollection::query($args)  ,
                ];
            }
        }

        return $this->_tag;
    }

    public function is_overview() {
        if(!$this->_is_overview) {
            $this->_is_overview = !empty(get_query_var('news_overview')) ? true : false;
        }
        return $this->_is_overview;
    }

    public function is_tag() {
        if(!$this->_is_tag) {
            $this->_is_tag = !empty(get_query_var('is_tag')) ? true : false;
        }
        return $this->_is_tag;
    }

}
