import {SelectAndMoveMode} from '/public/designer/editor/mode/SelectAndMoveMode.js';
import {TextCreateMode} from '/public/designer/editor/mode/TextCreateMode.js';
import {BoundingBox} from '/public/designer/canvas/primitives/BoundingBox.js';

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
            && this._ticketTextEditor.validate()
            && this._validateTextDefinitions();
    }

    _validateTextDefinitions() {
        if(!this._textDefinitionsInsideImageBounds()) {
            $("#toast-textdefinitions-outside-image-bounds").toast('show');
            return false;
        }
        return true;
    }

    _textDefinitionsInsideImageBounds() {
        let template = this.value;
        let image = this._ticketTemplateEditor.image;
        let imageBoundingBox = BoundingBox.ofRectangle(image.x, image.y, image.width, image.height);

        for(let i = 0; i < template.textDefinitions.length; i++) {

            let textDefinition = template.textDefinitions[i];
            let boundingBox = BoundingBox.ofRectangle(
                textDefinition.rectangle.x, textDefinition.rectangle.y, 
                textDefinition.rectangle.width, textDefinition.rectangle.height
            );

            if(!imageBoundingBox.containsBoundingBox(boundingBox)) {
                return false;
            }
        }
        return true;
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
                    response.json().then(data => {
                        if(this._id === undefined) {
                            window.location = `/admin/designer/${data.id}`;
                        }
                    });
                } else if(response.status == 400) {
                    response.json().then(data => {
                        showMessages(data);
                    });
                }
            });
        }
    }

    _delete() {
        if(this._id !== undefined) {
            fetch(`/rest/admin/ticket-templates/${this._id}`, {
                method: 'DELETE'
            })
            .then(response => {
                if(response.ok) {
                    window.location.href = "/admin/templates";
                } else if(response.status == 400) {
                    response.json().then(data => {
                        showMessages(data);
                    });
                }
            });
        }
    }

    async getTicketTemplate(id) {
        if(id !== undefined && id !== '') {
            let response = await fetch(`/rest/admin/ticket-templates/${id}`);
            let data = await response.json();
            return data;
        }
        return {};
    }
}