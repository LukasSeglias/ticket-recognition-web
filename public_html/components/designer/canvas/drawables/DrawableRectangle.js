
export class DrawableRectangle {
		
    constructor(boundingBox) {
        this._boundingBox = boundingBox;
    }

    draw(ctx) {
        let x = this.x();
        let y = this.y();
        let width = this.width();
        let height = this.height();
    
        let lineWidth = 2;
        
        ctx.beginPath();
        ctx.rect(x, y, width, height);
        ctx.strokeStyle = 'black';
        ctx.lineWidth = lineWidth;
        ctx.stroke();
        
        ctx.beginPath();
        ctx.rect(x + lineWidth, y + lineWidth, width - 2*lineWidth, height - 2*lineWidth);
        ctx.strokeStyle = 'white';
        ctx.lineWidth = lineWidth;
        ctx.stroke();
    }
    
    containsPoint(point) {
        return this._boundingBox.containsPoint(point);
    }
    
    moveBy(dx, dy) {
        this._boundingBox.moveBy(dx, dy);
    }

    resizeBy(deltaWidth, deltaHeight) {
        this._boundingBox.resizeBy(deltaWidth, deltaHeight);
    }

    x() {
        return this._boundingBox.x();
    }

    y() {
        return this._boundingBox.y();
    }

    position() {
        return this._boundingBox.position();
    }

    width() {
        return this._boundingBox.width();
    }

    height() {
        return this._boundingBox.height();
    }
    
    boundingBox() {
        return this._boundingBox;
    }
}
