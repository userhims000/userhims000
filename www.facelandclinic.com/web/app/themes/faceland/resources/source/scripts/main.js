window.documentReadyMain = () => {
    // const matchHeightElements = [];
    // rodeskDefaults.matchHeight(matchHeightElements);

    rodeskSelect.init(); // Init customselect
    rodeskCardHover.init();
    objectFitPolyfill();
};
