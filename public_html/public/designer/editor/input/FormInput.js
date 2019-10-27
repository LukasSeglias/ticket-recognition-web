
export class FormInput {

    constructor(inputElement, errorFeedbackElement) {
        this._inputElement = inputElement;
        this._errorFeedbackElement = errorFeedbackElement;
    }

    validate() {
        let result = this._validator ? this._validator.call(null, this.value) : { valid: true };
        this.invalid = !result.valid;
        this.errorMessage = !result.valid && result.message ? result.message : "";
        return !!result.valid;
    }

    addChangeListener(fn) {
        if(fn) {
            this._inputElement.addEventListener('change', (newValue) => fn.call(null, newValue));
        }
    }

    set validator(validator) {
        this._validator = validator;
    }

    get value() {
        return this._inputElement.value;
    }

    set value(value) {
        this._inputElement.value = value;
    }

    get disabled() {
        return this._inputElement.disabled;
    }

    set disabled(disabled) {
        this._inputElement.disabled = disabled;
    }

    get invalid() {
        element.classList.contains("is-invalid");
    }

    set invalid(invalid) {
        if(invalid) {
            this._inputElement.classList.add("is-invalid");
        } else {
            this._inputElement.classList.remove("is-invalid");
        }
    }

    set errorMessage(errorMessage) {
        if(this._errorFeedbackElement) {
            this._errorFeedbackElement.innerHTML = errorMessage;
        }
    }
}
