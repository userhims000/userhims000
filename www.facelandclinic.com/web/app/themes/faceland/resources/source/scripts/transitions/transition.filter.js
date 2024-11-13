(() => {
    const { Transition } = highway;

    class FilterTransition extends Transition {
        out({ from, done, trigger }) {
            trigger.classList.add('is-active');
            from.querySelector('.c-filter.is-active').classList.remove('is-active');

            const oldCardWrapper = from.querySelector('.js-filter-container');
            const oldCards = from.querySelector('.js-filter-items');

            oldCardWrapper.style.position = 'relative';
            anime({
                targets: oldCards,
                opacity: [1, 0],
                duration: 400,
                easing: 'easeOutCubic',

                complete() {
                    oldCardWrapper.innerHTML += '<span class="c-loader c-loader--circle">DIT IS EEN LOADER</span>';
                    done();
                },
            });
        }

        in({ from, to, done }) {
            const oldCards = from.querySelector('.js-filter-items');
            const newCards = to.querySelector('.js-filter-items');

            oldCards.style.opacity = 0;
            newCards.style.opacity = 0;

            to.querySelectorAll('.js-animation-element').forEach((element) => {
                element.classList.add('a-inview');
            });

            from.remove();

            done();

            anime({
                targets: newCards,
                opacity: 1,
                duration: 400,
                delay: 200,
                easing: 'easeOutCubic',

                complete() {
                    newCards.removeAttribute('style');
                },
            });
        }
    }

    Transitions.exports({ FilterTransition });
})();
