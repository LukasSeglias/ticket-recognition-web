
export class BoundingBox {
	
    static get MIN_SIZE() {
        return 10;
    }
    
    constructor(topLeft, bottomRight) {

        this._topLeft = topLeft;
        this._bottomRight = bottomRight;
    }

    containsPoint(point) {
        return this._topLeft.x <= point.x
            && this._topLeft.y <= point.y
            && this._bottomRight.x >= point.x
            && this._bottomRight.y >= point.y;
    }

    containsBoundingBox(boundingBox) {
        return this.containsPoint({ x: boundingBox.x(), y: boundingBox.y() })
            && this.containsPoint({ x: boundingBox.x() + boundingBox.width(), y: boundingBox.y() + boundingBox.height() });
    }
    
    moveBy(dx, dy) {
        this._topLeft.x += dx;
        this._topLeft.y += dy;
        this._bottomRight.x += dx;
        this._bottomRight.y += dy;
    }

    resizeBy(deltaWidth, deltaHeight) {

        let minWidth = BoundingBox.MIN_SIZE;
        let minHeight = BoundingBox.MIN_SIZE;

        if(deltaWidth < 0) {
            deltaWidth = Math.max(deltaWidth, minWidth - this.width());
        }

        if(deltaHeight < 0) {
            deltaHeight = Math.max(deltaHeight, minHeight - this.height());
        }

        this._bottomRight.x += deltaWidth;
        this._bottomRight.y += deltaHeight;
    }

    x() {
        return this._topLeft.x;
    }

    y() {
        return this._topLeft.y;
    }

    position() {
        return {
            x: this._topLeft.x,
            y: this._topLeft.y
        };
    }

    width() {
        return this._bottomRight.x - this._topLeft.x;
    }

    height() {
        return this._bottomRight.y - this._topLeft.y;
    }
}
