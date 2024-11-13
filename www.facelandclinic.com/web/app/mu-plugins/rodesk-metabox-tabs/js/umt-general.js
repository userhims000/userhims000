var RodeskMetaboxTabs = (function ($) {

    var $tabList, $tabs, pageID;

    $(document).ready(function () {
        init();
    });

    function init() {
        _initMetaboxTabs(); // Init the metaboxtab plugins
        _clickSavedTabs(); // Open the saved tab from local storage
    }

    /**
     * On click of a tab hide all metaboxes
     * Also show any metaboxes assosiated with tha tab
     */
    function _clickTab() {

        var $metaBoxes 	= $('#normal-sortables .postbox'),
            $parent 	= $(this).parent('li'),
            groupID 	= $parent.attr("id"),
            $groups 	= $parent.attr('data-acf-groups'),
            groupsNew 	= $groups.split(',').map(function (group) { return "#" + group; });

        // Hide all metaboxes
        $metaBoxes.hide();

        // Loop metaboxes assosiated with this tab and show them
        for (var i = 0; i < groupsNew.length; i++) {
            $(document).find(groupsNew[i]).show();
        }

        // Fix active classes
        $(document).find('#sw-ultimate-metabox-tab-list li a').removeClass('active');
        $(this).addClass('active');

        // Save active tab ID to localstorage
        // When a post is saved (reloaded) it wil open on the same tab
        if( pageID !== null) {
            var tabData = {};
            tabData[pageID] = groupID;
            _activeTab('save', tabData);
        }

        // Prevent any other default actions
        return false;

    }

    /**
     * Loop all tabs. Check if any of the assiged metaboxes is visible
     * Also show any metaboxes assosiated with tha tab
     */
    function _checkTabs() {

        var groups = $(this).attr('data-acf-groups'),
            groupsNew = groups.split(',').map(function (group) { return "#" + group; }).join(","),
            hiddenGroups = 0,
            totalGroups = 0;

        if ($(groupsNew).length > 0) {

            totalGroups = $(groupsNew).length;

            $(groupsNew).each(function () {
                if ($(this).hasClass('acf-hidden')) {
                    hiddenGroups++;
                }
            });

            if (hiddenGroups < totalGroups) {
                $(this).css({ display: 'block' });
            }

        }
    }

    /**
     * Save or get the active tab from the browsers localstorage
     */
    function _activeTab(type, data) {

        // Retrieve your data from locaStorage
        var saveData = JSON.parse(localStorage.metaBoxTabs || null) || {},
            activeTab;

        if (type == 'save' && data) {
            saveData.activeTab = $.extend({},saveData.activeTab, data);
            localStorage.metaBoxTabs = JSON.stringify(saveData);
        } else {

            if(saveData.activeTab && pageID in saveData.activeTab) {
                activeTab = saveData.activeTab[pageID];
            } else {
                activeTab = "";
            }

            return activeTab;
        }

    }

    /**
     * Check if there is any tab saved in the localstorage and trigger a click
     * If false grab the first tab in row
     */
    function _clickSavedTabs() {

        var savedTabName = _activeTab();

        if (savedTabName) {
            $('#sw-ultimate-metabox-tab-list').find('#' + savedTabName + ' a').trigger('click');
        } else {
            $tabs.first().find('a').trigger('click');
        }

    }

    /**
     * Setup the tabs
     */
    function _initMetaboxTabs() {

        $tabList 	= $(document).find('#sw-ultimate-metabox-tab-list');
        $tabs 		= $tabList.find('li'),
        pageID 		= /post=([^&]+)/.exec(location.href);

        if(pageID != null) {
            pageID = pageID[1];
        }

        // Loop all tabs. Check if any of the assiged metaboxes is visible
        // If true show the tab in the tab menu
        $tabs.each(_checkTabs);

        // On click of a tab hide all metaboxes
        // Also show any metaboxes assosiated with tha tab
        $tabs.find("a").on('click.rodeskTab', _clickTab);

    }

    return  {
        rebuild : init
    }

})(jQuery);