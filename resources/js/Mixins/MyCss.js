
window.hasClass = (el, clsName) => {
    return el.className.indexOf(clsName) != -1
};
window.addClass = (el, clsName) => {
    if(!hasClass(el, clsName)) {
        el.className += " " + clsName
    }
};
window.removeClass = (el, clsName) => {
    el.className = el.className.replace(clsName, "").trim()
};
