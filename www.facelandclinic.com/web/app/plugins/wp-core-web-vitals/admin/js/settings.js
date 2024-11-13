 jQuery(document).ready(function($) {



     /* -----===== TAB NAVIGATION =====----- */
     $('.cwv-tab-bar li').click(function(event) {
         event.preventDefault();

         $('.cwv-tab-panel').hide();
         $($(this).data('tab')).show();

         $('.cwv-tab-bar .active').removeClass('active');
         $(this).addClass('active');
         if (window.matchMedia("only screen and (max-width: 760px)").matches) {

             $([document.documentElement, document.body]).animate({
                 scrollTop: $($(this).data('tab')).offset().top
             }, 400);

         }
     });


     /* -----===== SHOW/HIDE HELP =====----- */
      $('.cwv-help').click(function(event) {
         event.preventDefault();
         $($(this).data('help')).slideToggle();
     });




     /* -----===== SAVE OPTIONS =====----- */
     $('#criticaloptions').submit(function() {

         var data = $('#criticaloptions').serialize() + '&action=critical_save_options';

         jQuery.post(ajaxurl, data, function(response) {
             vwc_toast({ 'title': 'Settings saved', 'text': '&#10004; Your settings have been saved' });

             wp_cwv_get_critical_rules();
             wp_cwv_get_script_rules();
         });

         return false;
     })




     /* -----===== CRITIICAL CSS RULES =====----- */
     //bubble criticalcssrules
     $('#criticalcssrules').on("click", ".deleterule", function() {
         $.post(ajaxurl, { "action": "delete_critical_css_rule", "id": $(this).data('id') }, function(html) {
             wp_cwv_get_critical_rules();

         })
         return false;
     });

     var wp_cwv_get_critical_rules = function() {
         $.post(ajaxurl, { "action": "wp_cwv_get_critical_css_rules" }, function(html) {
             $('#criticalcssrules').html(html);
         })
     }

     wp_cwv_get_critical_rules();




     /* -----===== SCRIPT RULES =====----- */
     //bubble wp_cwv_delete_script_rule
     $('#scriptrules').on("click", ".deleterule", function() {
         $.post(ajaxurl, { "action": "wp_cwv_delete_script_rule", "id": $(this).data('id') }, function(html) {
             wp_cwv_get_script_rules();
         })
         return false;
     });

     var wp_cwv_get_script_rules = function() {
         $.post(ajaxurl, { "action": "wp_cwv_get_script_rules" }, function(html) {
             $('#scriptrules').html(html);
         })
     }

     wp_cwv_get_script_rules();




     /* -----===== PLUGIN STATUS =====----- */
     var wp_cwv_get_plugin_status = function() {
         $.getJSON(ajaxurl, { "action": "wp_cwv_get_plugin_status" }, function(html) {
             $('#licencestate').html(html.licence);
             if (html.forceupdate) {
                 $('#wp_cwv_admin_main').html('<h1>Plugin not up to date</h1><p>There is a new major release update. Please update the WP Core Web Vitals Plugin first</p>');
             }
         })
     }
     wp_cwv_get_plugin_status();





     /* -----===== CLEAR CACHES =====----- */
     $('#clearhtmlcache').click(function() {
         $.post(ajaxurl, { "action": "critical_clear_cache" }, function(res) {
             vwc_toast({ 'title': 'Success', 'text': '&#10004; The HTML Cache has been cleared' });

         })
     })

     $('#clearcriticalcache').click(function() {
         $.post(ajaxurl, { "action": "critical_clear_critical" }, function(res) {
             vwc_toast({ 'title': 'Success', 'text': '&#10004; The Critical CSS Cache has been cleared' });
         })
     })

     /* toast */
     var vwc_toast = function(obj) {
         $('#vwc_toast #toasttitle').html(obj.title);
         $('#vwc_toast #toasttext').html(obj.text);
         $('#vwc_toast').addClass('show');
         setTimeout(function() {
             $('#vwc_toast').removeClass('show');
         }, 5000)
     }


 });