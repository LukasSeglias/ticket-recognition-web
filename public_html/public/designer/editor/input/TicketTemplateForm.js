import {DrawableImage} from '/public/designer/canvas/drawables/DrawableImage.js';
import {FileUploadInput} from '/public/designer/io/FileUploadInput.js';
import {ImageFilesReader} from '/public/designer/io/ImageFilesReader.js';
import {FormInput} from '/public/designer/editor/input/FormInput.js';

export class TicketTemplateForm {

    constructor(form, drawingCanvas) {
        
        this._form = form;
        this._changeListeners = [];
        this._drawingCanvas = drawingCanvas;
        this._oldValue = {};
        
        this._keyInput = new FormInput(this._getInputElementByName('key'));
        this._keyInput.validator = (value) => this._validateKey(value);
        this._touroperatorInput = new FormInput(this._getInputElementByName('touroperator'));
        this._touroperatorInput.validator = (value) => this._validateTouroperator(value);
        this._imageInput = this._getInputElementByName('image');
        this._imageUpload = new FileUploadInput(this._imageInput);
        this._imageUpload.validator = (value) => !!this._imageFile;
        
        this._addEventListeners();
    }

    get value() {
        let id = this._id;
        let key = this._keyInput.value;
        let touroperatorId = this._touroperatorInput.value;
        let imageFile = this._imageFile;

        return {
            id: id,
            key: key,
            touroperator: {
                id: touroperatorId,
                name: ''
            },
            imageFile: imageFile
        };
    }

    set value(template) {
        template = template || {};
        let touroperator = template.touroperator || {};
        this._id = template.id;
        this._keyInput.value = template.key ? template.key : "";
        this._touroperatorInput.value = touroperator.id ? touroperator.id : "";
        this._setImage(template.image);
        this._imageFile = template.imageFile;
    }

    setDisabled(disabled) {
        this._keyInput.disabled = disabled;
        this._touroperatorInput.disabled = disabled;
        this._imageInput.disabled = disabled;
    }
    
    onChange(fn) {
        this._changeListeners.push(fn);
    }

    validate() {
        let valid = this._keyInput.validate();
        valid &= this._touroperatorInput.validate();
        valid &= this._imageUpload.validate();

        let value = this.value;

        return valid
            && value
            && value.key
            && value.touroperator
            && value.touroperator.id
            && value.imageFile;
    }

    _addEventListeners() {
        this._keyInput.addChangeListener((newValue) => this._notifyChange());
        this._touroperatorInput.addChangeListener((newValue) => this._notifyChange());
        this._imageUpload.addFileUploadListener((files) => {
            let reader = new ImageFilesReader();
            reader.read(files)
            .then((images) => {
                if(images.length > 0) {
                    this._setImage(images[0].image);
                    this._imageFile = images[0].file;
                }
            })
        });
    }

    _setImage(img) {
        if(img) {
            let image = new DrawableImage(img);

            if(this._image) {
                this._drawingCanvas.replace(this._image, image);
            } else {
                this._drawingCanvas.add(image, 0);
            }
            this._image = image;

        } else if(this._image) {
            this._drawingCanvas.remove(this._image);
            this._image = undefined;
        }
    }

    _notifyChange() {
        
        if(this.validate()) {
            let newValue = this.value;
            this._changeListeners.forEach(listener => {
                if(listener) listener.call(null, this._oldValue, newValue);
            });
            this._oldValue = newValue;
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

    _validateKey(value) {
        let nonEmpty = !!value;
        let notTooLong = value && value.length <= 50;
        return {
            valid: nonEmpty && notTooLong
        };
    }

    _validateTouroperator(value) {
        return {
            valid: !!value
        };
    }

}
