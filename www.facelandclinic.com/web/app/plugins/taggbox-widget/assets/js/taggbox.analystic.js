jQuery(document).ready(function () {
    if (jQuery(location).attr('search') == '') {
        var elements = document.getElementsByClassName("taggbox-analystic");
        if (elements.length > 0) {
            let wallIds = [];
            jQuery.each(elements, function () {
                wallIds.push(jQuery(this).attr('data-widget-id'));
            });
            let siteUrl = jQuery(location).attr('href');
            var post_data = "action=data&param=embeddedPluginWidgetsAnalytics&wallIds=" + wallIds + "&siteUrl=" + siteUrl;
            return new Promise(function (resolve, reject) {
                jQuery.ajax({
                    url: taggboxAjaxurl.ajax_url,
                    type: "POST",
                    dataType: 'json',
                    data: post_data,
                },)
            })
        }
    }
});


