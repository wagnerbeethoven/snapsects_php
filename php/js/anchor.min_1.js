// @license magnet:?xt=urn:btih:d3d9a9a6595521f9666a5e94cc830dab83b65699&dn=expat.txt Expat
//
// AnchorJS - v4.2.0 - 2019-01-01
// https://github.com/bryanbraun/anchorjs
// Copyright (c) 2019 Bryan Braun; Licensed MIT
//
// @license magnet:?xt=urn:btih:d3d9a9a6595521f9666a5e94cc830dab83b65699&dn=expat.txt Expat
! function (A, e) {
    "use strict";
    "function" == typeof define && define.amd ? define([], e) : "object" == typeof module && module.exports ? module.exports = e() : (A.AnchorJS = e(), A.anchors = new A.AnchorJS)
}(this, function () {
    "use strict";
    return function (A) {
        function f(A) {
            A.icon = A.hasOwnProperty("icon") ? A.icon : "", A.visible = A.hasOwnProperty("visible") ? A.visible : "hover", A.placement = A.hasOwnProperty("placement") ? A.placement : "right", A.ariaLabel = A.hasOwnProperty("ariaLabel") ? A.ariaLabel : "Anchor", A.class = A.hasOwnProperty("class") ? A.class : "", A.base = A.hasOwnProperty("base") ? A.base : "", A.truncate = A.hasOwnProperty("truncate") ? Math.floor(A.truncate) : 64, A.titleText = A.hasOwnProperty("titleText") ? A.titleText : ""
        }

        function p(A) {
            var e;
            if ("string" == typeof A || A instanceof String) e = [].slice.call(document.querySelectorAll(A));
            else {
                if (!(Array.isArray(A) || A instanceof NodeList)) throw new Error("The selector provided to AnchorJS was invalid.");
                e = [].slice.call(A)
            }
            return e
        }
        this.options = A || {}, this.elements = [], f(this.options), this.isTouchDevice = function () {
            return !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch)
        }, this.add = function (A) {
            var e, t, i, n, o, s, a, r, c, h, l, u, d = [];
            if (f(this.options), "touch" === (l = this.options.visible) && (l = this.isTouchDevice() ? "always" : "hover"), A || (A = "h2, h3, h4, h5, h6"), 0 === (e = p(A)).length) return this;
            for (function () {
                    if (null === document.head.querySelector("style.anchorjs")) {
                        var A, e = document.createElement("style");
                        e.className = "anchorjs", e.appendChild(document.createTextNode("")), void 0 === (A = document.head.querySelector('[rel="stylesheet"], style')) ? document.head.appendChild(e) : document.head.insertBefore(e, A), e.sheet.insertRule(" .anchorjs-link {   opacity: 0;   text-decoration: none;   -webkit-font-smoothing: antialiased;   -moz-osx-font-smoothing: grayscale; }", e.sheet.cssRules.length), e.sheet.insertRule(" *:hover > .anchorjs-link, .anchorjs-link:focus  {   opacity: 1; }", e.sheet.cssRules.length), e.sheet.insertRule(" [data-anchorjs-icon]::after {   content: attr(data-anchorjs-icon); }", e.sheet.cssRules.length), e.sheet.insertRule(' @font-face {   font-family: "anchorjs-icons";   src: url(data:n/a;base64,AAEAAAALAIAAAwAwT1MvMg8yG2cAAAE4AAAAYGNtYXDp3gC3AAABpAAAAExnYXNwAAAAEAAAA9wAAAAIZ2x5ZlQCcfwAAAH4AAABCGhlYWQHFvHyAAAAvAAAADZoaGVhBnACFwAAAPQAAAAkaG10eASAADEAAAGYAAAADGxvY2EACACEAAAB8AAAAAhtYXhwAAYAVwAAARgAAAAgbmFtZQGOH9cAAAMAAAAAunBvc3QAAwAAAAADvAAAACAAAQAAAAEAAHzE2p9fDzz1AAkEAAAAAADRecUWAAAAANQA6R8AAAAAAoACwAAAAAgAAgAAAAAAAAABAAADwP/AAAACgAAA/9MCrQABAAAAAAAAAAAAAAAAAAAAAwABAAAAAwBVAAIAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAMCQAGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAQAAg//0DwP/AAEADwABAAAAAAQAAAAAAAAAAAAAAIAAAAAAAAAIAAAACgAAxAAAAAwAAAAMAAAAcAAEAAwAAABwAAwABAAAAHAAEADAAAAAIAAgAAgAAACDpy//9//8AAAAg6cv//f///+EWNwADAAEAAAAAAAAAAAAAAAAACACEAAEAAAAAAAAAAAAAAAAxAAACAAQARAKAAsAAKwBUAAABIiYnJjQ3NzY2MzIWFxYUBwcGIicmNDc3NjQnJiYjIgYHBwYUFxYUBwYGIwciJicmNDc3NjIXFhQHBwYUFxYWMzI2Nzc2NCcmNDc2MhcWFAcHBgYjARQGDAUtLXoWOR8fORYtLTgKGwoKCjgaGg0gEhIgDXoaGgkJBQwHdR85Fi0tOAobCgoKOBoaDSASEiANehoaCQkKGwotLXoWOR8BMwUFLYEuehYXFxYugC44CQkKGwo4GkoaDQ0NDXoaShoKGwoFBe8XFi6ALjgJCQobCjgaShoNDQ0NehpKGgobCgoKLYEuehYXAAAADACWAAEAAAAAAAEACAAAAAEAAAAAAAIAAwAIAAEAAAAAAAMACAAAAAEAAAAAAAQACAAAAAEAAAAAAAUAAQALAAEAAAAAAAYACAAAAAMAAQQJAAEAEAAMAAMAAQQJAAIABgAcAAMAAQQJAAMAEAAMAAMAAQQJAAQAEAAMAAMAAQQJAAUAAgAiAAMAAQQJAAYAEAAMYW5jaG9yanM0MDBAAGEAbgBjAGgAbwByAGoAcwA0ADAAMABAAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAAH//wAP) format("truetype"); }', e.sheet.cssRules.length)
                    }
                }(), t = document.querySelectorAll("[id]"), i = [].map.call(t, function (A) {
                    return A.id
                }), o = 0; o < e.length; o++)
                if (this.hasAnchorJSLink(e[o])) d.push(o);
                else {
                    if (e[o].hasAttribute("id")) n = e[o].getAttribute("id");
                    else if (e[o].hasAttribute("data-anchor-id")) n = e[o].getAttribute("data-anchor-id");
                    else {
                        for (c = r = this.urlify(e[o].textContent), a = 0; void 0 !== s && (c = r + "-" + a), a += 1, -1 !== (s = i.indexOf(c)););
                        s = void 0, i.push(c), e[o].setAttribute("id", c), n = c
                    }
                    n.replace(/-/g, " "), (h = document.createElement("a")).className = "anchorjs-link " + this.options.class, h.setAttribute("aria-label", this.options.ariaLabel), h.setAttribute("data-anchorjs-icon", this.options.icon), this.options.titleText && (h.title = this.options.titleText), u = document.querySelector("base") ? window.location.pathname + window.location.search : "", u = this.options.base || u, h.href = u + "#" + n, "always" === l && (h.style.opacity = "1"), "" === this.options.icon && (h.style.font = "1em/1 anchorjs-icons", "left" === this.options.placement && (h.style.lineHeight = "inherit")), "left" === this.options.placement ? (h.style.position = "absolute", h.style.marginLeft = "-1em", h.style.paddingRight = "0.5em", e[o].insertBefore(h, e[o].firstChild)) : (h.style.paddingLeft = "0.375em", e[o].appendChild(h))
                } for (o = 0; o < d.length; o++) e.splice(d[o] - o, 1);
            return this.elements = this.elements.concat(e), this
        }, this.remove = function (A) {
            for (var e, t, i = p(A), n = 0; n < i.length; n++)(t = i[n].querySelector(".anchorjs-link")) && (-1 !== (e = this.elements.indexOf(i[n])) && this.elements.splice(e, 1), i[n].removeChild(t));
            return this
        }, this.removeAll = function () {
            this.remove(this.elements)
        }, this.urlify = function (A) {
            return this.options.truncate || f(this.options), A.trim().replace(/\'/gi, "").replace(/[& +$,:;=?@"#{}|^~[`%!'<>\]\.\/\(\)\*\\\n\t\b\v]/g, "-").replace(/-{2,}/g, "-").substring(0, this.options.truncate).replace(/^-+|-+$/gm, "").toLowerCase()
        }, this.hasAnchorJSLink = function (A) {
            var e = A.firstChild && -1 < (" " + A.firstChild.className + " ").indexOf(" anchorjs-link "),
                t = A.lastChild && -1 < (" " + A.lastChild.className + " ").indexOf(" anchorjs-link ");
            return e || t || !1
        }
    }
});
// @license-end
