
export class DrawingModeAdapter {
			
    constructor(mode) {
        this._mode = mode || {};
    }

    mousedown(mouse) {
        if(this._mode.mousedown) this._mode.mousedown(mouse);
    }

    mouseup(mouse) {
        if(this._mode.mouseup) this._mode.mouseup(mouse);
    }

    mousemove(mouse) {
        if(this._mode.mousemove) this._mode.mousemove(mouse);
    }

    keydown(event) {
        if(this._mode.keydown) this._mode.keydown(event);
    }

    keyup(event) {
        if(this._mode.keyup) this._mode.keyup(event);
    }
}

export class DrawingModeListAdapter {
    
    constructor(modes) {
        this._modes = modes || [];
    }

    mousedown(mouse) {
        this._modes.forEach(mode => mode.mousedown(mouse));
    }

    mouseup(mouse) {
        this._modes.forEach(mode => mode.mouseup(mouse));
    }

    mousemove(mouse) {
        this._modes.forEach(mode => mode.mousemove(mouse));
    }

    keydown(event) {
        this._modes.forEach(mode => mode.keydown(event));
    }

    keyup(event) {
        this._modes.forEach(mode => mode.keyup(event));
    }
}
