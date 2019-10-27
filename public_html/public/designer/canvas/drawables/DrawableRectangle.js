
export class DrawableRectangle {
		
    constructor(boundingBox) {
        this._boundingBox = boundingBox;
        this.frame = 0;
        this.color = 'black';
        this._recalculateColor = false;
    }

    draw(ctx) {

        if(this._recalculateColor) {
            this.avg = this._getAveragePixelOfBoundingBox(ctx);
            this.color = this._contrastColor(this.avg);
            this._recalculateColor = false;
        }

        let x = this.x();
        let y = this.y();
        let width = this.width();
        let height = this.height();
    
        let lineWidth = 1;
        
        ctx.beginPath();
        ctx.rect(x, y, width, height);
        ctx.strokeStyle = this.color;
        ctx.lineWidth = lineWidth;
        ctx.stroke();
        
        /*
        var pixel = ctx.getImageData(x, y, 1, 1).data; 
        
        let r = Math.pow((p[0]/255), 2.2);
        let b = Math.pow((p[1]/255), 2.2);
        let g = Math.pow((p[2]/255), 2.2);
        */

        /*
        ctx.beginPath();
        ctx.rect(x + lineWidth, y + lineWidth, width - 2*lineWidth, height - 2*lineWidth);
        ctx.strokeStyle = 'white';
        ctx.lineWidth = lineWidth;
        */
        ctx.stroke();
    }

    calculateColor() {
        //let avg = this._getAveragePixelOfBoundingBox(ctx);
        //console.log('average pixel rgb: ' + avg[0] + ', '+ avg[1] + ',' + avg[2]);
        //this.color = 'rgb('+avg[0]+','+avg[1]+','+avg[2]+')';

        /*
        let r = Math.pow((avg[0]/255), 2.2);
        let b = Math.pow((avg[1]/255), 2.2);
        let g = Math.pow((avg[2]/255), 2.2);
        let y = 0.2126*r + 0.7151*g + 0.0721*b;
        */

       this._recalculateColor = true;
        //this.color = this._contrastColor(this.avg);
    }

    _contrastColor(color) {

        // Source: https://stackoverflow.com/a/1855903
        let luminance = (0.299 * color[0] + 0.587 * color[1] + 0.114 * color[2])/255;

        console.log('luminance: ' + luminance);

        if (luminance > 0.5) {
            return '#000';
        } else {
            return '#fff';
        }
    }

    _getAveragePixelOfBoundingBox(ctx) {
        const x = this.x();
        const y = this.y();
        const width = this.width();
        const height =this.height();

        var avg = [0, 0, 0];

        const pixelCount = 2*width + 2*height;

        for(let dy = 0; dy < 2; dy++) {
            for(let dx = 0; dx <= width; dx++) {
                var pixel = ctx.getImageData(x + dx, y + dy * height, 1, 1).data; 
                //console.log('pixel rgb: ' + pixel[0] + ', '+ pixel[1] + ',' + pixel[2]);
                avg[0] = this._rollingAverage(avg[0], pixel[0], pixelCount);
                avg[1] = this._rollingAverage(avg[1], pixel[1], pixelCount);
                avg[2] = this._rollingAverage(avg[2], pixel[2], pixelCount);
            }
        }
        for(let dx = 0; dx < 2; dx++) {
            for(let dy = 0; dy <= height; dy++) {
                var pixel = ctx.getImageData(x + dx * width, y + dy, 1, 1).data; 
                //console.log('pixel rgb: ' + pixel[0] + ', '+ pixel[1] + ',' + pixel[2]);
                avg[0] = this._rollingAverage(avg[0], pixel[0], pixelCount);
                avg[1] = this._rollingAverage(avg[1], pixel[1], pixelCount);
                avg[2] = this._rollingAverage(avg[2], pixel[2], pixelCount);
            }
        }
        return avg;
    }

    _rollingAverage(avg, value, n) {
        avg -= avg / n;
        avg += value / n;
        return avg;
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
