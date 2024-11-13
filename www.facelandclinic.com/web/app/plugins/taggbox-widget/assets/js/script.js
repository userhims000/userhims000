jQuery(document).ready(function () {
    /* BEGIN  REFRESH ALL DATA FOR TAGGBOX PLUGIN*/
    jQuery(document).on("click", "#taggboxRefresh", function () {
           // var post_data = "action=data&param=taggboxRefresh&" + jQuery("#formTaggboxLogin").serialize();
            var post_data = "action=data&param=taggboxRefresh";
            return new Promise(function (resolve, reject) {
                jQuery.ajax({
                    url: taggboxAjaxurl.ajax_url, // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    dataType: 'json',
                    data: post_data,
                    beforeSend: function () {
                        jQuery('#taggboxRefresh').addClass('tb_btn_icon_rotate tb_disabled00')
                        jQuery('html,body').css('cursor', 'wait');
                    },
                    complete: function () {
                        jQuery('#taggboxRefresh').removeClass('tb_btn_icon_rotate tb_disabled00')
                        jQuery('html,body').css('cursor', 'auto');
                    },
                },).done(function (response) {
                    if (response.status === false) {
                        jQuery(".tb_error_msg00").empty();
                        jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">'+response.message+'</div></div>');
                    } else if (response.status === true) {
                        location.reload(true);
                    }
                })
            })

    });
    /* END  REFRESH ALL DATA  FOR TAGGBOX PLUGIN*/

    /* BEGIN  LOGIN FOR TAGGBOX PLUGIN*/
    jQuery('#formTaggboxLogin').validate({
        submitHandler: function () {
            var post_data = "action=data&param=taggboxLogin&" + jQuery("#formTaggboxLogin").serialize();
            return new Promise(function (resolve, reject) {
                jQuery.ajax({
                    url: taggboxAjaxurl.ajax_url, // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    dataType: 'json',
                    data: post_data,
                    beforeSend: function () {
                        jQuery('html,body').css('cursor', 'wait');

                        jQuery('#tb_submit_login_btn').addClass('tb_spinner__00');

                    },
                },).done(function (response) {
                    if (response.status === false) {

                        jQuery('#tb_submit_login_btn').removeClass('tb_spinner__00');
                        jQuery('html,body').css('cursor', 'auto');

                        jQuery(".tb_error_msg00").empty();
                        jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">'+response.message+'</div></div>');
                        
                    } else if (response.status === true) {
                        window.location.replace(response.data.redirectUrl);
                    }
                })
            })
        }
    });
    /* END  LOGIN FOR TAGGBOX PLUGIN*/

    /* BEGIN  LOGOUT FOR TAGGBOX PLUGIN*/
    jQuery(document).on("click", "#taggboxLogout", function () {
        var post_data = "action=data&param=taggboxLogout";
        jQuery.ajax({
            url: taggboxAjaxurl.ajax_url, // Url to which the request is send
            type: "POST", // Type of request to be send, called as method
            dataType: 'json',
            data: post_data,
        }).done(function (response) {
            if (response.status === false) {
                reject('Oops! Something went wrong.');
                jQuery(".tb_error_msg00").empty();
                jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">Oops! Something went wrong.</div></div>');
            } else if (response.status === true) {
                window.location.replace(response.data.redirectUrl);
            }
        }).error(function () {
            jQuery(".tb_error_msg00").empty();
            jQuery(".tb_error_msg00").append("<div class='tb_alert__ tb_alert__danger'><div class='tb_alert__text'>We couldn't connect to the server!</div></div>");
        });

    });
    /* END  LOGOUT FOR TAGGBOX PLUGIN*/

    /* BEGIN  MANAGE WIDGET ACCORDING COLLABORATOR FOR TAGGBOX PLUGIN*/
    jQuery("#collaborator").change(function () {
        var post_data = "action=data&param=updateWidgetAccordingUser&userid=" + jQuery(this).val();
        return new Promise(function (resolve, reject) {
            jQuery.ajax({
                url: taggboxAjaxurl.ajax_url, // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                dataType: 'json',
                data: post_data,
                beforeSend: function () {
                    jQuery('html,body').css('cursor', 'wait');
                },
                complete: function () {
                    jQuery('html,body').css('cursor', 'auto');
                },
            },).done(function (response) {
                if (response.status === false) {
                    reject('Oops! Something went wrong.');
                } else if (response.status === true) {
                    location.reload(true);
                }
            }).error(function () {
                jQuery(".tb_error_msg00").empty();
                jQuery(".tb_error_msg00").append("<div class='tb_alert__ tb_alert__danger'><div class='tb_alert__text'>We couldn't connect to the server!</div></div>");

            });
        })
    });
    /* END  MANAGE WIDGET ACCORDING COLLABORATOR FOR TAGGBOX PLUGIN*/

    /* BEGIN APPEND EMBED JS DYNAMICALLY */

    if(jQuery('.taggbox-container > .taggbox-socialwall').length > 0) {
        jQuery.getScript('https://widget.taggbox.com/embed.min.js').done(function(script, textStatus){
        });
    }

    /* END APPEND EMBED JS DYNAMICALLY */
});

/*
* * BEGIN MANAGE SHORT CODE
*/
/*BEGIN COPY*/
function copyTbWidgetToClipboard(element) {
    jQuery('<div class="tb-copy-success-alert">Copied!</div>').insertAfter(jQuery('#input_'+element));
    jQuery('.tb-copy-success-alert').fadeIn(300);
    jQuery('.tb-copy-success-alert').delay(1500).fadeOut(300,function(){ jQuery('.tb-copy-success-alert').remove(); });

    var copyText = document.getElementById("input_"+element);

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */
  
    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);


    setTimeout(function(){
        document.getSelection().removeAllRanges();
    },1500);
}
/*END COPY*/
/*
* * END MANAGE SHORT CODE
*/