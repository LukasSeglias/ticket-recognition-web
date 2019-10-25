
export class RectangleDrawingMode {
			
    constructor(drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._lastMouse = undefined;
        this._mousedown = false;
        this._currentRectangle = undefined;
    }

    mousedown(mouse) {
        this._lastMouse = mouse;
        this._mousedown = true;
    }

    mouseup(mouse) {
        this._mousedown = false;
    }

    mousemove(mouse) {
        
        if (this._mousedown) {
            
            let newRectangle = this._drawingCanvas.drawableRectangle({
                x: Math.min(this._lastMouse.x, mouse.x),
                y: Math.min(this._lastMouse.y, mouse.y)
            },{
                x: Math.max(this._lastMouse.x, mouse.x),
                y: Math.max(this._lastMouse.y, mouse.y)
            });

            if(this._currentRectangle) {
                this._drawingCanvas.replace(this._currentRectangle, newRectangle);
            } else {
                this._drawingCanvas.add(newRectangle);
            }
            
            this._currentRectangle = newRectangle;
        }
    }
}
