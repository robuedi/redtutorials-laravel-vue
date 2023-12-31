export default class CookieBar {
    constructor(){

        this.loadLibrary();

        var cookiebar = new Cookiebar({
            id: "cookiebar",
            cls: "cookiebar",
            cookie: "cookiebar",
            content: {
                description: "This website uses cookies to improve user experience. By using this website you consent to all cookies in accordance with our ",
                link: "Privacy and Cookie Policy.",
                href: "/info/privacy-and-cookies-policy",
                button: "Continue",
                more: "..."
            },
            fade: {
                type: "in",
                ms: "500",
                display: "inline"
            },
            debug: 0    
        });
    }

    loadLibrary()
    {
        /**
         * cookiebar - It is a pure JS code, that warns the visitors in the notification bar, the page saves cookies. This is Compliant with the new EU cookie law.
         * Date 2018-12-25T03:13:56Z
         * 
         * @author Tamás András Horváth <htomy92@gmail.com> (https://icetee.hu)
         * @version v1.0.0
         * @link https://github.com/icetee/cookiebar#readme
         * @license MIT
         */

        !function(t,e){"function"==typeof define&&define.amd?define([],function(){return e(t)}):"object"==typeof exports?module.exports=e(t):t.Cookiebar=e(t)}("undefined"!=typeof global?global:"undefined"!=typeof window?window:this,function(d){var s=d.document;function o(t){if(!(this instanceof o))return new o(t);var e=t.charAt(0);this.el="#"===e?s.getElementById(t.substr(1)):"."===e?s.getElementsByClassName(t.substr(1)):s.getElementsByTagName(t)}o.prototype.fade=function(t,e,o){var i="in"===t,n=i?0:1,a=50/e,s=o||"inline",r=this;i&&(r.el.style.display=s,r.el.style.opacity=n);var c=d.setInterval(function(){n=i?n+a:n-a,(r.el.style.opacity=n)<=0&&(r.el.style.display="none"),(n<=0||1<=n)&&d.clearInterval(c)},50)};var t=function(){};t.prototype.extend=function(t){for(var e=1;e<arguments.length;++e){var o=arguments[e];if("object"==typeof o)for(var i in o)o.hasOwnProperty(i)&&(t[i]="object"==typeof o[i]?this.extend({},t[i],o[i]):o[i])}return t},t.prototype.trigger=function(t,e){var o=s.createEvent("Event");o.initEvent(e,!0,!0),t.dispatchEvent(o)},t.prototype.addEvent=function(t,e,o){return t[d.attachEvent?"attachEvent":"addEventListener"]((d.attachEvent?"on":"")+e,o,!0)},t.prototype.removeEvent=function(t,e,o){t.detachEvent?t.detachEvent("on"+e,o):t.removeEventListener(e,o)},t.prototype.parseTemplate=function(t,o){return t.replace(/\$\{(\w+)\}/gi,function(t,e){return void 0!==o[e]?o[e]:t})};var i=new t,e=function(t){var e=this;this.opt=i.extend({id:"cookiebar",cls:"cookiebar",cookie:"cookiebar",content:{description:"The site uses cookies to operate. By using our services you agree to use the cookies!",link:"More information",href:"http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm",button:"Accept",more:""},fade:{type:"in",ms:"500",display:"inline"},debug:0,exits:!0},t||{}),this.bar=null,this.data=this.opt,this.bodyMargBotBackup=s.body.style.marginBottom||"",this.accepted=!1,this.events={btnClick:function(t){t&&t.preventDefault?t.preventDefault():"object"==typeof t&&(t.returnValue=!1),e.accept()},winResize:function(){e.accepted||(s.body.style.marginBottom=e.bar.offsetHeight+"px")}},this.init()};return e.prototype.init=function(){var t=this;t.data.debug?t.setCookie("debug_cookibar","test",365,function(){t.withdraw()}):t.checkCookie()},e.prototype.getCookie=function(t){for(var e=t+"=",o=s.cookie.split(";"),i=0;i<o.length;i++){for(var n=o[i];" "==n.charAt(0);)n=n.substring(1);if(0===n.indexOf(e))return n.substring(e.length,n.length)}return""},e.prototype.setCookie=function(t,e,o,i){var n=new Date;n.setDate(n.getDate()+o);var a=escape(e)+(null===o?"":"; expires="+n.toUTCString()+"; path=/;");s.cookie=t+"="+a,"function"==typeof i&&i.call(this)},e.prototype.delCookie=function(t){s.cookie=t+"=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/"},e.prototype.html=function(){return i.parseTemplate('<div class="${cls}-wrapper"><div class="${cls}-content"><div class="${cls}-desciption">${des}</div><div class="${cls}-link"><a href="${href}">${link}</a></div></div><div class="${cls}-more" style="display: none;">${more}</div><div class="${cls}-actions"><div class="${cls}-button"><button type="button" name="${cls}-button" class="${cls}-btn">${btn}</button></div></div></div>',{cls:this.data.cls,href:this.data.content.href,link:this.data.content.link,more:this.data.content.more,btn:this.data.content.button,des:this.data.content.description})},e.prototype.withdraw=function(){this.delCookie(this.data.id),this.accepted=!1,this.checkCookie()},e.prototype.accept=function(){this.accepted=!0,this.setCookie(this.data.cookie,!0,365),i.removeEvent(d,"resize",this.events.winResize),this.bar&&(this.bar.style.display="none"),s.body.style.marginBottom!==this.bodyMargBotBackup&&(s.body.style.marginBottom=this.bodyMargBotBackup)},e.prototype.draw=function(){var t,e=this;e.accepted||(e.bar||(e.bar=s.createElement("div"),e.bar.id=e.data.id,e.bar.className=e.data.cls,e.bar.innerHTML=e.html(),s.body.insertBefore(e.bar,s.body.firstChild),t=e.bar.getElementsByClassName(e.data.cls+"-btn")[0],i.addEvent(t,"click",e.events.btnClick)),i.addEvent(d,"resize",e.events.winResize),i.trigger(d,"resize"),o("#"+e.data.id).fade(e.data.fade.type,e.data.fade.ms),e.setCookie(e.data.cookie,null,365))},e.prototype.checkCookie=function(){this.accepted="true"===this.getCookie(this.data.cookie),this.accepted||this.draw()},e.prototype.getStatus=function(){return this.accepted},e});
    }

}
