(() => {
    const { Transition } = highway;
    const loader = document.querySelector('.o-loader');

    class DefaultTransition extends Transition {
        out({ done, trigger }) {
            // Set loader default opacity and visibility
            loader.style.opacity = 0;
            loader.style.visibility = 'visible';

            anime({
                targets: loader,
                opacity: 1,
                duration: 400,
                easing: 'easeOutCubic',

                complete() {
                    rodeskMenu.closeMenu();

                    if (trigger !== 'popstate') {
                        window.scrollTo(0, 0);
                    }

                    done();
                },
            });
        }

        in({ from, done, to }) {
            if (to.querySelector('.js-trigger-reload')) {
                window.location.reload();
            }
            // Remove old view
            from.remove();

            done();

            // Set loader default opacity and visibility
            loader.style.opacity = 1;
            loader.style.visibility = 'visible';

            anime({
                targets: loader,
                opacity: 0,
                duration: 400,
                easing: 'easeOutCubic',

                complete() {
                    rodeskInView.init(); // Init inview module
                    loader.style.visibility = 'hidden';
                },
            });
        }
    }

    Transitions.exports({ DefaultTransition });
})();
