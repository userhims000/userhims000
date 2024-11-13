(() => {
    const { Renderer } = highway;
    class CustomRenderer extends Renderer {
        // onEnter() {}
        // onLeave() {}
        // onEnterCompleted() {}
        // onLeaveCompleted() {}
    }

    Renderers.exports({ CustomRenderer });
})();
