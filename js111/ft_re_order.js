var secs = 5;
var wait = secs * 1000;

document.all.Submit.disabled = true;
window.setTimeout("timer()", wait);

function timer() {
        document.all.Submit.disabled = false;
}