import {TicketText} from '/public/designer/ticket/TicketText.js';

export class EditorTools  {
	
    constructor(element, textForm, ticketTextList, drawingCanvas) {

        this._drawingCanvas = drawingCanvas;
        this._textForm = textForm;
        this._ticketTextList = ticketTextList;

        this._drawingCanvas.addDrawableChangedListener((drawable) => {
            if(drawable === this.drawable) {
                this.bindDrawable(drawable);
            }
        });

        this._textForm.onChange((oldValue, newValue) => {
            
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

                if(this.drawable && this.drawable.key()) {
                    ticketTextList.removeText(this.drawable.key());
                }
                if(newValue.key) {
                    ticketTextList.addText(newValue.key);
                }

                if(this.drawable) {
                    this._drawingCanvas.replace(this.drawable, newText);
                } else {
                    this._drawingCanvas.add(newText);
                }
                this.drawable = newText;
            }
        });
    }

    bindDrawable(drawable) {
        this.drawable = drawable;

        if(drawable instanceof TicketText) {
            this._textForm.setValue(drawable);
            this._textForm.setDisabled(false);
        } else {
            this._textForm.setValue();
            this._textForm.setDisabled(true);
        }
    }
}
