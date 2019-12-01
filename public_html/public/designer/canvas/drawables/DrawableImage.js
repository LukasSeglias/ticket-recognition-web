
export class DrawableImage {
			
    constructor(img) {

        this._img = img;
        this._x = 0;
        this._y = 0;
        this._width = img.width;
        this._height = img.height;
    }

    draw(ctx) {
        ctx.drawImage(this._img, this._x, this._y);
    }

    containsPoint(point) {
        return this._x <= point.x
            && this._y <= point.y
            && this._x + this._width >= point.x
            && this._y + this._height >= point.y;
    }

    get x() {
        return this._x;
    }

    get y() {
        return this._y;
    }

    get width() {
        return this._width;
    }

    get height() {
        return this._height;
    }
}
