import {DrawableImage} from '/components/designer/canvas/drawables/DrawableImage.js';
import {SelectAndMoveMode} from '/components/designer/editor/mode/SelectAndMoveMode.js';
import {TextCreateMode} from '/components/designer/editor/mode/TextCreateMode.js';
import {ImageFilesReader} from '/components/designer/io/ImageFilesReader.js';

export class Editor {
    
    constructor(drawingCanvas, interactionCanvas, templateImageUpload, addTextModeButton, cancelButton, editorTools) {
		
        this._drawingCanvas = drawingCanvas;
        
        templateImageUpload.setReader(new ImageFilesReader((img) => {
            let image = new DrawableImage(img);
            this._drawingCanvas.add(image);

            // TODO: cleanup
            console.dir(templateImageUpload.files);
            const formData = new FormData();

            for (let i = 0; i < templateImageUpload.files.length; i++) {
                let file = templateImageUpload.files[i]
        
                formData.append('files[]', file)
            }
        
            fetch('/admin/process.php', {
                method: 'POST',
                body: formData,
            }).then(response => {
                
            })
        }));
        
        this._interactionCanvas = interactionCanvas;
        this._textCreateMode = new TextCreateMode(this._drawingCanvas);
        this._selectMoveMode = new SelectAndMoveMode(this._drawingCanvas);
        this._interactionCanvas.setMode(this._selectMoveMode);

        this._selectMoveMode.onSelectedDrawableChange(function(selectedDrawable) {
            editorTools.bindDrawable(selectedDrawable);
        });

        cancelButton.addEventListener('click', () => {
            this._interactionCanvas.setMode(this._selectMoveMode);
            addTextModeButton.disabled = false;
            cancelButton.style.display = "none";
        });

        this._textCreateMode.onFinish((text) => {
            this._interactionCanvas.setMode(this._selectMoveMode);
            this._selectMoveMode.select(text);
            addTextModeButton.disabled = false;
            cancelButton.style.display = "none";
            text.calculateColor();
        });
        
        addTextModeButton.addEventListener('click', () => {
            this._interactionCanvas.setMode(this._textCreateMode);
            addTextModeButton.disabled = true;
            cancelButton.style.display = "initial";
        });
    }

    draw() {
        this._drawingCanvas.draw();
    }
}