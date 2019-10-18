
export class TicketText {
		
    constructor(key, rectangle) {
        this._key = key;
        this._rectangle = rectangle;
    }

    draw(ctx) {
        this._rectangle.draw(ctx);

        ctx.font = "10px Arial";
        ctx.fillText(this._key, this.x(), this.y() - 5);
    }
    
    containsPoint(point) {
        return this._rectangle.containsPoint(point);
    }
    
    moveBy(dx, dy) {
        this._rectangle.moveBy(dx, dy);
    }

    resizeBy(deltaWidth, deltaHeight) {
        this._rectangle.resizeBy(deltaWidth, deltaHeight);
    }

    key() {
        return this._key;
    }

    x() {
        return this._rectangle.x();
    }

    y() {
        return this._rectangle.y();
    }

    position() {
        return this._rectangle.position();
    }

    width() {
        return this._rectangle.width();
    }

    height() {
        return this._rectangle.height();
    }
    
    boundingBox() {
        return this._rectangle.boundingBox();
    }

    calculateColor() {
        this._rectangle.calculateColor();
    }
}
