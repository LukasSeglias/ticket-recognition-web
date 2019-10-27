import {BoundingBox} from '/public/designer/canvas/primitives/BoundingBox.js';
import {FormInput} from '/public/designer/editor/input/FormInput.js';

export class TicketTextForm {

    constructor(form, drawingCanvas) {
        
        this._form = form;
        this._changeListeners = [];
        this._drawingCanvas = drawingCanvas;
        this._oldValue = {};
        
        this._keyInput = new FormInput(this._getInputElementByName('key'));
        this._keyInput.validator = (value) => this._validateKey(value);
        this._descriptionInput = new FormInput(this._getInputElementByName('description'));
        this._descriptionInput.validator = (value) => this._validateDescription(value);
        this._xInput = new FormInput(this._getInputElementByName('x'));
        this._xInput.validator = (value) => this._validateNumber(value);
        this._yInput = new FormInput(this._getInputElementByName('y'));
        this._yInput.validator = (value) => this._validateNumber(value);
        this._widthInput = new FormInput(this._getInputElementByName('width'));
        this._widthInput.validator = (value) => this._validateNumber(value);
        this._heightInput = new FormInput(this._getInputElementByName('height'));
        this._heightInput.validator = (value) => this._validateNumber(value);

        this._addEventListeners();
    }

    get value() {
        let key = this._keyInput.value;
        let description = this._descriptionInput.value;
        let x = this._xInput.value;
        let y = this._yInput.value;
        let width = this._widthInput.value;
        let height = this._heightInput.value;

        return {
            key: key, 
            description: description,
            rectangle: {
                x: this._getNumber(x),
                y: this._getNumber(y),
                width: this._getNumber(width),
                height: this._getNumber(height)
            }
        };
    }
    
    setValue(text) {
        this._text = text;
        this._keyInput.value = text ? text.key() : "";
        this._descriptionInput.value = text ? text.description() : "";
        this._xInput.value = text ? text.x() : "";
        this._yInput.value = text ? text.y() : "";
        this._widthInput.value = text ? text.width() : "";
        this._heightInput.value = text ? text.height() : "";
    }

    setDisabled(disabled) {
        this._keyInput.disabled = disabled;
        this._descriptionInput.disabled = disabled;
        this._xInput.disabled = disabled;
        this._yInput.disabled = disabled;
        this._widthInput.disabled = disabled;
        this._heightInput.disabled = disabled;
    }
    
    onChange(fn) {
        this._changeListeners.push(fn);
    }

    validate() {
        if(this._text == undefined) {
            // No text bound to this form
            return true;
        }

        let valid = this._keyInput.validate();
        valid &= this._descriptionInput.validate();
        valid &= this._xInput.validate();
        valid &= this._yInput.validate();
        valid &= this._widthInput.validate();
        valid &= this._heightInput.validate();

        let value = this.value;
        return valid 
            && value
            && value.key
            && value.rectangle
            && value.rectangle.x != null
            && value.rectangle.y != null
            && value.rectangle.width != null
            && value.rectangle.height != null
            && this._drawingCanvas.boundingBox.containsBoundingBox(BoundingBox.ofRectangle(
                value.rectangle.x, value.rectangle.y, value.rectangle.width, value.rectangle.height
            ))
            && this._textDefinitionExistsCheck && !this._textDefinitionExistsCheck.call(null, value);
    }

    reset() {
        this._keyInput.invalid = false;
        this._descriptionInput.invalid = false;
        this._xInput.invalid = false;
        this._yInput.invalid = false;
        this._widthInput.invalid = false;
        this._heightInput.invalid = false;
    }

    set textDefinitionExistsCheck(fn) {
        this._textDefinitionExistsCheck = fn;
    }

    _addEventListeners() {
        this._keyInput.addChangeListener((newValue) => this._notifyChange());
        this._descriptionInput.addChangeListener((newValue) => this._notifyChange());
        this._xInput.addChangeListener((newValue) => this._notifyChange());
        this._yInput.addChangeListener((newValue) => this._notifyChange());
        this._widthInput.addChangeListener((newValue) => this._notifyChange());
        this._heightInput.addChangeListener((newValue) => this._notifyChange());
    }

    _notifyChange() {
        
        let newValue = this.value;
        this._changeListeners.forEach(listener => {
            if(listener) listener.call(null, this._oldValue, newValue);
        });
        this._oldValue = newValue;
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

    _validateNumber(value) {
        let valid = !isNaN(value);
        return {
            valid: valid
        };
    }

    _validateKey(value) {
        let nonEmpty = !!value;
        let nonDuplicate = !this._textDefinitionExistsCheck || !this._textDefinitionExistsCheck.call(null, value);
        let notTooLong = value && value.length <= 50;
        return {
            valid: nonEmpty && nonDuplicate && notTooLong
        };
    }

    _validateDescription(value) {
        let nonEmpty = !!value;
        let notTooLong = value && value.length <= 100;
        return {
            valid: nonEmpty && notTooLong
        };
    }
}
