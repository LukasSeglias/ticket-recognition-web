
export class ImageLoader {
    
    async fromUrl(url) {
        
        return fetch(url)
        .then(res => res.blob())
        .then(blob => {
            return this._blobToImage(blob)
            .then((image) => {
                const file = this._blobToFile(blob);
                return new Promise((resolve, reject) => resolve({
                    image: image,
                    file: file
                }));
            });
        });
    }

    async _blobToImage(blob) {
        return new Promise((resolve, reject) => {
            let img = new Image();
            img.src = URL.createObjectURL(blob);
            img.onload = () => resolve(img);
            img.onerror = () => reject();
        });
    }

    _blobToFile(blob) {
        let filename = this._randomFilename() + this._getFileExtensionForImageMimeType(blob.type);
        return new File([blob], filename, blob);
    }

    _randomFilename() {
        let min = 1000;
        let max = 100000;
        return Math.floor(Math.random() * (max - min + 1) + min);
    }

    _getFileExtensionForImageMimeType(imageType) {
        switch(imageType) {
            case "image/png": 
                return ".png";
            case "image/gif":
                return ".gif";
            case "image/bmp":
                return ".bmp";
            case "image/jpeg":
                return ".jpg";
            default:
                return undefined;
        }
    }
}
