/* -------------get params from url--------------*/
function getUrlVars()//method get param call by arg-> ['paramName']
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
/*  ------------------use name & value initialize--------------------------*/
// var paramName = 'adv';

var paramName = add_params_to_script.param_name;
var paramValue = getUrlVars()[paramName];
var timeCookie = parseInt(add_params_to_script.param_cookie);


function getCookie(name) {
    function escape(s) { return s.replace(/([.*+?\^${}()|\[\]\/\\])/g, '\\$1'); };
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
    return match ? match[1] : null;
}


/* ------------set param cookie by name & value on 24 hour---------------*/
function setParamInCookies(paramName, paramValue,timeCookie) { // SET COOKIE
    var d = new Date();
    d.setTime(d.getTime() + (timeCookie*24*60*60*1000)); // 30 days
    var expires = "expires="+ d.toUTCString();
    document.cookie = paramName + '=' + paramValue + ";" + expires + ";path=/";

}
/*---------------------------------*/
if(paramValue!=null) { //WRITE OR REWRITE PARAM IN COOKIE
  setParamInCookies(paramName,paramValue,timeCookie)
   // console.log('sett in cookie new param');
}
/* -------------------input hidden to form------------*/
var currentValueCookie = getCookie(paramName);
jQuery(document).ready( function ($) {
    $('li.adv input').val(currentValueCookie);
})

jQuery("form[id^='gform_']").on('submit', function(){
    setParamInCookies(paramName, paramValue,-1);
})

