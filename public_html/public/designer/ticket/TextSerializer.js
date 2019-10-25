
export class TextSerializer {

    serialize(text) {
        if(Array.isArray(text)) {
            return this._textsToString(text);
        } else {
            return this._textToString(text);
        }
    }

    _textsToString(texts) {
        var out = "";
        for(var textIndex = 0; textIndex < texts.length; textIndex++) {
            out += this._textToString(texts[textIndex]) + "\n";
        }
        return out;
    }
    
    _textToString(text) {
        var out = "";
        out += "name="+text.name + "\n";
        out += "boundingbox="+text.topLeft.x + ","+text.topLeft.y + ","+text.bottomRight.x + ","+text.bottomRight.y +"\n";
        return out;
    }
}
