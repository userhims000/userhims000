<?php
$userDetails = taggbox_user();
$collaborators = taggbox_collaborator($userDetails->userId);
$activeWidgetUserId = taggbox_activeWidgetUser();
?>
<div class="taggbox_wrapper__">
    <div class="tb-container-fluid">
        <div class="taggbox-widget-header-section">
            <div class="tb-d-flex tb-align-itmes-center tb-justify-content-between tb-flex-wrap">
                <div class="taggbox-logoLogin tb_widget_head__">
                    <div class="tb-d-flex tb-align-items-center tb-flex-nowrap">
                        <a href="https://taggbox.com/widget/" target="_blank"><img class="tb_img_fluid" src="<?= TAGGBOX_PLUGIN_URL . '/assets/images/taggbox-widget.svg' ?>" width="210" height="34" alt="Taggbox"></a>
                    </div>
                </div>
                <div class="tb_profile_actions">
                    <?php if (count($collaborators)) { ?>
                        <div class="taggbox-custom-select">
                            <select class="taggbox-widget-account-section-select" id="collaborator">
                                <option value="0">Select collaborator</option>
                                <option value="<?= esc_attr($userDetails->userId); ?>" <?= (($userDetails->userId == $activeWidgetUserId) ? "selected" : ""); ?> class="taggbox-widget-account-section-tb-select-option"><?= esc_attr($userDetails->name); ?></option>
                                <?php foreach ($collaborators as $collaborator) { ?>
                                    <option value="<?= esc_attr($collaborator->collaboratorId); ?>" <?= (($collaborator->collaboratorId == $activeWidgetUserId) ? "selected" : ""); ?> class="taggbox-widget-account-section-tb-select-option"><?= esc_attr($collaborator->name); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <button id="taggboxLogout" class="taggbox-logout-btn tb-btn">Sign Out 
                        <span class="tb-svg-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="#2b2b2b">
                                <path d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h5a1 1 0 1 0 0-2H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h5a1 1 0 1 0 0-2H6z"/>
                                <path d="M15.293 7.293a1 1 0 0 1 1.414 0l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414-1.414L17.586 13H10a1 1 0 1 1 0-2h7.586l-2.293-2.293a1 1 0 0 1 0-1.414z"/></g>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="taggbox-dashboard-section">
            <div class="tb-d-flex tb-align-itmes-center tb-justify-content-between tb-flex-wrap">
                <div class="taggbox_breadcrumb___ tb-d-flex tb-align-itmes-center">
                    <div class="taggbox-dashboard">Widget dashboard / </div>
                    <div class="taggbox-user-name"> <?= esc_attr($userDetails->name); ?> </div>
                </div>
                <div class="tb_dashbord_action tb-d-flex tb-align-items-center">
                    <a class="tb-btn tb-btn-icon createWidgetBtn" href="https://app.taggbox.com/widget/v1/walls?plugin" target="_blank">
                    <div class="tb-svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g id="Group_4424" data-name="Group 4424" transform="translate(10922 -4685)">
                            <rect id="Rectangle_2094" data-name="Rectangle 2094" width="24" height="24" transform="translate(-10922 4685)" fill="none" opacity="0"></rect>
                            <path id="Path_5219" data-name="Path 5219" d="M-15.382,10.935h-6.172V4.765A1.065,1.065,0,0,0-22.618,3.7a1.065,1.065,0,0,0-1.064,1.064v6.17h-6.174a1.058,1.058,0,0,0-.751.317,1.056,1.056,0,0,0-.305.756,1.068,1.068,0,0,0,1.058,1.055h6.172v6.169a1.059,1.059,0,0,0,.311.754,1.021,1.021,0,0,0,.755.313,1.055,1.055,0,0,0,.749-.309,1.059,1.059,0,0,0,.313-.756V13.063h6.175a1.066,1.066,0,0,0,1.057-1.072A1.069,1.069,0,0,0-15.382,10.935Z" transform="translate(-10887.383 4685)" fill="#545454"></path>
                            </g>
                        </svg>
                    </div>
                    Create Widget
                    </a>
                    <button id="taggboxRefresh" class="tb-btn tb-btn-icon taggbox-instant-update-btn">
                    <div class="tb-svg-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g id="Group_4474" data-name="Group 4474" transform="translate(10951 -4712)">
                            <rect id="Rectangle_2094" data-name="Rectangle 2094" width="24" height="24" transform="translate(-10951 4712)" fill="none" opacity="0"></rect>
                            <g id="Group_1" data-name="Group 1" transform="translate(-10950 4715)">
                            <path id="Path_17" data-name="Path 17" d="M17.617,40.968a6.864,6.864,0,0,1-3.843,1.155,6.966,6.966,0,0,1-6.929-6.059H8a1.027,1.027,0,0,0,.869-.474.9.9,0,0,0,0-.967L6.656,30.974a1,1,0,0,0-.869-.474h0a1.027,1.027,0,0,0-.869.474c-.778,1.25-1.933,3.277-2.122,3.556a1.344,1.344,0,0,0-.189.566.916.916,0,0,0,.961.967H4.814a8.994,8.994,0,0,0,8.962,7.993,8.833,8.833,0,0,0,4.9-1.438.955.955,0,0,0,.283-1.344,1.02,1.02,0,0,0-1.342-.307Z" transform="translate(-2.605 -26.138)" fill="#545454"></path>
                            <path id="Path_18" data-name="Path 18" d="M42.874,19.993h-1.25A8.993,8.993,0,0,0,32.666,12a8.833,8.833,0,0,0-4.9,1.438.971.971,0,1,0,1.061,1.626,6.864,6.864,0,0,1,3.843-1.155A6.966,6.966,0,0,1,39.6,19.969H38.444a1.027,1.027,0,0,0-.869.474.9.9,0,0,0,0,.967l2.213,3.654a1,1,0,0,0,.869.474h0a1.027,1.027,0,0,0,.869-.474c.778-1.25,1.933-3.277,2.122-3.556a1.344,1.344,0,0,0,.189-.566.923.923,0,0,0-.963-.949Z" transform="translate(-21.494 -12)" fill="#545454"></path>
                            </g>
                            </g>
                        </svg>
                    </div>
                    Refresh</button>
                </div>
            </div>
        </div>

        <div class="tb_error_msg00"></div>
        
        <div class="taggbox-widget-panel-main-div">
            <div class="taggbox_walls___">
                <div class="taggbox_custom-row">
                    <?php
                    $count = 1;
                    $widgets = taggbox_widget($activeWidgetUserId);
                    if (!empty($widgets)) {
                        foreach ($widgets as $widget) {
                            ?>
                            <div class="taggbox_wall_size__">
                                <div class="panel-body panel-default taggbox-widget-panel taggbox-color-<?= $count; echo ($widget->status)? ' tb_active_wall' : ' tb_inactive_wall' ?>">
                                    <div class="taggbox-widget-panel-body">
                                        <div class="taggbox-widget-panel-heading tb-d-flex tb-justify-content-between tb-align-items-center">
                                            <div class="tb_widget_head00__"><?= esc_attr($widget->name); ?></div>
                                            <a class="taggbox-edit-link" href="<?= TAGGBOX_PLUGIN_API_URL . "wall/index/"; ?><?= esc_attr($widget->widgetId); ?>" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                                    <g fill="none"><path d="M16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621z" stroke="#545454" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" stroke="#545454" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </g>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="taggbox-widget-panel-feed-number"><?= $widget->feedCount; ?> feed, </div>
                                        <div class="taggbox-widget-panel-feed-number"> <?= $widget->networkCount; ?> Network </div>
                                    </div>
                                    <div class="taggbox-short-code-div shortCodeCopy tb-d-flex tb-align-items-center">
                                        <div class="taggbox_copy_txt___">
                                            <input type="text" class="tb-form-control" id="input_tb_widget-<?= esc_attr($widget->widgetId); ?>" value='[taggbox widgetid="<?= esc_attr($widget->widgetId);?>"]' readonly>
                                        </div>
                                        <div class="tb-btn taggbox-short-code-copy-btn" id="tb_widget-<?= esc_attr($widget->widgetId); ?>" onclick="copyTbWidgetToClipboard('tb_widget-<?= esc_attr($widget->widgetId); ?>')">Copy</div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($count == 6) {
                                $count = 1;
                            } else {
                                $count++;
                            }
                        }
                    } else {
                        ?>
                        <div class="taggbox_nopost___">
                            <div class="tb__no_post">It seems there are no widgets in your Taggbox account. Please create one by clicking on <a href="https://app.taggbox.com/widget/v1/walls?plugin" target="_blank" class="tb_bold_txt">"Create Widget"</a> button.</div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* BEGIN  MANAGE SELECT DROPDOWN FOR TAGGBOX PLUGIN*/
    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "taggbox-custom-select":*/
    x = document.getElementsByClassName("taggbox-custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        ll = selElmnt.length;
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "tb-select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "tb-select-items tb-select-hide");
        for (j = 1; j < ll; j++) {
            /*for each option in the original select element,create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function (e) {
                /*when an item is clicked, update the original select box, and the selected item:*/
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        yl = y.length;
                        for (k = 0; k < yl; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
                onChangeCall();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function (e) {
           /*when the select box is clicked, close any other select boxes, and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("tb-select-hide");
            this.classList.toggle("tb-select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
         except the current select box:*/
        var x, y, i, xl, yl, arrNo = [];
        x = document.getElementsByClassName("tb-select-items");
        y = document.getElementsByClassName("tb-select-selected");
        xl = x.length;
        yl = y.length;
        for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("tb-select-arrow-active");
            }
        }
        for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("tb-select-hide");
            }
        }
    }
    /*if the user clicks anywhere outside the select box, then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);
    /* END MANAGE SELECT DROPDOWN FOR TAGGBOX PLUGIN*/
    
    /* BEGIN  MANAGE WIDGET ACCORDING USER FOR TAGGBOX PLUGIN*/
    function onChangeCall() {
        var post_data = "action=data&param=updateWidgetAccordingUser&userid=" + jQuery('#collaborator').val();
        return new Promise(function (resolve, reject) {
            jQuery.ajax({
                url: taggboxAjaxurl.ajax_url,
                type: "POST",
                dataType: 'json',
                data: post_data,
                beforeSend: function () {
                    jQuery('html,body').css('cursor', 'wait');
                },
                complete: function () {
                    jQuery('html,body').css('cursor', 'auto');
                },
            }, ).done(function (response) {
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
    }
    /* END  MANAGE WIDGET ACCORDING USER FOR TAGGBOX PLUGIN*/
</script>