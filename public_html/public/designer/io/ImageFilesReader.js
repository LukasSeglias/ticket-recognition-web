
export class ImageFilesReader {
            
    constructor(callback) {
        this._callback = callback;
    }

    read(files) {

        for(let fileIndex = 0; fileIndex < files.length; fileIndex++) {

            let reader = new FileReader();
            reader.onload = (event) => {
                let img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    this._callback.call(null, img);
                };
            }

            reader.readAsDataURL(files[fileIndex]);
        }
    };
}
