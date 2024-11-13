/*------------------------------------------------------------------------*/
/*  Rodesk breakpoint functions
/*------------------------------------------------------------------------*/

window.rodeskBreakpoints = (() => {
    /*
     * Use this JS module to define the actual SCSS breakpoint
     * This allowes to share SCSS breakpoints with JavaScript
     *
     * This function returns a string with the actual breakpoint
     * rodeskBreakpoints.getBreakpoint()
     *
     * This function checks if a passed string matches the actual breakpoint
     * Returns true/false
     * rodeskBreakpoints.isBreakpoint( breakpoint )
     *
     */
    class RodeskBreakpoints {
        /**
         * Remove the quotes from a string
         * @param  string   The string to be cleaned
         * @return string   The cleaned string wihtout quotes
         */
        _removeQuotes(string) {
            this.string = string;
            if (typeof this.string === 'string' || this.string instanceof String) {
                const cleanString = this.string.replace(/[^a-zA-Z ]/g, '');
                return cleanString;
            }

            return false;
        }

        /**
         * Output the actual browser viewport breakpoint
         * @return  string  The actual breakpoint of the browser
         */
        getBreakpoint() {
            let style = null;

            if (window.getComputedStyle && window.getComputedStyle(document.body, '::after')) {
                style = window.getComputedStyle(document.body, '::after');
                style = style.content;
            } else {
                window.getComputedStyle = el => {
                    this.el = el;
                    this.getPropertyValue = prop => {
                        const re = /(-([a-z]){1})/g;

                        if (re.test(prop)) {
                            prop.replace(re, (...args) => {
                                return args[2].toUpperCase();
                            });
                        }
                        return el.currentStyle[prop] ? el.currentStyle[prop] : null;
                    };
                    return this;
                };
                style = window.getComputedStyle(document.getElementsByTagName('head')[0]);
                style = style.getPropertyValue('font-family');
            }

            return this._removeQuotes(style);
        }

        /**
         * Check if a breakpoints matches the actual browser viewport breakpoint
         * @param  string  breakpoint The breakpoint name we are checking
         * @return Boolean            Check if breakpoints matches with actual browser breakpoint
         */
        isBreakpoint(breakpoint) {
            // @TODO find a better method / more dynamic for this
            const breakpoints = {
                small: ['small', 'compact', 'medium', 'large', 'wide', 'huge', 'mega'],
                compact: ['compact', 'medium', 'large', 'wide', 'huge', 'mega'],
                medium: ['medium', 'large', 'wide', 'huge', 'mega'],
                large: ['large', 'wide', 'huge', 'mega'],
                wide: ['wide', 'huge', 'mega'],
                huge: ['huge', 'mega'],
                mega: ['mega']
            };

            const actualBreakpoint = this.getBreakpoint();

            if ($.inArray(actualBreakpoint, breakpoints[breakpoint]) !== -1) {
                return true;
            }
            return false;
        }
    }

    return new RodeskBreakpoints();
})();
