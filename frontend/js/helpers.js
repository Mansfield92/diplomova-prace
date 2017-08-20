module.exports = (function() {
    /**
     * Globally available console.log
     * that won't print anything in production.
     * Protip: blackbox this file in devtools
     */
    window.log = (...args) => {(!PRODUCTION) ? console.log(...args) : false;},
    window.warn = (...args) => {(!PRODUCTION) ? console.warn(...args) : false;},
    window.error = (...args) => {(!PRODUCTION) ? console.error(...args) : false;}
})();
