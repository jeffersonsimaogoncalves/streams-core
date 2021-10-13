import lzs from 'lz-string';

export class Transformer {
    static typePrefix = '__ls_';

    static compress(value) {
        return this.typePrefix + 'lz-s|' + lzs.compressToUTF16(value);
    }

    static decompress(value) {
        let type, length, source;

        length = value.length;
        if ( length < 9 ) {
            // then it wasn't compressed by us
            return value;
        }

        type   = value.substr(0, 8);
        source = value.substring(9);

        if ( type === this.typePrefix + 'lz-s' ) {
            value = lzs.decompressFromUTF16(source);
        }

        return value;
    }

    static encode(value) {
        if ( Object.prototype.toString.call(value) === '[object Date]' ) {
            return this.typePrefix + 'date|' + value.toUTCString();
        }
        if ( Object.prototype.toString.call(value) === '[object RegExp]' ) {
            return this.typePrefix + 'expr|' + value.source;
        }
        if ( typeof value === 'number' ) {
            return this.typePrefix + 'numb|' + value;
        }
        if ( typeof value === 'boolean' ) {
            return this.typePrefix + 'bool|' + (value ? '1' : '0');
        }
        if ( typeof value === 'string' ) {
            return this.typePrefix + 'strn|' + value;
        }
        if ( typeof value === 'function' ) {
            return this.typePrefix + 'strn|' + value.toString();
        }
        if ( value === Object(value) ) {
            return this.typePrefix + 'objt|' + JSON.stringify(value);
        }

        // hmm, we don't know what to do with it,
        // so just return it as is
        return value;
    }

    static decode(value) {
        let type, length, source;

        length = value.length;
        if ( length < 9 ) {
            // then it wasn't encoded by us
            return value;
        }

        type   = value.substr(0, 8);
        source = value.substring(9);

        switch ( type ) {
            case this.typePrefix + 'date':
                return new Date(source);

            case this.typePrefix + 'expr':
                return new RegExp(source);

            case this.typePrefix + 'numb':
                return Number(source);

            case this.typePrefix + 'bool':
                return Boolean(source === '1');

            case this.typePrefix + 'strn':
                return '' + source;

            case this.typePrefix + 'objt':
                return JSON.parse(source);

            default:
                // hmm, we reached here, we don't know the type,
                // then it means it wasn't encoded by us, so just
                // return whatever value it is
                return value;
        }
    }
}
