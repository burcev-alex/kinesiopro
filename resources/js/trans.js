export default function trans(key, replace) {
    let translation, translationNotFound = true
    
    try {
        translation = key.split('.').reduce((t, i) => t[i] || null, window._translations[window._locale].php)

        if (translation) {
            translationNotFound = false
        }
    } catch (e) {
        translation = key
    }

    if (translationNotFound) {
        translation = window._translations[window._locale]['json'][key]
            ? window._translations[window._locale]['json'][key]
            : key
    }
    
    if(replace && (typeof replace == 'array')){
        replace.forEach(function(value, key) {
            translation = translation.replace(':' + key, value)
        })
    }
    else if(replace && (typeof replace == 'object')){
        for (const [key, value] of Object.entries(replace)) {
            translation = translation.replace(':' + key, value)
        }
    }

    return translation
}