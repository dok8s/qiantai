function chg_language(langx) {
    var homepage = "";
    if (langx != "zh-tw" && langx != "zh-cn") {
        homepage = "/tpl/member/en-us/QA.html";
    } else {
        homepage = "/tpl/member/"+langx+"/QA.html";
    }
    self.location = homepage;
}
function OnMouseOverPIC(langx) {
    document.getElementById("OverQA_"+langx).style.display = "";
    document.getElementById("OutQA_"+langx).style.display = "none";
}
function OnMouseOutPIC(langx) {
    document.getElementById("OverQA_"+langx).style.display = "none";
    document.getElementById("OutQA_"+langx).style.display = "";
}
function MM_showHideLayers() { //v9.0
    var i,p,v,obj,args=MM_showHideLayers.arguments;
    for (i=0; i<(args.length-2); i+=3)
        with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
            if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
            obj.visibility=v; }
}

function MouseEvent(qa,aa) {
    if(document.getElementById(qa).className=="Q_close"){
        document.getElementById(qa).className = "Q_up";
        document.getElementById(aa).style.display = "";
    }else if(document.getElementById(qa).className=="Q_up"){
        document.getElementById(qa).className = "Q_close";
        document.getElementById(aa).style.display = "none";
    }
}