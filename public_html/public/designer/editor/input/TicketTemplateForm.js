import {DrawableImage} from '/public/designer/canvas/drawables/DrawableImage.js';
import {FileUploadInput} from '/public/designer/io/FileUploadInput.js';
import {ImageFilesReader} from '/public/designer/io/ImageFilesReader.js';

export class TicketTemplateForm {

    constructor(form, drawingCanvas) {
        
        this._form = form;
        this._changeListeners = [];
        this._drawingCanvas = drawingCanvas;
        this._oldValue = {};
        
        this._keyInput = this._getInputElementByName('key');
        this._imageInput = this._getInputElementByName('image');
        this._imageUpload = new FileUploadInput(this._imageInput);
        
        this._addEventListeners();
    }

    get value() {
        let id = this._id;
        let key = this._keyInput.value;
        let imageFile = this._imageFile;

        return {
            id: id,
            key: key,
            imageFile: imageFile
        };
    }

    set value(template) {
        template = template || {};
        this._id = template.id;
        this._keyInput.value = template.key;
        this._setImage(template.image);
        this._imageFile = template.imageFile;
    }

    setDisabled(disabled) {
        this._keyInput.disabled = disabled;
        this._imageInput.disabled = disabled;
    }
    
    onChange(fn) {
        this._changeListeners.push(fn);
    }

    validate() {
        let value = this.value;
        return value
            && value.key
            && value.imageFile;
    }

    _addEventListeners() {
        this._keyInput.addEventListener('change', (newValue) => this._notifyChange());
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
            let newValue = this.getValue();
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

}
