window.transitionManager = (() => {
    const { Core } = highway;
    // const { CustomRenderer } = Renderers.default;
    const { DefaultTransition, FilterTransition } = Transitions.animations;

    const transitionManager = new Core({
        // renderers: {
        //     default: CustomRenderer
        // },
        transitions: {
            default: DefaultTransition,
            contextual: {
                filter: FilterTransition
            }
        }
    });

    return transitionManager;
})();
