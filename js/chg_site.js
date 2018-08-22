

function chkhei(body_hei){

    var show_hei=document.body.scrollHeight;

    if(body_hei>=show_hei)
    {
        document.getElementById("bsDIV").style.height=body_hei+"px";
    }else{
        document.getElementById("bsDIV").style.height=show_hei+"px";
    }
}