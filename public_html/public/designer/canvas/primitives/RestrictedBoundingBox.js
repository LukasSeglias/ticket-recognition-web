import {BoundingBox} from '/public/designer/canvas/primitives/BoundingBox.js';

export class RestrictedBoundingBox extends BoundingBox {
	
    constructor(topLeft, bottomRight, minSize, maxBoundingBox) {
        super(topLeft, bottomRight);
        this._minSize = minSize;
        this._maxBoundingBox = maxBoundingBox;
    }

    moveBy(dx, dy) {

        let x = this.x();
        let y = this.y();
        let width = this.width();
        let height = this.height();
        let minX = this._maxBoundingBox.x();
        let minY = this._maxBoundingBox.y();
        let maxWidth = this._maxBoundingBox.width();
        let maxHeight = this._maxBoundingBox.height();
        
        if(dx > 0) {
            dx = Math.min(dx, (maxWidth - (x + width)));
        } else {
            dx = Math.max(dx, minX - x);
        }
        
        if(dy > 0) {
            dy = Math.min(dy, (maxHeight - (y + height)));
        } else {
            dy = Math.max(dy, minY - y);
        }

        super.moveBy(dx, dy);
    }

    resizeBy(deltaWidth, deltaHeight) {
        
        let x = this.x();
        let y = this.y();
        let width = this.width();
        let height = this.height();
        let maxWidth = this._maxBoundingBox.width();
        let maxHeight = this._maxBoundingBox.height();
        let minSize = this._minSize;
        
        if(deltaWidth > 0) {
            deltaWidth = Math.min(deltaWidth, (maxWidth - (x + width)));
        } else {
            deltaWidth = Math.max(deltaWidth, minSize - this.width());
        }

        if(deltaHeight > 0) {
            deltaHeight = Math.min(deltaHeight, (maxHeight - (y + height)));
        } else {
            deltaHeight = Math.max(deltaHeight, minSize - this.height());
        }
        
        super.resizeBy(deltaWidth, deltaHeight);
    }
}
