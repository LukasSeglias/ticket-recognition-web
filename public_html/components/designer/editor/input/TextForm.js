
export class TextForm {

    constructor(form) {
        
        this._form = form;
        this._changeListeners = [];
        
        this._keyInput = this._getInputElementByName('key');
        this._xInput = this._getInputElementByName('x');
        this._yInput = this._getInputElementByName('y');
        this._widthInput = this._getInputElementByName('width');
        this._heightInput = this._getInputElementByName('height');
        
        this._addEventListeners();
    }

    getValue() {
        let key = this._keyInput.value;
        let x = this._xInput.value;
        let y = this._yInput.value;
        let width = this._widthInput.value;
        let height = this._heightInput.value;

        return {
            key: key, 
            x: this._getNumber(x),
            y: this._getNumber(y),
            width: this._getNumber(width),
            height: this._getNumber(height)
        };
    }

    setDisabled(disabled) {
        this._keyInput.disabled = disabled;
        this._xInput.disabled = disabled;
        this._yInput.disabled = disabled;
        this._widthInput.disabled = disabled;
        this._heightInput.disabled = disabled;
    }
    
    onChange(fn) {
        this._changeListeners.push(fn);
    }
    
    setValue(text) {
        this._keyInput.value = text ? text.key() : "";
        this._xInput.value = text ? text.x() : "";
        this._yInput.value = text ? text.y() : "";
        this._widthInput.value = text ? text.width() : "";
        this._heightInput.value = text ? text.height() : "";
    }

    validate() {
        let value = this.getValue();
        return value
            && value.key
            && value.x != null
            && value.y != null
            && value.width != null
            && value.height != null;
    }

    _addEventListeners() {
        this._keyInput.addEventListener('change', (newValue) => this._notifyChange());
        this._xInput.addEventListener('change', (newValue) => this._notifyChange());
        this._yInput.addEventListener('change', (newValue) => this._notifyChange());
        this._widthInput.addEventListener('change', (newValue) => this._notifyChange());
        this._heightInput.addEventListener('change', (newValue) => this._notifyChange());
    }

    _notifyChange() {
        
        if(this.validate()) {
            let newValue = this.getValue();
            this._changeListeners.forEach(listener => {
                if(listener) listener.call(null, newValue);
            });
        }
    }

    _getInputElementByName(name) {
        for(let i = 0; i < this._form.elements.length; i++) {
            let element = this._form.elements[i];
            if(element.name === name) {
                return element;
            }
        }
    }

    _getNumber(stringValue) {
        if(isNaN(stringValue)) {
            return null;
        }
        return +stringValue;
    }
}
