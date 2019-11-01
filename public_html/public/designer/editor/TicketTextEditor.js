import {TicketText} from '/public/designer/ticket/TicketText.js';

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
                this.selectedDrawable = drawable;
            }
        });

        this._textForm.onChange((oldValue, newValue) => {

            if(this._textForm.validate()) {
                addButton.disabled = false;
                ticketTextList.disabled = false;

                let textDefinition = this._textForm.value;

                this._updateTextDefinition(this._selectedKey, textDefinition);
                this._onTextFormChange(textDefinition);
                this._selectedKey = textDefinition.key;
            } else {
                addButton.disabled = true;
                ticketTextList.disabled = true;
            }
        });

        this._textForm.textDefinitionExistsCheck = (key) => {
            if(this._selectedKey != undefined && this._selectedKey == key) {
                return false;
            }
            return this._findTextDefinitionIndex(key) >= 0;
        }

        ticketTextList.onSelect((key) => {
            this._selectListeners.forEach((listener) => {
                if(listener) listener(key);
            });
        });
        
        addButton.addEventListener('click', () => {
            this._add();
        });

        deleteButton.addEventListener('click', () => {
            this._delete();
        });
    }

    validate() {
        return this._textForm.validate();
    }

    _add() {
        this._drawable = undefined;
        this._selectedKey = undefined;

        this.selectedDrawable = {};

        this._addListeners.forEach((listener) => {
            if(listener) listener();
        });
    }

    _delete() {

        this._drawingCanvas.remove(this._drawable);
        
        if(this._selectedKey) {
            this._removeTextDefinition(this._selectedKey);
        }

        this._drawable = undefined;
        this._selectedKey = undefined;
        this.selectedDrawable = undefined;
        this._textForm.reset();

        this._deleteListeners.forEach((listener) => {
            if(listener) listener();
        });
    }

    _updateTextDefinition(key, textDefinition) {
        // Remove old entry
        let oldIndex = this._findTextDefinitionIndex(key);
        if(oldIndex >= 0) {
            this._textDefinitions.splice(oldIndex, 1);
        }
        // Add new entry
        if(textDefinition.key) {
            this._textDefinitions.push(textDefinition);
        }

        // Remove old entry
        if(this._ticketTextList.contains(key)) {
            this._ticketTextList.remove(key);
        }
        // Add new entry
        if(textDefinition.key) {
            this._ticketTextList.add(textDefinition.key);
        }
    }

    _removeTextDefinition(key) {
        let index = this._findTextDefinitionIndex(key);
        if(index >= 0) {
            this._textDefinitions.splice(index, 1);
        }
        this._ticketTextList.remove(key);
    }

    _findTextDefinitionIndex(key) {
        for(let i = 0; i < this._textDefinitions.length; i++) {
            if(this._textDefinitions[i].key === key) {
                return i;
            }
        }
        return -1;
    }

    get selectedDrawable() {
        return this._drawable;
    }

    set selectedDrawable(drawable) {

        if(drawable && drawable instanceof TicketText) {

            this._drawable = drawable;
            this._selectedKey = drawable.key();
            this._textForm.setValue(drawable);
            this._updateTextDefinition(this._selectedKey, this._textForm.value);
            this._textForm.setDisabled(false);
            this._ticketTextList.disabled = !this._textForm.validate();
            this._addButton.disabled = !this._textForm.validate();
            this._deleteButton.disabled = false;

            if(drawable.key()) {
                this._ticketTextList.add(drawable.key());
            }

        } else {
            this._drawable = undefined;
            this._selectedKey = undefined;
            this._textForm.setValue();
            this._textForm.setDisabled(true);
            this._ticketTextList.disabled = false;
            this._addButton.disabled = false;
            this._deleteButton.disabled = true;
        }
    }

    get value() {
        return this._textDefinitions;
    }

    set value(textDefinitions) {
        textDefinitions = textDefinitions || [];
        this._textDefinitions = textDefinitions;
        this._ticketTextList.value = textDefinitions;

        textDefinitions.forEach((textDefinition) => {

            let newRectangle = this._convertRectangle(textDefinition.rectangle);
            if(newRectangle) {
                let newText = new TicketText(textDefinition.key, textDefinition.description, newRectangle);
                this._drawingCanvas.add(newText);
            } else {
                console.error('TextDefinition has invalid rectangle');
                console.dir(textDefinition);
            }
        });
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

        let newRectangle = this._convertRectangle(newValue.rectangle);
        if(newRectangle) {
            let newText = new TicketText(newValue.key, newValue.description, newRectangle);

            if(this._drawable) {
                this._drawingCanvas.replace(this._drawable, newText);
            } else {
                this._drawingCanvas.add(newText);
            }
            this._drawable = newText;
        }
    }

    _convertRectangle(rectangle) {
        rectangle = rectangle || {};
        return this._drawingCanvas.drawableRectangle({
            x: rectangle.x,
            y: rectangle.y
        },{
            x: rectangle.x + rectangle.width,
            y: rectangle.y + rectangle.height
        });
    }
}
