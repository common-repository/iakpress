/*! For license information please see 75.edaa3357.chunk.js.LICENSE.txt */
(this["webpackJsonpiak-bundles"]=this["webpackJsonpiak-bundles"]||[]).push([[75],{629:function(t,e,n){"use strict";n.r(e),n.d(e,"startTapClick",(function(){return o}));var i=n(36),o=function(t){var e,n,o,l,v=10*-f,p=0,L=t.getBoolean("animated",!0)&&t.getBoolean("rippleEffect",!0),m=new WeakMap,h=function(t){v=Object(i.q)(t),w(t)},E=function(){clearTimeout(l),l=void 0,n&&(T(!1),n=void 0)},b=function(t){n||void 0!==e&&null!==e.parentElement||(e=void 0,g(a(t),t))},w=function(t){g(void 0,t)},g=function(t,e){if(!t||t!==n){clearTimeout(l),l=void 0;var o=Object(i.p)(e),a=o.x,c=o.y;if(n){if(m.has(n))throw new Error("internal error");n.classList.contains(s)||k(n,a,c),T(!0)}if(t){var d=m.get(t);d&&(clearTimeout(d),m.delete(t));var f=r(t)?0:u;t.classList.remove(s),l=setTimeout((function(){k(t,a,c),l=void 0}),f)}n=t}},k=function(t,e,n){p=Date.now(),t.classList.add(s);var i=L&&c(t);i&&i.addRipple&&(q(),o=i.addRipple(e,n))},q=function(){void 0!==o&&(o.then((function(t){return t()})),o=void 0)},T=function(t){q();var e=n;if(e){var i=d-Date.now()+p;if(t&&i>0&&!r(e)){var o=setTimeout((function(){e.classList.remove(s),m.delete(e)}),d);m.set(e,o)}else e.classList.remove(s)}},j=document;j.addEventListener("ionScrollStart",(function(t){e=t.target,E()})),j.addEventListener("ionScrollEnd",(function(){e=void 0})),j.addEventListener("ionGestureCaptured",E),j.addEventListener("touchstart",(function(t){v=Object(i.q)(t),b(t)}),!0),j.addEventListener("touchcancel",h,!0),j.addEventListener("touchend",h,!0),j.addEventListener("mousedown",(function(t){var e=Object(i.q)(t)-f;v<e&&b(t)}),!0),j.addEventListener("mouseup",(function(t){var e=Object(i.q)(t)-f;v<e&&w(t)}),!0),j.addEventListener("contextmenu",(function(t){w(t)}),!0)},a=function(t){if(!t.composedPath)return t.target.closest(".ion-activatable");for(var e=t.composedPath(),n=0;n<e.length-2;n++){var i=e[n];if(i.classList&&i.classList.contains("ion-activatable"))return i}},r=function(t){return t.classList.contains("ion-activatable-instant")},c=function(t){if(t.shadowRoot){var e=t.shadowRoot.querySelector("ion-ripple-effect");if(e)return e}return t.querySelector("ion-ripple-effect")},s="ion-activated",u=200,d=200,f=2500}}]);
//# sourceMappingURL=75.edaa3357.chunk.js.map