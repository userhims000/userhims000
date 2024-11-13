/*------------------------------------------------------------------------*/
/*  Rodesk head module
/*------------------------------------------------------------------------*/

window.rodeskUpdate = (() => {
    /*
     * Use this class to update head on
     *
     *
     */
    class RodeskUpdate {
        _disableExternalLinks() {
            const externalLinks = document.querySelectorAll(
                '[rel="external"], [rel="external nofollow"], .disable-highyway a'
            );

            externalLinks.forEach(link => {
                link.removeEventListener('click', transitionManager._navigate);
            });
        }

        _updateHtmlClasses(to) {
            document.documentElement.classList = to.page.documentElement.classList;
            document.documentElement.setAttribute('lang', to.page.documentElement.getAttribute('lang'));
        }

        _updateBodyClasses(to) {
            document.body.classList = to.page.body.classList;
        }

        _updateCampaignStyles(to) {
            const campaignStyle = document.querySelector('#rokit-campaign-styles');
            const newCampaignStyle = to.page.head.querySelector('#rokit-campaign-styles');

            if (document.body.classList.contains('body--single--campaign')) {
                if (transitionManager.cache.has(transitionManager.location.href)) {
                    transitionManager.cache.delete(transitionManager.location.href);
                }

                if (campaignStyle) {
                    campaignStyle.replaceWith(newCampaignStyle);
                } else {
                    document.head.appendChild(newCampaignStyle);
                }
            } else {
                if (campaignStyle) {
                    campaignStyle.remove();
                }
            }
        }

        _updateNavigation(to) {
            const headerTop = document.querySelector('.js-header-top');
            const newHeaderTop = to.page.body.querySelector('.js-header-top').cloneNode(true);
            headerTop.replaceWith(newHeaderTop);

            const headerBottom = document.querySelector('.js-header-bottom');
            const newHeaderBottom = to.page.body.querySelector('.js-header-bottom').cloneNode(true);
            headerBottom.replaceWith(newHeaderBottom);

            const footer = document.querySelector('.js-footer');
            const newFooter = to.page.body.querySelector('.js-footer').cloneNode(true);
            footer.replaceWith(newFooter);

            const langSwitch = document.querySelector('.js-lang-switch');
            const newlangSwitch = to.page.body.querySelector('.js-lang-switch').cloneNode(true);
            langSwitch.replaceWith(newlangSwitch);
        }

        _updateHeader(to) {
            document.querySelector('.js-header-top').classList = to.page.body.querySelector('.js-header-top').classList;
        }

        _updateMeta(to) {
            [].forEach.call(to.page.head.childNodes, node => {
                switch (node.nodeName) {
                    case 'META': {
                        const contentElement = document.querySelector(
                            `meta[property="${node.getAttribute('property')}"]`
                        );

                        const nameElement = document.querySelector(`meta[name="${node.getAttribute('name')}"]`);

                        if (contentElement !== null && node.hasAttribute('property')) {
                            contentElement.setAttribute('content', node.content);
                        }
                        if (nameElement !== null && node.hasAttribute('name')) {
                            nameElement.setAttribute('content', node.content);
                        }
                        break;
                    }
                    case 'LINK': {
                        const element = document.querySelector(`link[rel="${node.getAttribute('rel')}"]`);

                        if (element !== null && node.hasAttribute('rel') && node.getAttribute('rel') === 'canonical') {
                            element.setAttribute('href', node.getAttribute('href'));
                        } else if (
                            element == null &&
                            node.hasAttribute('rel') &&
                            node.getAttribute('rel') === 'canonical'
                        ) {
                            const link = document.createElement('link');

                            link.rel = 'canonical';
                            link.href = transitionManager.location.href;

                            document.head.appendChild(link);
                        }
                        break;
                    }
                    default:
                        break;
                }
            });
        }
        /**
         *
         *
         *
         */

        init(to) {
            this._updateNavigation(to);
            this._updateHtmlClasses(to);
            this._updateBodyClasses(to);
            this._updateCampaignStyles(to);
            this._updateHeader(to);
            this._updateMeta(to);
        }

        disable() {
            this._disableExternalLinks();
        }
    }

    return new RodeskUpdate();
})();
