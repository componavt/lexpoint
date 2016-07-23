function toggleText(textName, eleName, showText, hideText) {
    var ele = document.getElementById(eleName);
    var text = document.getElementById(textName);
    if (ele.style.display == "block") {
            ele.style.display = "none";
        text.innerHTML = showText;
    }
    else {
        ele.style.display = "block";
        text.innerHTML = hideText;
    }
} 
