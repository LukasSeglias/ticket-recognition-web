import {SelectAndMoveMode} from '/public/designer/editor/mode/SelectAndMoveMode.js';
import {TextCreateMode} from '/public/designer/editor/mode/TextCreateMode.js';

export class Editor {
    
    constructor(drawingCanvas, interactionCanvas, templateImageUpload, ticketTextEditor, ticketTemplateEditor) {
		
        this._drawingCanvas = drawingCanvas;
        this._ticketTemplateEditor = ticketTemplateEditor;
        this._ticketTextEditor = ticketTextEditor;
        
        this._interactionCanvas = interactionCanvas;
        this._textCreateMode = new TextCreateMode(this._drawingCanvas);
        this._selectMoveMode = new SelectAndMoveMode(this._drawingCanvas);
        this._interactionCanvas.setMode(this._selectMoveMode);

        this._selectMoveMode.onSelectedDrawableChange(function(selectedDrawable) {
            ticketTextEditor.selectedDrawable = selectedDrawable;
        });

        this._textCreateMode.onFinish((text) => {
            this._interactionCanvas.setMode(this._selectMoveMode);
            this._selectMoveMode.select(text);
            text.calculateColor();
        });

        ticketTextEditor.onSelect((key) => {
            let list = this._drawingCanvas.find((drawable) => {
                return drawable.key && drawable.key() === key;
            });
            if(list.length > 0) {
                this._interactionCanvas.setMode(this._selectMoveMode);
                this._selectMoveMode.select(list[0]);
            }
        });

        ticketTextEditor.onAdd(() => {
            this._interactionCanvas.setMode(this._textCreateMode);
        });

        ticketTemplateEditor.onSave(() => {
            this._save();
        });

        ticketTemplateEditor.onDelete(() => {
            this._delete();
        });
    }

    draw() {
        this._drawingCanvas.draw();
    }

    set value(value) {

        this._id = value.id;
        this._ticketTemplateEditor.value = value;
        this._ticketTextEditor.value = value.textDefinitions;
    }

    get value() {
        let template = this._ticketTemplateEditor.value;
        template.textDefinitions = this._ticketTextEditor.value;
        return template;
    }

    init(id) {
        this.getTicketTemplate(id)
        .then((template) => {
            this.value = template;
        });
    }

    validate() {
        return this._ticketTemplateEditor.validate()
            && this._ticketTextEditor.validate();
    }

    _save() {
        if(this.validate()) {
            let template = this.value;

            let imageFile = new File([template.imageFile], template.imageFile.name);
            delete template.imageFile;

            const formData = new FormData();
            formData.append('templateImage', imageFile);
            formData.append('template', JSON.stringify(template));
            
            let url = this._id != undefined ? `/rest/admin/ticket-templates/${this._id}` : `/rest/admin/ticket-templates`;

            fetch(url, {
                method: 'POST',
                body: formData,
            }).then(response => {
                if(response.ok) {
                    $("#toast-save-successful").toast('show');
                }
                // TODO: handle error
            });
        }
    }

    _delete() {
        if(this._id !== undefined) {
            fetch(`/rest/admin/ticket-templates/${this._id}`, {
                method: 'DELETE'
            })
            .then(res => {
                if(res.ok) {
                    window.location.href = "/admin/designs.php";
                } else {
                    console.error('Error occured on template delete');
                }
            });
        }
    }

    async getTicketTemplate(id) {
        if(id !== undefined) {
            let response = await fetch(`/rest/admin/ticket-templates/${id}`);
            let data = await response.json();
            return data;
        }
        return {};
    }
}