
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

    validate() {
        let result = this._validator ? this._validator.call(null, this.value) : { valid: true };
        this.invalid = !result.valid;
        this.errorMessage = !result.valid && result.message ? result.message : "";
        return !!result.valid;
    }

    set validator(validator) {
        this._validator = validator;
    }

    get value() {
        let files = this._element.files;
        return files.length > 0 ? files[0] : undefined;
    }

    get disabled() {
        return this._element.disabled;
    }

    set disabled(disabled) {
        this._element.disabled = disabled;
    }

    get invalid() {
        this._element.classList.contains("is-invalid");
    }

    set invalid(invalid) {
        if(invalid) {
            this._element.classList.add("is-invalid");
        } else {
            this._element.classList.remove("is-invalid");
        }
    }
}
