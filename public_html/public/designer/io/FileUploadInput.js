
export class FileUploadInput {

    constructor(element) {
        this._element = element;
    }

    addFileUploadListener(listener) {
        if(listener) {
            this._element.addEventListener('change', (event) => {
                listener.call(null, event.target.files);
            });
        }
    }
}
