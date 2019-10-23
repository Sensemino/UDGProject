/**
 * Created by etudiant on 15/02/17.
 */
function ajaxget(url)
{
    // Firefox, Chrome ...
    if(window.XMLHttpRequest)
        httprequest = new XMLHttpRequest();
    // IE
    else if(window.ActiveXObject)
        httprequest = new ActiveXObject("Microsoft.XMLHTTP");
    else
        return(false);
    httprequest.open("GET", url, true);
    httprequest.send(null);
    // 4 signifie 'complete', donc les données sont accessibles
}


function AjaxSend (url, method) {
    // hide all error fields


    // get message data
    // defined in ajax_form.js

    // send the request
    var httpRequest = CreateRequestObj ();  // defined in ajax_form.js
    // try..catch is required if working offline
    try {
        httpRequest.open("POST", url, false);  // synchron
        httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        httpRequest.send();
    }
    catch (e) {
        alert ("Cannot connect to the server!");
        return;
    }

    // handle the response
}


function CreateRequestObj () {
    // although IE supports the XMLHttpRequest object, but it does not work on local files.
    var forceActiveX = (window.ActiveXObject && location.protocol === "file:");
    if (window.XMLHttpRequest && !forceActiveX) {
        return new XMLHttpRequest();
    }
    else {
        try {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {}
    }
}

function GetMessageBody (form) {
    var data = "";
    for (var i = 0; i < form.elements.length; i++) {
        var elem = form.elements[i];
        if (elem.name) {
            var nodeName = elem.nodeName.toLowerCase ();
            var type = elem.type ? elem.type.toLowerCase () : "";

            // if an input:checked or input:radio is not checked, skip it
            if (nodeName === "input" && (type === "checkbox" || type === "radio")) {
                if (!elem.checked) {
                    continue;
                }
            }

            var param = "";
            // select element is special, if no value is specified the text must be sent
            if (nodeName === "select") {
                for (var j = 0; j < elem.options.length; j++) {
                    var option = elem.options[j];
                    if (option.selected) {
                        var valueAttr = option.getAttributeNode ("value");
                        var value = (valueAttr && valueAttr.specified) ? option.value : option.text;
                        if (param != "") {
                            param += "&";
                        }
                        param += encodeURIComponent (elem.name) + "=" + encodeURIComponent (value);
                    }
                }
            }
            else {
                param = encodeURIComponent (elem.name) + "=" + encodeURIComponent (elem.value);
            }

            if (data != "") {
                data += "&";
            }
            data += param;
        }
    }
    return data;
}
