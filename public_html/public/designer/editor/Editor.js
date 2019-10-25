import {DrawableImage} from '/public/designer/canvas/drawables/DrawableImage.js';
import {SelectAndMoveMode} from '/public/designer/editor/mode/SelectAndMoveMode.js';
import {TextCreateMode} from '/public/designer/editor/mode/TextCreateMode.js';
import {ImageFilesReader} from '/public/designer/io/ImageFilesReader.js';

export class Editor {
    
    constructor(drawingCanvas, interactionCanvas, templateImageUpload, ticketTextEditor) {
		
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
            ticketTextEditor.value = selectedDrawable;
        });

        this._textCreateMode.onFinish((text) => {
            console.log('finished text, switch mode');
            this._interactionCanvas.setMode(this._selectMoveMode);
            this._selectMoveMode.select(text);
            text.calculateColor();
        });

        ticketTextEditor.onSelect((key) => {
            let list = this._drawingCanvas.find((drawable) => {
                console.log('drawable');
                console.dir(drawable);

                if(drawable.key){
                    console.log(' drawable key is ' + drawable.key());
                }
                return drawable.key && drawable.key() === key;
            });
            console.log('found ' + list.length + ' entries that match key : ' + key);
            if(list.length > 0) {
                this._interactionCanvas.setMode(this._selectMoveMode);
                this._selectMoveMode.select(list[0]);
            }
        });

        ticketTextEditor.onAdd(() => {
            this._interactionCanvas.setMode(this._textCreateMode);
        });
    }

    draw() {
        this._drawingCanvas.draw();
    }
}