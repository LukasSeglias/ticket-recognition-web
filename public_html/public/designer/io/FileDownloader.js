
export class FileDownloader {
			
    constructor(mediatype = 'text/plain', charset = 'utf-8') {
    
        this._mediatype = mediatype;
        this._charset = charset;
    }

    static get JSON_UTF8() {
        return new FileDownloader('application/json', 'utf-8');
    }

    static get TEXT_UTF8() {
        return new FileDownloader('text/plain', 'utf-8');
    }

    download(filename, content) {
        // Source: https://ourcodeworld.com/articles/read/189/how-to-create-a-file-and-generate-a-download-with-javascript-in-the-browser-without-a-server
        let element = document.createElement('a');
        element.setAttribute('href', 'data:' + this._mediatype + ';charset=' + this._charset + ',' + encodeURIComponent(content));
        element.setAttribute('download', filename);

        element.style.display = 'none';
        document.body.appendChild(element);

        element.click();

        document.body.removeChild(element);
    }
}
