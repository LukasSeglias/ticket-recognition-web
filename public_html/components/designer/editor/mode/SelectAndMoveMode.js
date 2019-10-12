
export class SelectAndMoveMode {
			
    static get REGULAR_STEP() {
        return 10;
    }

    constructor(drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._drawable = undefined;
        this._lastMouse = undefined;
        this._mousedown = false;
        this._selectedDrawableChangeListeners = [];
    }

    onSelectedDrawableChange(fn) {
        this._selectedDrawableChangeListeners.push(fn);
    }
    
    select(drawable) {
        this._drawable = drawable;
        this._notifySelectedDrawableChange(this._drawable);
    }

    mousedown(mouse) {
        this._lastMouse = mouse;
        this._mousedown = true;
        this._drawable = this._drawingCanvas.findByPosition(mouse);
        this._notifySelectedDrawableChange(this._drawable);
    }

    mouseup(mouse) {
        this._mousedown = false;
    }

    mousemove(mouse) {
        
        if (this._mousedown && this._drawable) {

            let dx = mouse.x - this._lastMouse.x;
            let dy = mouse.y - this._lastMouse.y;

            this._drawingCanvas.moveBy(this._drawable, dx, dy);
            this._lastMouse = mouse;
        }
    }

    getDeltaByArrowkey(key, step) {
        if (key === 'ArrowLeft') {
            return { x: -step, y: 0 };

        } else if (key === 'ArrowUp') {
            return { x: 0, y: -step };

        } else if (key === 'ArrowRight') {
            return { x: +step, y: 0 };

        } else if (key === 'ArrowDown') {
            return { x: 0, y: +step };
        } else {
            return undefined;
        }
    }

    keydown(event) {

        if (this._drawable) {
            
            let step = event.ctrlKey ? 1 : SelectAndMoveMode.REGULAR_STEP;
            let delta = this.getDeltaByArrowkey(event.key, step);

            if(delta) {
                if(event.altKey) {
                    this._drawingCanvas.resizeBy(this._drawable, delta.x, delta.y);

                    // Prevent Chrome's Alt + ArrowLeft navigating back
                    event.preventDefault();

                } else {
                    this._drawingCanvas.moveBy(this._drawable, delta.x, delta.y);
                }
            }
        }
    }

    _notifySelectedDrawableChange(drawable) {
        this._selectedDrawableChangeListeners.forEach(listener => {
            if(listener) listener.call(null, drawable);
        });
    }
}
