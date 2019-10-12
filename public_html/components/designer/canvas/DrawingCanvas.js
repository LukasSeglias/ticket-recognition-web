import {DrawableRectangle} from '/components/designer/canvas/drawables/DrawableRectangle.js';
import {BoundingBox} from '/components/designer/canvas/primitives/BoundingBox.js';
import {RestrictedBoundingBox} from '/components/designer/canvas/primitives/RestrictedBoundingBox.js';

export class DrawingCanvas {
	
    constructor(canvas) {
        this._canvas = canvas;
        this._ctx = canvas.getContext("2d");
        this._layers = [ { visible: true, drawables: [] } ];
        this._currentLayerIndex = 0;
        this._drawableChangeListener = [];
    }

    addDrawableChangeListener(listener) {
        if(listener) {
            this._drawableChangeListener.push(listener);
        }
    }
    
    drawableRectangle(topLeft, bottomRight) {
        let minSize = 10; // TODO: move somewhere else
        let canvasBoundingBox = new BoundingBox({ x: 0, y: 0 }, { x: this.width(), y: this.height() });
        let boundingBox = new RestrictedBoundingBox(topLeft, bottomRight, minSize, canvasBoundingBox);

        if(canvasBoundingBox.containsBoundingBox(boundingBox)) {
            return new DrawableRectangle(boundingBox);
        }
        return null;
    }

    width() {
        return this._canvas.width;
    }
    
    height() {
        return this._canvas.height;
    }
    
    draw() {
        this._ctx.clearRect(0, 0, this.width(), this.height());

        this._foreachDrawable((index, drawable) => {
            drawable.draw(this._ctx);
        });
    }
    
    add(drawable) {
        this._layers[this._currentLayerIndex].drawables.push(drawable);
    }
    
    replace(oldDrawable, newDrawable) {
    
        for(let layerIndex = 0; layerIndex < this._layers.length; layerIndex++) {
            let layer = this._layers[layerIndex];
            
            let index = layer.drawables.indexOf(oldDrawable);
            if (index > -1) {
                layer.drawables.splice(index, 1, newDrawable);
                this._notifyDrawableChange(newDrawable);
                return;
            }
        }
    }

    calculateKey(drawable) {
        for(let layerIndex = 0; layerIndex < this._layers.length; layerIndex++) {
            let layer = this._layers[layerIndex];
            
            let index = layer.drawables.indexOf(drawable);
            if (index > -1) {
                return layerIndex + "-" + index;
            }
        }
    }
    
    findByPosition(point) {
        
        return this._foreachDrawable((index, drawable) => {
        
            if(drawable.containsPoint && drawable.containsPoint(point)) {
                return drawable;
            }
            
        }, false);
    }
    
    moveBy(drawable, dx, dy) {
    
        if(drawable && drawable.moveBy) {

            drawable.moveBy(dx, dy);
            this._notifyDrawableChange(drawable);
        }
    }

    resizeBy(drawable, deltaWidth, deltaHeight) {
    
        if(drawable && drawable.resizeBy) {
        
            drawable.resizeBy(deltaWidth, deltaHeight);
            this._notifyDrawableChange(drawable);
            
        } else {
            throw new Error('Tried to resize incompatible drawable');
        }
    }

    _notifyDrawableChange(drawable) {
        console.log('key: ' + this.calculateKey(drawable));
        this._drawableChangeListener.forEach(listener => {
            if(listener) listener.call(null, drawable);
        });
    }
    
    _foreachLayer(fn, backToFront = true) {
        if(backToFront) {
            for(let layerIndex = 0; layerIndex < this._layers.length; layerIndex++) {
                let layer = this._layers[layerIndex];
                
                if(layer.visible) {
                    let returnValue = fn.call(this, layerIndex, layer);
                    if(returnValue) {
                        return returnValue;
                    }
                }
            }
        } else {
            for(let layerIndex = this._layers.length - 1; layerIndex >= 0; layerIndex--) {
                let layer = this._layers[layerIndex];
                
                if(layer.visible) {
                    let returnValue = fn.call(this, layerIndex, layer);
                    if(returnValue) {
                        return returnValue;
                    }
                }
            }
        }
    }
    
    _foreachDrawable(fn, backToFront = true) {

        return this._foreachLayer((layerIndex, layer) => {
            
            if(backToFront) {
                for(let i = 0; i < layer.drawables.length; i++) {
                    let drawable = layer.drawables[i];
                    let returnValue = fn.call(this, i, drawable);
                    if(returnValue) {
                        return returnValue;
                    }
                }
            } else {
                for(let i = layer.drawables.length - 1; i >= 0; i--) {
                    let drawable = layer.drawables[i];
                    let returnValue = fn.call(this, i, drawable);
                    if(returnValue) {
                        return returnValue;
                    }
                }
            }
        }, backToFront);
    }
}
