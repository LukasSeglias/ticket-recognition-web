
export class DrawablesList {

    constructor(element, drawingCanvas, filterFunction) {
        
        this._element = element;
        this._drawingCanvas = drawingCanvas;
        this._filterFunction = filterFunction;
    }

    

    _getInputElementByName(name) {
            
        for(let i = 0; i < this._form.elements.length; i++) {
            let element = this._form.elements[i];
            if(element.name === name) {
                return element;
            }
        }
    }
}
