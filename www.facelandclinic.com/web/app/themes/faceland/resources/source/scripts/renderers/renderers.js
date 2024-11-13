/*------------------------------------------------------------------------*/
/*  Renderers Class
/*------------------------------------------------------------------------*/
window.Renderers = (() => {
    class Renderers {
        constructor() {
            this.renderers = {};
        }

        exports(renderer) {
            this.renderers = Object.assign(this.renderers, renderer);
        }

        get default() {
            return this.renderers;
        }
    }

    const R = new Renderers();

    return R;
})();
