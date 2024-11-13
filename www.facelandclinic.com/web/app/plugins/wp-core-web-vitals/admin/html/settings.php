<?php namespace WPCWV; ?>
<div id="vwc_toast">
    <div><b id="toasttitle"></b></div>
    <div id="toasttext"></div>
</div>
<div class="wrap" id="wp_cwv_admin_main">
    <!--  <h1> Core Web Vitals Settings</h1> -->
    <div class="cwv-grid">
        <div>
            <div class="cwv-logo"> <img width="140" height="30" src="<?php echo WP_CWV_PLUGIN_DIR;?>/admin/img/cwv_logo_plugin.png"></div>
            <ul class="cwv-tab-bar">
                <li data-tab="#tabs-1" class="active">
                    <svg class="icon">
                        <use xlink:href="#icon-dashboard"></use>
                    </svg>
                    <div class="ti">Dashboard</div>
                    <div class="he">Main info, account and help</div>
                </li>
                <li data-tab="#tabs-4">
                    <svg class="icon">
                        <use xlink:href="#icon-css3"></use>
                    </svg>
                    <div class="ti">Critical CSS</div>
                    <div class="he">Minfify, combine & Critical CSS</div>
                </li>
                <li data-tab="#tabs-3">
                    <svg class="icon">
                        <use xlink:href="#icon-images"></use>
                    </svg>
                    <div class="ti">Images</div>
                    <div class="he">Lazy load, rendering</div>
                </li>
                <li data-tab="#tabs-2">
                    <svg class="icon">
                        <use xlink:href="#icon-options"></use>
                    </svg>
                    <div class="ti">Page options</div>
                    <div class="he">Caching, preloading and minify</div>
                </li>
                <li data-tab="#tabs-5">
                    <svg class="icon">
                        <use xlink:href="#icon-scripts"></use>
                    </svg>
                    <div class="ti">Scripts</div>
                    <div class="he">Optimize, defer & minfiy</div>
                </li>
                <li data-tab="#tabs-6">
                    <svg class="icon">
                        <use xlink:href="#icon-expert"></use>
                    </svg>
                    <div class="ti">Developper</div>
                    <div class="he">Advanced Core Web Vitals</div>
                </li>
            </ul>
        </div>
        <form method="post" action="options.php" id="criticaloptions">
            <div class="cwv-tab-panel" id="tabs-1">
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-dashboard"></use>
                    </svg>Dashboard</h2>
                <div class="intro">
                    <h3>WP Core Web Vitals is installed and ready to speed up your site.</h3>
                    <p class="warning">Please e-mail <a href="mailto:info@corewebvitals.io">info@corewebvitals.io</a> with any questions you might have.</p>
                </div>
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-pro"></use>
                    </svg>Pro features</h2>
                <p>* Pro features will enable advanced optimizations that run through our optimization cloud. </p>
                <p>Licence state is <span id="licencestate"> ... </span>
                </p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Licence Key</th>
                        <td><input type="text" name="cwv_api_key" value="<?php echo esc_attr( critical_get_option('cwv_api_key') ); ?>" /></td>
                    </tr>
                </table>
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-refresh"></use>
                    </svg>Cache</h2>
                <p>* WP Core Web Vitals will clear it's cache automatically. On site-wide changes clear the cache manually.</p>
                <a id="clearhtmlcache" class="button button-primary" href="#">Clear HTML Cache</a>
                <a id="clearcriticalcache" class="button button-primary" href="#">Clear Critical CSS Cache</a>
            </div>
            <div class="cwv-tab-panel" id="tabs-4" style="display: none;">
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-css3"></use>
                    </svg>
                    Styles
                    <svg data-help=".criticalcssoptshelp" class="cwv-help helpicon">
                        <use xlink:href="#icon-question"></use>
                    </svg>
                </h2>
                <p>* Optimized styles will improve paint metrics like First Contenful Paint and Largest Contentful paint</p>
                <div class="cwvhelptext criticalcssoptshelp">
                    <p>Optimized styles will not block the page from rendering but might introduce a lay-out shift</p>
                    <p>Combining CSS is usually not the best idea. However in combination with Critical CSS it might speed up the page considerably in some cases. Please test carefully when enabling this feature</p>
                    <p>Critical CSS is a must-have for any fast website. Critcal CSS is a collection of only the styles that are needed for rendering the visible viewport. While original stylesheets are loaded in the background the browser can start rendering the page without needing to wait for external stylesheets</p>
                    <p>Extra styles </p>
                </div>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Generate Critical CSS</th>
                        <td>
                            <div class="switch-field">
                                <input name="wp_cwv_css" id="wp_cwv_css0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'wp_cwv_css' ) ); ?> />
                                <label for="wp_cwv_css0">no</label>
                                <input name="wp_cwv_css" id="wp_cwv_css1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'wp_cwv_css' ) ); ?> />
                                <label for="wp_cwv_css1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Combine CSS</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_combine_css" id="cwv_combine_css0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_combine_css' ) ); ?> />
                                <label for="cwv_combine_css0">no</label>
                                <input name="cwv_combine_css" id="cwv_combine_css1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_combine_css' ) ); ?> />
                                <label for="cwv_combine_css1">yes</label>
                            </div>
                        </td>                   
                    </tr>
                    <tr valign="top">
                    <th scope="row">Critical CSS Page matching</th>
                        <td>
                            <div class="switch-field">
                                <input name="wp_cwv_critical_all_pages" id="wp_cwv_critical_all_pages0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'wp_cwv_critical_all_pages' ) ); ?> />
                                <label for="wp_cwv_critical_all_pages0">smart</label>
                                <input name="wp_cwv_critical_all_pages" id="wp_cwv_critical_all_pages1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'wp_cwv_critical_all_pages' ) ); ?> />
                                <label for="wp_cwv_critical_all_pages1">all</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Add extra CSS</th>
                        <td><textarea type="text" name="cwv_extra_css"><?php echo esc_attr( critical_get_option('cwv_extra_css') ); ?></textarea></td>
                    </tr>
                </table>
                <br />
                <br />
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-css3"></use>
                    </svg>
                    Generated Critical Files
                    <svg data-help=".generatedcriticalcsshelp" class="cwv-help helpicon">
                        <use xlink:href="#icon-question"></use>
                    </svg>
                </h2>
                <p>By default Critical CSS is generated for each possible combionation of page type, template type and post type.</p>
                <div class="cwvhelptext generatedcriticalcsshelp">
                    <p>This is a list of all generated Critical CSS files. We will generate a critical CSS file of each page type, template and post type combination.</p>
                </div>
                <table class="bordered">
                    <tr>
                        <th>Example url</th>
                        <th>Page type</th>
                        <th>Template</th>
                        <th>Post type</th>
                        <th></th>
                    </tr>
                    <?php foreach($oCriticalFiles as $oCriticalFile){?>
                    <tr>
                        <td>
                            <?php echo $oCriticalFile->url;?>
                        </td>
                        <td>
                            <?php echo $oCriticalFile->pagetype;?>
                        </td>
                        <td>
                            <?php echo ($oCriticalFile->templateslug)?$oCriticalFile->templateslug:'--';?>
                        </td>
                        <td>
                            <?php echo $oCriticalFile->posttype;?>
                        </td>
                        <td><span class="badge badge-<?php echo $oCriticalFile->status;?>">
                                <?php echo $oCriticalFile->status;?></span></td>
                    </tr>
                    <?php } ?>
                </table>
                <br />
                <br />
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-css3"></use>
                    </svg>
                    Critical Rules
                    <svg data-help=".criticalcssruleshelp" class="cwv-help helpicon">
                        <use xlink:href="#icon-question"></use>
                    </svg>
                </h2>
                <p>Create different Critical CSS files for any url that start with:</p>
                <div class="cwvhelptext criticalcssruleshelp">
                    <p>
                        If you need more Critical CSS rules because pages with the same combination of 'Page type', 'Template' and 'Post type' have different lay-outs or styles just add (part of) their url into a new rule. WP Core Web Vitals will then generate seperate Critical Styles for all pages mathcing this rule!
                    </p>
                    <p>
                        For example: '<b>blog/</b>' will match any page that has blog/ in the url. For example
                        <?php echo WP_CWV_SITE_URL;?>/<b>blog/</b>my-first-blog.
                    </p>
                </div>
                <div id="criticalcssrules">
                </div>
            </div>
            <div class="cwv-tab-panel" id="tabs-2" style="display: none;">
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-options"></use>
                    </svg>Page options</h2>
                <p>* Caching and preloading. Caching pages will speed up your site considerably. We suggest you enable this option. Disable this option while developing.</p>
                <p> Minify HTML minifies your code for faster download. This might cause issues with broken HTML. </p>
                <p>Preload visible links will pre-cache all the links on a page for a logged-out visitor. Do not enable preloading without caching.</p>
                <table class="form-table" width="100%">
                    <tr valign="top">
                        <th scope="row">Cache page files</th>
                        <td>
                            <div class="switch-field">
                                <input name="wp_cwv_page_cache" id="wp_cwv_page_cache0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'wp_cwv_page_cache' ) ); ?> /><label for="wp_cwv_page_cache0">no</label>
                                <input name="wp_cwv_page_cache" id="wp_cwv_page_cache1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'wp_cwv_page_cache' ) ); ?> /><label for="wp_cwv_page_cache1">yes</label>
                            </div>
                        </td>
                    </tr> 
                    <tr valign="top">
                        <th scope="row">Cache pages with url parameters</th>
                        <td>
                            <div class="switch-field">
                                <input name="wp_cwv_page_cache_urlparam" id="wp_cwv_page_cache_urlparam0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'wp_cwv_page_cache_urlparam' ) ); ?> /><label for="wp_cwv_page_cache_urlparam0">no</label>
                                <input name="wp_cwv_page_cache_urlparam" id="wp_cwv_page_cache_urlparam1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'wp_cwv_page_cache_urlparam' ) ); ?> /><label for="wp_cwv_page_cache_urlparam1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Minify HTML</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_page_minify" id="cwv_page_minify0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_page_minify' ) ); ?> />
                                <label for="cwv_page_minify0">no</label>
                                <input name="cwv_page_minify" id="cwv_page_minify1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_page_minify' ) ); ?> />
                                <label for="cwv_page_minify1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Remove dns-prefetch tags</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_page_remove_dns_prefetch" id="cwv_page_remove_dns_prefetch0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_page_remove_dns_prefetch' ) ); ?> />
                                <label for="cwv_page_remove_dns_prefetch0">no</label>
                                <input name="cwv_page_remove_dns_prefetch" id="cwv_page_remove_dns_prefetch1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_page_remove_dns_prefetch' ) ); ?> />
                                <label for="cwv_page_remove_dns_prefetch1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Remove preconnect tags</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_page_remove_preconnect" id="cwv_page_remove_preconnect0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_page_remove_preconnect' ) ); ?> />
                                <label for="cwv_page_remove_preconnect0">no</label>
                                <input name="cwv_page_remove_preconnect" id="cwv_page_remove_preconnect1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_page_remove_preconnect' ) ); ?> />
                                <label for="cwv_page_remove_preconnect1">yes</label>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="cwv-tab-panel" id="tabs-3" style="display: none;">
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-images"></use>
                    </svg>Images</h2>
                <p>* You should probably enable all these settings. Disable any other lazy load plugins</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Enable native lazy load</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_lazy_load_images" id="cwv_lazy_load_images0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_lazy_load_images' ) ); ?> />
                                <label for="cwv_lazy_load_images0">no</label>
                                <input name="cwv_lazy_load_images" id="cwv_lazy_load_images1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_lazy_load_images' ) ); ?> />
                                <label for="cwv_lazy_load_images1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enable JavaScript lazy load</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_lazy_load_images_js" id="cwv_lazy_load_images_js0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_lazy_load_images_js' ) ); ?> />
                                <label for="cwv_lazy_load_images_js0">no</label>
                                <input name="cwv_lazy_load_images_js" id="cwv_lazy_load_images_js1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_lazy_load_images_js' ) ); ?> />
                                <label for="cwv_lazy_load_images_js1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Lazy load inline background images</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_lazy_load_bg_images" id="cwv_lazy_load_bg_images0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_lazy_load_bg_images' ) ); ?> />
                                <label for="cwv_lazy_load_bg_images0">no</label>
                                <input name="cwv_lazy_load_bg_images" id="cwv_lazy_load_bg_images1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_lazy_load_bg_images' ) ); ?> />
                                <label for="cwv_lazy_load_bg_images1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Async render images</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_async_render_images" id="cwv_async_render_images0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_async_render_images' ) ); ?> />
                                <label for="cwv_async_render_images0">no</label>
                                <input name="cwv_async_render_images" id="cwv_async_render_images1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_async_render_images' ) ); ?> />
                                <label for="cwv_async_render_images1">yes</label>
                            </div>
                        </td>
                    </tr>
                </table>
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-images"></use>
                    </svg>
                    Help
                </h2>
                <h3>Lazy load</h3>
                <p>
                    Lazy loading images will speed up the page. This should be enables on allmost all sites.<br />
                    Native lazy load will add loading="lazy" to each image.<br />
                    JavaScript lazyload will add a placeholder for each image and use the Interaction Observer API to show images. <br />
                    It is possible to comine Native And JavaScript lazy loading.
                </p>
            </div>
            <div class="cwv-tab-panel" id="tabs-5" style="display: none;">
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-scripts"></use>
                    </svg>Scripts</h2>
                <p>* Deferred scripts are usually a safe option. Agressive deferring pushes these script untill after page load.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Defer JavaScripts</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_defer_scripts" id="cwv_defer_scripts0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_defer_scripts' ) ); ?> />
                                <label for="cwv_defer_scripts0">no</label>
                                <input name="cwv_defer_scripts" id="cwv_defer_scripts1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_defer_scripts' ) ); ?> />
                                <label for="cwv_defer_scripts1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Move JavaScripts to bottom of the page</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_footer_scripts" id="cwv_footer_scripts0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_footer_scripts' ) ); ?> />
                                <label for="cwv_footer_scripts0">no</label>
                                <input name="cwv_footer_scripts" id="cwv_footer_scripts1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_footer_scripts' ) ); ?> />
                                <label for="cwv_footer_scripts1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Ignore optimisation for (regex)</th>
                        <td><input type="text" name="cwv_defer_scripts_lower_regex" value="<?php echo esc_attr( critical_get_option('cwv_defer_scripts_lower_regex') ); ?>" /></td>
                    </tr>
                </table>
                <p>Deferring Script and/or moving script to the bottom of the page will improve the First Contentful Paint and Largest Contentful Paint metrics.</p>
            </div>
            <div class="cwv-tab-panel" id="tabs-6" style="display: none;">
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-expert"></use>
                    </svg>Developer</h2>
                <div class="intro">
                    <p class="warning"><b>Warning</b> developper options are a powerful tool in the hands of a skilled developper but may slow down your site when used incorrectly or break site functionality!</p>
                </div>
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-scripts"></use>
                    </svg>
                    Lazy load JavaScript
                    <svg data-help=".lazyscriptshelp" class="cwv-help helpicon">
                        <use xlink:href="#icon-question"></use>
                    </svg>
                </h2>
                <p>Load scripts just-in-time based on actions and triggers</p>
                <div class="cwvhelptext lazyscriptshelp">
                    <p>This will load scripts just in time. <span style="color:red">Be very carefull</span> when using this feature because it might break site functionality!</p>
                    <p>If for example you would like to load /wp-content/scripts/autocomplete.js just-in-time when a visitor hovers over the search bar (with a classname of 'search') add this:</p>
                    <ul>
                        <li>Regex: 'autocomplete.js'</li>
                        <li>Trigger: 'hover /click'</li>
                        <li>Selector: '.search'</li>
                    </ul>
                </div>
                <div id="scriptrules">
                </div>
                <h2 class="cwv-tab-heading"><svg class="icon">
                        <use xlink:href="#icon-images"></use>
                    </svg>Images</h2>
                <p>Adding missing image height and width will reduce layout shift but might make images appear out of proportion. Try adding img{max-width:100%;height:auto;width:auto;} to your stylesheet.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Add image missing width and height</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_img_width_height" id="cwv_img_width_height0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_img_width_height' ) ); ?> />
                                <label for="cwv_img_width_height0">no</label>
                                <input name="cwv_img_width_height" id="cwv_img_width_height1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_img_width_height' ) ); ?> />
                                <label for="cwv_img_width_height1">yes</label>
                            </div>
                        </td>
                    </tr>
                </table>
                <h2 class="cwv-tab-heading">
                    <svg class="icon">
                        <use xlink:href="#icon-font"></use>
                    </svg>
                    Fonts
                </h2>
                <p>Preload fonts and improve font rendering</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Improve font rendering</th>
                        <td>
                            <div class="switch-field">
                                <input name="cwv_text_rendering" id="cwv_text_rendering0" type="radio" value="0" <?php checked( '0' , critical_get_option( 'cwv_text_rendering' ) ); ?> />
                                <label for="cwv_text_rendering0">no</label>
                                <input name="cwv_text_rendering" id="cwv_text_rendering1" type="radio" value="1" <?php checked( '1' , critical_get_option( 'cwv_text_rendering' ) ); ?> />
                                <label for="cwv_text_rendering1">yes</label>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Preload fonts</th>
                        <td><textarea type="text" name="cvw_custom_preload"><?php echo esc_attr( critical_get_option('cvw_custom_preload') ); ?></textarea></td>
                    </tr>
                </table>
            </div>
            <?php submit_button(); ?>
        </form>
    </div>
</div>
<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <symbol id="icon-dashboard" viewBox="0 0 32 32">
            <path d="M32 18.451l-16-12.42-16 12.42v-5.064l16-12.42 16 12.42zM28 18v12h-8v-8h-8v8h-8v-12l12-9z"></path>
        </symbol>
        <symbol id="icon-images" viewBox="0 0 36 32">
            <path d="M34 4h-2v-2c0-1.1-0.9-2-2-2h-28c-1.1 0-2 0.9-2 2v24c0 1.1 0.9 2 2 2h2v2c0 1.1 0.9 2 2 2h28c1.1 0 2-0.9 2-2v-24c0-1.1-0.9-2-2-2zM4 6v20h-1.996c-0.001-0.001-0.003-0.002-0.004-0.004v-23.993c0.001-0.001 0.002-0.003 0.004-0.004h27.993c0.001 0.001 0.003 0.002 0.004 0.004v1.996h-24c-1.1 0-2 0.9-2 2v0zM34 29.996c-0.001 0.001-0.002 0.003-0.004 0.004h-27.993c-0.001-0.001-0.003-0.002-0.004-0.004v-23.993c0.001-0.001 0.002-0.003 0.004-0.004h27.993c0.001 0.001 0.003 0.002 0.004 0.004v23.993z"></path>
            <path d="M30 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"></path>
            <path d="M32 28h-24v-4l7-12 8 10h2l7-6z"></path>
        </symbol>
        <symbol id="icon-options" viewBox="0 0 32 32">
            <path d="M27 0h-24c-1.65 0-3 1.35-3 3v26c0 1.65 1.35 3 3 3h24c1.65 0 3-1.35 3-3v-26c0-1.65-1.35-3-3-3zM26 28h-22v-24h22v24zM8 18h14v2h-14zM8 22h14v2h-14zM10 9c0-1.657 1.343-3 3-3s3 1.343 3 3c0 1.657-1.343 3-3 3s-3-1.343-3-3zM15 12h-4c-1.65 0-3 0.9-3 2v2h10v-2c0-1.1-1.35-2-3-2z"></path>
        </symbol>
        <symbol id="icon-mmisc" viewBox="0 0 32 32">
            <path d="M8 6l-4-4h-2v2l4 4zM10 0h2v4h-2zM18 10h4v2h-4zM20 4v-2h-2l-4 4 2 2zM0 10h4v2h-4zM10 18h2v4h-2zM2 18v2h2l4-4-2-2zM31.563 27.563l-19.879-19.879c-0.583-0.583-1.538-0.583-2.121 0l-1.879 1.879c-0.583 0.583-0.583 1.538 0 2.121l19.879 19.879c0.583 0.583 1.538 0.583 2.121 0l1.879-1.879c0.583-0.583 0.583-1.538 0-2.121zM15 17l-6-6 2-2 6 6-2 2z"></path>
        </symbol>
        <symbol id="icon-earth" viewBox="0 0 32 32">
            <path d="M16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 30c-1.967 0-3.84-0.407-5.538-1.139l7.286-8.197c0.163-0.183 0.253-0.419 0.253-0.664v-3c0-0.552-0.448-1-1-1-3.531 0-7.256-3.671-7.293-3.707-0.188-0.188-0.442-0.293-0.707-0.293h-4c-0.552 0-1 0.448-1 1v6c0 0.379 0.214 0.725 0.553 0.894l3.447 1.724v5.871c-3.627-2.53-6-6.732-6-11.489 0-2.147 0.484-4.181 1.348-6h3.652c0.265 0 0.52-0.105 0.707-0.293l4-4c0.188-0.188 0.293-0.442 0.293-0.707v-2.419c1.268-0.377 2.61-0.581 4-0.581 2.2 0 4.281 0.508 6.134 1.412-0.13 0.109-0.256 0.224-0.376 0.345-1.133 1.133-1.757 2.64-1.757 4.243s0.624 3.109 1.757 4.243c1.139 1.139 2.663 1.758 4.239 1.758 0.099 0 0.198-0.002 0.297-0.007 0.432 1.619 1.211 5.833-0.263 11.635-0.014 0.055-0.022 0.109-0.026 0.163-2.541 2.596-6.084 4.208-10.004 4.208z"></path>
        </symbol>
        <symbol id="icon-scripts" viewBox="0 0 40 32">
            <path d="M26 23l3 3 10-10-10-10-3 3 7 7z"></path>
            <path d="M14 9l-3-3-10 10 10 10 3-3-7-7z"></path>
            <path d="M21.916 4.704l2.171 0.592-6 22.001-2.171-0.592 6-22.001z"></path>
        </symbol>
        <symbol id="icon-css3" viewBox="0 0 32 32">
            <path d="M4.762 1.516l-1.074 5.373h21.867l-0.684 3.47h-21.881l-1.059 5.372h21.865l-1.219 6.127-8.813 2.919-7.638-2.919 0.523-2.658h-5.372l-1.278 6.448 12.632 4.834 14.563-4.834 4.805-24.133z"></path>
        </symbol>
        <symbol id="icon-pro" viewBox="0 0 32 32">
            <path d="M30 0l-14 4-14-4c0 0-0.141 1.616 0 4l14 4.378 14-4.378c0.141-2.384 0-4 0-4zM2.256 6.097c0.75 7.834 3.547 21.007 13.744 25.903 10.197-4.896 12.995-18.069 13.744-25.903l-13.744 5.167-13.744-5.167z"></path>
        </symbol>
        <symbol id="icon-refresh" viewBox="0 0 32 32">
            <path d="M27.802 5.197c-2.925-3.194-7.13-5.197-11.803-5.197-8.837 0-16 7.163-16 16h3c0-7.18 5.82-13 13-13 3.844 0 7.298 1.669 9.678 4.322l-4.678 4.678h11v-11l-4.198 4.197z"></path>
            <path d="M29 16c0 7.18-5.82 13-13 13-3.844 0-7.298-1.669-9.678-4.322l4.678-4.678h-11v11l4.197-4.197c2.925 3.194 7.13 5.197 11.803 5.197 8.837 0 16-7.163 16-16h-3z"></path>
        </symbol>
        <symbol id="icon-expert" viewBox="0 0 32 32">
            <path d="M30 0l-14 4-14-4c0 0-0.141 1.616 0 4l14 4.378 14-4.378c0.141-2.384 0-4 0-4zM2.256 6.097c0.75 7.834 3.547 21.007 13.744 25.903 10.197-4.896 12.995-18.069 13.744-25.903l-13.744 5.167-13.744-5.167z"></path>
        </symbol>
        <symbol id="icon-font" viewBox="0 0 32 32">
            <path d="M24.987 0.506c-2.829 0-4.644-0.506-7.558-0.506-9.415 0-13.806 5.362-13.806 10.809 0 3.209 1.52 4.264 4.518 4.264-0.211-0.464-0.591-0.971-0.591-3.251 0-6.375 2.406-8.233 5.489-8.36 0 0-2.529 24.793-9.868 27.767v0.771h9.894l3.376-16h6.183l1.377-4h-6.716l1.623-7.693c1.858 0.38 3.673 0.76 5.235 0.76 1.942 0 3.715-0.591 4.686-5.066-1.182 0.38-2.449 0.506-3.842 0.506z"></path>
        </symbol>
        <symbol id="icon-question" viewBox="0 0 20 20">
            <path d="M10 20c-5.523 0-10-4.477-10-10s4.477-10 10-10v0c5.523 0 10 4.477 10 10s-4.477 10-10 10v0zM12 7c0 0.28-0.21 0.8-0.42 1l-1.58 1.58c-0.57 0.58-1 1.6-1 2.42v1h2v-1c0-0.29 0.21-0.8 0.42-1l1.58-1.58c0.57-0.58 1-1.6 1-2.42 0-2.209-1.791-4-4-4s-4 1.791-4 4v0h2c0-1.105 0.895-2 2-2s2 0.895 2 2v0zM9 15v2h2v-2h-2z"></path>
        </symbol>
    </defs>
</svg>