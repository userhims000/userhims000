/*------------------------------------------------------------------------*/
/*  Transition Class
/*------------------------------------------------------------------------*/
window.Transitions = (() => {
    class Transitions {
        constructor() {
            this.transitions = {};
        }

        exports(transition) {
            this.transitions = Object.assign(this.transitions, transition);
        }

        get animations() {
            return this.transitions;
        }
    }

    const T = new Transitions();

    return T;
})();
