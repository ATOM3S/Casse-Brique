var pElt = document.getElementById("scoreInfo");
var url = "http://numbersapi.com/" + pElt.textContent;

function addInfo(text) {
    pElt.textContent = text;
}

ajaxGet(url, addInfo);