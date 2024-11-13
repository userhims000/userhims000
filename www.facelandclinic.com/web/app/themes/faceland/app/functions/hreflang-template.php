<?php 
//add_action('rodesk_head', 'wp_custom_head');
function wp_custom_head() {
    global $wp;
    if(is_front_page()){
        $siteURL = str_replace('cms','', get_site_url());
        $hreflangs =  Array
        (
            'nl-nl' => $siteURL."nl/",
            'nl-be' => $siteURL."be/",
            'de-de' => "https://www.facelandgermany.com",
            'de-ch' => $siteURL."ch/",
            'en-gb' => $siteURL."worldwide/",
            "x-default" => $siteURL,
        );
        foreach ( $hreflangs as $lang => $url ) {
            printf( '<link rel="alternate" hreflang="%s" href="%s" />' . "\n", esc_attr( $lang ), esc_url( $url ) );
        }
    }
    if(!is_front_page()){
        global $post;
        $post_slug = $post->post_name;
        $siteURL = str_replace('cms','', get_site_url());
        $new_page_slug_array = [
            'fronsrimpel' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/fronsrimpel/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/fronsrimpel/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/zornesfalten-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/zornesfalten-entfernen/',
                "x-default" => home_url( $wp->request ),
            ],
            'zornesfalten-entfernen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/fronsrimpel/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/fronsrimpel/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/zornesfalten-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/zornesfalten-entfernen/',
                "x-default" => home_url( $wp->request ),
            ],
            'rimpels-voorhoofd' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/rimpels-voorhoofd',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/rimpels-voorhoofd/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/stirnfalten/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/stirnfalten/',
                "x-default" => home_url( $wp->request ),
            ],
            'stirnfalten' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/rimpels-voorhoofd',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/rimpels-voorhoofd/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/stirnfalten/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/stirnfalten/',
                'x-default' => home_url( $wp->request ),
            ],
            'kraaienpootjes' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/kraaienpootjes/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/kraaienpootjes/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/kraehenfuesse-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/kraehenfuesse-entfernen/',
                'x-default' => home_url( $wp->request ),
            ],
            'kraehenfuesse-entfernen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/kraaienpootjes/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/kraaienpootjes/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/kraehenfuesse-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/kraehenfuesse-entfernen/',
                'x-default' => home_url( $wp->request ),
            ],
            'wenkbrauwlift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/wenkbrauwlift/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/wenkbrauwlift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/augenbrauenlifting/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/augenbrauenlifting/',
                'x-default' => home_url( $wp->request ),
            ],
            'augenbrauenlifting' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/wenkbrauwlift/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/wenkbrauwlift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/augenbrauenlifting/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/augenbrauenlifting/',
                'x-default' => home_url( $wp->request ),
            ],
            'face-slimming' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/face-slimming/',
                'x-default' => home_url( $wp->request ),
            ],
            'lip-flip' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/lip-flip/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/lip-flip/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/lip-flip/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/lip-flip/',
                'x-default' => home_url( $wp->request ),
            ],
            'hyperhidrose-behandeling' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/hyperhidrose-behandeling/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/hyperhidrose-behandeling/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/hyperhidrose-behandlung/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/hyperhidrose-behandlung/',
                'x-default' => home_url( $wp->request ),
            ],
            'hyperhidrose-behandlung' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/hyperhidrose-behandeling/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/hyperhidrose-behandeling/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/hyperhidrose-behandlung/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/hyperhidrose-behandlung/',
                'x-default' => home_url( $wp->request ),
            ],
            'migraine-behandeling' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/migraine-behandeling/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/migraine-behandeling/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/migraene-behandlung/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/migraene-behandlung/',
                'x-default' => home_url( $wp->request ),
            ],
            'migraene-behandlung' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/migraine-behandeling/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/migraine-behandeling/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/migraene-behandlung/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/migraene-behandlung/',
                'x-default' => home_url( $wp->request ),
            ],
            'bunny-lines' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/bunny-lines/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/bunny-lines/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/bunny-lines/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/bunny-lines/',
                'x-default' => home_url( $wp->request ),
            ],
            'gummy-smile' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/gummy-smile/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/gummy-smile/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/gummy-smile-korrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/gummy-smile-korrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'gummy-smile-korrektur' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/gummy-smile/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/gummy-smile/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/gummy-smile-korrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/gummy-smile-korrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'neuslift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/neuslift/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/neuslift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/nasenlift/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/nasenlift/',
                'x-default' => home_url( $wp->request ),
            ],
            'nasenlift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/neuslift/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/neuslift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/nasenlift/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/nasenlift/',
                'x-default' => home_url( $wp->request ),
            ],
            'hangende-mondhoeken' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/hangende-mondhoeken/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/hangende-mondhoeken/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/mundwinkellifting/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/mundwinkellifting/',
                'x-default' => home_url( $wp->request ),
            ],
            'mundwinkellifting' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/hangende-mondhoeken/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/hangende-mondhoeken/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/mundwinkellifting/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/mundwinkellifting/',
                'x-default' => home_url( $wp->request ),
            ],
            'rimpels-nek' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/rimpels-nek',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/rimpels-nek/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/falten-am-hals/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/falten-am-hals/',
                'x-default' => home_url( $wp->request ),
            ],
            'falten-am-hals' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/rimpels-nek',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/rimpels-nek/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/falten-am-hals/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/falten-am-hals/',
                'x-default' => home_url( $wp->request ),
            ],
            'spierontspanners-kaaklijn' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/spierontspanners-kaaklijn/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/spierontspanners-kaaklijn/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/nefertiti-lift/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/nefertiti-lift/',
                'x-default' => home_url( $wp->request ),
            ],
            'nefertiti-lift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/spierontspanners-kaaklijn/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/spierontspanners-kaaklijn/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/nefertiti-lift/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/nefertiti-lift/',
                'x-default' => home_url( $wp->request ),
            ],
            'fillers-neus' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/spierontspanners-neus/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/spierontspanners-neus/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/liquid-nasenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/liquid-nasenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'liquid-nasenkorrektur' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/spierontspanners-neus/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/spierontspanners-neus/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/liquid-nasenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/liquid-nasenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'full-face-treatment' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/full-face-treatment/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/full-face-treatment/',
                'x-default' => home_url( $wp->request ),
            ],
            'liquid-facelift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/liquid-facelift/',
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/liquid-facelift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/liquid-nasenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/liquid-facelift/',
                'x-default' => home_url( $wp->request ),
            ],
            'lip-fillers' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/lip-fillers/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/lip-fillers/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/lippen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/lippen-aufspritzen',
                'x-default' => home_url( $wp->request ),
            ],
            'lippen-aufspritzen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/lip-fillers/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/lip-fillers/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/lippen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/lippen-aufspritzen',
                'x-default' => home_url( $wp->request ),
            ],
            'ingevallen-wangen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/ingevallen-wangen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/ingevallen-wangen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/wangen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/wangen-aufspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'wangen-aufspritzen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/ingevallen-wangen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/ingevallen-wangen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/wangen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/wangen-aufspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'neuslippenplooi' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/neuslippenplooi/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/neuslippenplooi/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/nasolabialfalte-unterspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/nasolabialfalte-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'nasolabialfalte-unterspritzen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/neuslippenplooi/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/neuslippenplooi/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/nasolabialfalte-unterspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/nasolabialfalte-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'marionetlijnen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/marionetlijnen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/marionetlijnen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/marionettenfalten-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/marionettenfalten-entfernen/',
                'x-default' => home_url( $wp->request ),
            ],
            'marionettenfalten-entfernen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/marionetlijnen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/marionetlijnen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/marionettenfalten-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/marionettenfalten-entfernen/',
                'x-default' => home_url( $wp->request ),
            ],
            'rokerslijntjes' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/rokerslijntjes/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/rokerslijntjes/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/raucherfalten/',
                'de-ch' => $siteURL.'ch/behandlung/filler/raucherfalten/',
                'x-default' => home_url( $wp->request ),
            ],
            'traangoot-filler' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/traangoot-filler/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/traangoot-filler/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/augenringe-unterspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/augenringe-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'augenringe-unterspritzen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/traangoot-filler/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/traangoot-filler/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/augenringe-unterspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/augenringe-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'kaaklijn-fillers' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/kaaklijn-fillers/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/kaaklijn-fillers/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/jawline-unterspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/jawline-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'jukbeenderen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/jukbeenderen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/jukbeenderen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/jochbein-unterspritzen/',
                'de-ch' => $siteURL.'/ch/behandlung/filler/jochbein-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'jochbein-unterspritzen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/jukbeenderen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/jukbeenderen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/jochbein-unterspritzen/',
                'de-ch' => $siteURL.'/ch/behandlung/filler/jochbein-unterspritzen/',
                'x-default' => home_url( $wp->request ),
            ],
            'kin' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/kin/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/kin/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/kinnkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/filler/kinnkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'kinnkorrektur' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/kin/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/kin/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/kinnkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/filler/kinnkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'oorlelcorrectie' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/oorlelcorrectie/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/oorlelcorrectie/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/ohrlaeppchenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/filler/ohrlaeppchenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'ohrlaeppchenkorrektur' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/oorlelcorrectie/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/oorlelcorrectie/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/ohrlaeppchenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/filler/ohrlaeppchenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'neusbrug' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/neusbrug/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/neusbrug/',
                'de-ch' => $siteURL.'ch/behandlung/filler/nasenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'nasenkorrektur' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/neusbrug/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/neusbrug/',
                'de-ch' => $siteURL.'ch/behandlung/filler/nasenkorrektur/',
                'x-default' => home_url( $wp->request ),
            ],
            'profhilo' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/profhilo/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/profhilo/',
                'de-ch' => $siteURL.'ch/behandlung/filler/profhilo/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/profhilo',
                'x-default' => home_url( $wp->request ),
            ],
            'handen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/handen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/handen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/faltige-haende/',
                'de-ch' => $siteURL.'ch/behandlung/filler/faltige-haende/',
                'x-default' => home_url( $wp->request ),
            ],
            'faltige-haende' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/handen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/handen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/faltige-haende/',
                'de-ch' => $siteURL.'ch/behandlung/filler/faltige-haende/',
                'x-default' => home_url( $wp->request ),
            ],
            'body-butt-tightening' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/body-butt-tightening/',
                'x-default' => home_url( $wp->request ),
            ],
            'hals-en-decollete' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/hals-en-decollete/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/hals-en-decollete/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/hals-straffen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/hals-straffen/',
                'x-default' => home_url( $wp->request ),
            ],
            'ingevallen-slapen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/ingevallen-slapen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/ingevallen-slapen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/eingefallene-schlaefen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/eingefallene-schlaefen/',
                'x-default' => home_url( $wp->request ),
            ],
            'eingefallene-schlaefen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/ingevallen-slapen/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/ingevallen-slapen/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/eingefallene-schlaefen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/eingefallene-schlaefen/',
                'x-default' => home_url( $wp->request ),
            ],
            'hyalase' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/hyalase/',
                'nl-be' => $siteURL.'be/behandelingen/fillers/hyalase/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/hyalase/',
                'de-ch' => $siteURL.'ch/behandlung/filler/hyalase/',
                'x-default' => home_url( $wp->request ),
            ],
            'bovenooglidcorrectie' => [
                'nl-nl' => $siteURL.'nl/behandelingen/ooglidcorrectie-facelift/bovenooglidcorrectie/',
                'nl-be' => $siteURL.'be/behandelingen/chirurgie/bovenooglidcorrectie/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/oberlidstraffung/',
                'de-ch' => $siteURL.'ch/behandlung/chirurgie/augenlidstraffung/',
                'x-default' => home_url( $wp->request ),
            ],
            'augenlidstraffung' => [
                'nl-nl' => $siteURL.'nl/behandelingen/ooglidcorrectie-facelift/bovenooglidcorrectie/',
                'nl-be' => $siteURL.'be/behandelingen/chirurgie/bovenooglidcorrectie/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/oberlidstraffung/',
                'de-ch' => $siteURL.'ch/behandlung/chirurgie/augenlidstraffung/',
                'x-default' => home_url( $wp->request ),
            ],
            'schaamlipcorrectie' => [
                'nl-nl' => $siteURL.'nl/behandelingen/chirurgie/schaamlipcorrectie/',
                'de-ch' => $siteURL.'ch/behandlung/chirurgie/schamlippenverkleinerung/',
                'en-gb' => $siteURL.'nl/worldwide-labia-surgery/',
                'x-default' => $siteURL.'nl/worldwide-labia-surgery/',
            ],
            'worldwide-labia-surgery' => [
                'nl-nl' => $siteURL.'nl/behandelingen/chirurgie/schaamlipcorrectie/',
                'de-ch' => $siteURL.'ch/behandlung/chirurgie/schamlippenverkleinerung/',
                'en-gb' => $siteURL.'nl/worldwide-labia-surgery/',
                'x-default' => $siteURL.'nl/worldwide-labia-surgery/',
            ],
            'facelift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/ooglidcorrectie-facelift/facelift/',
                'x-default' => home_url( $wp->request ),
            ],
            'borstvergroting' => [
                'nl-nl' => $siteURL.'nl/behandelingen/borstcorrectie/borstvergroting/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/brustvergroesserung/',
                'x-default' => home_url( $wp->request ),
            ],
            'borstlift' => [
                'nl-nl' => $siteURL.'nl/behandelingen/borstcorrectie/borstlift/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/brustlifting/',
                'x-default' => home_url( $wp->request ),
            ],
            'prothesewissel' => [
                'nl-nl' => $siteURL.'nl/behandelingen/borstcorrectie/prothesewissel/',
                'x-default' => home_url( $wp->request ),
            ],
            'onderooglidcorrectie' => [
                'nl-nl' => $siteURL.'nl/behandelingen/ooglidcorrectie-facelift/onderooglidcorrectie/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/untere-augenlidstraffung/',
                'x-default' => home_url( $wp->request ),
            ],
            'brustverkleinerung' => [
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/chirurgie/brustverkleinerung',
                'x-default' => home_url( $wp->request ),
            ],
            'lip-fillers' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/lip-fillers/', 
                'nl-be' => $siteURL.'be/behandelingen/fillers/lip-fillers/', 
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/lippen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/lippen-aufspritzen', 
                'x-default' => home_url( $wp->request ),
            ],
            'ingevallen-wangen' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/ingevallen-wangen/', 
                'nl-be' => $siteURL.'be/behandelingen/fillers/ingevallen-wangen/', 
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/filler/wangen-aufspritzen/',
                'de-ch' => $siteURL.'ch/behandlung/filler/wangen-aufspritzen/', 
                'x-default' => home_url( $wp->request ),
            ],
            'fillers-neus' => [
                'nl-nl' => $siteURL.'nl/behandelingen/fillers/fillers-neus/', 
                'nl-be' => $siteURL.'be/behandelingen/fillers/fillers-neus/', 
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/liquid-nasenkorrektur/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/liquid-nasenkorrektur/', 
                'x-default' => home_url( $wp->request ),
            ],
            'kraaienpootjes-spierontspanners' => [
                'nl-nl' => $siteURL.'nl/behandelingen/spierontspanners/kraaienpootjes-spierontspanners/', 
                'nl-be' => $siteURL.'be/behandelingen/spierontspanners/kraaienpootjes/',
                'de-de' => 'https://facelandclinic.com/de/betreibergesellschaft/behandlung/muskelrelaxans/kraehenfuesse-entfernen/',
                'de-ch' => $siteURL.'ch/behandlung/botulinum/kraehenfuesse-entfernen/', 
                'x-default' => home_url( $wp->request ),
            ],
        ];


        if (!array_key_exists($post_slug,$new_page_slug_array)){
            global $wp;
            $url = home_url( add_query_arg( array(), $wp->request ) );
            $current_lang = pll_current_language();
            if($current_lang == 'nl'){
                $lang = 'nl-nl';
            }elseif($current_lang == 'be'){
                $lang = 'nl-be';
            }elseif($current_lang == 'ch'){
                $lang = 'de-ch';
            }
            printf( '<link rel="alternate" hreflang="%s" href="%s" />' . "\n", esc_attr( $lang ), esc_url( $url ) );
        }else{
            $hreflangs = $new_page_slug_array[$post_slug];

            foreach ( $hreflangs as $lang => $url ) {
                printf( '<link rel="alternate" hreflang="%s" href="%s" />' . "\n", esc_attr( $lang ), esc_url( $url ) );
            }
        }
    }


}
?>