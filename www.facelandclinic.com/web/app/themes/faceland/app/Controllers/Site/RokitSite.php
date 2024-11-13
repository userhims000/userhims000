<?php

// Set the namespace
namespace Rokit\Controllers\Site;

// Include Timber objects
use Timber\Timber as Timber;
use Timber\Site as TimberSite;
use TimberHelper;
use Twig_Extension_StringLoader;
use Twig_Filter_Function;
use Timber\Twig_Function as Twig_Function;

// Include Rodesk objects
use Rokit\Controllers\Menu\Menu;
use Rokit\Frame\Seo\RokitSeo;
use Rokit\Frame\Request;
use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\SpecialistCollection;

/**
 * RokitSite class to extend the global TimberSite object to add context & extend Twig
 */

class RokitSite extends TimberSite {

    public function __construct() {
        add_filter('get_twig', [$this, 'addToTwig']);
        add_filter('timber_context', [$this, 'addToContext']);

        parent::__construct();
    }

    public function addToContext($data) {

        // Add small defaults to site contet
        $data['wp_title']       = $this->title(); // Add wp page title info to the global Timber context
        $data['date']           = $this->date(); // Add date info to the global Timber context
        $data['menu']           = $this->menus(); // Add menu info to the global Timber context
        $data['socials']        = $this->socials(); // Add social info to the global Timber context
        $data['contacts']       = $this->contacts(); // Add contact info to the global Timber context
        $data['header']         = $this->header(); // Add header info to the global Timber context
        $data['footer']         = $this->footer(); // Add footer info to the global Timber context
        $data['is_nl']         = $this->is_nl(); // Add footer info to the global Timber context
        $data['is_be']         = $this->is_be(); // Add footer info to the global Timber context
        $data['is_ch']         = $this->is_ch(); // Add footer info to the global Timber context
        $data['is_be_fr']         = $this->is_be_fr(); // Add footer info to the global Timber context
        $data['is_de']         = $this->is_de(); // Add footer info to the global Timber context
        $data['is_en']         = $this->is_en(); // Add footer info to the global Timber context
        $data['is_en_uk']         = $this->is_en_uk(); // Add footer info to the global Timber context
        $data['cookieDeclaration'] = $this->cookieDeclaration(); // Add CookieDeclaration info to the global Timber context
        $data['get_connected']  = $this->get_connected(); // Add contact info to the global Timber context
        $data['request']        = $this->request(); // Add custom request class to the global Timber context
        $data['logo_url']        = $this->logoURL(); // Add logo url to the site
        $data['newsletter']     = $this->newsletter(); // Add custom request class to the global Timber context
        $data['commentoptin']     = $this->commentoptin(); // Add custom request class to the global Timber context
        $data['fonts_link']     = rokit_asset_path('fonts/fonts.css'); // Add font path to site context
        $data['environment']    = env('WP_ENV'); // Add environment to site context
        $data['is_mobile']    = wp_is_mobile(); // Check if is a mobile screen
        $data['current_page_slug']    = $this->get_current_page_slug(); // Get current page slug
        $data['get_blog_post_type_slug']    = $this->get_blog_post_type_slug(); // Get current page slug
        $data['get_clinic_post_type_slug']    = $this->get_clinic_post_type_slug(); // Get current page slug
        $data['get_query_object']    = $this->get_query_object(); // Get current page slug
        $data['want_to_see_text']    = $this->get_option_want_to_see_text(); // Get current page slug
        $data['be_site_direction_popup']    = $this->be_site_direction_popup(); // Get current page slug
        $data['is_clinic_page']    = $this->is_clinic_page(); // check if clinic page     
        $data['webshop_url']    = get_field('webshop_url', 'option');
        $data['is_authenticate']    = is_user_logged_in();
        $data['snowflake_img_url']    = get_field('global_snowflake_image_url', 'option');
        $data['is_article']    = is_singular( 'article' );
        $data['g_translate_shortcode']    = do_shortcode('[gtransxlate]');
        $data['current_language_translated_page']  = $this->fetch_current_translated_page();
        $data['current_page_url']  = $this->fetch_current_page_url();
        $data['current_page_id']  = $this->fetch_current_page_id();
        $data['page_template_slug']  = get_page_template_slug( get_queried_object_id() );

        // Add single post to the global Timber context
        if( ( is_singular() || is_404() ) ) {

            // Add the post data to the context
            $data['post'] = $this->context_post();

            // Fetch the SEO data from the controller to Yoast plugin
            new RokitSeo( 'single' );

        // Add archive posts to the global Timber context
        } else if( is_post_type_archive() || is_search() || get_query_var('is_tag') == true ) {

            // Add the post data to the context
            $data['collection']    = $this->context_posts();

            // Add the pagination data to the context
            $data['pagination'] = Timber::get_pagination();

            // Fetch the SEO data from the controller to Yoast plugin
            new RokitSeo( 'archive' );

        // Add taxonomy data to the global Timber context
        } elseif( is_tax() ) {

            $data['taxonomy']  = $this->context_term();

            // Fetch the SEO data from the controller to Yoast plugin
            new RokitSeo( 'taxonomy' );
        }

        return $data;
    }

    /**
     * Add custom request class to global timber context
     */

    public function request() {

        return new Request();

    }

    /**
     * Add logo URL from the option page
     */

    public function logoURL() {

        $languageSpecificLogoURL = [
            'nl_logo_url' => get_field('logo_nl_url', 'option'),
            'be_logo_url' => get_field('logo_be_url', 'option'),
            'ch_logo_url' => get_field('logo_ch_url', 'option'),
            'fr_logo_url' => get_field('logo_fr_url', 'option'),
            'de_logo_url' => get_field('logo_de_url', 'option'),
            'worldwide_logo_url' => get_field('logo_worldwide_url', 'option')
        ];

        return $languageSpecificLogoURL;

    }

    /**
     * Add newsletterdata to global timber context
     */

    public function newsletter() {

        $current_lang = pll_current_language();

        if ($current_lang == 'ch') {
            //M0wxNU4zSErUNTGxMAYS5ha6SYlGlrqmRpaJZhapiRZp5oYA
            $form_id = get_field('newsletter_form_id_ch', 'option');
        } elseif ($current_lang == 'de'){
            //SzFLMkgyTzbQTbNMTNM1MTVI1k00SLTQNbNMTkk2MExMTk60AAA
            $form_id = get_field('newsletter_form_id_de', 'option');
        } elseif ($current_lang == 'be'){
            //SzJIMTBOS7PQTU1LTNY1sTQw0LUwtjTTNU4zM08xM0gxMzYzAgA
            $form_id = get_field('newsletter_form_id_be', 'option');
        } elseif ($current_lang == 'be-fr'){
            //SzNLSUoySjXXTUsysNQ1MTcw0E2yME7UNU5KTrNIs7S0SDU2AAA
            $form_id = get_field('newsletter_form_id_be_fr', 'option');
        } elseif ($current_lang == 'en'){
            //MzMzNzQ2NjfRNTJJMtA1MU820U0ySzbXNUw1TjE1NDO0SEw2AQA
            $form_id = get_field('newsletter_form_id_en', 'option');
        } elseif ($current_lang == 'en-gb'){
            //MzMzNzQ2NjfRNTJJMtA1MU820U0ySzbXNUw1TjE1NDO0SEw2AQA
            $form_id = get_field('newsletter_form_id_en_gb', 'option');
        } else {
            $form_id = get_field('newsletter_form_id_nl', 'option');
            //SzWwsDBNMTLVNTU2T9E1MU6y1LVMMbbUNUqxMEqyMEhNM01JBQA
        }

        $account = 'MzawMDE3MzMxBwA';

        $webshop = '';
        $script = sprintf("<!-- SharpSpring Form for Nieuwsbrief %s| %s -->", $webshop, $current_lang);
        $script .= '<script type="text/javascript">';
        $script .= sprintf("var ss_form = {'account': '%s', 'formID': '%s'};", $account, $form_id);
        $script .= "ss_form.width = '100%';";
        $script .= "ss_form.height = '1000';";
        $script .= "ss_form.domain = 'app-3QNJIEKQ16.marketingautomation.services';";
        $script .= "// ss_form.hidden = {'field_id': 'value'}; // Modify this for sending hidden variables, or overriding values";
        $script .= "// ss_form.target_id = 'target'; // Optional parameter: forms will be placed inside the element with the specified id";
        $script .= "// ss_form.polling = true; // Optional parameter: set to true ONLY if your page loads dynamically and the id needs to be polled continually.";
        $script .= "</script>";
        $script .= '<script type="text/javascript" src="https://koi-3QNJIEKQ16.marketingautomation.services/client/form.js?ver=2.0.1"></script>';


        return [
            'title'     => get_field('newsletter_title', 'option'),
            'subtitle'  => get_field('newsletter_subtitle', 'option'),
            'form'    => $script,
            'show_newsletter_form' => [
                'show_nl' => get_field('show_button_nl', 'option'), 
                'show_be' => get_field('show_button_be', 'option'), 
                'show_ch' =>   get_field('show_button_ch', 'option'), 
                'show_be_fr' =>  get_field('show_button_be_fr', 'option'), 
                'show_de' => get_field('show_button_de', 'option'),
                'show_en' => get_field('show_button_en', 'option'),
                'show_en_gb' => get_field('show_button_en_gb', 'option')
            ],
        ];
    }

    /**
     * Add newsletterdata to global timber context
     */
    public function commentoptin() {

        return strip_tags(str_replace('"', "'", get_field('comment_optin', 'option')), '<a>');

    }

    /**
     * Add taxonomy posts to the global Timber context
     */

    public function context_term() {

        $controller   = rokit_timber_term_class();
        $term         = new $controller();

        return $term;

    }

    /**
     * Add archive posts to the global Timber context
     */

    public function context_posts() {

        $controller   = rokit_timber_collection_class();
        $post         = new $controller();

        return $post;

    }

    /**
     * Add single post to the global Timber context
     */

    public function context_post() {

        $controller   = rokit_timber_type_class();
        $post         = new $controller();

        return $post;

    }

    /**
     * Add menu data to the global Timber context
     */

    public function menus() {
        $appointmentButtonLable = ''; $appointmentButtonURL = ''; $appointmentButtonExternal = '';
        $krestButtonURL = ''; $krestButtonExternalURL = ''; $krestButtonLabel = '';
        if ( is_page_template( 'templates/page-worlwide.php' ) ) {
            $appointmentButtonLable = get_field('book_consulation_label', 'option');
            $appointmentButtonURL = get_field('book_consulation_url', 'option');
            $appointmentButtonExternal = get_field('book_consulation_external', 'option');
            $worldwide = true;
        }else {
            if(pll_current_language('slug') == 'nl'){
                $appointmentButtonLable = get_field('nl_book_consulation_lable', 'option');
                $appointmentButtonURL = get_field('nl_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('nl_book_consulation_external', 'option');
                $krestButtonLabel = get_field('nl_krest_button_label', 'option');
                $krestButtonURL = get_field('nl_krest_button_url', 'option');
                $krestButtonExternalURL = get_field('nl_krest_button_external', 'option');
            }elseif(pll_current_language('slug') == 'be') {
                $appointmentButtonLable = get_field('be_book_consulation_lable', 'option');
                $appointmentButtonURL = get_field('be_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('be_book_consulation_external', 'option');
            }elseif(pll_current_language('slug') == 'ch') {
                $appointmentButtonLable = get_field('ch_book_consulation_lable', 'option');
                $appointmentButtonURL = get_field('ch_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('ch_book_consulation_external', 'option');
                $krestButtonLabel = get_field('ch_krest_button_label', 'option');
                $krestButtonURL = get_field('ch_krest_button_url', 'option');
                $krestButtonExternalURL = get_field('ch_krest_button_external', 'option');
            }elseif(pll_current_language('slug') == 'be-fr') {
                $appointmentButtonLable = get_field('be_fr_book_consulation_lable', 'option');
                $appointmentButtonURL = get_field('be_fr_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('be_fr_book_consulation_external', 'option');
            }elseif(pll_current_language('slug') == 'de') {
                $appointmentButtonLable = get_field('de_book_consulation_lable', 'option');
                $appointmentButtonURL = get_field('de_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('de_book_consulation_external', 'option');
                $krestButtonLabel = get_field('de_krest_button_label', 'option');
                $krestButtonURL = get_field('de_krest_button_url', 'option');
                $krestButtonExternalURL = get_field('de_krest_button_external', 'option');
            }elseif(pll_current_language('slug') == 'en') {
                $appointmentButtonLable = get_field('book_consulation_label', 'option');
                $appointmentButtonURL = get_field('book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('book_consulation_external', 'option');
            }elseif(pll_current_language('slug') == 'en-gb') {
                $appointmentButtonLable = get_field('en_gb_book_consulation_label', 'option');
                $appointmentButtonURL = get_field('en_gb_book_consulation_url', 'option');
                $appointmentButtonExternal = get_field('en_gb_book_consulation_external', 'option');
            }
            $worldwide = false; 
        }
        $menu = [
            'main' => new Menu( 'main ' . pll_current_language('slug') ),
            'lang' => rokit_get_menu(),
            'page_wordwide' => $worldwide,
            'shop' => new Menu( 'shop ' . pll_current_language('slug') ),
            'worldwide' => new Menu( 'worldwide ' . pll_current_language('slug') ),
            'mobile_menu' => new Menu( 'mobile ' . pll_current_language('slug') ),
            'appointment' => [
                'label' => $appointmentButtonLable ? pll__($appointmentButtonLable) : '',
                'url' => $appointmentButtonURL ? $appointmentButtonURL : '',
                'external' => $appointmentButtonExternal ? $appointmentButtonExternal : ''
            ],
            'krest_deals' => [
                'label' => $krestButtonLabel,
                'url' => $krestButtonURL ? $krestButtonURL : '',
                'external' => $krestButtonExternalURL ? $krestButtonExternalURL : ''
            ]
        ];

        return $menu;
    }


    /**
     * Add social info to the global Timber context
     */

    public function socials() {
        $socials = [];
        // Get global social settings
        foreach (rokit_get_language_settings()['socials'] as $key => $value) {
            if ($value){
                $socials[$key] = [ 'url' => get_field( $key . '_url','option'), 'show_url_worldwide' => get_field( 'show_'.$key.'_worldwide','option') ];
            }
        }
        return $socials;

    }

    /**
     * Add social info to the global Timber context
     */

    public function contacts() {

        $contacts['visit'] = [
            'street'        => get_field('contact_street','option'),
            'zip'           => get_field('contact_zip','option'),
            'city'          => get_field('contact_city','option'),
            'country'       => get_field('contact_country','option')
        ];

        $contacts['post'] = [
            'name'          => get_field('post_name','option'),
            'street'        => get_field('post_street','option'),
            'zip'           => get_field('post_zip','option'),
            'city'          => get_field('post_city','option'),
            'country'       => get_field('post_country','option'),
        ];

        $contacts['online'] = $this->contacts_online();

        return $contacts;

    }

    /**
     * Add header info to the global Timber context
     */

    public function header() {

        if($show = get_field('header_button_show','option') ) {
            $header['buttons'] = [
                'sign_in'   => get_field('header_login_button','option'),
                'register'  => get_field('header_register_button','option')
            ];
        }

        if (!empty($header)){
            return $header;
        }

    }

    /**
     * Add footer info to the global Timber context
     */

    public function footer() {
        if(is_page_template('templates/page-worlwide.php')){
            $footer_top['wordwide_about'] = [
                'title'     => get_field('footer_worldwide_about_title','option'),
                'urls'      => get_field('footer_worldwide_about_urls','option')
            ];
            $footer_top['wordwide_info'] = [
                'title'     => get_field('footer_worldwide_info_title','option'),
                'urls'      => get_field('footer_worldwide_info_urls','option')
            ];
            $footer_top['wordwide_service'] = [
                'title'     => get_field('footer_worldwide_service_title','option'),
                'urls'      => get_field('footer_worldwide_service_urls','option')
            ];
            $footer_top['socials'] = [
                'socials' => true
            ];
        }
        else {
            $footer_top['about'] = [
                'title'     => get_field('footer_about_title','option'),
                'urls'      => get_field('footer_about_urls','option')
            ];

            $footer_top['info'] = [
                'title'     => get_field('footer_info_title','option'),
                'urls'      => get_field('footer_info_urls','option')
            ];

            $footer_top['service'] = [
                'title'     => get_field('footer_service_title','option'),
                'urls'      => get_field('footer_service_urls','option')
            ];
            $footer_top['socials'] = [
                'socials' => true
            ];
        }


        $footer['top'] = $footer_top;
        $footer['bottom'] = get_field('footer_bottom_urls','option');

        return $footer;

    }

    /**
     * Add is_nl info to the global Timber context
     */
    public function is_nl() {

        return (pll_current_language() == 'nl') ? true : false;;

    }

     /**
     * Add is_nl info to the global Timber context
     */
    public function is_en() {

        return (pll_current_language() == 'en') ? true : false;;

    }

    /**
     * Add is_be info to the global Timber context
     */
    public function is_be() {

        return (pll_current_language() == 'be') ? true : false;;

    }

    /**
     * Add is_ch info to the global Timber context
     */
    public function is_ch() {

        return (pll_current_language() == 'ch') ? true : false;;

    }

    /**
     * Add is_be_fr info to the global Timber context
     */
    public function is_be_fr() {

        return (pll_current_language() == 'be-fr') ? true : false;

    }

    /**
     * Add is_be_fr info to the global Timber context
     */
    public function is_de() {

        return (pll_current_language() == 'de') ? true : false;

    }

    /**
     * Add is_be_fr info to the global Timber context
     */
    public function is_en_uk() {

        return (pll_current_language() == 'en-gb') ? true : false;

    }

    /**
     * Get current page title
     */
    public function get_current_page_slug() {
        global $post;
        return is_object($post) ? $post->post_name : '';
    }

    /**
     * Check is_archive page in wordpress
     */
    public function get_blog_post_type_slug() {
        if ( is_post_type_archive( 'blog_article' )){
            return "true";
        }else{
            return "false";
        }
    }

    /**
     * Check is_archive page in wordpress
     */
    public function get_clinic_post_type_slug() {
        if ( is_single( 'location' )){
            return 'true';
        }else{
            return 'false';
        }
    }

    /**
     * Check Current page is taxonomy term page
     */
    public function get_query_object() {
        $queryObject = get_queried_object();

        return $queryObject;
    }

    /**
     * Add cookieDeclaration info to the global Timber context
     */

    public function cookieDeclaration() {

        $current_language = pll_current_language();
        $data_culture = 'nl';

        if($current_language = 'be'){
            $data_culture = 'nl';
        } else if ($current_language = 'de' || 'ch'){
            $data_culture = 'de';
        }

        $id = '728663b3-18d1-4fa3-a804-5658e0e8c18d';
        return sprintf('<script id="CookieDeclaration" data-culture="'. $data_culture .'" src="https://consent.cookiebot.com/'. $id .'/cd.js" type="text/javascript" async></script>', $data_culture, $id );

    }

    /**
     * Add social info to the global Timber context
     */

    function contacts_online() {

        $contacts_online['appointment'] = [
            'show'          => get_field('contact_online_appointment_show','option'),
            'image'         => get_field('contact_online_appointment_image','option'),
            'label'         => get_field('contact_online_appointment_label','option'),
            'show_label'    => get_field('contact_online_appointment_show_label','option'),
            'titles'        => get_field('contact_online_appointment_titles','option'),
            'popup'         => ['intro' => get_field('contact_online_appointment_popup_intro','option')],
            'featherlight'  => 'appointment'
        ];

        $contacts_online['phone']  = [
            'show'          => get_field('contact_online_phone_show','option'),
            'phone'         => get_field('contact_online_phone','option'),
            'image'         => get_field('contact_online_phone_image','option'),
            'show_label'    => get_field('contact_online_phone_show_label','option'),
            'label'         => get_field('contact_online_phone_label','option'),
            'titles'        => get_field('contact_online_phone_titles','option'),
            'popup'         => ['intro' => get_field('contact_online_phone_popup_intro','option')],
            'featherlight'  => 'phone'
        ];
        $contacts_online['chat']  = [
            'show'      => get_field('contact_online_chat_show','option'),
            'chat'      => get_field('contact_online_chat','option'),
            'image'     => get_field('contact_online_chat_image','option'),
            'show_label'      => get_field('contact_online_chat_show_label','option'),
            'label'     => get_field('contact_online_chat_label','option'),
            'titles'    => get_field('contact_online_chat_titles','option'),
            'open_chat' => 'chat'
        ];

        $contacts_online['whatsapp']  = [
            'show'          => get_field('contact_online_whatsapp_show','option'),
            'whatsapp'     => get_field('contact_online_whatsapp_whatsapp','option'),
            'image'         => get_field('contact_online_whatsapp_image','option'),
            'show_label'          => get_field('contact_online_whatsapp_show_label','option'),
            'label'         => get_field('contact_online_whatsapp_label','option'),
            'titles'        => get_field('contact_online_whatsapp_titles','option'),
            'popup'         => ['intro'   => get_field('contact_online_whatsapp_popup_intro','option')],
            'featherlight' => 'whatsapp'
        ];

        $contacts_online['messenger']  = [
            'show'          => get_field('contact_online_messenger_show','option'),
            'chat'          => get_field('contact_online_messenger','option'),
            'image'         => get_field('contact_online_messenger_image','option'),
            'show_label'          => get_field('contact_online_messenger_show_label','option'),
            'label'         => get_field('contact_online_messenger_label','option'),
            'titles'        => get_field('contact_online_messenger_titles','option'),
            'popup'         => ['intro' => get_field('contact_online_messenger_popup_intro','option')],
            'featherlight'  => 'messenger'
        ];

        $contacts_online['email']  = [
            'show'          => get_field('contact_online_email_show','option'),
            'email'          => get_field('contact_online_email','option'),
            'image'         => get_field('contact_online_email_image','option'),
            'show_label'    => get_field('contact_online_email_show_label','option'),
            'label'         => get_field('contact_online_email_label','option'),
            'titles'        => get_field('contact_online_email_titles','option'),
            'popup'         => ['intro' => get_field('contact_online_email_popup_intro','option')],
            'featherlight'  => 'email',
            'formid'        => get_field('contact_online_email_formid','option'),
        ];

        if (!empty($contacts_online['phone']['popup']['intro'])){
            // Compile phone popup info. {{phone}} will be parsed.
            $contacts_online['phone']['titles'] = rokit_compile($contacts_online['phone']['titles'], ['phone' => rokit_get_a_tag_aen_code(get_field('contact_online_phone', 'option'), true)]);
            $contacts_online['phone']['popup']['intro'] = rokit_compile($contacts_online['phone']['popup']['intro'], ['phone' => rokit_get_a_tag_aen_code(get_field('contact_online_phone', 'option'))]);
        }


        return $contacts_online;

    }

    function get_connected() {
        $connect =  [
            'small' => get_field('faq_archive_connect_small_title', 'option'),
            'big'   => get_field('faq_archive_connect_big_title', 'option')
        ];

        return $connect;
    }
    /**
     * Add WP title to the global Timber context
     */

    public function title() {

        $page_title = wp_title( '|', false, 'right' ); 

        $current_lang = pll_current_language();

        if( $current_lang == "ch" ){
            $title = $this->page_title($page_title);
        }else{
            $title = $page_title;
        }
        
        return $title;
    }

    /**
     * Add date info to the global Timber context
     */

    public function date() {

        /* Add extra data */
        $date = array(
            'year'  => date('Y'),
            'month' => date('m'),
            'day'   => date('d')
        );

        return $date;

    }

    /**
     * Add page string translation for the sepecific pages
     */

    public function page_title($page_title) {

        $page_string_title = ["Behandelingen", "Action Archief"];
        $string_updated_title = ["Behandlungen", "Aktionen"];

        $title = str_replace($page_string_title, $string_updated_title, $page_title);

        return $title;
    }

    /**
     * Add a custom Yoast filter to twig filters
     */

    public function addToTwig($twig) {

        // Add some custom filters
        $twig->addExtension(new Twig_Extension_StringLoader());
        $twig->addFilter('yoast_filter', new Twig_Filter_Function( [$this, 'yoast_filter'] ));
        $twig->addFilter('antispambot', new Twig_Filter_Function( [$this, 'antispambot'] ));
        $twig->addFilter('format_tel', new Twig_Filter_Function( 'rokit_tel_nr' ));
        $twig->addFilter('format_date', new Twig_Filter_Function( 'rokit_dateformat' ));
        $twig->addFilter('truncate', new Twig_Filter_Function( 'rokit_truncate' ));
        //$twig->addFilter('get_acedemy_list', new Twig_Filter_Function( [$this, 'get_acedemy_list'] ));

        if ( class_exists( 'WooCommerce' ) ) {
            $twig->addFilter('price_format', new Twig_Filter_Function( 'wc_price' ));
        }

        // Add some custom functions
        $twig->addFunction( new Twig_Function( 'rokit_asset_path', 'rokit_asset_path' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_attachment', 'rokit_get_attachment' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_ratio', 'rokit_get_ratio' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_image', 'rokit_get_image' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_image_alt', 'rokit_get_image_alt' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_static_image', 'rokit_get_static_image' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_view_name', 'rokit_get_view_name' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_news_description', 'rokit_get_news_description' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_treatment_bodypart', 'rokit_get_treatment_bodypart' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_post_permalink', 'rokit_get_post_permalink' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_query_param', 'rokit_get_query_param' ) );
        $twig->addFunction( new Twig_Function( 'rokit_is_decimal', 'rokit_is_decimal' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_image_id', 'rokit_get_image_id' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_image_id_img_carousel', 'rokit_get_image_id_img_carousel' ) );
        $twig->addFunction( new Twig_Function( 'rokit_get_image_width_height_attr', 'rokit_get_image_width_height_attr' ) );
        
        $twig->addFunction( new Twig_Function( '_n', '_n' ) );
        $twig->addFunction( new Twig_Function( 'get_acedemy_list', [$this, 'get_acedemy_list'] ) );
        $twig->addFunction( new Twig_Function( 'get_label_color', [$this, 'get_label_color'] ) );
        $twig->addFunction( new Twig_Function( 'google_map_locations', [$this, 'google_map_locations'] ) );

        return $twig;
    }

    /**
     * Add WP Antispambot filter
     */

    public function antispambot( $filter_content ) {

        $email = antispambot( $filter_content );

        return $email;
    }

    /**
     * List of the academy
     */

    public function get_acedemy_list( $post_id ) {
        $academy_title = get_field('academy_title', $post_id);
        $academy_date = get_field('academy_date', $post_id);
        $academy_treatments = get_field('academy_treatments', $post_id);
        $data = [];
        foreach( $academy_treatments as $postID ) {
            $data[] = [
                'price' => $postID['price'],
                'column_two' => ['title' => get_post($postID['column_two'])->post_title, 'link' => get_post_permalink($postID['column_two'])],
                'column_three' => ['title' => get_post($postID['column_three'])->post_title, 'link' => get_post_permalink($postID['column_three'])]  
            ];
        }
        $returnArray = [
            'academy_title' => $academy_title,
            'academy_date' => $academy_date,
            'academy_treatments' => $data   
        ];

        return $returnArray;
    }

    public function get_label_color($term_id, $taxonomy) {
        $labelColor = get_field('blog_article_taxonomy_color', $taxonomy.'_'.$term_id );
        return $labelColor;  
    }

    public function google_map_locations($locations) {
        $locations = LocationCollection::posts_by_id($locations);
        foreach($locations as $location){
            $latitude = $location->latitude();
            $longitude = $location->longitude();
            $locationTitle = $location->title();
            $locationStreet = $location->street();
            $locationCity = $location->city();
            $locationCountry = $location->country();
            $locationZipcode = $location->zipcode();
            $locationInformationp[] = [
                $locationTitle,
                $latitude,
                $longitude,
                $locationStreet,
                $locationZipcode,
                $locationCity,
                $locationCountry,
            ];
        }     
        //echo "<pre>"; print_r($locationInformationp); echo "</pre>";
        $locations = json_encode($locationInformationp);
        return $locations;  
    }


    /**
     * Create a custom Yoast filter to twig to filter out Yoast SEO comments
     */

    public function yoast_filter( $filter_content ) {
        if (!empty(get_plugins()['wordpress-seo/wp-seo.php'])){
            ob_start();
            echo $filter_content;
            $wp_head_output = ob_get_contents();
            ob_end_clean();

            $wp_head_output = str_replace('<!-- This site is optimized with the Yoast SEO plugin v'. get_plugins()['wordpress-seo/wp-seo.php']['Version'].' - https://yoast.com/wordpress/plugins/seo/ -->', '', $wp_head_output);
            $wp_head_output = str_replace('<!-- / Yoast SEO plugin. -->', '', $wp_head_output );
            $wp_head_output = str_replace(" class='yoast-schema-graph yoast-schema-graph--main'", '', $wp_head_output );

            return $wp_head_output;
        }
    }

    public function get_option_want_to_see_text(){

        $wantToSeeText = get_field('want_to_see_more_title', 'option');
        
        return $wantToSeeText;

    }

    public function be_site_direction_popup(){

        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));
        if (strpos($current_url, 'be-fr') !== false) {
            $beFrButtonURL = $current_url ? $current_url : get_field('second_button_url', 'option');
            $beLangURL = get_field('first_button_url', 'option');
        } elseif (strpos($current_url, 'be') !== false) {
            $beLangURL = $current_url ? $current_url : get_field('first_button_url', 'option');
            $beFrButtonURL = get_field('second_button_url', 'option');
        }

        $returnPopUpArray = [
            'title' => get_field('be_popup_title', 'option'),
            'description' => get_field('be_popup_description', 'option'),
            'buttons' => [
                'firstButtonLabel' => get_field('first_button_label', 'option'),
                'firstButtonURL' => $beLangURL,
                'firstButtonExternal' => get_field('first_button_external', 'option'),
                'secondButtonLabel' => get_field('second_button_label', 'option'),
                'secondButtonURL' => $beFrButtonURL,
                'secondButtonExternal' => get_field('second_button_external', 'option'),
            ]
        ];

        return $returnPopUpArray;

    }

    public function is_clinic_page() {
        if(is_singular( 'location' )){
            $cls = 'btn-align-center';
        }else{
            $cls = '';
        }
        return $cls; 
    }

    public function fetch_current_translated_page() {
        $currentPageID = get_queried_object_id();
        $queried_object = get_queried_object();
        $lang = pll_current_language();
        //echo $lang;
        if($lang == "nl") {
            $lang = "en";
        }elseif($lang == "en"){
            $lang = "nl";
        }

        // Check if Polylang function exists
        if (function_exists('pll_get_post') && function_exists('pll_current_language') && function_exists('pll_home_url') && function_exists('pll_get_term') ) {
            if ($queried_object instanceof \WP_Post) {
                // Get the translation ID of the current page in the specified language
                $translatedPageID = pll_get_post($currentPageID, $lang);
                // If translated page ID is found, get the URL
                if ($translatedPageID) {
                    $translatedPageURL = get_permalink($translatedPageID);
                    return $translatedPageURL;
                }
            }

            if ($queried_object instanceof \WP_Term) {
                $translatedTermID = pll_get_term($queried_object->term_id, $lang);
                if ($translatedTermID) {
                    $translatedTermURL = get_term_link($translatedTermID);
                    return $translatedTermURL;
                }
            }
        }

        // Return false if translation or URL not found
        return false;
    }

    public function fetch_current_page_url(){
        $currentPageID = get_queried_object_id();
        $queried_object = get_queried_object();
        if ($queried_object instanceof \WP_Post) {
            $link = get_permalink($currentPageID);
        }
        if ($queried_object instanceof \WP_Term) {
            $link = get_term_link($currentPageID);
        }
        return $link;
    }

    public function fetch_current_page_id(){
        $currentPageID = get_queried_object_id();
        $queried_object = get_queried_object();
        if ($queried_object instanceof \WP_Post) {
            $id = $currentPageID;
        }
        if ($queried_object instanceof \WP_Term) {
            $id = $currentPageID;
        }
        return $id;
    }
}

