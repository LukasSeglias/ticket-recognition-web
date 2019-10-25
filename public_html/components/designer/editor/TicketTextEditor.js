import {TicketText} from '/components/designer/ticket/TicketText.js';

export class TicketTextEditor  {
	
    constructor(textForm, ticketTextList, addButton, deleteButton, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._textForm = textForm;
        this._ticketTextList = ticketTextList;
        this._addButton = addButton;
        this._deleteButton = deleteButton;
        this._addListeners = [];
        this._deleteListeners = [];
        this._changeListeners = [];
        this._selectListeners = [];

        this._drawingCanvas.addDrawableChangedListener((drawable) => {
            if(drawable === this._drawable) {
                this.value = drawable;
            }
        });

        this._textForm.onChange((oldValue, newValue) => {

            if(this._textForm.validate()) {
                addButton.disabled = false;
                ticketTextList.disabled = false;

                let text = this._textForm.getValue();

                if(this._drawable && this._drawable.key()) {
                    this._ticketTextList.remove(this._drawable.key());
                }
                this._ticketTextList.add(text.key);

                this._onTextFormChange(newValue);
            } else {
                addButton.disabled = true;
                ticketTextList.disabled = true;
            }
        });

        ticketTextList.onSelect((key) => {
            console.log('selected key ' + key);

            this._selectListeners.forEach((listener) => {
                if(listener) listener(key);
            });
        });
        
        addButton.addEventListener('click', () => {
            this._drawable = undefined;

            this.value = {};

            this._addListeners.forEach((listener) => {
                if(listener) listener();
            });
        });

        deleteButton.addEventListener('click', () => {
            
            this._drawingCanvas.remove(this._drawable);
            
            if(this._drawable.key()) {
                ticketTextList.remove(this._drawable.key());
            }

            this.value = undefined;

            this._deleteListeners.forEach((listener) => {
                if(listener) listener();
            });
        });
    }

    get value() {
        return this._drawable;
    }

    set value(drawable) {
        this._drawable = drawable;

        if(drawable && drawable instanceof TicketText) {

            this._textForm.setValue(drawable);
            this._textForm.setDisabled(false);
            this._ticketTextList.disabled = !this._textForm.validate();
            this._addButton.disabled = !this._textForm.validate();
            this._deleteButton.disabled = false;

            if(drawable.key()) {
                this._ticketTextList.add(drawable.key());
            }

        } else {
            this._textForm.setValue();
            this._textForm.setDisabled(true);
            this._ticketTextList.disabled = false;
            this._addButton.disabled = false;
            this._deleteButton.disabled = true;
        }
    }

    onAdd(fn) {
        if(fn) this._addListeners.push(fn);
    }

    onSelect(fn) {
        if(fn) this._selectListeners.push(fn);
    }

    onChange(fn) {
        if(fn) this._changeListeners.push(fn);
    }

    _onTextFormChange(newValue) {

        this._changeListeners.forEach((listener) => {
            if(listener) listener();
        });

        // TODO: check if is text
        let newRectangle = this._drawingCanvas.drawableRectangle({
            x: newValue.x,
            y: newValue.y
        },{
            x: newValue.x + newValue.width,
            y: newValue.y + newValue.height
        });

        if(newRectangle) {
            let newText = new TicketText(newValue.key, newRectangle);

            if(this._drawable) {
                this._drawingCanvas.replace(this._drawable, newText);
            } else {
                this._drawingCanvas.add(newText);
            }
            this._drawable = newText;
        }
    }
}
