import {addClass, hasClass, removeClass} from "leaflet/src/dom/DomUtil";

export default {
    methods: {
        hasClass(el, clsName) {
            return el.className.indexOf(clsName) != -1
        },
        addClass(el, clsName) {
            if(!hasClass(el, clsName)) {
                el.className += " " + clsName
            }
        },
        removeClass(el, clsName) {
            el.className = el.className.replace(clsName, "").trim()
        },
        toggleClass(el, className) {
            if(el) {
                if(hasClass(el,className)) {
                    removeClass(el, className)
                } else {
                    addClass(el, className)
                }
            }
        }
    }
}
