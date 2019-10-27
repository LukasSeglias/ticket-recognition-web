import {ImageLoader} from '/public/designer/io/ImageLoader.js';

export class TicketTemplateEditor  {
	
    constructor(templateForm, saveButton, deleteButton, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._templateForm = templateForm;
        this._saveButton = saveButton;
        this._deleteButton = deleteButton;
    }

    onSave(fn) {
        this._saveButton.addEventListener('click', () => {
            fn.call(null);
        });
    }

    onDelete(fn) {
        this._deleteButton.addEventListener('click', () => {
            fn.call(null);
        });
    }

    validate() {
        return this._templateForm.validate();
    }

    get value() {
        return this._templateForm.value;
    }

    set value(value) {
        value = value || {};
        this._id = value.id;

        if(value.id) {
            this._getTemplateImage(value.imageFilename)
            .then((image) => {
                this._templateForm.value = {
                    id: value.id,
                    key: value.key,
                    image: image.image,
                    imageFile: image.file
                };
            });
        } else {
            this._templateForm.value = value;
        }

        this._saveButton.disabled = false;
        this._deleteButton.disabled = !this._isEdit(value);
    }

    async _getTemplateImage(imageFilename) {
        return (new ImageLoader()).fromUrl(`/admin/images/ticket-template/${imageFilename}`);
    }

    _isEdit(template) {
        return template && template.id !== undefined;
    }

}
