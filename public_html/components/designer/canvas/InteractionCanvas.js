import {DrawingModeAdapter, DrawingModeListAdapter} from '/components/designer/editor/mode/DrawingModeAdapters.js';

class NoopDrawingMode {}

export class InteractionCanvas {
	
    constructor(canvas) {
        this._canvas = canvas;
        this._mode = new NoopDrawingMode();

        this._canvas.addEventListener('mousedown', (event) => this._mode.mousedown(this._relativeMousePosition(event)));
        this._canvas.addEventListener('mouseup', (event) => this._mode.mouseup(this._relativeMousePosition(event)));
        this._canvas.addEventListener('mousemove', (event) => this._mode.mousemove(this._relativeMousePosition(event)));
        this._canvas.addEventListener('keydown', (event) => this._mode.keydown(event));
        this._canvas.addEventListener('keyup', (event) => this._mode.keyup(event));
    }

    setMode(mode) {
        this._mode = new DrawingModeListAdapter([ new DrawingModeAdapter(mode) ]);
    }

    _relativeMousePosition(event) {
        // Source: https://stackoverflow.com/a/17130415
        let canvaspos = this._canvas.getBoundingClientRect();
        return {
            x: parseInt(event.clientX - canvaspos.left),
            y: parseInt(event.clientY - canvaspos.top)
        };
    }
}
