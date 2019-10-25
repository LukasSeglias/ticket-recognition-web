
export class FileUploadInput {

    constructor(element) {

        this._element = element;

        this._element.addEventListener('change', (event) => {
            if(this._reader) {
                this._reader.read(event.target.files);
            }
        });
    }

    setReader(reader) {
        this._reader = reader;
    }

    get files() {
        return this._element.files;
    }
}
