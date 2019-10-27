
export class ImageFilesReader {

    async read(files) {

        let promises = [];
        
        for(let fileIndex = 0; fileIndex < files.length; fileIndex++) {
            promises.push(this._readImageFile(files[fileIndex]));
        }

        return Promise.all(promises);
    }

    async _readImageFile(file) {
        
        return new Promise((resolve, reject) => {

            let reader = new FileReader();
            reader.onload = (event) => {
                let img = new Image();
                img.src = event.target.result;
                img.onload = () => resolve({
                    image: img,
                    file: file
                });
            }
            reader.readAsDataURL(file);
        });
    }
}
