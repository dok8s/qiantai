/**
 * Created by LIYUQING on 2017-8-26.
 */
var frame_broke = 'Y';
var show_ior = '100';
var username='';
var maxcredit='';
var code='';
var pg=0;
var sel_league='';
var loading = 'Y';
var loading_var = 'Y';
var ShowType = '';
var ltype = '2';
var retime_flag = 'N';
var retime = 0;
var str_even = '和局';
var str_renew = '秒自動更新';
var str_submit = '確認';
var str_reset = '重設';
var pages = 1;
var msg = '';
var gamount = 0;
var GameFT = new Array(512);
var iorpoints=2;
var GameHead=new Array();
var show_more_gid = '';
var delay='';
var league_id='';
var hot_game='';
top.SortType='T';
top.odd_f_type='H';
var odd_f_str = 'H,M,I,E';
var lid_arr=new Array();
top.lid_arr=lid_arr;
top.today_gmt = '2017-08-25';
top.showtype = '';
top.rtype = rtype;
top.sel_gd = 'ALL';
var g_date= 'ALL';
var Format=new Array();
Format[0]=new Array( 'H','香港盘','Y');
Format[1]=new Array( 'M','马来盘','Y');
Format[2]=new Array( 'I','印尼盘','Y');
Format[3]=new Array( 'E','欧洲盘','Y');
var keepGameData=new Object();
var gidData=new Array();
parent.gamecount=0;
//判斷賠率是否變動
//包td
var motherStr;
try{
    if(frame_broke) motherStr = "";

}catch(e){
    //try{ console.log("error str set from flash_ior_mem"); }catch(e){};
    motherStr = "parent.";
}

//包font
function checkRatio_font(gid,rtype,value){

    if (flash_ior_set =='Y'){
        if (""+keepGameData[gid]=="undefined"||keepGameData[gid]==""){
            keepGameData[gid] = new Object();
        }
        if (""+keepGameData[gid][rtype]=="undefined"||keepGameData[gid][rtype] ==""){
            keepGameData[gid][rtype]=value;
        }
        if (keepGameData[gid][rtype]!=value && keepGameData[gid][rtype]!=""&&value!="") {
            keepGameData[gid][rtype]=value;
            //keepGameData[gid][rtype] = "";
            //return "<span name=\"jq_fade_out\" class=\"live_oddWordBox\"></span>";
            return ' onmouseover=\"iornameMouseOver(this.id);\" class="bet_text_color"';
        }

        return 'class="bet_bg_color"';
    }
}
/*
 function checkRatio_font(rec,index){

 gid = gameData[rec]["gid"];

 if (flash_ior_set =='Y'){
 if (""+keepGameData[gid]=="undefined"||keepGameData[gid]==""){
 keepGameData[gid] = new Object();
 }

 if (""+keepGameData[gid][index]=="undefined"||keepGameData[gid][index] ==""){
 keepGameData[gid][index]=gameData[rec][index];
 }
 if (keepGameData[gid][index]!=gameData[rec][index] && keepGameData[gid][index] !=""&&gameData[rec][index]!="") {
 keepGameData[gid][index] = "";
 return "<span name=\"jq_fade_out\" class=\"live_oddWordBox\"></span>";
 }

 return "";
 }
 }
 */

function runFadeOut(){
    //JQ.fadeOut("span[name='jq_fade_out']", fade_out_sec);
}

function gethighlight(){
    return " style=\"color:red\" style=\"font-weight:bolder\" ";
}
//滑鼠移動帶出索引
//function showMsg(msg, type) {
//	var showHelpMsg = body_browse.document.getElementById("showHelpMsg");
////	var showHelpMsg = parent.body_browse.document.getElementById('showHelpMsg');
//	var helpMsg = body_browse.document.getElementById('helpMsg').innerHTML;
//	var tmpHTML = "";
//	if(type == 1) {
//		tmpHTML = helpMsg;
//		tmpHTML = tmpHTML.replace("*SHOWMSG*", msg);
//		showHelpMsg.innerHTML = tmpHTML;
//		showHelpMsg.style.display = "block";
//		showHelpMsg.style.top = body_browse.document.body.scrollTop+body_browse.event.clientY-10;
//		showHelpMsg.style.left = body_browse.document.body.scrollLeft+body_browse.event.clientX+10;
//	} else showHelpMsg.style.display = "none";
//}

//====== 加入現場轉播功能 2009-04-09
// 開啟轉播
function OpenLive(eventid, gtype){

    var paramObj = new Object();
    paramObj["eventid"] = eventid;
    paramObj["eventlive"] = "Y";
    paramObj["gtype"] = gtype;

    try{
        parent.showLive(paramObj);
    }catch(e){

    }
}

function VideoFun(eventid, hot, play, gtype) {
    var tmpStr = "";
    //play="Y";

    if(top.showKR=="Y"){
        tmpStr = " style=\"visibility:hidden\"";
    }else if (play == "Y"&&eventid!="") {
        //tmpStr+= "<img lowsrc=\"/images/member/video_1.gif\" onClick=\"parent.OpenLive('"+eventid+"','"+gtype+"')\" style=\"cursor:hand\">";
        tmpStr= " onClick=\""+motherStr+"OpenLive('"+eventid+"','"+gtype+"')\"";
    }

    return tmpStr;
}

function MM_ShowLoveI(gid,getDateTime,getLid,team_h,team_c){
    var txtout="";
    var ret = new Object();
    var _id = MM_imgId(getDateTime,gid);
    if(!chkRepeat(gid,getDateTime)){
        //txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div id='"+MM_imgId(getDateTime,gid)+"' class=\"fov_icon_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></div></span>";

        ret["id"] = _id;
        ret["css"] = " style='display:none' ";
        ret["css"]+= " class='bet_game_star_out' ";
        ret["css"]+= " title='"+top.str_ShowMyFavorite+"' ";
        ret["css"]+= " onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"');\" ";
    }else{
        //txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div></span>";

        ret["id"] = _id+"_off";
        ret["css"] = " title='"+top.str_delShowLoveI+"' ";
        ret["css"]+= " class='bet_game_star_on' ";
        ret["css"]+= " onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\" ";
    }

    return ret;
}
// 足球 其它 棒球 160322 joe
function MM_ShowLoveI_FT(gid,getDateTime,getLid,team_h,team_c,gidm){
    var txtout="";
    var ret = new Object();
    var _id = MM_imgId(getDateTime,gid);
    if(!chkRepeat(gid,getDateTime)){
        //txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div id='"+MM_imgId(getDateTime,gid)+"' class=\"fov_icon_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"'); \"></div></span>";

        ret["id"] = _id;
        ret["css"] = " style='display:none' ";
        ret["css"]+= " class='bet_game_star_out' ";
        ret["css"]+= " title='"+top.str_ShowMyFavorite+"' ";
        ret["css"]+= " onClick=\"addShowLoveI('"+gid+"','"+getDateTime+"','"+getLid+"','"+team_h+"','"+team_c+"','"+gidm+"');\" ";
    }else{
        //txtout = "<span id='sp_"+MM_imgId(getDateTime,gid)+"'><div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"'); \"></div></span>";

        ret["id"] = _id+"_off";
        ret["css"] = " title='"+top.str_delShowLoveI+"' ";
        ret["css"]+= " class='bet_game_star_on' ";
        ret["css"]+= " onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\" ";
    }

    return ret;
}



function chkRepeat(gid,getDateTime){
    var getGtype =getGtypeShowLoveI();
    var sw =false;
    try{
        for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
            //if(top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1].substr(0,15) == getDateTime.substr(0,15))
            // 2017-03-22 3054. 新舊會員端-所有球類-當賽事加進我的最愛後再更改時間，我的最愛中賽事只更新時間，星星的小圖示會沒有出現，正確應為時間更新、星星也出現
            if(top.ShowLoveIarray[getGtype][i][0]==gid)
                sw =true;
        }
    }
    catch(e){};
    return sw;
}


function MM_IdentificationDisplay(time,gid){
    var getGtype = getGtypeShowLoveI();

    try{
        var txt_array = top.ShowLoveIOKarray[getGtype];
    }catch(e){}
    if(top.swShowLoveI){
        var tmp = time.split("<br>")[0];
        if(txt_array.length==0)return true;
        if(txt_array.indexOf(tmp+gid +",",0)== -1)
            return true;
    }

}
function MM_IdentificationDisplay_FT(time,gid,gidm){
    var getGtype = getGtypeShowLoveI();

    try{
        var txt_array = top.ShowLoveIOKarray[getGtype];
    }catch(e){}

    if(top.swShowLoveI){
        var tmp = time.split("<br>")[0];
        //console.log(txt_array.indexOf(gidm)!= -1);
        if(txt_array.length==0)return true;
        if(txt_array.indexOf("@"+gidm+",")!= -1)return false; //多判斷gidm
        else return true;
        //if(txt_array.indexOf(tmp+gid+",",0)== -1) return true;
    }

}

function getGtypeShowLoveI(){
    var Gtype;
    var getGtype =sel_gtype;
    var getRtype =rtype;
    Gtype =getGtype;
    if(getRtype=="re"){
        Gtype +="RE";
    }
    /*
     if(getGtype =="FU"||getGtype=="FT"){
     Gtype ="FT";
     }else if(getGtype =="OM"||getGtype=="OP"){
     Gtype ="OP";
     }else if(getGtype =="BU"||getGtype=="BK"){
     Gtype ="BK";
     }else if(getGtype =="BSFU"||getGtype=="BS"){
     Gtype ="BS";
     }else if(getGtype =="VU"||getGtype=="VB"){
     Gtype ="VB";
     }else if(getGtype =="TU"||getGtype=="TN"){
     Gtype ="TN";
     }else {
     Gtype ="FT";
     }
     */

    //alert("in==>"+parent.sel_gtype+",out==>"+Gtype);
    return Gtype;
}
function MM_imgId(time,gid){
    var tmp = time.split("<br>")[0];
    //alert("tmp===>"+tmp+"==="+"gid===>"+gid+"===");
    return tmp+gid;
}


/**
 * 選擇多盤口時 轉換成該選擇賠率
 * @param odd_type 	選擇盤口
 * @param iorH		主賠率
 * @param iorC		客賠率
 * @param show		顯示位數
 * @return		回傳陣列 0-->H  ,1-->C
 */
function  get_other_ioratio(odd_type, iorH, iorC , showior){
    var out=new Array();
    if(iorH!="" ||iorC!=""){
        out =chg_ior(odd_type,iorH,iorC,showior);
    }else{
        out[0]=iorH;
        out[1]=iorC;
    }
    return out;
}
/**
 * 轉換賠率
 * @param odd_f
 * @param H_ratio
 * @param C_ratio
 * @param showior
 * @return
 */
function chg_ior(odd_f,iorH,iorC,showior){
    //console.log("1. "+odd_f+"<>"+iorH+"<>"+iorC+"<>"+showior);
    iorH = Math.floor((iorH*1000)+0.001) / 1000;
    iorC = Math.floor((iorC*1000)+0.001) / 1000;

    var ior=new Array();
    if(iorH < 11) iorH *=1000;
    if(iorC < 11) iorC *=1000;
    iorH=parseFloat(iorH);
    iorC=parseFloat(iorC);
    switch(odd_f){
        case "H":	//香港變盤(輸水盤)
            ior = get_HK_ior(iorH,iorC);
            break;
        case "M":	//馬來盤
            ior = get_MA_ior(iorH,iorC);
            break;
        case "I" :	//印尼盤
            ior = get_IND_ior(iorH,iorC);
            break;
        case "E":	//歐洲盤
            ior = get_EU_ior(iorH,iorC);
            break;
        default:	//香港盤
            ior[0]=iorH ;
            ior[1]=iorC ;
    }
    ior[0]/=1000;
    ior[1]/=1000;

    ior[0]=printf(Decimal_point(ior[0],showior),iorpoints);
    ior[1]=printf(Decimal_point(ior[1],showior),iorpoints);
    //alert("odd_f="+odd_f+",iorH="+iorH+",iorC="+iorC+",ouH="+ior[0]+",ouC="+ior[1]);
    return ior;
}

/**
 * 換算成輸水盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_HK_ior( H_ratio, C_ratio){
    var out_ior=new Array();
    var line,lowRatio,nowRatio,highRatio;
    var nowType="";
    if (H_ratio <= 1000 && C_ratio <= 1000){
        out_ior[0]=Math.floor(H_ratio/10+0.0001)*10;
        out_ior[1]=Math.floor(C_ratio/10+0.0001)*10;
        //out_ior[0]=H_ratio;
        //out_ior[1]=C_ratio;
        return out_ior;
    }
    line=2000 - ( H_ratio + C_ratio );

    if (H_ratio > C_ratio){
        lowRatio=C_ratio;
        nowType = "C";
    }else{
        lowRatio = H_ratio;
        nowType = "H";
    }
    if (((2000 - line) - lowRatio) > 1000){
        //對盤馬來盤
        nowRatio = (lowRatio + line) * (-1);
    }else{
        //對盤香港盤
        nowRatio=(2000 - line) - lowRatio;
    }

    if (nowRatio < 0){
        highRatio = Math.floor(Math.abs(1000 / nowRatio) * 1000) ;
    }else{
        highRatio = (2000 - line - nowRatio) ;
    }
    if (nowType == "H"){
        out_ior[0]=Math.floor(lowRatio/10+0.0001)*10;
        out_ior[1]=Math.floor(highRatio/10+0.0001)*10;
        //out_ior[0]=lowRatio;
        //out_ior[1]=highRatio;
    }else{
        out_ior[0]=Math.floor(highRatio/10+0.0001)*10;
        out_ior[1]=Math.floor(lowRatio/10+0.0001)*10;
        //out_ior[0]=highRatio;
        //out_ior[1]=lowRatio;
    }
    return out_ior;
}
/**
 * 換算成馬來盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_MA_ior( H_ratio, C_ratio){
    var out_ior=new Array();
    var line,lowRatio,highRatio;
    var nowType="";
    if ((H_ratio <= 1000 && C_ratio <= 1000)){
        out_ior[0]=H_ratio;
        out_ior[1]=C_ratio;
        return out_ior;
    }
    line=2000 - ( H_ratio + C_ratio );
    if (H_ratio > C_ratio){
        lowRatio = C_ratio;
        nowType = "C";
    }else{
        lowRatio = H_ratio;
        nowType = "H";
    }
    highRatio = (lowRatio + line) * (-1);
    if (nowType == "H"){
        out_ior[0]=lowRatio;
        out_ior[1]=highRatio;
    }else{
        out_ior[0]=highRatio;
        out_ior[1]=lowRatio;
    }
    return out_ior;
}
/**
 * 換算成印尼盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_IND_ior( H_ratio, C_ratio){
    var out_ior=new Array();
    out_ior = get_HK_ior(H_ratio,C_ratio);
    H_ratio=out_ior[0];
    C_ratio=out_ior[1];
    H_ratio /= 1000;
    C_ratio /= 1000;
    if(H_ratio < 1){
        H_ratio=(-1) / H_ratio;
    }
    if(C_ratio < 1){
        C_ratio=(-1) / C_ratio;
    }
    out_ior[0]=H_ratio*1000;
    out_ior[1]=C_ratio*1000;

    return out_ior;
}
/**
 * 換算成歐洲盤賠率
 * @param H_ratio
 * @param C_ratio
 * @return
 */
function get_EU_ior(H_ratio, C_ratio){
    var out_ior=new Array();
    out_ior = get_HK_ior(H_ratio,C_ratio);
    H_ratio=out_ior[0];
    C_ratio=out_ior[1];
    out_ior[0]=H_ratio+1000;
    out_ior[1]=C_ratio+1000;
    return out_ior;
}
/*
 去正負號做小數第幾位捨去
 進來的值是小數值
 */
function Decimal_point(tmpior,show){
    var sign="";
    sign =((tmpior < 0)?"Y":"N");
    tmpior = (Math.floor(Math.abs(tmpior) * show + 1 / show )) / show;
    return (tmpior * ((sign =="Y")? -1:1)) ;
}


/*
 公用 FUNC
 */
function printf(vals,points){ //小數點位數
    vals=""+vals;
    var cmd=new Array();
    cmd=vals.split(".");
    if (cmd.length>1){
        for (ii=0;ii<(points-cmd[1].length);ii++)vals=vals+"0";
    }else{
        vals=vals+".";
        for (ii=0;ii<points;ii++)vals=vals+"0";
    }
    return vals;
}top.isTestSite = false;
var gtypeAry = new Array("FT","BK","TN","VB","BS","OP","TT","BM","SK");
var notfind = new Object();
var JQ;
var load_jq_complet = false;
var fade_out_sec = 5000;  //賠率變色畫動秒數
var slide_sec = 100; //slide動畫秒數

try{
    if(console){
        //if(!top.isTestSite) setEmpty(console);
        /*
         console.log = emptyFun;
         console.trace = emptyFun;
         console.error = emptyFun;
         console.info = emptyFun;
         console.warn = emptyFun;
         console.table = emptyFun;*/
        //
    }


}catch(e){
    console = new Object();
    //setEmpty(console);

    console.log = emptyFun;
    console.trace = emptyFun;
    console.error = emptyFun;
    console.info = emptyFun;
    console.warn = emptyFun;
    console.table = emptyFun;
}

function emptyFun(){

}

function setEmpty(console){
    console.log = emptyFun;
    console.trace = emptyFun;
    console.error = emptyFun;
    console.info = emptyFun;
    console.warn = emptyFun;
    console.table = emptyFun;
}



var util = new Object();
util.classname = "[util.js]";
try{ util.HttpRequest = HttpRequest; }catch(e){}
try{ util.ParseHTML = ParseHTML; }catch(e){}
util.fail_count = new Object();
util.fail_limit = 10;
util.timeout_sec = 3000;
util.reload_sw = true;
var load_css = false;
var load_js = false;


//go to page
util.goToPage=function(filename, paramObj){
    util.trace(util.classname+"goToPage: "+filename);
    //if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

    util.fail_count[filename] = 0;

    paramObj.targetWindow = paramObj.targetWindow || document.getElementsByTagName("body")[0];
    paramObj.targetHead = paramObj.targetHead || document.getElementsByTagName("head")[0];
    paramObj.loadComplete = paramObj.loadComplete || function(){};
    paramObj.param = paramObj.param||"";

    if(paramObj.filename.indexOf(".php")!=-1){
        paramObj.filepath = filename;
        paramObj.method = "POST";
    }else if(paramObj.filename.indexOf(".html")!=-1){
        paramObj.filepath = "/tpl/member/"+top.langx+"/"+filename+".html";
        paramObj.method = "GET";
    }else{
        util.systemMsg("[type error] "+filename);
    }

    var getHttp = new util.HttpRequest();
    getHttp.addEventListener("LoadComplete", function(html){
        util.loadHtmlFinish(html, paramObj);
    });

    getHttp.addEventListener("onError", function(html){
        if(util.reload_sw){
            util.fail_count[filename]++;

            if(util.fail_count[filename]<util.fail_limit){
                window.setTimeout(function(){
                    getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);
                }, util.timeout_sec);
            }else{
                util.systemMsg("[load html fail] "+filename+".html");
            }
        }
    });

    getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);

}


//load html finish
util.loadHtmlFinish=function(html, paramObj){
    //util.trace(util.classname+"loadHtmlFinish");
    //if(!util.ParseHTML) util.systemMsg("ParseHTML does not load.");

    var tempHtml = new util.ParseHTML(html);

    //HTML
    dbody = tempHtml.getTag("div")[0];
    paramObj.targetWindow.innerHTML = "";
    if(dbody)paramObj.targetWindow.appendChild(dbody);




    //===== load JS =====
    var js_count = 0;
    jsAry = tempHtml.getTag("script");
    if(jsAry==0){

        //paramObj.loadComplete();


        //===== load CSS =====
        var css_count = 0;
        cssAry = tempHtml.getTag("link");
        if(cssAry.length==0){

            paramObj.loadComplete();

        }else{
            for(i=0;i<cssAry.length;i++) {
                var cssObj = cssAry[i];
                var _src = cssObj.href;

                //util.trace(_src);

                util.fail_count[_src] = 0;


                util.loadCSS(_src, paramObj, function(){
                    css_count++;

                    if(css_count>=cssAry.length){
                        //util.trace("[load css finish]");
                        //console.log("[load css finish]");
                        paramObj.loadComplete();

                    }

                });

            }
        }
        //===== load CSS =====

    }else{
        for(i=0;i<jsAry.length;i++) {
            var jsObj = jsAry[i];
            var _src = jsObj.src;

            util.fail_count[_src] = 0;
            //util.trace(_src);

            util.loadScript(_src, paramObj, function(){


                js_count++;
                //util.trace("load js: "+js_count);

                if(js_count>=jsAry.length){
                    //console.log("[load js finish]");
                    //paramObj.loadComplete();



                    //===== load CSS =====
                    var css_count = 0;
                    cssAry = tempHtml.getTag("link");
                    if(cssAry.length==0){

                        paramObj.loadComplete();

                    }else{
                        for(i=0;i<cssAry.length;i++) {
                            var cssObj = cssAry[i];
                            var _src = cssObj.href;

                            //util.trace(_src);

                            util.fail_count[_src] = 0;


                            util.loadCSS(_src, paramObj, function(){
                                css_count++;

                                if(css_count>=cssAry.length){
                                    //util.trace("[load css finish]");
                                    //console.log("[load css finish]");
                                    paramObj.loadComplete();

                                }

                            });

                        }
                    }
                    //===== load CSS =====

                }

            });
        }
    }
    //===== load JS =====








}

/*
 function load_complete(_type, loadFun){

 //load_count++;

 switch(_type){
 case "css":
 load_css = true;
 break;
 case "js":
 load_js = true;
 break;
 default:
 break;
 }

 console.log("[load_complete]"+_type+",css="+load_css+",js="+load_js);

 if(load_css && load_js){
 //if(load_count>=2){
 console.log("[load_complete]");
 loadFun();
 load_css = false;
 load_js = false;
 //load_count = 0;
 }
 }
 */

//load css
util.loadCSS=function(_src, paramObj, loadFun){
    //util.trace(util.classname+"loadCSS: "+_src);
    var css = document.createElement("link");
    css.setAttribute("rel", "stylesheet");
    css.setAttribute("type", "text/css");
    css.setAttribute("href", _src);

    css.onload=function(){
        //util.trace("load css finish: "+_src);
        //console.log("load css finish: "+_src);
        if(loadFun) loadFun();
    };

    //IE is not working
    css.onerror=function(){
        //util.trace("load css fail: "+_src);

        if(util.reload_sw){
            util.fail_count[_src]++;

            if(util.fail_count[_src]<util.fail_limit){

                window.setTimeout(function(){
                    paramObj.targetHead.removeChild(css);
                    util.loadCSS(_src, paramObj, loadFun);
                },util.timeout_sec);

            }else{
                var tmp_src = _src.split("/");
                util.systemMsg("[load css fail] "+tmp_src[tmp_src.length-1]);
            }
        }
    };

    paramObj.targetHead.appendChild(css);


}

//load script
util.loadScript=function(_src, paramObj, loadFun){
    //util.trace(util.classname+"loadScript: "+_src);
    //if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

    var getHttp = new util.HttpRequest();
    getHttp.addEventListener("LoadComplete",function(html){

        var script = document.createElement("script");
        script.setAttribute("type","text/javascript");
        script.text = html;
        paramObj.targetHead.appendChild(script);

        if(loadFun) loadFun();

    });

    getHttp.addEventListener("onError", function(html){

        if(util.reload_sw){
            util.fail_count[_src]++;

            if(util.fail_count[_src]<util.fail_limit){
                window.setTimeout(function(){getHttp.loadURL(_src,"GET","");}, util.timeout_sec);
            }else{
                var tmp_src = _src.split("/");
                util.systemMsg("[load script fail] "+tmp_src[tmp_src.length-1]);
            }
        }
    });

    getHttp.loadURL(_src,"GET","");

}


//print stack trace
util.printStackTrace=function(code){
    /*
     var _this = arguments.callee.caller;
     var msg = "Stack trace:";
     var base = "\n";
     if(code) msg=code+base+msg;
     while(_this.caller){
     var param = util.getArguments(_this.caller.arguments);
     msg+=base+"function "+_this.caller.name+"("+param+")";
     //msg+=base+"function "+_this.caller.name;
     //msg+=base+"function "+_this.caller;
     _this = _this.caller;
     }

     console.log(msg);
     */
    console.trace();
}

//get arguments
util.getArguments=function(obj){
    var ret = new Array();
    for(var _key in obj){
        var content = obj[_key];
        if(content!=null){
            if(content.length > 10) content=content.substr(0,10)+"...";
        }
        ret.push(typeof(obj[_key])+" ["+content+"]");


        //ret.push(typeof(obj[_key]));
    }
    return ret.join(",");
}

//print Hash
util.printHash=function(obj, _title){

    var count = 0;
    var str = "";

    if(_title!=null) str+="["+_title+"]\n";

    for(key in obj){
        str+=key+"======>"+obj[key]+"\n";
        count++;
    }
    str+="length======>"+count+"\n";
    util.trace(util.classname+str);
}


//http or https
util.getProtocal=function(){
    return document.location.protocol;
}


util.getWebDomain=function(){
    return document.domain;
}


util.getNowDomain=function(){
    return util.getProtocal()+"//"+util.getWebDomain();
}


//system msg
util.systemMsg=function(msg, isStack){
    console.warn(msg);
    if(isStack!=false) util.printStackTrace();
}

//trace
util.trace=function(msg, isStack){
    if(top.isTestSite){
        console.log(msg);
        //isStack = true;
        if(isStack) util.printStackTrace();
    }
}

util.showTxt=function(txt){
    if(txt+""=="undefined"||txt+""=="null"||txt+""=="NaN")  return "";
    return txt;
}

util.isIPad=function(){
    var agent = navigator.userAgent;
    if(agent.indexOf("iPad")!=-1){
        return true;
    }
    return false;
}

//含IE8以下
util.isIE8=function(){
    var ret = false;
    var agent = navigator.userAgent;
    var ie = "MSIE";
    var pos = agent.indexOf(ie);
    //Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET4.0C)

    if(pos!=-1){
        var tmp_agent = agent.substring(pos+ie.length,agent.length);
        var str = tmp_agent.indexOf(".");
        var version = tmp_agent.substring(0, str);
        if(version*1<=8) ret = true;
    }
    return ret;
}
util.checkBrowser=function (){
    var ret = false;
    var agent = navigator.userAgent;

    if(agent.indexOf("rv:11")!=-1||agent.indexOf("Firefox")!=-1||agent.indexOf("Edge")!=-1){
        //if(agent.indexOf("Firefox")!=-1){
        ret=true;
    }
    return ret;
}
util.isIE11=function(){//ie11 edge
    var ret = true;
    var agent = navigator.userAgent;
    var ie = "MSIE";
    var pos = agent.indexOf(ie);
    var brows = new Array("Chrome","Safari","Firefox");
    if(agent.indexOf("Edge")== -1){
        for(var i=0;i<brows.length;i++){
            if(agent.indexOf(brows[i]) != -1){
                ret = false;
                break;
            }
        }
    }
    return ret;
}

//set obj class
util.setObjectClass=function(targetObj,classStr){
    if(targetObj.className!=undefined){
        targetObj.className = classStr;
    }else{
        try{
            targetObj.setAttribute("class", classStr);
        }catch(e){}
    }
}


//get obj class
util.getObjectClass=function(targetObj){
    if(targetObj.className!=undefined){
        return targetObj.className;
    }else{
        return targetObj.getAttribute("class");
    }
}

util.reachBottom=function(DOC){
    var scrollTop = 0;
    var clientHeight = 0;
    var scrollHeight = 0;
    if (DOC.documentElement && DOC.documentElement.scrollTop) {
        scrollTop = DOC.documentElement.scrollTop;
    } else if (DOC.body) {
        scrollTop = DOC.body.scrollTop;
    }
    if (DOC.body.clientHeight && DOC.documentElement.clientHeight) {
        clientHeight = (DOC.body.clientHeight < DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    } else {
        clientHeight = (DOC.body.clientHeight > DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    }
    scrollHeight = Math.max(DOC.body.scrollHeight, DOC.documentElement.scrollHeight);
    if (scrollTop + clientHeight == scrollHeight) {
        return true;
    } else {
        return false;
    }
}

util.getObjAbsolute_new=function(obj,stop_name){
    var abs = new Object();

    abs["left"] = obj.offsetLeft;
    abs["top"] = obj.offsetTop;

    while(obj = obj.offsetParent){
        ////console.log(obj);
        ////console.log(obj.offsetLeft+" >> "+obj.offsetTop);
        if(util.getStyle(obj,"position") == "relative"){
            ////console.log(obj.id+"|"+obj.offsetParent.id+"|"+_self.getStyle(obj,"top")+"|"+_self.getStyle(obj,"margin-top")+"|"+obj.offsetTop);
            if((obj.id!="" && obj.offsetParent.id!="") && util.getStyle(obj,"top")!="auto" && util.getStyle(obj,"margin-top")!="auto" && util.getStyle(obj,"margin-top")!="0px"){
                abs["top"] += -obj.offsetTop;
                continue;
            }
        }

        if(stop_name!=undefined && obj.id==stop_name){
            break;
        }else if(util.getStyle(obj,"position") == "absolute"){
            break;
        }

        abs["left"] += obj.offsetLeft;
        abs["top"] += obj.offsetTop;
    }

    return abs;
}


util.getObjAbsolute=function(obj){
    var _abs = new Object();

    _abs["left"] = obj.offsetLeft;
    _abs["top"] = obj.offsetTop;

    while (obj = obj.offsetParent) {
        _abs["left"] += obj.offsetLeft;
        _abs["top"] += obj.offsetTop;
    }

    return _abs;
}


util.getStyle=function(oElm,strCssRule){
    var strValue = "";
    if(document.defaultView && document.defaultView.getComputedStyle){
        strValue = document.defaultView.getComputedStyle(oElm,"").getPropertyValue(strCssRule);
    }else if(oElm.currentStyle){
        strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
            return p1.toUpperCase();
        });
        strValue = oElm.currentStyle[strCssRule];
    }else{
        return "error";
    }
    return strValue;
}


util.clearObject=function(obj){
    for(var key in obj){
        delete obj[key];
    }
    return obj;
}

util.clearArray=function(ary){
    ary.length = 0;
    return ary;
}


function getChildAry(objAry, _id, newAry){

    for(var i=0; i<objAry.length; i++){
        var obj = objAry[i];

        if(obj.getAttribute("id")==_id){
            newAry.push(obj);
        }

        if(obj.children.length > 0){
            getChildAry(obj.children, _id, newAry);
        }

    }
    return newAry;
}

function iframe_onError(iframe,errorfunc){
    try{
        check = iframe.contentWindow.document.body.onload;
    }catch(e){
        check = null;
    }
    if(check == null && iframe.loadsrc != undefined ){
        iframe.times = iframe.times || 0;
        errorfunc(iframe);
    }else{
        iframe.times = 0;
        try{
            iframe.loadsrc = ""+iframe.contentWindow.location;
        }catch(e){}
    }
}

function showerror(e){
    e.times+=1;
    if(e.times > 10)	return;
    setTimeout(function(){e.contentWindow.location=e.loadsrc;},5000);
}


function iframe_src(obj, url){

    if(obj!=null&&obj.tagName!=null&&url!=null){
        //2017.0112 johnson 斷線時記錄url
        obj.loadsrc = url;

        obj.contentWindow.location = url;
    }
}
function divOnBlur(showdiv,selid){
    //console.log("divOnBlur======>"+showdiv.id);
    selid.onclick=null;
    showdiv.style.display='';
    showdiv.focus();

}

function initDivBlur(showdiv,selid){
    showdiv.tabIndex=100;
    showdiv.onblur=function(){
        showdiv.style.display='none';
        setTimeout(function(){
            selid.onclick=function(){
                //alert("onblur");
                divOnBlur(showdiv,selid);
                document.body.scrollTop = "0";
            }
        },300);
    };

}

function iframe_src_new(obj, url){
    //console.log("util iframe_src_new"+obj+","+obj.tagName+","+url);
    if(obj!=null&&obj.tagName!=null&&url!=null){

        //console.log("util.checkBrowser()"+util.checkBrowser());
        if(util.checkBrowser()){
            iframe_src(obj, url);
            return;
        }

        var _id = obj.getAttribute("id");
        var bakObj = document.getElementById(_id+"_bak");

        if(bakObj==null||bakObj.tagName==null){
            trace("obj"+obj);
            bakObj = obj.cloneNode(false);
            bakObj.setAttribute("id", _id+"_bak");
            bakObj.style.display = "none";
            obj.parentNode.appendChild(bakObj);

        }
        bakObj.contentWindow.location = url;
        //console.error(bakObj.innerHTML);
    }
}

//when iframe loaded and parse screen finish
function iframe_rename(_id, Parent){
    if(util.checkBrowser()){

        var dom = (Parent)?Parent.document:document;
        var orgObj = dom.getElementById(_id);
        orgObj.style.display = "";
        return;
    }



    var dom = (Parent)?Parent.document:document;
    var orgObj = dom.getElementById(_id);
    var bakObj = dom.getElementById(_id+"_bak");


    if(orgObj==null||orgObj.tagName==null||bakObj==null||bakObj.tagName==null){
        return;
    }


    var orgName = _id;
    var bakName = _id+"_bak";

    orgObj.setAttribute("id", bakName);
    bakObj.setAttribute("id", orgName);


    dom.getElementById(_id).style.display = "";
    dom.getElementById(_id+"_bak").style.display = "none";

    //iframe_src(dom.getElementById(_id+"_bak"), "about:blank");
    dom.getElementById(_id+"_bak").parentNode.removeChild(dom.getElementById(_id+"_bak"));

}
function getKeyCode(e){
    return (window.event)?window.event.keyCode:e.which;
}
function iframe_onload(iframe, fun){
    //if(fun==null) return;

    //IE (before finish init)
    /*
     iframe.onreadystatechange = function(){
     if (iframe.readyState == "complete"){
     alert("Local iframe is now loaded.");
     }
     };
     */

    //IE (after finish init)
    if(iframe.attachEvent){
        iframe.attachEvent("onload", function(){
            //trace("attachEvent");
            if(fun) fun();
        });

        //other (after finish init)
    }else{
        iframe.onload=function(){
            //trace("onload");
            if(fun) fun();
        };
    }
}

function echo(msg){
    if(document.all){
        alert(msg);
    }else{
        console.log(msg);
    }
}
var elemtAll=null;
var aa = false;
var bb = this.name;
document.getElementById=function(_id){
    if(bb=="body"){
        if (elemtAll==null) elemtAll=document.getElementsByTagName("*");
        obj=elemtAll[_id];
    }else{
        obj=document.getElementsByTagName("*")[_id];
    }
    if(obj==null){
        if(notfind[_id]==null){
            obj = new Object();
            obj.style = new Object();
            obj.getAttribute = emptyFun;
            obj.setAttribute = emptyFun;
            obj.innerHTML = emptyFun;
            notfind[_id] = obj;
        }else{
            obj = notfind[_id];
        }
    }
    return obj;
}

function clearElementAll(){
    elemtAll=null;
}

/*
 document.getElementById=function(_id){
 var newAry = new Array();
 var bodyObj = document.getElementsByTagName("body")[0];
 var objAry = null;
 var obj = null;

 if(bodyObj!=null&&_id!=null){
 objAry = bodyObj.children;
 if(bodyObj.getAttribute("id")==_id){
 obj = bodyObj;
 }else{
 obj = getChildAry(objAry, _id, newAry)[0];
 }
 }

 if(obj==null){

 if(notfind[_id]==null){
 obj = new Object();

 obj.style = new Object();
 obj.getAttribute = emptyFun;
 obj.setAttribute = emptyFun;
 obj.innerHTML = emptyFun;
 notfind[_id] = obj;
 }

 obj = notfind[_id];
 //console.warn("Object \""+_id+"\" is not exist.");
 //if(top.isTestSite) console.trace();
 ////util.systemMsg("Object \""+_id+"\" is not exist.");

 }

 return obj;
 }
 */

function loadComplet(){
    load_jq_complet = true;
}
/*
 try{
 var _src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js";
 var paramObj = new Object();
 paramObj["targetHead"] = document.getElementsByTagName("head")[0];
 util.loadScript(_src, paramObj, loadComplet);
 }catch(e){
 //console.error(e.toString());
 }
 */
JQ = new JQAnimate();

function JQAnimate(){
    var _self = this;
    _self.init=function(){

    }

    //hide
    _self.hide=function(divname, speed, callback){
        try{
            $(divname).hide(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //show
    _self.show=function(divname, speed, callback){
        try{
            $(divname).show(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //hide/show
    _self.toggle=function(divname, speed, callback){
        try{
            $(divname).toggle(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //slide up
    _self.slideUp=function(divname, speed, callback){
        try{
            $(divname).slideUp(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //slide down
    _self.slideDown=function(divname, speed, callback){
        try{
            $(divname).slideDown(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //slide up/down
    _self.slideToggle=function(divname, speed, callback){
        try{
            $(divname).slideToggle(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //fade in
    _self.fadeIn=function(divname, speed, callback){
        try{
            $(divname).fadeIn(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //fade out
    _self.fadeOut=function(divname, speed, callback){
        try{
            $(divname).fadeOut(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //fade in/out
    _self.fadeToggle=function(divname, speed, callback){
        try{
            $(divname).fadeToggle(speed, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //fade to
    _self.fadeTo=function(divname, speed, opacity, callback){
        try{
            $(divname).fadeTo(speed, opacity, callback);
        }catch(e){
            console.error(e.toString());
            throw new Error("error");
        }
    }

    //focus out
    _self.focusOut=function(divname, callback){
        //console.log("set focus out=====>"+divname+","+callback);
        try{
            $(divname).focusout(function(){
                return _self.transFun(callback);
            });

        }catch(e){
            console.error(e.toString());
            /*
             if(!load_jq_complet){
             setTimeout(function(){_self.focusOut(divname, callback)}, 1000);
             }
             */
        }
    }

    _self.transFun=function(callback){

        //if(typeof callback=="function"){
        //		return callback();
        //}
        if(typeof callback=="string"){
            return new Function("return "+callback)();
        }
        return null;
    }

}
var ObjDataFT=new Array();
var oldObjDataFT=new Array();
//var GameHead=new Array("gid","datetime","league","gnum_h","gnum_c","team_h","team_c","strong","ratio","ior_RH","ior_RC","ratio_o","ratio_u","ior_OUH","ior_OUC","ior_MH","ior_MC","ior_MN","str_odd","str_even","ior_EOO","ior_EOE","hgid","hstrong","hratio","ior_HRH","ior_HRC","hratio_o","hratio_u","ior_HOUH","ior_HOUC","ior_HMH","ior_HMC","ior_HMN","more","eventid","hot","play");
var keepleg="";
var legnum=0;
var NoshowLeg=new Array();
var myLeg=new Array();
var LeagueAry=new Array();
var keepscroll=0;
var tmpkeephei=0;
var keephei=0;

//var scrollHeight=0;
//var tempscrollHeight=0;
var step=1;
//that body_browse be self
body_browse = this;
var ptype_arr=new Array();
var keep_obt=new Object();

var keep_loading = true;

function ShowGameList(){
    clearElementAll();

    reTimeNow = retime;

    if(""+top.hot_game=="undefined"){
        top.hot_game="";
    }
    try{
        start_time=body_browse.get_timer();
    }catch(E){}
    if(loading == 'Y') return;
    if (parent.gamecount!=gamount){
        oldObjDataFT=new Array();
    }
    if(top.odd_f_type==""||""+top.odd_f_type=="undefined") top.odd_f_type="H";

    keepscroll= body_browse.document.documentElement.scrollTop || body_browse.document.body.scrollTop || 0;

    var conscroll= body_browse.document.getElementById('controlscroll');
    /*
     if (conscroll.style.display!=""){
     conscroll.style.display="";
     step=step*-1;
     //alert(conscroll.style.top);

     conscroll.style.top = keepscroll+step;
     //conscroll.style.width=800;
     //conscroll.style.Height=600;
     conscroll.focus();
     }
     */
    //conscroll.blur();
    //conscroll.style.top=parseInt(conscroll.style.top)-1;

    dis_ShowLoveI();
    //足球 其他 棒球我的最愛盤面隱藏覽看主要盤口
    dis_Market();


    //秀盤面
    if(isObt=="Y"){
        showtables(GameFT,GameHead,gamount,top.odd_f_type,GameOBT,ObtHead,Obtamount);// obt 0427
    }else{
        showtables(GameFT,GameHead,gamount,top.odd_f_type);
    }


    //conscroll.style.top=top.keepscroll;
    //conscroll.focus();

    //20160215 改玩法或改球類先將畫面歸零

    keepscroll = getKeepScroll(top, keepscroll);
    body_browse.scroll(0,keepscroll);

    keephei= body_browse.document.getElementById("showtable").scrollHeight;

    if(keephei<tmpkeephei ){
        body_browse.scroll(0,0);
    }
    tmpkeephei=keephei;

    //設定右方重新整理位置
    setRefreshPos();

    //顯示盤口
    body_browse.ChkOddfDiv();
    //跑馬燈
//	obj_msg = body_browse.document.getElementById('real_msg');
//	obj_msg.innerHTML = '<marquee scrolldelay=\"300\">'+msg+'</marquee>';

    //更新秒數
    //只有 讓分/走地 才有更新時間
    //hr_info = body_browse.document.getElementById('hr_info');
    //if(retime){
    //	hr_info.innerHTML = retime+str_renew;
    //}else{
    //	hr_info.innerHTML = str_renew;
    //}

    parent.gamecount=gamount;
    //日期下拉霸

    /*if (sel_gtype=="FU"){
     if (""+body_browse.document.getElementById('g_date')!="undefined"){
     body_browse.selgdate("r",g_date);
     body_browse.document.getElementById('g_date').value=g_date;
     }
     }*/

    if (top.hot_game!=""){
        // 2017-03-14 1901.精選、特別盤面-今日、早餐、滾球、過關、冠軍-加上選擇聯盟功能，選擇聯盟裡的聯盟要是特別和精選的賽事(pjm-736)
        //body_browse.document.getElementById('sel_league').style.display='none';
        (util.isIE8()==false)?show_page():show_ie8();
    }else{

        if(top.showtype=='hgft'||top.showtype=='hgfu'){
            obj_sel = body_browse.document.getElementById('sel_league');
            obj_sel.style.display='none';
            try{
                var obj_date='';
                obj_date=body_browse.document.getElementById("g_date").value;
                body_browse.selgdate("",obj_date);
            }catch(E){}
        }else{
            (util.isIE8()==false)?show_page():show_ie8();
        }
    }

    conscroll.style.display="none";
    coun_Leagues();
    body_browse.showPicLove();
    loadingOK();
    showHOT(gameCount);
    try{
        body_browse.document.getElementById('show_run_time').innerHTML="time:"+((body_browse.get_timer()-start_time)/1000)+"s";
    }catch(E){}
    keep_show_more(show_more_gid,ObjDataFT,gamount);
    initfixhead();

    trace("load height "+parent.document.getElementById("loading").scrollHeight);
    trace("body_view "+parent.document.getElementById("body_view").scrollHeight);

    /*tempscrollHeight = scrollHeight;
     scrollHeight = document.getElementById("showtable").scrollHeight;
     if(tempscrollHeight > scrollHeight )//如果重新載入的表格高度變短捲軸移到頂端2016-0331 William
     {
     backtop();
     }*/
    if(keep_loading) parent.display_loading(false);

    //if(top.lastidName != "")
    if( typeof( top.lastidName ) != "undefined" && top.lastidName != "")
    {
        document.getElementById(top.lastidName).className = "bet_bg_color_bet";
    }

}



var hotgdateArr =new Array();
function hot_gdate(gdate){
    if((""+hotgdateArr).indexOf(gdate)==-1){
        hotgdateArr.push(gdate);
    }
}
function coun_Leagues(){
    var coun=0;
    //var str_tmp ="|"+parent[sel_gtype+'_lname_ary'];
    // 2017-03-17 1901.精選、特別盤面-今日、早餐、滾球、過關、冠軍-加上選擇聯盟功能，選擇聯盟裡的聯盟要是特別和精選的賽事(pjm-736)
    var str_tmp =("|"+(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]));
    if(str_tmp=='|ALL'){
        body_browse.document.getElementById("str_num").innerHTML ="("+top.alldata+")";
    }else{
        var larray=str_tmp.split('|');
        for(var i =0;i<larray.length;i++){
            if(larray[i]!=""){coun++}
        }
        // 2017-03-23 3052.新會員端-全球類盤面-我的最愛盤面-選擇聯盟上的統計 依照用戶勾的統計
        if(!top.swShowLoveI){
            coun =LeagueAry.length;
        }
        body_browse.document.getElementById("str_num").innerHTML ="("+coun+")";
    }


}
//------單式顯示------
//function ShowData_OU(obj_table,GameData,data_amount,odd_f_type){
//showtables();
//}

//var GameFT=new Array();


//表格函數
function showtables(GameData,Game_Head,data_amount,odd_f_type,GameOBT,ObtHead,Obtamount){
//	var conscroll= body_browse.document.getElementById('controlscroll');

    //var conscroll= document.getElementById('controlscroll');
//	conscroll.style.display="block";
//	conscroll.top=keepscroll;
    //alert("kkkk");


    ObjDataFT=new Array();
    ObjOBT=new Object();
    myLeg=new Array();
    for (var j=0;j < data_amount;j++){
        if (GameData[j]!=null){
            ObjDataFT[j]=parseArray(Game_Head,GameData[j]);
        }
    }
    if(isObt=="Y"){   //obt
        for(var _gid in GameOBT){
            if (GameOBT[_gid]!=null){
                ObjOBT[_gid] = new Object();
                ObjOBT[_gid]=OBTArray(ObtHead,GameOBT[_gid],_gid);
            }
        }
    }
    //alert("ObjDataFT===>"+ObjDataFT.length);
    var trdata;//=body_browse.document.getElementById('DataTR').innerHTML;
    var showtableData;
    if(body_browse.document.all){
        showtableData=body_browse.document.getElementById('showtableData').innerText ;
        trdata=body_browse.document.getElementById('DataTR').innerText;
        subtrdata=body_browse.document.getElementById('subDataTR').innerText;
        mtrdata=body_browse.document.getElementById('MtypeData').innerText;
        obtdata=body_browse.document.getElementById('ObtData').innerText;
        goaldata=body_browse.document.getElementById('GoalData').innerText;
        notrdata=body_browse.document.getElementById('NoDataTR').innerText;
        new_notrdata=body_browse.document.getElementById('NoDataTR_new').innerText;


    } else{
        showtableData=body_browse.document.getElementById('showtableData').textContent ;
        trdata=body_browse.document.getElementById('DataTR').textContent;
        subtrdata=body_browse.document.getElementById('subDataTR').textContent;//多類別往外拉
        mtrdata=body_browse.document.getElementById('MtypeData').textContent;//多類別藍色盤面
        obtdata=body_browse.document.getElementById('ObtData').textContent;
        goaldata=body_browse.document.getElementById('GoalData').textContent;//點球
        notrdata=body_browse.document.getElementById('NoDataTR').textContent;
        new_notrdata=body_browse.document.getElementById('NoDataTR_new').textContent;
    }
    //alert(trdata);
    var showtable=body_browse.document.getElementById('showtable');
    var showlayers="";
    keepleg="";
    legnum=0;
    LeagueAry =new Array();
    var chk_Love_I=new Array();


    if(top.hot_gtype!=null && top.hot_gtype!=""){
        if(top.hot_gtype.indexOf("FU")!=-1 && top.sel_gd !="ALL") notrdata=new_notrdata;
    }else{
        if(top.select_showtype=="early" && top.sel_gd !="ALL") notrdata=new_notrdata;
    }
    if(ObjDataFT.length > 0){

        for ( i=0 ;i < ObjDataFT.length;i++){
            if((ObjDataFT[i].ptype_map=="0"&&ObjDataFT[i].ptype=="")||ObjDataFT[i].ptype==null||ObjDataFT[i].important=="N"){//普通盤面
                tmp_Str=getLayer(trdata,i,odd_f_type);
            }else if(ObjDataFT[i].ptype!=""&&ptype_str[ObjDataFT[i].ptype_map]!="Corner"&&ptype_str[ObjDataFT[i].ptype_map]!="Bookings"){//多type往外拉
                tmp_Str=getLayer(subtrdata,i,odd_f_type)
            }else if(ObjDataFT[i].ptype!=""){//多type藍色盤面
                tmp_Str=getLayer(mtrdata,i,odd_f_type)
                ptype_arr.push(ObjDataFT[i].datetime.split("<br>")[0]+ObjDataFT[i].gnum_h);//滑過變色存id
            }
            showlayers+=tmp_Str;
            //====================obt start====================
            var nextOBJ=ObjDataFT[i+1];
            if(isObt=="Y"){

                if(ObjDataFT[i].ptype_map!="0"){
                    if(!chk_ptype(ObjDataFT[i],"r")){//過濾ptype
                        if(ObjOBT[ObjDataFT[i].gid]!=null && ObjDataFT[i].isMaster=="Y") keep_obt=ObjDataFT[i];
                    }
                }else{
                    if(ObjOBT[ObjDataFT[i].gid]!=null && ObjDataFT[i].isMaster=="Y") keep_obt=ObjDataFT[i];
                }

                if(nextOBJ!=null){
                    if (nextOBJ.gidm!=keep_obt.gidm&&ObjOBT[keep_obt.gid]!=null){
                        showlayers+=getObtLayer(obtdata,keep_obt.gid,odd_f_type);
                        //util.clearObject(keep_obt);
                        keep_obt = new Object();
                    }
                }else if(ObjOBT[keep_obt.gid]!=null){
                    showlayers+=getObtLayer(obtdata,keep_obt.gid,odd_f_type);
                    //util.clearObject(keep_obt);
                    keep_obt = new Object();
                }


            }
            //showlayers+=obtdata;
            //====================obt end====================

            if (top.swShowLoveI){
                chk_Love_I.push(ObjDataFT[i]);
            }
        }

        //if(showlayers=="")showlayers=notrdata;
        //沒賽事選擇聯盟要跳回全部
        keep_loading=true;
        if(showlayers==""){
            showlayers=notrdata;

            //if(parent[sel_gtype+"_lname_ary"]!="ALL"){
            // 2017-03-17 1901.精選、特別盤面-今日、早餐、滾球、過關、冠軍-加上選擇聯盟功能，選擇聯盟裡的聯盟要是特別和精選的賽事(pjm-736)
            if(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]!="ALL"){
                //document.getElementById("legFrame").contentWindow.selall();
                //document.getElementById("legFrame").contentWindow.chk_league();
                //parent[sel_gtype+'_lname_ary']="ALL";
                //parent[sel_gtype+'_lid_ary']="ALL";
                //parent[sel_gtype+'_lid_type']=(top.swShowLoveI)?"3":"";
                top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]="ALL";
                top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"]="ALL";
                top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_type"]=(top.swShowLoveI)?"3":"";
                //LegBack();
                reload_var("");

                keep_loading=false;
                return;
            }
        }
        //======================
        showtableData=showtableData.replace("*showDataTR*",showlayers);
    }else{
        //沒賽事選擇聯盟要跳回全部
        //parent[sel_gtype+'_lname_ary']="ALL";
        //parent[sel_gtype+'_lid_ary']="ALL";
        //parent[sel_gtype+'_lid_type']=(top.swShowLoveI)?"3":"";
        top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]="ALL";
        top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"]="ALL";
        top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_type"]=(top.swShowLoveI)?"3":"";
        //======================
        showtableData=showtableData.replace("*showDataTR*",notrdata);

    }



    if (top.head_FU=="FT"){
        if (top.hot_game==""){
            if(top.swShowLoveI){
                body_browse.checkLoveCount(chk_Love_I);
            }
        }
    }

    showtable.innerHTML=showtableData;

    //----------leg圖--------


}

//表格內容
function getLayer(onelayer,gamerec,odd_f_type){
    var open_hot = false;
    if (top.hot_game==""){
        //我的最愛過濾
        //if(MM_IdentificationDisplay(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h)) return "";
        if(MM_IdentificationDisplay_FT(ObjDataFT[gamerec].datetime,ObjDataFT[gamerec].gnum_h,ObjDataFT[gamerec].gidm)) return "";

    }
    if(ObjDataFT[gamerec].ptype_map!="0"){
        if(chk_ptype(ObjDataFT[gamerec],"r")) return "";
    }
    //如果有選我的最愛,選擇聯盟不判斷
    /*if (!top.swShowLoveI){
     // 2017-03-16 1901.精選、特別盤面-今日、早餐、滾球、過關、冠軍-加上選擇聯盟功能，選擇聯盟裡的聯盟要是特別和精選的賽事(pjm-736)
     //if (top.hot_game==""){
     //if(("|"+parent[sel_gtype+"_lname_ary"]).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1&&parent[sel_gtype+"_lname_ary"]!='ALL') return "";
     if(("|"+(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"])).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1 && top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]!='ALL') return "";
     if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
     //}
     }else{
     //if(("|"+parent[sel_gtype+"_lname_ary"]).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)!==-1&&parent[sel_gtype+"_lname_ary"]!='ALL'){
     if(("|"+(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"])).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)!==-1 && top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]!='ALL'){
     if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);
     }
     }*/
    // 2017-03-23 3052.新會員端-全球類盤面-我的最愛盤面-選擇聯盟上的統計 依照用戶勾的統計
    if(("|"+(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"])).indexOf(("|"+ObjDataFT[gamerec].league+"|"),0)==-1 && top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]!='ALL') return "";
    if((""+LeagueAry).indexOf(ObjDataFT[gamerec].league)== -1)LeagueAry.push(ObjDataFT[gamerec].league);


    var tmp_date = ObjDataFT[gamerec].datetime.split("<br>")[0];
    onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+ObjDataFT[gamerec].gnum_h);
    //子盤隱藏和局
    onelayer=onelayer.replace(/\*NODARW\*/g,(ObjDataFT[gamerec].isMaster=="Y" || !NotMasterDarw)?"":"_sub");


    onelayer=onelayer.replace(/\*TR_EVENT\*/g,"onMouseOver='mouseEnter_pointer(this.id);' onMouseOut='mouseOut_pointer(this.id);'");

    //alert(ObjDataFT[gamerec].league+"==="+keepleg+"["+(ObjDataFT[gamerec].league==keepleg)+"]")


    if (""+myLeg[ObjDataFT[gamerec].league]=="undefined"){
        myLeg[ObjDataFT[gamerec].league]=ObjDataFT[gamerec].league;
        myLeg[ObjDataFT[gamerec].league]=new Array();
        myLeg[ObjDataFT[gamerec].league][0]=tmp_date+ObjDataFT[gamerec].gnum_h;
    }else{
        myLeg[ObjDataFT[gamerec].league][myLeg[ObjDataFT[gamerec].league].length]=tmp_date+ObjDataFT[gamerec].gnum_h;
    }


    //--------------判斷聯盟名稱列顯示或隱藏----------------
    if (ObjDataFT[gamerec].league==keepleg){
        onelayer=onelayer.replace("*ST*"," style='display: none;' id='LEG_"+tmp_date+ObjDataFT[gamerec].gnum_h+"'");
    }else{
        onelayer=onelayer.replace("*ST*"," style='display: ;' id='LEG_"+tmp_date+ObjDataFT[gamerec].gnum_h+"' ");
    }
    //---------------------------------------------------------------------
    //--------------判斷聯盟底下的賽事顯示或隱藏----------------
    if (NoshowLeg[ObjDataFT[gamerec].league]==-1){
        onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: none;'");
        onelayer=onelayer.replace("*LegMark*","class='bet_game_league_down'"); //聯盟的小圖箭頭向下
    }else{
        onelayer=onelayer.replace(/\*CLASS\*/g,"style='display: ;'");
        onelayer=onelayer.replace("*LegMark*","class='bet_game_league'");  //聯盟的小圖箭頭向上
    }
    //---------------------------------------------------------------------

    var R_ior =Array();
    var OU_ior =Array();
    var HR_ior =Array();
    var HOU_ior =Array();
    var EO_ior =Array();
    R_ior  = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_RH   , ObjDataFT[gamerec].ior_RC   , show_ior);
    OU_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_OUH  , ObjDataFT[gamerec].ior_OUC  , show_ior);
    HR_ior = get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HRH  , ObjDataFT[gamerec].ior_HRC  , show_ior);
    HOU_ior= get_other_ioratio(odd_f_type, ObjDataFT[gamerec].ior_HOUH , ObjDataFT[gamerec].ior_HOUC , show_ior);

    if((ObjDataFT[gamerec].ior_EOO != 0) && (ObjDataFT[gamerec].ior_EOE != 0)){
        EO_ior= get_other_ioratio("H", ObjDataFT[gamerec].ior_EOO*1-1 , ObjDataFT[gamerec].ior_EOE*1-1 , show_ior);
        ObjDataFT[gamerec].ior_EOO=EO_ior[0]*1+1;
        ObjDataFT[gamerec].ior_EOE=EO_ior[1]*1+1;
    }

    ObjDataFT[gamerec].ior_RH=R_ior[0];
    ObjDataFT[gamerec].ior_RC=R_ior[1];
    ObjDataFT[gamerec].ior_OUH=OU_ior[0];
    ObjDataFT[gamerec].ior_OUC=OU_ior[1];
    ObjDataFT[gamerec].ior_HRH=HR_ior[0];
    ObjDataFT[gamerec].ior_HRC=HR_ior[1];
    ObjDataFT[gamerec].ior_HOUH=HOU_ior[0];
    ObjDataFT[gamerec].ior_HOUC=HOU_ior[1];

    //滾球字眼
    ObjDataFT[gamerec].datetime=ObjDataFT[gamerec].datetime.replace("Running Ball",top.str_RB);
    keepleg=ObjDataFT[gamerec].league;
    onelayer=onelayer.replace(/\*LEG\*/gi,ObjDataFT[gamerec].league);

    var tmp_date=ObjDataFT[gamerec].datetime.split("<br>");
    if (sel_gtype=="FU"){
        tmp_date_str=tmp_date[0]+"</div>";
        tmp_date_str+="<div class='bet_early_time_live'>"+change_time(tmp_date[1])+"</div>";
    }else{
        tmp_date_str=change_time(tmp_date[1]);
    }



    var team_h = ObjDataFT[gamerec].team_h;
    var display_live = (tmp_date.length==3)?"":"none";
    var display_mid = (team_h.indexOf("[Mid]")!=-1||team_h.indexOf("[中]")!=-1)?"":"none";
    if(ObjDataFT[gamerec].isMaster=="Y"){
        onelayer=onelayer.replace("*DATETIME*",tmp_date_str);
        onelayer=onelayer.replace("*DISPLAY_LIVE*", "style='display:"+display_live+"'");
        onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:"+display_mid+"'");
        onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top'");
    }else{
        onelayer=onelayer.replace("*DATETIME*","");
        onelayer=onelayer.replace("*DISPLAY_LIVE*", "style='display:none'");
        onelayer=onelayer.replace("*DISPLAY_MIDFIELD*", "style='display:none'");
        onelayer=onelayer.replace("*TR_TOP*","class='bet_game_tr_top_color'");
    }

    // 2016-12-07 足球多type所有細單改位罝顯示
    if(ObjDataFT[gamerec].important != "N" && ObjDataFT[gamerec].ptype !="" ){
        onelayer=onelayer.replace("*PTYPE*",replacePtype(ObjDataFT[gamerec].ptype));
        onelayer=onelayer.replace("*TEAM_H*",Mtype_TeamName(TeamName(ObjDataFT[gamerec].team_h),ObjDataFT[gamerec].ptype));
        onelayer=onelayer.replace("*TEAM_C*",Mtype_TeamName(TeamName(ObjDataFT[gamerec].team_c),ObjDataFT[gamerec].ptype));
    }else{
        onelayer=onelayer.replace("*PTYPE*","");
        onelayer=onelayer.replace("*TEAM_H*",TeamName(ObjDataFT[gamerec].team_h));
        onelayer=onelayer.replace("*TEAM_C*",TeamName(ObjDataFT[gamerec].team_c));
    }

    //全場
    //獨贏
    var isDarw=(ObjDataFT[gamerec].hide_N=="Y")?true:false;// 隱藏和局開關

    //----------------子盤不顯示和局顯示----------------
    if(NotMasterDarw){
        onelayer=onelayer.replace("*DIS_DARW*",(ObjDataFT[gamerec].isMaster=="N")? "style='display: none;'":"");
        onelayer=onelayer.replace("*TR_NUM*",(ObjDataFT[gamerec].isMaster=="N")?"2":"3");
        onelayer=onelayer.replace("*PTYPE_DIS_DARW*",(ObjDataFT[gamerec].isMaster=="N")? "style='display: none;'":"");
        onelayer=onelayer.replace("*PTYPE_TR_NUM*",(ObjDataFT[gamerec].isMaster=="N")?"3":"4");
    }else{
        onelayer=onelayer.replace("*DIS_DARW*","");
        onelayer=onelayer.replace("*TR_NUM*","3");
        onelayer=onelayer.replace("*PTYPE_DIS_DARW*","");
        onelayer=onelayer.replace("*PTYPE_TR_NUM*","4");

    }
    //------------------------------------------------

    onelayer=onelayer.replace("*DRAW_STR*",(isDarw)?"&nbsp;":top.team3);// 隱藏和局
    if ((ObjDataFT[gamerec].ior_MH*1 > 0) && (ObjDataFT[gamerec].ior_MC*1 > 0)){
        onelayer=onelayer.replace("*RATIO_MH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"M"));
        onelayer=onelayer.replace("*RATIO_MC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"M"));
        if ((ObjDataFT[gamerec].ior_MN*1) > 0){
            onelayer=onelayer.replace("*RATIO_MN*",(isDarw)?"&nbsp;":parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"M"));
        }else{
            onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
        }
    }else{
        onelayer=onelayer.replace("*RATIO_MH*","&nbsp;");
        onelayer=onelayer.replace("*RATIO_MC*","&nbsp;");
        onelayer=onelayer.replace("*RATIO_MN*","&nbsp;");
    }
    //讓球
    if (ObjDataFT[gamerec].strong=="H"){
        onelayer=onelayer.replace("*CON_RH*",ObjDataFT[gamerec].ratio);	/*讓球球頭*/
        onelayer=onelayer.replace("*CON_RC*","");
    }else{
        onelayer=onelayer.replace("*CON_RH*","");
        onelayer=onelayer.replace("*CON_RC*",ObjDataFT[gamerec].ratio);
    }


    onelayer=onelayer.replace("*RATIO_RH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"R"));/*讓球賠率*/
    onelayer=onelayer.replace("*RATIO_RC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"R"));
    //大小
    var CON_OUH = ObjDataFT[gamerec].ratio_o.replace("O","");
    var CON_OUC = ObjDataFT[gamerec].ratio_u.replace("U","");
    var text_o = top.text_o;
    var text_u = top.text_u;

    if(top.langx!="en-us"){
        text_o = top.strOver;
        text_u = top.strUnder;
    }
    onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",""));
    onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",""));
    onelayer=onelayer.replace("*TEXT_OUH*",(CON_OUH=="")?"":text_o);
    onelayer=onelayer.replace("*TEXT_OUC*",(CON_OUC=="")?"":text_u);
    /*
     if (top.langx=="en-us"){
     onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O","o") );	//大小球頭
     onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U","u") );
     }else{
     onelayer=onelayer.replace("*CON_OUH*",ObjDataFT[gamerec].ratio_o.replace("O",top.strOver));	//大小球頭
     onelayer=onelayer.replace("*CON_OUC*",ObjDataFT[gamerec].ratio_u.replace("U",top.strUnder));
     */
    onelayer=onelayer.replace("*RATIO_OUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"OU"));/*大小賠率*/
    onelayer=onelayer.replace("*RATIO_OUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"OU"));
    //單雙
    //onelayer=onelayer.replace("*RATIO_EOO*",ObjDataFT[gamerec].str_odd+parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO"));
    //onelayer=onelayer.replace("*RATIO_EOE*",ObjDataFT[gamerec].str_even+parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO"));

    var RATIO_EOO = parseUrl(uid,odd_f_type,"O",ObjDataFT[gamerec],gamerec,"EO");
    var RATIO_EOE = parseUrl(uid,odd_f_type,"E",ObjDataFT[gamerec],gamerec,"EO");
    onelayer=onelayer.replace("*RATIO_EOO*",RATIO_EOO);
    onelayer=onelayer.replace("*RATIO_EOE*",RATIO_EOE);
    var o_text = top.text_o;
    var e_text = top.text_e;

    if(top.langx!="en-us"){
        o_text = top.str_o;
        e_text = top.str_e;
    }

    onelayer=onelayer.replace("*TEXT_EOO*",(RATIO_EOO=="")?"":o_text);
    onelayer=onelayer.replace("*TEXT_EOE*",(RATIO_EOE=="")?"":e_text);

    //上半場
    //獨贏
    if ((ObjDataFT[gamerec].ior_HMH*1 > 0) && (ObjDataFT[gamerec].ior_HMC*1 > 0)){
        onelayer=onelayer.replace("*RATIO_HMH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HM"));
        onelayer=onelayer.replace("*RATIO_HMC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HM"));
        if ((ObjDataFT[gamerec].ior_HMN*1) > 0){
            onelayer=onelayer.replace("*RATIO_HMN*",(isDarw)?"&nbsp;":parseUrl(uid,odd_f_type,"N",ObjDataFT[gamerec],gamerec,"HM"));
        }else{
            onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
        }
    }else{
        onelayer=onelayer.replace("*RATIO_HMH*","&nbsp;");
        onelayer=onelayer.replace("*RATIO_HMC*","&nbsp;");
        onelayer=onelayer.replace("*RATIO_HMN*","&nbsp;");
    }


    //讓球
    if (ObjDataFT[gamerec].hstrong=="H"){
        onelayer=onelayer.replace("*CON_HRH*",ObjDataFT[gamerec].hratio);	/*讓球球頭*/
        onelayer=onelayer.replace("*CON_HRC*","");
    }else{
        onelayer=onelayer.replace("*CON_HRH*","");
        onelayer=onelayer.replace("*CON_HRC*",ObjDataFT[gamerec].hratio);
    }
    onelayer=onelayer.replace("*RATIO_HRH*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HR"));/*讓球賠率*/
    onelayer=onelayer.replace("*RATIO_HRC*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HR"));
    //大小

    var CON_HOUH = ObjDataFT[gamerec].hratio_o.replace("O","");
    var CON_HOUC = ObjDataFT[gamerec].hratio_u.replace("U","");
    onelayer=onelayer.replace("*CON_HOUH*",CON_HOUH);
    onelayer=onelayer.replace("*CON_HOUC*",CON_HOUC);
    onelayer=onelayer.replace("*TEXT_HOUH*",(CON_HOUH=="")?"":text_o);
    onelayer=onelayer.replace("*TEXT_HOUC*",(CON_HOUC=="")?"":text_u);
    /*
     if (top.langx=="en-us"){
     onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O","o") );	//大小球頭
     onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U","u") );
     }else{
     onelayer=onelayer.replace("*CON_HOUH*",ObjDataFT[gamerec].hratio_o.replace("O",top.strOver));	//大小球頭
     onelayer=onelayer.replace("*CON_HOUC*",ObjDataFT[gamerec].hratio_u.replace("U",top.strUnder));
     }
     */
    onelayer=onelayer.replace("*RATIO_HOUH*",parseUrl(uid,odd_f_type,"C",ObjDataFT[gamerec],gamerec,"HOU"));/*大小賠率*/
    onelayer=onelayer.replace("*RATIO_HOUC*",parseUrl(uid,odd_f_type,"H",ObjDataFT[gamerec],gamerec,"HOU"));

    var moreAry = parseAllBets(ObjDataFT[gamerec],gamerec,game_more);
    onelayer=onelayer.replace("*COUNT_MORE*", moreAry["count"]);
    onelayer=onelayer.replace("*DISPLAY_MORE*", moreAry["display"]);
    onelayer=onelayer.replace("*ONCLICK_MORE*", moreAry["onclick"]);
    //我的最愛
    var mylove = parseMyLove(ObjDataFT[gamerec]);
    onelayer=onelayer.replace(/\*MYLOVE_ID\*/gi,(ObjDataFT[gamerec].isMaster=="N")?"":"love"+mylove["id"]);
    onelayer=onelayer.replace(/\*MYLOVE_ID_none\*/gi,(ObjDataFT[gamerec].isMaster=="N")?"":"love"+mylove["id"]+"_none");
    onelayer=onelayer.replace(/\*MYLOVE_CSS\*/gi,(ObjDataFT[gamerec].isMaster=="N")?"":mylove["css"]);

    var show_type=mylove["id"].split("_");
    //console.log("======>"+show_type[1]);
    onelayer=onelayer.replace(/\*MYLOVE_CSS_none\*/gi,(show_type[1]=="off"||ObjDataFT[gamerec].isMaster=="N")?"style='display: none;'":"");

    //onelayer=onelayer.replace("*MYLOVE*",parseMyLove(ObjDataFT[gamerec]));
    /*
     if (ObjDataFT[gamerec].play=="Y"){
     onelayer=onelayer.replace("*TV_ST*","style='display:block;'");

     }else{
     onelayer=onelayer.replace("*TV_ST*","style='display:none;'");
     }

     */	onelayer=onelayer.replace("*TV_CLASS*",(ObjDataFT[gamerec].isMaster=="N")?"":"class=\"bet_TV_btn_out\"");
    if (ObjDataFT[gamerec].eventid != "" && ObjDataFT[gamerec].eventid != "null" && ObjDataFT[gamerec].eventid != undefined) {	//判斷是否有轉播
        var tmpStr= VideoFun(ObjDataFT[gamerec].eventid, ObjDataFT[gamerec].hot, ObjDataFT[gamerec].play, "FT");
        //alert(tmpStr);
        onelayer=onelayer.replace("*TV*",(ObjDataFT[gamerec].isMaster=="N")?"":tmpStr);


    }
    onelayer=onelayer.replace("*TV*",(ObjDataFT[gamerec].isMaster=="N")?"":"style=\"visibility:hidden\"");




    //alert(onelayer);

    return onelayer;
}

//obt表格內容
function getObtLayer(onelayer,gamerec,odd_f_type){
    if(MM_IdentificationDisplay_FT(keep_obt.datetime,keep_obt.gnum_h,keep_obt.gidm)) return "";
    if(("|"+(top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"])).indexOf(("|"+keep_obt.league+"|"),0)==-1 && top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lname_ary"]!='ALL') return "";

    var OUH_ior =Array();
    var OUC_ior =Array();
    OUH_ior= get_other_ioratio(odd_f_type, ObjOBT[gamerec].ior_OUHO , ObjOBT[gamerec].ior_OUHU , show_ior);
    OUC_ior= get_other_ioratio(odd_f_type, ObjOBT[gamerec].ior_OUCO , ObjOBT[gamerec].ior_OUCU , show_ior);

    ObjOBT[gamerec].ior_OUHO=OUH_ior[0];
    ObjOBT[gamerec].ior_OUHU=OUH_ior[1];
    ObjOBT[gamerec].ior_OUCO=OUC_ior[0];
    ObjOBT[gamerec].ior_OUCU=OUC_ior[1];

    //var TS_ior = Array();
    //TS_ior=get_other_ioratio(odd_f_type, ObjOBT[gamerec].ior_TSY , ObjOBT[gamerec].ior_TSN , show_ior);
    //ObjOBT[gamerec].ior_TSY=TS_ior[0];
    //ObjOBT[gamerec].ior_TSN=TS_ior[1];

    var pd_rtype=Array("H1C0","H2C0","H2C1","H3C0","H3C1","H3C2","H4C0","H4C1","H4C2","H4C3","H0C0","H1C1","H2C2","H3C3","H4C4","OVH","H0C1","H0C2","H1C2","H0C3","H1C3","H2C3","H0C4","H1C4","H2C4","H3C4");
    var t_rtype=Array("H","C","N","T0","T1","T2","TOV");
    var t_tag=Array("PGFH","PGFC","PGFN","T01","T23","T46","OVER");
    var t_wtype=Array("PGF","PGF","PGF","T","T","T","T")
    var ts_rtype=Array("Y","N","H","C","H","C");
    var ts_wtype=Array("TS","TS","WN","WN","CS","CS");
    var ouh_rtype=Array("O","U","O","U");
    var ouh_wtype=Array("OUH","OUH","OUC","OUC");
    var mou_rtype=Array("HO","HU","NO","NU","CO","CU");
    var mou_tag=Array("MOUHO","MOUHU","MOUNO","MOUNU","MOUCO","MOUCU");

    var tmp_ior="";
    var display_more=true;//隱藏allbet
    var display_pd=true;//隱藏pd
    var display_t=true;//隱藏t
    var display_ts=true;//隱藏ts
    var display_ouh=true;//隱藏ts
    var display_mou=true;//隱藏mou
    var display_all=true;//隱藏all

    //var isDarw=(ObjDataFT[gamerec].hide_N=="Y")?true:false;// 隱藏和局開關
    var isDarw=false;

    var obt_ior_class="<span class='bet_obt_color'>-</span>";
    var mod_str="obt_";
    //波膽
    for(var i=0 ;i<pd_rtype.length;i++){
        tmp_ior=parseUrl(uid,odd_f_type,pd_rtype[i],ObjOBT[gamerec],gamerec,"PD",mod_str);
        onelayer=onelayer.replace("*RATIO_"+pd_rtype[i]+"*",(tmp_ior!="")? tmp_ior:obt_ior_class);

        if(tmp_ior!="") {display_pd=false;display_more=false;display_all=false;}
    }


    //總進球數
    tmp_ior="";
    for(var i=0 ;i<t_rtype.length;i++){
        tmp_ior=parseUrl(uid,odd_f_type,t_rtype[i],ObjOBT[gamerec],gamerec,t_wtype[i],mod_str);
        onelayer=onelayer.replace("*RATIO_"+t_tag[i]+"*",(tmp_ior!="")? tmp_ior:obt_ior_class);
        if(tmp_ior!="") {display_t=false;display_more=false;display_all=false;}
    }

    //雙方球隊進球 零失球獲勝  零失球
    tmp_ior="";
    for(var i=0 ;i<ts_rtype.length;i++){
        tmp_ior=parseUrl(uid,odd_f_type,ts_rtype[i],ObjOBT[gamerec],gamerec,ts_wtype[i],mod_str);
        onelayer=onelayer.replace("*RATIO_"+ts_wtype[i]+ts_rtype[i]+"*",(tmp_ior!="")? tmp_ior:obt_ior_class);
        if(tmp_ior!="") {display_ts=false;display_more=false;display_all=false;}
    }
    //球隊進球大小
    tmp_ior="";
    for(var i=0 ;i<ouh_rtype.length;i++){
        tmp_ior=parseUrl(uid,odd_f_type,ouh_rtype[i],ObjOBT[gamerec],gamerec,ouh_wtype[i],mod_str);
        onelayer=onelayer.replace("*RATIO_"+ouh_wtype[i]+ouh_rtype[i]+"*",(tmp_ior!="")? tmp_ior:obt_ior_class);
        onelayer=onelayer.replace("*CON_"+ouh_wtype[i]+ouh_rtype[i]+"*",(ObjOBT[gamerec]["ratio_"+ouh_wtype[i]+ouh_rtype[i]]!="")?ObjOBT[gamerec]["ratio_"+ouh_wtype[i]+ouh_rtype[i]]:"");

        if(tmp_ior!="") {display_ouh=false;display_more=false;display_all=false;}
    }
    //獨贏 & 大小 wtype_MU有時會是空的
    tmp_ior="";
    for(var i=0 ;i<mou_rtype.length;i++){
        if(ObjOBT[gamerec].wtype_MOU!=""){
            tmp_ior=parseUrl(uid,odd_f_type,mou_rtype[i],ObjOBT[gamerec],gamerec,ObjOBT[gamerec].wtype_MOU,mod_str);
        }

        if(isDarw && (mou_tag[i]=="MOUNO" || mou_tag[i]=="MOUNU")){ //隱藏和局
            onelayer=onelayer.replace("*RATIO_"+mou_tag[i]+"*","&nbsp;");
            onelayer=onelayer.replace("*CON_"+mou_tag[i]+"*","&nbsp;");
        }else{
            onelayer=onelayer.replace("*RATIO_"+mou_tag[i]+"*",(tmp_ior!="")? tmp_ior:obt_ior_class);
            onelayer=onelayer.replace("*CON_"+mou_tag[i]+"*",(ObjOBT[gamerec]["ratio_"+mou_tag[i]]!="")?ObjOBT[gamerec]["ratio_"+mou_tag[i]]:"");
        }
        if(tmp_ior!="") {display_mou=false;display_more=false;display_all=false;}
    }


    //隱藏和局
    onelayer=onelayer.replace("*DARW_STRO*",(isDarw)?"&nbsp;&nbsp;":top.team3+"&nbsp;&");
    onelayer=onelayer.replace("*DARW_STRU*",(isDarw)?"&nbsp;&nbsp;":top.team3+"&nbsp;&");
    onelayer=onelayer.replace("*DARW_O*",(isDarw)?"&nbsp;":top.strOver);
    onelayer=onelayer.replace("*DARW_U*",(isDarw)?"&nbsp;":top.strUnder);

    //隱藏整行

    onelayer=onelayer.replace("*DIS_MORE*",(display_more)?"style='display:none'":"");
    onelayer=onelayer.replace("*DIS_PD*",(display_pd)?"style='display:none'":"");
    onelayer=onelayer.replace("*DIS_T*",(display_t)?"style='display:none'":"");
    onelayer=onelayer.replace("*DIS_TS*",(display_ts)?"style='display:none'":"");
    onelayer=onelayer.replace("*DIS_OUHO*",(display_ouh)?"style='display:none'":"");
    onelayer=onelayer.replace("*DIS_MOU*",(display_mou)?"style='display:none'":"");

    //allbet
    var moreAry = parseAllBets(keep_obt,gamerec,game_more);
    onelayer=onelayer.replace("*ONCLICK_MORE*", moreAry["onclick"]);

    //加時賽
    onelayer=onelayer.replace("*DIS_ETIME*",(ptype_str[keep_obt.ptype_map]=="ETime")?"":"style='display:none'");


    //點聯盟隱藏
    var tmp_date = keep_obt.datetime.split("<br>")[0];
    onelayer=onelayer.replace(/\*ID_STR\*/g,tmp_date+keep_obt.gnum_h);
    //子盤隱藏和局
    onelayer=onelayer.replace(/\*NODARW\*/g,(keep_obt.isMaster=="Y" || !NotMasterDarw)?"":"_sub");

    //reload 隱藏聯盟
    if (NoshowLeg[keep_obt.league]==-1){
        onelayer=onelayer.replace("*DIS_ALL*","style='display: none;'");
    }else{
        onelayer=onelayer.replace("*DIS_ALL*","");
    }


    return onelayer;

}

//----------------------
//取得下注的url
function parseUrl(uid,odd_f_type,betTeam,GameData,gamerec,wtype,mod){

    if(wtype=="") return""; //獨贏 & 大小沒開時
    var urlArray=new Array();
    urlArray['R']=new Array("../FT_order/FT_order_r.php",GameData["team_"+betTeam.toLowerCase()]);
    urlArray['HR']=new Array("../FT_order/FT_order_hr.php",GameData["team_"+betTeam.toLowerCase()]);
    urlArray['OU']=new Array("../FT_order/FT_order_ou.php",(betTeam=="C" ? top.strOver : top.strUnder));
    urlArray['HOU']=new Array("../FT_order/FT_order_hou.php",(betTeam=="C" ? top.strOver : top.strUnder));
    urlArray['M']=new Array("../FT_order/FT_order_m.php",(betTeam=="N" ? top.str_irish_kiss : GameData["team_"+betTeam.toLowerCase()]));
    urlArray['HM']=new Array("../FT_order/FT_order_hm.php",(betTeam=="N" ? top.str_irish_kiss : GameData["team_"+betTeam.toLowerCase()]));
    urlArray['EO']=new Array("../FT_order/FT_order_t.php", (betTeam=="O"  ? top.str_o : top.str_e));

    urlArray['PD']=new Array("",(betTeam=="OVH" ? top.OVH : betTeam.replace("H","").replace("C","-")));
    var paramRtype = new Array();
    paramRtype['T0'] = top.str_RT[0];
    paramRtype['T1'] = top.str_RT[1];
    paramRtype['T2'] = top.str_RT[2];
    paramRtype['TOV'] = top.str_RT[3];

    urlArray["T"]=new Array("../FT_order/FT_order_t.php",paramRtype[betTeam]);

    if(wtype=="PGF"){
        if(betTeam=="H"){
            urlArray["PGF"]=new Array("",top.str_HCN[0]);
        }else if(betTeam=="C"){
            urlArray["PGF"]=new Array("",top.str_HCN[1]);
        }else{
            urlArray["PGF"]=new Array("",top.str_HCN[2]);
        }
    }
    urlArray["TS"]=new Array("",(betTeam=="Y"? top.yes:top.no));
    urlArray["WN"]=new Array("",(betTeam=="H"? top.team1:top.team2));
    urlArray["CS"]=new Array("",(betTeam=="H"? top.team1:top.team2));

    urlArray["OUH"]=new Array("",betTeam=="O" ? top.strOver : top.strUnder);
    urlArray["OUC"]=new Array("",betTeam=="O" ? top.strOver : top.strUnder);

    var MOURtype = new Array();
    MOURtype['HO'] = top.team1+" & "+top.strOver;
    MOURtype['HU'] = top.team1+" & "+top.strUnder;
    MOURtype['CO'] = top.team2+" & "+top.strOver;
    MOURtype['CU'] = top.team2+" & "+top.strUnder;
    MOURtype['NO'] = top.team3+" & "+top.strOver;
    MOURtype['NU'] = top.team3+" & "+top.strUnder;

    urlArray["MOUA"]=new Array("",MOURtype[betTeam]);
    urlArray["MOUB"]=new Array("",MOURtype[betTeam]);
    urlArray["MOUC"]=new Array("",MOURtype[betTeam]);
    urlArray["MOUD"]=new Array("",MOURtype[betTeam]);


    var param=getParam(uid,odd_f_type,betTeam,wtype,GameData);
    var idName=getidName(uid,odd_f_type,betTeam,wtype,GameData);//點了要變色+id

    //var order=urlArray[wtype][0];
    // 2016-09-19 將盤面上滑鼠停留在賠率鼠標訊息中立場的中拿掉
    //var team=urlArray[wtype][1].replace("[Mid]","[N]").replace("<font style=background-color:#FFFF99>","").replace("</font>","");
    var team=urlArray[wtype][1].replace("<font style=background-color:#FFFF99>","").replace("</font>","").replace("[Mid]","").replace("[中]","").replace(" ","");


    var tmp_rtype="ior_"+wtype+betTeam;
    if(wtype=="PD"||wtype=="T") tmp_rtype="ior_"+betTeam;
    if(wtype.indexOf("MOU")!=-1) tmp_rtype="ior_MOU"+betTeam;


    //var ioratio_str="GameData."+tmp_rtype;

    var ioratio=GameData[tmp_rtype];


    if(ioratio!=""){
        ioratio=Mathfloor(ioratio);
        ioratio=printf(ioratio,2);

    }


//20121023 max新增 輸水盤 負值顯示藍色
    if (odd_f_type=="M" || odd_f_type=="I"){
        if (ioratio<0) ioratio="<font color=#1f497d>"+ioratio+"</font>";
    }
    var ret = "";
    var ischange = check_ioratio(gamerec,tmp_rtype,GameData,mod);
    if(ioratio!=""){

        //ret="<span onclick=\"parent.mem_order.betOrder('FT','"+wtype+"','"+param+"');Bright('"+idName+"');\" title='"+team+"'><span onmouseover=\"iorMouseOver(this);\" onmouseout=\"iorMouseOut(this);\" "+ischange+">"+ioratio+"</span></span>";
        ret="<span onclick=\"parent.mem_order.betOrder('FT','"+wtype+"','"+param+"','"+idName+"');\" title='"+team+"'>"+ioratio+"</span>";
    }
    if(ischange == true )
    {
        var span_color_s = "<span id="+idName+" class=\"bet_bg_color\">";
    }
    else
    {
        var span_color_s = "<span id="+idName+" onmouseover=\"iornameMouseOver(this.id);\" class=\"bet_text_color\">";
    }
    //賠率滑過變色
    //var span_color_s = "<span id="+idName+" class=\"bet_bg_color\">";
    var span_color_e = "</span>";
    if(ret!="") ret=span_color_s+ret+span_color_e;

    return ret;

}
function Mathfloor(z){
    var tmp_z;
    tmp_z=(Math.floor(z*100+0.01))/100;
    return tmp_z;
}

//--------------------------public function --------------------------------
//取得id
function getidName(uid,odd_f_type,betTeam,wtype,GameData){
    var idNameArray=new Array();
    idNameArray['R']=new Array("type","gid");
    idNameArray['HR']=new Array("type","gid");
    idNameArray['OU']=new Array("type","gid");
    idNameArray['HOU']=new Array("type","gid");
    idNameArray['M']=new Array("type","gid");
    idNameArray['HM']=new Array("type","gid");
    idNameArray['EO']=new Array("type","gid");

    idNameArray['PD']=new Array("type","gid");
    idNameArray["T"]=new Array("type","gid");
    idNameArray["PGF"]=new Array("type","gid");
    idNameArray["TS"]=new Array("type","gid");
    idNameArray["WN"]=new Array("type","gid");
    idNameArray["CS"]=new Array("type","gid");
    idNameArray["OUH"]=new Array("type","gid");
    idNameArray["OUC"]=new Array("type","gid");
    idNameArray["MOUA"]=new Array("type","gid");
    idNameArray["MOUB"]=new Array("type","gid");
    idNameArray["MOUC"]=new Array("type","gid");
    idNameArray["MOUD"]=new Array("type","gid");




    var idName="";
    var gid=((wtype.indexOf("H")!= 0) ? GameData.gid : GameData.hgid);
    var gnum=GameData["gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase())];
    var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
    var rtype=(betTeam=="O" ? "ODD" : "EVEN");
    var type=betTeam;


    idName+=wtype;
    for (var i=0;i<idNameArray[wtype].length;i++){
        idName+=eval(idNameArray[wtype][i]);
    }
    return idName;
}


//取得下注參數
function getParam(uid,odd_f_type,betTeam,wtype,GameData){
//	console.log(betTeam+" , "+wtype);
    var paramArray=new Array();
    // 2016-12-14 足球多type所有細單改位罝顯示
    // 3.新會員端&手機-下注單、下注確認單、我的注單-都沒有改到位置
    // paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx","ptype","imp");
    // paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx","ptype","imp");
    // paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp");
    // paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp");
    // paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp");
    // paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp");
    // paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp");
    paramArray['R']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx","ptype","imp","rtype","wtype");
    paramArray['HR']=new Array("gid","uid","odd_f_type","type","gnum","strong","langx","ptype","imp","rtype","wtype");
    paramArray['OU']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp","rtype","wtype");
    paramArray['HOU']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp","rtype","wtype");
    paramArray['M']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp","rtype","wtype");
    paramArray['HM']=new Array("gid","uid","odd_f_type","type","gnum","langx","ptype","imp","rtype","wtype");
    paramArray['EO']=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp","rtype","wtype");

    // paramArray['PD']=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp");
    // paramArray["T"]=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp");
    // paramArray["PGF"]=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp");
    paramArray['PD']=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp","wtype");
    paramArray["T"]=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp","wtype");
    paramArray["PGF"]=new Array("gid","uid","odd_f_type","rtype","langx","ptype","imp","wtype");
    paramArray["TS"]=new Array("gid","uid","odd_f_type","rtype","langx","wtype","ptype","imp");
    paramArray["WN"]=new Array("gid","uid","odd_f_type","rtype","langx","wtype","ptype","imp");
    paramArray["CS"]=new Array("gid","uid","odd_f_type","rtype","langx","wtype","ptype","imp");
    paramArray["OUH"]=new Array("gid","uid","odd_f_type","type","langx","gnum","rtype","wtype","ptype","imp");
    paramArray["OUC"]=new Array("gid","uid","odd_f_type","type","langx","gnum","rtype","wtype","ptype","imp");
    paramArray["MOUA"]=new Array("gid","uid","odd_f_type","langx","rtype","wtype","ptype","imp");
    paramArray["MOUB"]=new Array("gid","uid","odd_f_type","langx","rtype","wtype","ptype","imp");
    paramArray["MOUC"]=new Array("gid","uid","odd_f_type","langx","rtype","wtype","ptype","imp");
    paramArray["MOUD"]=new Array("gid","uid","odd_f_type","langx","rtype","wtype","ptype","imp");



    var param="";

    var gid=((wtype.indexOf("H")!= 0) ? GameData.gid : GameData.hgid);
    var gnum=GameData["gnum_"+(betTeam=="N"? "c":betTeam.toLowerCase())];
    var strong=(wtype=="R" ? GameData.strong : GameData.hstrong);
    var rtype="";

    // var imp = GameData.important;
    // var ptype = GameData.ptype;
    // 2017-04-28
    if(!GameData.important && !GameData.ptype){
        for(var i in ObjDataFT){
            if(ObjDataFT[i].gid == gid){
                var imp = ObjDataFT[i].important;
                var ptype = ObjDataFT[i].ptype;
            }
        }
    }else{
        var imp = GameData.important;
        var ptype = GameData.ptype;
    }

    if(wtype=="T"){
        var TRtype = new Array();
        TRtype['T0'] = "0~1";
        TRtype['T1'] = "2~3";
        TRtype['T2'] = "4~6";
        TRtype['TOV'] = "OVER";
        betTeam=TRtype[betTeam];
    }
    if(wtype!="PD"&&wtype!="T"&&wtype!="PGF"&&wtype!="TS"&&wtype!="WN"&&wtype!="CS"&&wtype.indexOf("MOU")==-1&&wtype!="M"&&wtype!="HR"&&wtype!="OU"&&wtype!="HOU"&&wtype!="R"&&wtype!="HM") {
        rtype=(betTeam=="O" ? "ODD" : "EVEN");
        // if(wtype!="PD"&&wtype!="T"&&wtype!="PGF"&&wtype!="TS"&&wtype!="WN"&&wtype!="CS"&&wtype.indexOf("MOU")==-1) {
        // 	rtype=(betTeam=="O" ? "ODD" : "EVEN");
    }else if(wtype=="PD"||wtype=="T"){
        rtype=betTeam;
    }else{
        rtype=wtype+betTeam;
    }
    var type=betTeam;

    if(wtype=="OUH"||wtype=="OUC"){
        var gnum = (wtype=="OUH")? keep_obt.gnum_h:keep_obt.gnum_c;
        rtype=wtype+betTeam;
        type=betTeam;
    }


    for (var i=0;i<paramArray[wtype].length;i++){
        if (i>0)  param+="&";
        param+=paramArray[wtype][i]+"="+eval(paramArray[wtype][i]);
    }
    return param;
}

function parsemore(GameData,g_more){
    var ret="";
    if(g_more=='0'||GameData.more=='0'){
        ret="&nbsp;";
    }else{
        ret="<A href=javascript: onClick=show_more('"+GameData.gid+"',event);>"+"<font class='total_color'>+"+GameData.more+"&nbsp;</font>"+str_more+"</A>";
    }
    return ret;
}
function show_more(gid,evt){
    evt = evt ? evt : (window.event ? window.event : null);
    var mY = evt.pageY ? evt.pageY : evt.y;
    body_browse.document.getElementById('more_window').style.position='absolute';
    body_browse.document.getElementById('more_window').style.top=mY+30;
    body_browse.document.getElementById('more_window').style.left=body_browse.document.body.scrollLeft+10;
    show_more_gid = gid;
    var  url="body_var_r_more.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx;
    body_browse.showdata.location.href = url;
}
function parseAllBets(GameData,gamerec,g_more){
    var ret = new Object();
    if(g_more=='0'||GameData.more=='0' || GameData.isMaster=='N'){
        ret["display"] = 'none';
        ret["count"] = "0";
        ret["onclick"] = "";
    }else{
        ret["display"] = "";
        ret["count"] = GameData.more;
        // 2016-12-14 足球多type所有細單改位罝顯示
        // 3.新會員端&手機-下注單、下注確認單、我的注單-都沒有改到位置
        ret["onclick"] = "onClick=show_allbets('"+GameData.gid+"',"+gamerec+",event);";
    }

    return ret;
}

// 2016-12-14 足球多type所有細單改位罝顯示
// 3.新會員端&手機-下注單、下注確認單、我的注單-都沒有改到位置
function show_allbets(gid,gamerec,evt){
    closediv();
    evt = evt ? evt : (window.event ? window.event : null);
    var mY = evt.pageY ? evt.pageY : evt.y;

    top.browse_ScrollY = getScroll(body_browse);//body_browse.scrollY;
    body_browse.document.getElementById('box').style.display="none";
    //body_browse.document.getElementById('refresh_right').style.display="none";
    //body_browse.document.getElementById('refresh_down').style.display="none";
    try{
        body_browse.document.getElementById('p3Title').style.display="none";
    }catch(E){}

    if(typeof(g_date) == "undefined"){
        body_browse.document.getElementById('MFT').className="more_bar";
    }
    else {
        body_browse.document.getElementById('MFT').className="more_bar";
    }

    //var imp = ObjDataFT[gamerec].important;
    //var ptype = ObjDataFT[gamerec].ptype;
    if(gid == gamerec){
        for(var i in ObjDataFT){
            if(ObjDataFT[i].gid == gamerec){
                var imp = ObjDataFT[i].important;
                var ptype = ObjDataFT[i].ptype;
            }
        }
    }else{
        var imp = ObjDataFT[gamerec].important;
        var ptype = ObjDataFT[gamerec].ptype;
    }

    show_more_gid = gid;
    retime_flag = "N";
    if(typeof(top.more_fave_wtype) == "undefined" ) top.more_fave_wtype = new (top.Array)();
    //if(typeof(top.more_fave_wtype[show_more_gid]) == "undefined" ) top.more_fave_wtype[show_more_gid] = new (top.Array)();

    parent.display_loading(true);
    var  url="body_var_r_allbets.php?gid="+gid+"&uid="+uid+"&ltype="+ltype+"&langx="+top.langx+"&gtype=FT&imp="+imp+"&ptype="+ptype;

    body_browse.showdata.location.href = url;

    // 2017-04-07 3067.新會員端-chrome v.57- all bets 會發生 滾軸沒作用的清況 (bgm-335)
    // 初步採取做法 將外層scrollTop 移至最上方 可以暫時解決
    body_browse.document.body.scrollTop = 0;
}

function getScroll(frameObj){
    return body_browse.scrollY || body_browse.document.body.scrollTop ;
}




function parseMyLove(GameData){
    /*
     var tmpStr="";
     //====== 加入現場轉播功能 2009-04-09, VideoFun 放在 flash_ior_mem.js
     tmpStr = "<table width='99%'   border='0' cellpadding='0' cellspacing='0'><tr><td align='left'>"+str_even+"</td>";
     tmpStr+= "<td class='hot_td'>";
     //	tmpStr+= "<table><tr align='right'><td>";
     tmpStr+=MM_ShowLoveI(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c);
     tmpStr+= "</td>";
     tmpStr+= "<td class='hot_tv'>";
     //	if (top.casino == "SI2") {
     if (GameData.eventid != "" && GameData.eventid != "null" && GameData.eventid != undefined) {	//判斷是否有轉播
     tmpStr+= VideoFun(GameData.eventid, GameData.hot, GameData.play, "FT");
     }
     //	}
     tmpStr+= "</td>";
     tmpStr+= "</tr></table>";
     */
    var ret = MM_ShowLoveI_FT(GameData.gnum_h,GameData.datetime,GameData.league,GameData.team_h,GameData.team_c,GameData.gidm);
    return  ret;
}


var isHot_game = false;//是否為世足賽
var isFixed = true; //2016.0216 Leslie
var view_alldate = (top.select_showtype=="parlay")?true:true; //跨天過關看全部日期
var chgIor_TS = true;	//雙方球隊進球轉成雙盤
var scrollmax = 0;
var blurHash = new Object();
blurHash["pg_txt"] = "N";
//that body_browse be self
var showpage_ie11=false;
var page_sw=true;//ie11 edge 分頁 開關 20160711
var NotMasterDarw=true;//子盤和局要隱藏歐冠後
var getScrollsw=true;//收聯盟時top_back不重取高度

try{
    if(frame_broke) body_browse = this;
    else 			body_browse = body_browse;
}catch(e){
    //try{ console.log("error body_browse set from FT_mem_Function"); }catch(e){};
}


//--------------------------------public function ----------------------------

function setRefreshPos(){
    //var refresh_right= body_browse.document.getElementById('refresh_right');
    //refresh_right.style.left= body_browse.document.getElementById('myTable').clientWidth*1+20;
    //refresh_right.style.top= 39;
}

function parseArray(gameHead,gameData){
    var gameObj=new Object();
    for (var i=0;i<gameHead.length;i++){
        if (gameHead[i]!=""){
            eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
        }
    }
    return gameObj;
}
function OBTArray(gameHead,gameData,gameGid){
    var gameObj=new Object();
    for (var i=0;i<gameHead.length;i++){
        if (gameHead[i]!=""){
            gameObj[gameHead[i]]=gameData[i];
        }
    }
    return gameObj;
}

function check_ioratio(rec,rtype,GameData,mod){
    if(mod==null) mod="";

    if (flash_ior_set =='Y'){
        //alert(oldObjDataFT[rec]);
        if (""+oldObjDataFT[mod+rec]=="undefined" || oldObjDataFT[mod+rec].gid != GameData.gid){
            var gameObj=new Object();
            gameObj.gid=GameData.gid;
            oldObjDataFT[mod+rec]=gameObj;
        }

        var new_ioratio=GameData[rtype];
        var old_ioratio=oldObjDataFT[mod+rec][rtype];

        if (""+old_ioratio=="undefined"){
            oldObjDataFT[mod+rec][rtype]=GameData[rtype];
            old_ioratio=oldObjDataFT[mod+rec][rtype];
        }

        //alert("old_ioratio==>"+old_ioratio+",new_ioratio==>"+new_ioratio);
        if (""+new_ioratio=="undefined" || new_ioratio==""){
            oldObjDataFT[mod+rec][rtype]=GameData[rtype];
            return;
        }

        /*
         if (parseFloat(old_ioratio)>parseFloat(new_ioratio) ){
         eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
         return "  style='border: 1px solid #FF0000;' ";
         }
         if (parseFloat(old_ioratio)<parseFloat(new_ioratio) ){
         eval("oldObjDataFT[rec]."+rtype+"=GameData."+rtype);
         return "  style='border: 1px solid #00FF00;' ";
         }
         */

        //console.trace("change");
        if (old_ioratio!=new_ioratio && old_ioratio !="" && new_ioratio!="") {
            //console.log("new "+new_ioratio+" old "+ old_ioratio+" ,rtype=>"+rtype);

            oldObjDataFT[mod+rec][rtype]=GameData[rtype];
            //return "  style='background-color : yellow' ";
            return " class='bet_text_color' ";
        }

        return true;
    }

}
//--------------判斷聯盟顯示或隱藏----------------
function showLEG(leg){
    var m_id='.TR_'+leg;
    var dis=$(m_id).css('display');
    if(dis=='none'){
        $(m_id).show();
    }else{
        $(m_id).hide();
    }
}
function showLegIcon(leg,state,gnumH,display){
    var  ary=body_browse.document.getElementsByName(leg);


    var tmp=gnumH.split(":");
    var gnumH=tmp[0];
    var isMaster=tmp[1];

    for (var j=0;j<ary.length;j++){
        ary[j].innerHTML="<span id='"+state+"'></span>";
    }
    //console.log("TR2_"+gnumH+"display  "+display);
    try{//聯盟前面加箭頭 william 2016-03-14
        body_browse.document.getElementById("LEG_"+gnumH).className=(display != "none")? "bet_game_league":"bet_game_league_down";
    }catch(E){}
    try{
        if(isMaster=="N" && NotMasterDarw){
            body_browse.document.getElementById("TR3_"+gnumH).style.display="";
        }else{
            body_browse.document.getElementById("TR3_"+gnumH).style.display=display;
        }
    }catch(E){}
    try{
        body_browse.document.getElementById("TR2_"+gnumH).style.display=display;
    }catch(E){}
    try{
        body_browse.document.getElementById("TR1_"+gnumH).style.display=display;
    }catch(E){}
    try{
        body_browse.document.getElementById("TR_"+gnumH).style.display=display;
    }catch(E){}
    try{
        body_browse.document.getElementById("BASE_"+gnumH).style.display=display;
    }catch(E){}
    try{
        body_browse.document.getElementById("OBT_"+gnumH).style.display=display;
    }catch(E){}
    try{
        body_browse.document.getElementById("GOAL_"+gnumH).style.display=display;
    }catch(E){}

}
//----------------------

//分頁
function show_page(){


    //alert(rtype)
    pg_str='';
    obj_pg = body_browse.document.getElementById('pg_txt');
    obj_pg.style.display="none";

    if(page_sw){
        obj_pg_new = body_browse.document.getElementById('show_page_txt');
        obj_pg_new.style.display="none";
    }
//	alert(t_page);
    if (t_page==0){
        t_page=1;
        //obj_pg.innerHTML = "";
        //return;
    }
    var tmp_lid="";
    if (rtype=="re"||rtype.match("^re")){
        //tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
        // 2017-04-06 3063.新、舊會員端-早餐、過關(包含特殊&精選)盤面-選擇聯盟改判斷為所有頁數，選擇後的頁數也會重新計算為目前所選的賽事統計頁數
        tmp_lid = top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary_RE"];
    }else{
        //tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
        // 2017-04-06 3063.新、舊會員端-早餐、過關(包含特殊&精選)盤面-選擇聯盟改判斷為所有頁數，選擇後的頁數也會重新計算為目前所選的賽事統計頁數
        tmp_lid = top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"];
    }

    if((tmp_lid=='ALL'&&!top.swShowLoveI&&g_date=="ALL"&&top.select_showtype!="today")||showpage_ie11||top.usepage){

        if(!top.usepage&& util.isIE11()){ //早餐過關  所有日期會進來
            obj_pg.style.display="none";
            if(page_sw) obj_pg_new.style.display="";
            body_browse.document.getElementById("show_pg_chk").style.display="";
            body_browse.document.getElementById("show_pg_chk_msg").style.display="";

        }else{

            obj_pg.style.display="";

            var page_str;
            var page_str_new;
            if(top.PAGE=="P"){
                page_str=top.PAGE+" "+(pg*1+1)+"/" +t_page;
            }else{
                page_str=(pg*1+1)+"/" +t_page+top.PAGE;
            }

            page_str_new=(pg*1+1)+"/" +t_page;//盤面下方 160517 joe

            var pghtml="<tt class='bet_normal_text'>"+page_str+"</tt>";
            pghtml+="	<div id='show_page' onmouseleave='hideDiv(this.id);' tabindex='100' class='bet_page_bg' style='display:none;'>"
            pghtml+="<span class='bet_arrow'></span><span class='bet_arrow_text'>"+top.PAGE_NUM+"</span>";
            pghtml+="<ui>";
            for(var i=0;i<t_page;i++){
                pghtml+="<li id='page_"+i+"' class='bet_page_contant' style='list-style-type:none;' onclick='chg_pg("+i+");'>"+(i+1)+"</li>";
            }
            pghtml+="</ui></div>";
            obj_pg.value="1/3";
            obj_pg.innerHTML = pghtml;

            //	pg*1+1
            //	t_page
            var show=""
            if((pg*1+1) <= 1){
                show+="<span id='top_left'  class='bet_page_Lleft_out'></span>";
            }else{
                show+="<span id='top_left' onclick=\"clickpg('1')\" class='bet_page_Lleft'></span>";
            }
            if((pg*1+1)>1){
                show+="<span id='pg_left' onclick=\"clickpg('del')\" class='bet_page_left'></span>";
            }else{
                show+="<span id='pg_left'  class='bet_page_left_out'></span>";
            }
            show+="<tt id='num' class='bet_page_text'>"+page_str_new+"</tt>"
            if((pg*1+1) == t_page){
                show+="<span id='pg_right'  class='bet_page_right_out'></span>";
            }else{
                show+="<span id='pg_right' onclick=\"clickpg('add')\" class='bet_page_right'></span>";
            }
            if(page_sw)
            {
                if(util.isIE11()){


                    body_browse.document.getElementById("show_pg_chk").style.display="";
                    body_browse.document.getElementById("show_pg_chk_msg").style.display="";
                }
                obj_pg_new.innerHTML=show;
                obj_pg_new.style.display="";
            }



            document.getElementById("pg_txt").onclick=function(){
                //divOnBlur(document.getElementById("show_page"),document.getElementById("pg_txt"));
                //console.log("click: "+blurHash["pg_txt"]);
                if(blurHash["pg_txt"]=="N"){
                    document.getElementById("show_page").style.display='';
                    document.getElementById("show_page").focus();
                    set_class();
                }
            }
            initDivBlur_PFunction_new(document.getElementById("show_page"),document.getElementById("pg_txt"));
        }
    }else{
        obj_pg.style.display="none";
        if(page_sw) obj_pg_new.style.display="";

        if(util.isIE11()){
            body_browse.document.getElementById("show_pg_chk").style.display="";
            body_browse.document.getElementById("show_pg_chk_msg").style.display="";
        }
    }
}
//分頁 新按鈕
function clickChkbox(){

    var tmp = top.uid.match(/m\d*l\d*$/);
    tmp = tmp[0];
    tmp = tmp.substring(1,tmp.length).split("l")
    tmp = tmp[0];

    top.usepage=(document.getElementById("pg_chk").checked)?true:false;
    showpage_ie11=top.usepage;   //分頁按鈕
    pg =(top.usepage)? pg:0;		 //取消要回到第一頁

    top.pageType=(top.usepage)?"Y":"N";
    top.CM.set("pageType@"+tmp,top.pageType);
    try{
        if (rtype.indexOf("re")!=-1||!page_sw){//滾球不秀 page_sw過渡期開關
            showpage_ie11=false;
        }
    }catch(e){}
    reload_var("");
}
function clickpg(sel){
    //trace("chg_pg");
    if(sel=="1"){
        pg=0;
    }else if(sel ==="add"){
        pg++;
    }else if(sel ==="del"){
        pg--;
    }
    reload_var("");
}



function hideDiv(id_str){
    document.getElementById(id_str).style.display ="none";
}
//ie8分頁
function show_ie8(){
    util.trace("=======in showie8======");
    //window.onscroll = scroll;
}

/*function scroll()
 {
 var ret = util.reachBottom(document);
 if(ret){
 trace("捲到底部了");
 //pg=1;
 //reload_var("");
 }
 }*/
//將時間 轉回 24小時//04:00p
function  change_time(get_time){

    if (get_time.indexOf("font") > 0 ) return get_time;
    if (get_time.indexOf("p")>0 || get_time.indexOf("a")>0){
        gtime=get_time.split(":");
        if (gtime[1].indexOf("p")>0){

            if (gtime[0]!="12"){
                gtime[0]=gtime[0]*1+12;
            }
        }
        gtime[1]=gtime[1].replace("a","").replace("p","");

    }else{
        return get_time;
    }
    return gtime[0]+":"+gtime[1];

}

//隱藏我的最愛選擇聯賽
function dis_ShowLoveI(){

//if(top.swShowLoveI){
    //body_browse.document.getElementById("sel_league").style.display="none";
    //}else{
    body_browse.document.getElementById("sel_league").style.display="";
    //}
}
//足球 其他 棒球我的最愛盤面隱藏覽看主要盤口
function dis_Market(){
    // 2017-03-13 我的最愛盤面要加上選擇聯盟、看主盤、所有、賽局的按鈕需求(PJM-499)
    //if(top.swShowLoveI){
    //body_browse.document.getElementById("sel_Market").style.display="none";
    //}else{
    body_browse.document.getElementById("sel_Market").style.display="";
    //}
}
function changeTitleStr(s,at){
    if (s.charAt(at)=="H"){
        return "H";
    }else if(s.charAt(at)=="C"){
        return "A";
    }else if(s.charAt(at)=="N"){
        return "D";
    }
    return "";
}
//2017-0124-johnson-早餐足球-半場/全場,要帶出實際主客隊的隊名
function changeTitleStr2(s,at,gd){
    if (s.charAt(at)=="H"){
        return " "+gd.team_h;
    }else if(s.charAt(at)=="C"){
        return " "+gd.team_c;
    }else if(s.charAt(at)=="N"){
        return " "+top["team3"]+" ";
    }
    return "";
}


function loadingOK(){
    //alert("loadingOK")
    /*
     try{
     body_browse.document.getElementById("refresh_btn").className="refresh_btn";
     }catch(E){}
     try{
     body_browse.document.getElementById("refresh_right").className="refresh_M_btn";
     }catch(E){}
     try{
     body_browse.document.getElementById("refresh_down").className="refresh_M_btn";
     }catch(E){}
     */
}


var gameCount="";
var recordHash=new Array();
function showHOT(countHOT){

    if( (""+countHOT=="") || (""+countHOT=="undefined") ){

        //body_browse.document.getElementById("euro_btn").style.display="none";
        //body_browse.document.getElementById("euro_up").style.display="none";

    }else{

        if(""+top.hot_game=="undefined"){
            top.hot_game="";
        }
        var gtypeHOT =new Array("FT","BK","TN","VB","BM","TT","OP");
        var countgames=countHOT.split(",");
        recordHash=new Array();
        var head_str="";

        if(rtype == "re"){
            head_str="RB";
        }else{
            head_str=top.head_FU;
        }
        //alert(head_str);

        for( var i=0;i<countgames.length;i++){
            var detailgame=countgames[i].split("|");
            recordHash[detailgame[0]+"_"+detailgame[1]]=detailgame[2]*1;
        }
        if(recordHash[top.head_gtype+"_HOT_"+head_str]*1==0){
            //body_browse.document.getElementById("euro_btn").style.display="none";
            //body_browse.document.getElementById("euro_up").style.display="none";
            //body_browse.document.getElementById("euro_close").style.display="";
            if(top.hot_game!=""){
                //top.hot_game="";
                //body_browse.reload_var();
            }
        }else{
            if(isHot_game){
                if(top.hot_game!=""){
                    //body_browse.document.getElementById("euro_btn").style.display="none";
                    //body_browse.document.getElementById("euro_up").style.display="";
                }else{
                    //body_browse.document.getElementById("euro_btn").style.display="";
                    //body_browse.document.getElementById("euro_up").style.display="none";
                }
            }
            //body_browse.document.getElementById("euro_close").style.display="none";
        }
        //alert(recordHash[top.head_gtype+"_HOT_RB"]);
        //alert(recordHash[top.head_gtype+"_HOT_FT"]);
        //alert(recordHash[top.head_gtype+"_HOT_FU"]);
        //parent.mem_order.showHOT(recordHash[top.head_gtype+"_HOT_FT"],recordHash[top.head_gtype+"_HOT_FU"]);
        //parent.mem_order.showHOT(recordHash["FT_HOT_FT"],recordHash["FT_HOT_FU"]);
        /*
         var today_hot=0;
         var early_hot=0;
         for( var i=0;i<gtypeHOT.length;i++){
         try{
         parent.mem_order.document.getElementById(gtypeHOT[i]+"_FT").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FT"]+")";
         parent.mem_order.document.getElementById(gtypeHOT[i]+"_FU").innerHTML=eval("top.str_"+gtypeHOT[i]) + "("+recordHash[gtypeHOT[i]+"_HOT_FU"]+")";
         }catch(E){}

         today_hot +=recordHash[gtypeHOT[i]+"_HOT_FT"];
         early_hot +=recordHash[gtypeHOT[i]+"_HOT_FU"];
         }

         parent.mem_order.showHOT(today_hot,early_hot);
         */
        try{
            parent.mem_order.getCountHOT(countHOT);
        }catch(e){}

    }

}

//function getCountHOT(){
//	return recordHash[top.head_gtype+"_HOT_FT"];
//}
function keep_show_more(gid,GameFT,gamount){
    if(gid!=''){
        show_more_gid = '';
        for (var j=0;j < gamount;j++){
            if(gid == GameFT[j].gid  && GameFT[j].more != 0){
                //body_browse.showdata.location.reload();
                show_more_gid = gid;
                return;
            }
        }
    }
    body_browse.document.getElementById('more_window').style.display='none';
}

function showCleanData(gtype,rtype,show){
    body_browse.location.href="../showCleanData.php?uid="+uid+"&ltype="+ltype+"&gtype="+gtype+"&rtype="+rtype+"&show="+show+"&langx="+langx;
}


function TeamName(Name){
    return Name.replace(" [Mid]","").replace(" [中]","").replace("#FFFF99","").split(" - (")[0];
}
function TeamName_BS(Name){//BS OP
    return Name.replace(" [Mid]","").replace(" [中]","").replace("#FFFF99","");
}


function iornameMouseOver(idName)//滑鼠一上去就要有底色
{
    if(top.lastidName == idName)	return;//被選的不用改
    document.getElementById(idName).className = "bet_bg_color";
}

function iorMouseOver(obj){
    var org_class = util.getObjectClass(obj);
    obj.setAttribute("org" , org_class);
    util.setObjectClass(obj, "");

}

function iorMouseOut(obj){
    var org_class = obj.getAttribute("org");
    util.setObjectClass(obj, org_class);
}
function arrayMege(gm,g){
    var retary=[];
    for (var i=0;i<g.length;i++){
        var a=g[i].splice(0,1);
        tempG=[];
        tempG=tempG.concat(a,gm[a[0]],g[i]);
        retary.push(tempG);
    }
    return retary;
}
//after parse finish
function initfixhead(){

    try{
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
        var div_show = document.getElementById("showtable");
        var tab_show = div_show.children[0];

        tab_bak = tab_show.cloneNode(false);
        tab_bak.setAttribute("id", "tab_bak");

        div_bak = document.createElement("div");
        with(div_bak){
            setAttribute("id", "div_bak");
            style["z-index"] = 1;
            //style.width = tab_bak.clientWidth+"px";
            style.height = tab_bak.clientHeight+"px";
            style.width = "100%";
            //style.height = "100%";
            style.position = "absolute";
            style.top = (scrollTop)+"px";
            style.left = "0px";
            appendChild(tab_bak);
        }
        div_show.appendChild(div_bak);



        if(isFixed){ //2016.0216 Leslie
            document.getElementById("fixhead_layer").style.position = "fixed";
            //div_bak.style.position = "fixed";
            //div_bak.style.top = "0px";
            //div_bak.style.top = (scrollTop)+"px";
            tab_bak.style.position = "fixed";
        }else{
            //div_bak.style.position = "absolute";
            //div_bak.style.top = (scrollTop)+"px";
            document.getElementById("fixhead_layer").style.top = scrollTop+"px";
        }


        var fixAry = document.getElementsByName("fixhead_copy");

        for(var i=0; i<fixAry.length; i++){

            var obj = fixAry[i];
            var org_w = obj.clientWidth;
            var org_h = obj.clientHeight;
            var _name = obj.id+"_bak";


            bak = obj.cloneNode(true);
            with(bak){
                setAttribute("id", _name);
                setAttribute("name", _name);
                style.width = org_w+"px";
                style.height = org_h+"px";
            }
            //if(isFixed) bak.style.position = "fixed"; //2016.0216 Leslie
            tab_bak.appendChild(bak);

            var last_line = false;
            for(var j=0; j<obj.children.length; j++){
                try{
                    //console.info("["+_name+"]"+obj.children[j].clientWidth+","+obj.children[j].clientHeight);
                    var w = obj.children[j].clientWidth;
                    var h = obj.children[j].clientHeight;

                    //td大小不含css,線的px不含在裡面
                    if(bak.children[j].className=="bet_two_td_left"){ //線在左
                        w+=1;
                    }

                    if(last_line){
                        w+=1;
                        last_line = false;
                    }

                    if(bak.children[j].className=="bet_title_oe"){ //線在右
                        last_line = true;
                    }



                    bak.children[j].style.width = w+"px";
                    bak.children[j].style.height = h+"px";

                    //console.info(bak.children[j].getAttribute("style"));
                }catch(ee){
                    systemMsg(ee.toString());
                }
            }

        }

    }catch(e){
        systemMsg(e.toString());
    }


    scrollmax = getScrollMax();
}

function setshowfixhead(){

//on scroll
    document.body.onscroll = function (){
        //if(isFixed) return; //2016.0216 Leslie

        try{
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
            if(!isFixed){
                document.getElementById("fixhead_layer").style.top= scrollTop+"px";
                document.getElementById("div_bak").style.top = (scrollTop)+"px";
            }
            //回到頂部======== joe 160122
            var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
            var tab_bak=document.getElementById("tab_bak").clientHeight;
            var back_value="";
            //back_value= scrollTop+bodyheight-tab_bak;
            back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

            if(back_value>scrollmax) back_value=scrollmax;

            if(scrollTop>0){
                document.getElementById("backTOP").style.display="";
                document.getElementById("backTOP").style.top= back_value+"px";
                document.getElementById("backTOP").style["z-index"] = 1;
                document.getElementById("show_page_txt").className="bet_page_bot_rt";
            }else{
                document.getElementById("backTOP").style.display="none";
                document.getElementById("show_page_txt").className="bet_page_bot";

            }
            //===============
        }catch(e){
            systemMsg(e.toString());
        }
    }


}

function showfixhead(){

    //if(isFixed) return; //2016.0216 Leslie

    try{
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
        if(!isFixed){
            document.getElementById("fixhead_layer").style.top= scrollTop+"px";
            document.getElementById("div_bak").style.top = (scrollTop)+"px";
        }
        //回到頂部======== joe 160122
        var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
        var tab_bak=document.getElementById("tab_bak").clientHeight;
        var back_value="";
        //back_value= scrollTop+bodyheight-tab_bak;
        back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

        if(back_value>scrollmax) back_value=scrollmax;

        if(scrollTop>0){
            document.getElementById("backTOP").style.display="";
            document.getElementById("backTOP").style.top= back_value+"px";
            document.getElementById("backTOP").style["z-index"] = 1;
            document.getElementById("show_page_txt").className="bet_page_bot_rt";
        }else{
            document.getElementById("backTOP").style.display="none";
            document.getElementById("show_page_txt").className="bet_page_bot";
        }
        //===============
    }catch(e){
        systemMsg(e.toString());
    }
}

function getback_top(){
    try{
        var scrollTop = document.documentElement.scrollTop || document.body.scrollTop || 0;
        var scrollmax=getScrollMax();
        //回到頂部======== joe 160122
        var bodyheight = document.documentElement.clientHeight || document.body.clientHeight ||0;
        var tab_bak=document.getElementById("tab_bak").clientHeight;
        var back_value="";
        //back_value= scrollTop+bodyheight-tab_bak;
        back_value = scrollTop+bodyheight-tab_bak+9;//多一行白色+9 160309 joe

        //console.log("back_value==> "+back_value+"scrollmax==> "+scrollmax );
        if(back_value>scrollmax) back_value=scrollmax;

        if(scrollTop>0){
            //console.log("backTOP display");
            document.getElementById("backTOP").style.display="";
            document.getElementById("backTOP").style.top= back_value+"px";
            document.getElementById("backTOP").style["z-index"] = 1;

            document.getElementById("show_page_txt").className="bet_page_bot_rt";
        }else{
            document.getElementById("backTOP").style.display="none";
            document.getElementById("show_page_txt").className="bet_page_bot";
        }
        //===============
    }catch(e){
        systemMsg(e.toString());
    }
}

function getScrollMax(){
    var sh = document.getElementById("showtable").offsetHeight;
    return sh+44;
}

function backtop(){
    try{
        document.body.scrollTop="0";
        document.documentElement.scrollTop="0";
    }catch(e){}
}

function set_class(){
    var temp = odd_f_str.split(",");
    if(top.SortType=="" && top.rtype.indexOf("re")==-1)top.SortType="T";
    else if(top.SortType=="" && top.rtype.indexOf("re")!=-1) top.SortType="C";

    if(top.SortType=="C"){
        document.getElementById("sort_time").className="bet_sort_time";
        document.getElementById("sort_leg").className="bet_sort_comp_choose";
    }else{
        document.getElementById("sort_time").className="bet_sort_time_choose";
        document.getElementById("sort_leg").className="bet_sort_comp";
    }
    //被選擇盤口亮色
    for(i=0;i<temp.length;i++){
        if(top.odd_f_type!=temp[i]){
            document.getElementById("odd_"+temp[i]).className="bet_odds_contant";
        }else{
            document.getElementById("odd_"+top.odd_f_type).className="bet_odds_contant_choose";
        }
    }
    //被選擇頁數亮色
    for(i=0;i<t_page;i++){
        if(pg!=i){
            document.getElementById("page_"+i).className="bet_page_contant";
        }else{
            document.getElementById("page_"+pg).className="bet_page_contant_choose";
        }
    }
}



function initDivBlur_PFunction_new(showdiv,selid){
    showdiv.tabIndex=100;
    showdiv.onblur=function(){
        blurHash[selid.id] = "Y";
        showdiv.style.display='none';
        setTimeout(function(){
            blurHash[selid.id] = "N";
        },300);
    };

}

function initDivBlur_PFunction(showdiv,selid){
    showdiv.tabIndex=100;
    showdiv.onblur=function(){
        showdiv.style.display='none';
        setTimeout(function(){
            selid.onclick=function(){
                //alert("onblur");
                divOnBlur(showdiv,selid);
                set_class();
            }
        },300);

    };

}
var selShowDivStatus = false;

function chgSelShowDivStatus(){
    selShowDivStatus = !selShowDivStatus;
    //console.log("selShowDivStatus ==>"+selShowDivStatus);
}

function initDivBlur_filter(showdiv,selid){
    showdiv.tabIndex=100;

    selid.onmousedown=function(){

        //	console.log("onmousedown==> "+selShowDivStatus);
        if(!selShowDivStatus && showdiv.style.display == "none"){

            init_mtype();
            showdiv.style.display='';
            chgSelShowDivStatus();
        }
        //set_class();
    }

    selid.onclick = function(){
        if(showdiv.style.display == ""){
            //console.log("aaaa1");
            showdiv.focus();
            //console.log("aaaa2");
            showdiv.onblur=function(){
                //setTimeout(function(){
                DivBlur_filter(showdiv,selid);
                //},100);
            }

            //console.log("aaaa3");
        }
    }

    showdiv.onmouseover = function(){

        //showdiv.onblur= null;
        showdiv.onblur = function(){
            //	console.log("onblur nul==>"+selset_filters);
        }
        showdiv.focus();
        //divOnBlur(showdiv,selid);
    }

    showdiv.onmouseout = function(){

        showdiv.onblur=function(){
            //	console.log("selset_filters==>"+selset_filters);
            if(!selset_filters||selShowDivStatus){
                //setTimeout(function(){

                DivBlur_filter(showdiv,selid);
            }
            selset_filters=false;
            //},100);
        }

    }


}



function DivBlur_filter(showdiv,selid){
    //console.log("div onblur");
    showdiv.style.display='none';
    chgSelShowDivStatus();

}
function getKeepScroll(_top, keepscroll){
    var ret = 0;

    if(_top.select_gtype==_top.keep_gtype&&_top.sel_gd==_top.keep_gd){
        ret = keepscroll;
    }else{
        ret = 0;
        top.keep_gtype = top.select_gtype;
        top.keep_gd = top.sel_gd;
    }
    return ret;
}

//點了要有底色再點一次要取消注單 William 2016-03-15
function Bright(idName){
    top.lastidName = idName;
    document.getElementById(idName).className = "bet_bg_color_bet";

    try{
        showdata.document.getElementById(idName).className = "bet_bg_color_bet";
    }catch(e){}
    try{
        parent.show_tv.Live_mem.document.getElementById(idName).className = "bet_bg_color_bet";
    }catch(E){}
}

//ie11 edge 不允許重複id
function id_rename(chg_id,re_type){
    if(re_type=="bak"){
        try{
            chg_id.setAttribute("id",chg_id.id.split("_bak")[0]+"_bak");
        }catch(e){}
        //console.log(chg_id+" , "+chg_id.id);
    }else{
        try{
            chg_id.setAttribute("id",chg_id.id.split("_bak")[0]);
        }catch(e){}
    }
}
//多類別去掉 -
function replacePtype(ptype){
    var tmp_ptype = ptype;
    var base_ary = Array(" - "," -"," -","-");
    for(var i=0; i<base_ary.length; i++){
        var base = base_ary[i]
        var pos = tmp_ptype.indexOf(base);
        if(pos==0){
            tmp_ptype = tmp_ptype.replace(base, "");
            break;
        }
    }
    return tmp_ptype;
}


function init_page(){

    if(util.isIE11()){
        if(top.pageType!="def"){
            document.getElementById("pg_chk").checked=(top.pageType=="Y")?true:false;
            top.usepage=(top.pageType=="Y")?true:false;
        }else{
            document.getElementById("pg_chk").checked=true;
            top.usepage=true;
        }
    }


    if(top.usepage==null){//init

        if(util.isIE11())	{
            document.getElementById("pg_chk").checked=true;
            top.usepage=true;
            top.pageType="Y";

        }else{
            top.usepage=false;
            top.pageType="N";
        }

        showpage_ie11=util.isIE11();   //分頁按鈕
        try{
            if (rtype.indexOf("re")!=-1){//滾球不秀

                showpage_ie11=false;
            }
        }catch(e){}
    }
}
//在body_browse載入
var ReloadTimeID;
//var sel_gtype=parent.sel_gtype;
var reloadFakeSec = 10;//秒數內做假更新
var LastReloadSec;
var ReloadTimeFake;
var isHot_game = true;//是否為世足賽
var reTimeNow = retime;
var Market="";
var Lid_reload=true;//區別是否是選擇聯盟重整的2016-0407 william
var TempLid="";		//選擇聯盟未按送出暫時儲存
var tmpeHot_Game="";

var ptype_str = new Object(); //多type
ptype_str["900"] = ["Corner"];
ptype_str["910"] = ["Corner"];//-加時賽-角球數
ptype_str["901"] = ["Bookings"];
ptype_str["911"] = ["Bookings"];//-加時賽-罰牌數
ptype_str["1"] = ["ETime"];
ptype_str["2"] = ["PK"];
ptype_str["3"] = ["PK"];

var div_sw=false;

//網頁載入
function onLoad(){
    //trace("onLoad");


    LastReloadSec = 0;
    obj_layer = document.getElementById('LoadLayer');
    obj_layer.style.display = 'none';
    obj_layer = document.getElementById('controlscroll');
    obj_layer.style.display = 'none';
    top.swShowLoveI=false;
    //if((""+eval("parent."+sel_gtype+"_lname_ary"))=="undefined") eval("parent."+sel_gtype+"_lname_ary='ALL'");
    //if((""+eval("parent."+sel_gtype+"_lid_ary"))=="undefined") eval("parent."+sel_gtype+"_lid_ary='ALL'");
    if(ShowType==""||rtype=="r") ShowType = 'OU';
    if(rtype=="hr") ShowType = 'OU';
    if(rtype=="re") ShowType = 'RE';

    if(rtype=="rpd") ShowType = 'RPD';
    if(rtype=="hrpd") ShowType = 'HRPD';
    if(rtype=="rt") ShowType = 'RT';
    if(rtype=="rf") ShowType = 'RF';

    if(rtype=="pd") ShowType = 'PD';
    if(rtype=="hpd") ShowType = 'HPD';
    if(rtype=="t") ShowType = 'EO';
    if(rtype=="f") ShowType = 'F';

    if(parent.leg_flag=="Y"){
        parent.leg_flag="N";
        pg=0;
        //reload_var("");
    }
    //trace("ShowType:"+ShowType+" ShowType end");
    loading = 'N';

    //2015-02-04 過關畫面異動
    if(rtype == "p3"){
        try{
            showDateSel_FT();
        }catch(E){}
    }

    if(loading_var == 'N'){
        ShowGameList();
        //obj_layer = document.getElementById('LoadLayer');
        //obj_layer.style.display = 'none';
    }
    if (retime_flag == 'Y'){
        //ReloadTimeID = setInterval("reload_var()",retime*1000);
        count_down();
    }else{
        //trace("========>refreshtime!!");
        var rt=document.getElementById('refreshTime');
        rt.innerHTML=top.refreshTime;
    }
    //document.getElementById("odd_f_window").style.display = "none";
    if(sel_gtype=="FU"){

        if (rtype == "r" || rtype=="r_main" || rtype == "pd" || rtype == "hpd" || rtype == "t" || rtype == "f"){
            try{
                showDateSel_Future();
            }catch(E){}
        }
        /*else{
         if(top.showtype!='hgft'){
         selgdate(rtype);
         }
         }*/
    }
    ////trace("wtype:"+rtype+" gameSort start");

    gameSort();

    //trace("wtype:"+rtype+" load start");
    setMarketPeriod(rtype);
    MarketPeriod();
    document.getElementById("body_var").onload=iframe_onError;
    init_mtype();
    reload_var("");

    initDivBlur_PFunction(document.getElementById("show_sort"),document.getElementById("sel_sort"));
    initDivBlur_PFunction(document.getElementById("show_odd"),document.getElementById("chose_odd"));
    initDivBlur_PFunction(document.getElementById("show_page"),document.getElementById("pg_txt"));
    initDivBlur_filter(document.getElementById("filter_div"),document.getElementById("sel_filters"));
    document.getElementById("sel_sort").onclick=function(){
        divOnBlur(document.getElementById("show_sort"),document.getElementById("sel_sort"));
        set_class();
    }
    document.getElementById("chose_odd").onclick=function(){
        divOnBlur(document.getElementById("show_odd"),document.getElementById("chose_odd"));
        set_class();
    }
    document.getElementById("pg_txt").onclick=function(){
        divOnBlur(document.getElementById("show_page"),document.getElementById("pg_txt"));
        set_class();
    }



    window.onscroll = showfixhead;//ie11 onscroll無作用 改用window.onscroll joe


}
function iframe_onError(){
    var iframe = document.getElementById("body_var");

    try{
        check = iframe.contentWindow.document.body.onload;
    }catch(e){
        check = null;
    }

    if(check == null){
        iframe.times = iframe.times || 0;
        showerror(iframe);
    }else{
        iframe.times = 0;
    }
}

function showerror(e){
    //2017-0216-johnson-3.新舊會員端-連線判斷改為無上限 (CRM-197)
    //e.times+=1;
    //if(e.times > 10)	return;
    setTimeout('onLoad()',5000);
}


body_var_onLoad=function(){

    ////trace("body_var_onLoad");
    _=window;

    if(_.parent.mem_order.location == 'about:blank'){

    }
    _.reTimeNow=_.retime
    if(_.retime > 0){
        _.retime_flag='Y';
        _.count_down();
    }else{
        _.retime_flag='N';
    }
    _.loading_var = 'N';
    if(_.clean_data_sw=="Y"){
        _.showCleanData("FT",_.rtype,"FT");
    }else{
        if(_.loading == 'N' && _.ShowType != ''){
            ////trace("body_var_onLoad========>ShowGameList()");
            if(top.usepage){
                document.getElementById("pg_chk").checked=true;
            }

            _.ShowGameList();
            //parent.body_browse.document.all.LoadLayer.style.display = 'none';
        }
    }



}


//function scroll()
//{

//var refresh_right= document.getElementById('refresh_right');
//refresh_right.style.top=document.body.scrollTop+39;

//var refresh_down= document.getElementById('refresh_down');


//refresh_down.style.left=-100;
//refresh_down.style.left=10+document.getElementById('myTable').clientWidth/2+refresh_down.style.width/2;
//refresh_right.style.top=document.body.scrollTop+21+34+25+10;
//refresh_right.style.top=document.body.scrollTop+(document.body.clientHeight-118)/2;
// 捲軸位置              +( frame高度                -header高度)/2

//alert("scroll event detected! "+document.body.scrollTop);
//
//conscroll.style.display="block";
//conscroll.style.top=document.body.scrollTop;
// note: you can use window.innerWidth and window.innerHeight to access the width and height of the viewing area
//}


function showDateSel(){
    //trace("showDateSel")
    var showDateSel = body_browse.document.getElementById("showDateSel");
    var dateSel = body_browse.document.getElementById("dateSel").innerHTML;
    var tmpShow = "";
    var tempDate = new Array;
    tempDate=getnowek(DateAry);//去掉星期

    for(var i=0; i<DateAry.length; i++){
        var tmp = dateSel;
        var sel_class = "&nbsp;";
        var sel_value = "";
        var sel_str = "";

        if(i == 0){
            tmp = tmp.replace("*DATE_SHOWTYPE*","");
            sel_value = tempDate[i];
            sel_str = top.showtoday;
        }else if((i+1) == DateAry.length){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[1]+"|"+tempDate[2]+"|"+tempDate[3]+"|"+tempDate[4]+"|"+tempDate[5]+"|"+tempDate[6];
            sel_str = top.showfuture;
        }else{
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[i];
            sel_str = chgDateStr(DateAry[i]);
        }

        if(top.sel_gd=="today" && i==0){
            sel_class = "bet_date_color";
        }else{
            var tAry = top.sel_gd.split("|");
            if((tAry.length > 1) && ((i+1) == DateAry.length)){
                sel_class = "bet_date_color";
            }else if(sel_value == top.sel_gd){
                sel_class = "bet_date_color";
            }
        }

        tmp = tmp.replace("*DATE_CLASS*",sel_class);
        tmp = tmp.replace("*DATE_VALUE*",sel_value);
        tmp = tmp.replace("*DATE_SEL*",sel_str);

        tmpShow += tmp;
    }

    showDateSel.innerHTML = tmpShow;
}

function showDateSel_FT(){
    //trace("showDateSel_FT");
    var showDateSel = body_browse.document.getElementById("showDateSel");
    var dateSel = body_browse.document.getElementById("dateSel").innerHTML;
    var tmpShow = "";
    var tempDate = new Array;
    tempDate=getnowek(DateAry);//去掉星期

    for(var i=0; i<=DateAry.length; i++){
        var tmp = dateSel;
        var sel_class = "&nbsp;";
        var sel_value = "";
        var sel_str = "";
        var sel_id = "";
        if(i == 0){
            tmp = tmp.replace("*DATE_SHOWTYPE*","");
            sel_str = top.showtoday;
        }else if(i == 1){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[i];
            sel_str = top.showtomorrow;
        }else if((i+1) == DateAry.length){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[1]+"|"+tempDate[2]+"|"+tempDate[3]+"|"+tempDate[4]+"|"+tempDate[5]+"|"+tempDate[6];
            sel_str = top.showfuture;
        }else if(i == DateAry.length){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = 'ALL';
            sel_str = top.date;
            sel_id = "sel_all";
        }else{
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[i];
            sel_str = chgDateStr(DateAry[i]);
        }

        if(top.sel_gd=="today" && i==0){
            sel_class = "bet_date_color";
        }else{
            var tAry = top.sel_gd.split("|");
            if((tAry.length > 1) && ((i+1) == DateAry.length)){
                sel_class = "bet_date_color";
            }else if(sel_value == top.sel_gd){
                sel_class = "bet_date_color";
            }
        }

        tmp = tmp.replace("*DATE_ID*",sel_id);
        tmp = tmp.replace("*DATE_CLASS*",sel_class);
        tmp = tmp.replace("*DATE_VALUE*",sel_value);
        tmp = tmp.replace("*DATE_SEL*",sel_str);

        tmpShow += tmp;
    }

    showDateSel.innerHTML = tmpShow;
}


function showDateSel_Future(){
    var showDateSel = body_browse.document.getElementById("showDateSel");
    var dateSel = body_browse.document.getElementById("dateSel").innerHTML;
    var tmpShow = "";
    var tempDate = new Array;
    tempDate=getnowek(DateAry);//去掉星期


    //初始化選擇的日期
    top.sel_gd = g_date;
    //g_date = DateAry[0];

    //日期清單要列幾個
    var dateList = 9;
    for(var i=0; i<dateList; i++){
        var tmp = dateSel;
        var sel_class = "&nbsp;";
        var sel_value = "";
        var sel_str = "";
        var sel_id= "";
        if(i == dateList -2){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate.slice(i).join("|");
            sel_str = top.showfuture;
        }else if(i == dateList -1){
            tmp = tmp.replace("*DATE_SHOWTYPE*","ALL");
            sel_value = "ALL";
            //sel_value = DateAry.join("|");
            sel_str = top.date;
            sel_id = "sel_all";
        }else if(i == 0){
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[i];
            sel_str = top.showtomorrow;
        }else{
            tmp = tmp.replace("*DATE_SHOWTYPE*","FU");
            sel_value = tempDate[i];
            sel_str = chgDateStr(DateAry[i]);
        }

        if(sel_value.match(top.sel_gd)!= null){
            sel_class = "bet_date_color";
        }else{
            var tAry = top.sel_gd.split("|");
            if((tAry.length > 1) && ((i+1) == DateAry.length)){
                sel_class = "bet_date_color";
            }else if(sel_value == top.sel_gd){
                sel_class = "bet_date_color";
            }
        }
        tmp = tmp.replace("*DATE_ID*",sel_id);
        tmp = tmp.replace("*DATE_CLASS*",sel_class);
        tmp = tmp.replace("*DATE_VALUE*",sel_value);
        tmp = tmp.replace("*DATE_SEL*",sel_str);

        tmpShow += tmp;
    }

    showDateSel.innerHTML = tmpShow;
}

function getnowek(DateAry)//去掉星期
{
    var temp=new Array;
    var tempDateAry = new Array();
    for(var i=0; i<DateAry.length; i++)
    {
        temp = DateAry[i].split("-");
        tempDateAry[i] = temp[0] +"-"+ temp[1]+"-"+temp[2];
    }
    return tempDateAry;
}

function chgDateStr(date){
    var showgdate = date.split("-");
    var tmpsdate="";

    if(top.langx=="zh-tw" || top.langx=="zh-cn"){
        if((showgdate[1]*1)< 10)	showgdate[1] = showgdate[1]*1;
        if((showgdate[2]*1)< 10)	showgdate[2] = showgdate[2]*1;
        tmpsdate = top._date[showgdate[3]]+" "+showgdate[1]+top.showmonth+showgdate[2]+top.showday;
    }else{
        tmpsdate =showgdate[3]+" "+showgdate[2]+" "+top._date["m"+showgdate[1]];
    }

    return tmpsdate;
}

function new_chg_gdate(obj,stype,date){
    g_date = date;
    top.sel_gd=date;
    pg = 0;

    if(obj=="sel_all") obj=document.getElementById("sel_all");

    /*try{
     if(g_date != top.sel_gd && (g_date != "" || top.sel_gd != "today") && (top.cgTypebtn == "hp3_class" || top.cgTypebtn == "hpa_class")){
     parent.header.reload_leg();
     }
     }catch(e){}*/

    //2015-02-09 綜合過關 選日期換色
    var tmpObj = document.getElementById("showDateSel");
    for(var i=0; i<tmpObj.children.length; i++){
        tmpObj.children[i].className = "";
    }
    obj.className = "bet_date_color";

    parent.display_loading(true);

    reload_var("",stype);
}

function reload_fake(){
    //parent.display_loading(true);
    //trace(" under 10 ");
    reTimeNow = retime;
    ReloadTimeFake = setTimeout("ShowGameList()",200);
}


function reload_chk(time){
    if(ReloadTimeFake){
        clearTimeout(ReloadTimeFake);
    }

    var nowReloadSec = new Date().getTime();
    var nowSec = Math.round(nowReloadSec/1000);
    //trace("now >> "+nowSec);

    if(LastReloadSec == 0){
        LastReloadSec = nowSec;
    }else{
        var lastSec = LastReloadSec;
        //trace("last >> "+lastSec);
        //trace(" > "+(nowSec-lastSec));

        if((nowSec - lastSec) >= time){
            //trace(" over "+time+" ");
            //LastReloadSec = 0;
            LastReloadSec = nowSec;
            return true
        }else{
            return false;
        }
    }
}

function reload_var(Level,p3_sel){
    var $url = '/app/member/order/body_var.php';
    if(sel_gtype == 'FT'){
        $url = '/app/member/order/body_var_ft.php';
    }
        //{
        //    'uid':top.uid,
        //    'langx':top.langx,
        //    'rtype':rtype,
        //    'gtype':top.langx,
        //    'showtype':showtype,
        //    'sortType':sortType,
        //    'page_no':page_no,
        //    'num_page':num_page,
        //};



}




var cntTimer;
//倒數自動更新時間
function count_down(){
    if(cntTimer) clearTimeout(cntTimer);
    var rt=document.getElementById('refreshTime');
    cntTimer = setTimeout('count_down()',1000);
    if (retime_flag == 'Y'){
        if(reTimeNow <= 0){
            if(loading_var == 'N')
                reload_var("");

            return;
        }
        reTimeNow--;
        rt.innerHTML=reTimeNow;
        //alert(retime);
        //obj_cd = document.getElementById('cd');
        //obj_cd.innerHTML = retime;
    }
}



//賽事換頁
function chg_pg(mypg){
    //trace("chg_pg");
    if (mypg==pg) {return;}
    pg=mypg;
    setTimeout("document.getElementById('show_page').style.display = 'none'",10);
    if(top.rtype.indexOf("re")!=-1) chk_heisw=true;//是否檢查高度
    reload_var("");
}

function chg_wtype(wtype){
    //parent.display_loading(true);
    var l_id =eval("parent."+sel_gtype+"_lid_type");
    if(top.swShowLoveI) l_id=3;
    if(top.showtype=='hgft'&&sel_gtype=="FU"){
        l_id=3;
    }

    var url = "index.php?uid="+uid+"&rtype="+wtype+"&langx="+langx+"&mtype="+mtype+"&league_id="+l_id+"&hot_game="+top.hot_game;
    try{
        url += "&g_date="+g_date;
    }catch(Ex){}
    //trace("wtype:"+wtype);
    location.href=url;



}

//選擇聯盟=================start
function chg_league(Lreload){
    //區別是否是選擇聯盟重整的2016-0407 william
    if(Lreload == undefined || Lreload == true)
    {
        Lid_reload=false;
    }
    else
    {
        Lid_reload=true;
    }
    //trace("g_date====>"+g_date+",top.sel_gd====>"+top.sel_gd);
    if(cntTimer) clearTimeout(cntTimer);
    //trace("chg_league");
    closediv();
    parent.display_loading(true);
    var legview =document.getElementById('legView');
    var parlayType = "";
    if(rtype == "p3"){
        if(top.sel_gd!="today")	parlayType = "&parlayType=FU";
    }
    try{
        //legFrame.location.href="./body_var_lid.php?uid="+uid+"&rtype="+rtype+"&langx="+langx+"&mtype="+ltype+parlayType+"&sel_gd="+top.sel_gd+"&hot_game="+hot_game;
        // 2017-03-30 3060.精選&特殊-我的最愛-選擇聯盟 -不另外做精選&特殊的過濾 ，秀目前全部聯盟即可
        legFrame.location.href="./body_var_lid.php?uid="+uid+"&rtype="+rtype+"&langx="+langx+"&mtype="+ltype+parlayType+"&sel_gd="+top.sel_gd+"&hot_game="+hot_game+"&is_love="+(top.swShowLoveI?"Y":"N");
    }catch(e){
        //legFrame.src="./body_var_lid.php?uid="+uid+"&rtype="+rtype+"&langx="+langx+"&mtype="+ltype+parlayType+"&sel_gd="+top.sel_gd+"&hot_game="+hot_game;
        // 2017-03-30 3060.精選&特殊-我的最愛-選擇聯盟 -不另外做精選&特殊的過濾 ，秀目前全部聯盟即可
        legFrame.src="./body_var_lid.php?uid="+uid+"&rtype="+rtype+"&langx="+langx+"&mtype="+ltype+parlayType+"&sel_gd="+top.sel_gd+"&hot_game="+hot_game+"&is_love="+(top.swShowLoveI?"Y":"N");
    }
}
function show_legview(SW){
    document.getElementById('legView').style.display=SW;
}
function setleghi(leghight){
    //trace("setleghi ing...")
    var legview =document.getElementById('legFrame');
    var showtable=document.getElementById('showtable');
    legview.width=showtable.offsetWidth;
    legview.height = leghight;

}
function closediv(){
    var div_id= Array("page","sort","odd");
    for(i=0;i<div_id.length;i++){
        if(document.getElementById("show_"+div_id[i]!=null)){
            document.getElementById("show_"+div_id[i]).style.display ="none";
        }
    }
}
function LegBack(){

    var legview =document.getElementById('legView');
    legview.style.display='none';
    (util.isIE8()==false)?show_page():show_ie8();
    if(top.rtype.indexOf("re")!=-1) chk_heisw=true;//是否檢查高度

    // 2017-04-06 3063.新、舊會員端-早餐、過關(包含特殊&精選)盤面-選擇聯盟改判斷為所有頁數，選擇後的頁數也會重新計算為目前所選的賽事統計頁數
    console.log( top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"] );
    if( top[sel_gtype+"_lid"][sel_gtype+"_"+(top.hot_game!=""?top.hot_game:"")+"lid_ary"] != "ALL" ){
        console.log(document.getElementById("pg_txt"));
        document.getElementById("pg_txt").style.display = "none";
        document.getElementById("show_page_txt").style.display = "none";
    }else{
        document.getElementById("pg_txt").style.display = "";
        document.getElementById("show_page_txt").style.display = "";
    }

    reload_var("");
}

//選擇聯盟=================end
function unload(){
    clearInterval(ReloadTimeID);
}
window.onunload=unload;

//-----------------------------future------------------------
function selgdate(rtype,cdate){
    //賽事分日期
    var date_opt = "";
    var arrDate =new Array();
    var year ='';
    var nowDate="";
    if(top.showtype=='hgft'){
        var tmpdate=DateAry[0].split("-");
        for (i = 0; i < hotgdateArr.length; i++) {
            var tmpd =hotgdateArr[i].split("-");
            if(tmpdate[1]*1 > tmpd[0]*1){
                year =tmpdate[0]*1+1;
            }else{
                year =tmpdate[0];
            }
            arrDate =arraySort1(arrDate,year+'-'+hotgdateArr[i]);
        }
        if(cdate=='')cdate ='ALL';
        date_opt = '<select id="g_date" name="g_date" onChange="chg_gdate()">';
        date_opt+= '<option value="ALL" '+((cdate =='ALL')?'selected':'')+'>'+top.alldata+'</option>';
        for (i = 0; i < arrDate.length; i++) {
            nowDate=showdate(arrDate[i]);
            date_opt+= '<option value="'+arrDate[i]+'" '+((cdate ==arrDate[i])?'selected':'')+'>'+nowDate+'</option>';
        }
        date_opt+= "</select>";
    }else{
        arrDate=DateAry ;
        date_opt = "<select id=\"g_date\" name=\"g_date\" onChange=\"chg_gdate()\">";
        date_opt+= "<option value=\"ALL\">"+top.alldata+"</option>";
        if (rtype == "r") {
            date_opt+= "<option value=\"1\" >"+top.S_EM+"</option>";
        }
        for (i = 0; i < arrDate.length; i++) {
            nowDate=showdate(arrDate[i]);
            date_opt+= "<option value=\""+arrDate[i]+"\" >"+nowDate+"</option>";
        }
        date_opt+= "</select>";
    }

    document.getElementById("show_date_opt").innerHTML = date_opt;
}
function showdate(sdate){
    var showgdate=sdate.split("-");
    tmpsdate=showgdate[1]+"-"+showgdate[2];
    if(top.langx=="zh-tw"||top.langx=="zh-cn") {
        if((showgdate[1]*1)< 10) showgdate[1]=showgdate[1]*1;
        if((showgdate[2]*1)< 10) showgdate[2]=showgdate[2]*1;
        tmpsdate=showgdate[1]+top.showmonth+showgdate[2]+top.showday;
    }
    return tmpsdate;
}
function arraySort1(array ,data){
    var outarray =new Array();
    var newarray =new Array();
    for(var i=0;i < array.length ;i++){
        if(array[i]<= data){
            outarray.push(array[i]);
        }else{
            newarray.push(array[i]);
        }
    }
    outarray.push(data);
    for(var i=0;i < newarray.length ;i++){
        outarray.push(newarray[i]);
    }
    return  outarray;
}

//切換日期
function chg_gdate(){

    var obj_gdate = document.getElementById("g_date");

    g_date=obj_gdate.value;
    pg=0;
    reload_var("");
}

//====== 取表格 TD 的x軸
function GetTD_X(TD_lay,GetTableID){
    var TBar = document.getElementById(GetTableID);
    var td_x = TD_lay;
    for(var i=0; i < TBar.rows[0].children.length; i++){
        if (i == TD_lay) { break; }
        td_x += TBar.rows[0].children[i].clientWidth;
    }
    return td_x;
}
//====== 取表格 TD 的y軸
function GetTD_Y(AryIndex,GetTableID){
    var TBar = document.getElementById(GetTableID);
    var td_y = parseInt(AryIndex)+2;

    for(var i=0; i <= parseInt(AryIndex)+1; i++){
        try{
            td_y += TBar.rows[i].clientHeight;
        } catch (E){
            td_y += TBar.rows[i-1].clientHeight;
        }
    }
    return td_y;
}

// 2017-03-08 1949.當盤面停留在我的最愛盤-左上的星星有多加統計 ex:畫面在滾球足球的我的最愛 左上的統計要是秀目前滾球統計量 (此統計要是不包括冠軍的) (PJM-723)
function CountGame(ObjHead, ObjDataFT){
    var MasterIndex = 0;
    var MasterCount = 0;
    for(var key in ObjHead){
        if(ObjHead[key] == "isMaster") MasterIndex = key;
    }

    for(var game in ObjDataFT){
        for(var i = 0; i < ObjDataFT[game].length;i++){
            if(i == MasterIndex){
                if(ObjDataFT[game][i] == "Y") MasterCount++;
            }
        }
    }
    return MasterCount;
}


//----------------------------我的最愛  start----------------------------------
function showPicLove(){

    var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
    // 2017-03-08 1949.當盤面停留在我的最愛盤-左上的星星有多加統計 ex:畫面在滾球足球的我的最愛 左上的統計要是秀目前滾球統計量 (此統計要是不包括冠軍的) (PJM-723)
    var masterNum = CountGame(_.GameHead,_.GameFT);
    var dis_none = "none";
    var dis_block = "";
    try{
        //document.getElementById("fav_num").style.display = "none";

        document.getElementById("live_num").style.display = dis_none;
        document.getElementById("live_num_all").style.display = dis_none;
        document.getElementById("showNull").style.display = dis_none;
        document.getElementById("showAll").style.display = dis_none;
        document.getElementById("showMy").style.display = dis_none;
        if(gtypeNum!=0){
            document.getElementById("live_num").innerHTML =gtypeNum;
            //document.getElementById("live_num_all").innerHTML =gtypeNum;
            // 2017-03-08 1949.當盤面停留在我的最愛盤-左上的星星有多加統計 ex:畫面在滾球足球的我的最愛 左上的統計要是秀目前滾球統計量 (此統計要是不包括冠軍的) (PJM-723)
            document.getElementById("live_num_all").innerHTML =masterNum;
            document.getElementById("live_num").style.display = dis_block;
            document.getElementById("live_num_all").style.display = dis_block;
            //document.getElementById("fav_num").style.display = dis_block;
            /*if(top.hot_game!=""){
             document.getElementById("showMy").style.display = dis_block;
             }else{*/
            if(top.swShowLoveI){
                document.getElementById("showAll").style.display = dis_block;
                document.getElementById("mylovegtype").style.display=dis_block;
                document.getElementById("mygtype").style.display=dis_none;
                //document.getElementById("sel_Market").style.display=dis_none;
            }else{
                document.getElementById("showMy").style.display = dis_block;
                document.getElementById("mylovegtype").style.display=dis_none;
                document.getElementById("mygtype").style.display=dis_block;
                //document.getElementById("sel_Market").style.display=dis_block;
            }
            //}
        }else{
            document.getElementById("showNull").style.display = dis_block;
            top.swShowLoveI=false;
        }
    }catch(e){
        systemMsg(e.toString());
    }
}
//我的最愛中的顯示全部
function showAllGame(gtype){
    top.swShowLoveI=false;
    //eval(""+sel_gtype+"_lid_type=''");
    eval("parent."+sel_gtype+"_lid_type=top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']");
    parent.mem_order.initGtypeClass();
    //顯示全部後order要正確亮色william20160222
    if(sel_gtype == "FT" && (rtype == "re" || rtype == "re_main"))//滾球
    {
        parent.mem_order.Go_RB_page('FT');
    }
    if(sel_gtype == "FT" && (rtype == "r" || rtype == "r_main"))//今日
    {
        parent.mem_order.chgShowType('today');
        parent.mem_order.chgTitle('FT');
        parent.mem_order.chgWtype("wtype_FT_r");
        parent.mem_order.chg_type("wtype_FT_r",'');
    }
    if(sel_gtype == "FU" && (rtype == "r" || rtype == "r_main"))//早盤
    {
        parent.mem_order.chgShowType('early');
        parent.mem_order.chgTitle('FT');
        parent.mem_order.chgWtype("wtype_FT_r");
        parent.mem_order.chg_type("wtype_FT_r",'');
    }
    //reload_var("");
}

//單式盤面點下我的最愛
function showMyLove(gtype){
    top.swShowLoveI =true;
    //精選賽事導回
    if(isHot_game){
        if(top.hot_game!=""){
            //top.hot_game="LV" +top.hot_game;
            top.hot_game="";
            //document.getElementById("euro_btn").style.display='';
            //document.getElementById("euro_up").style.display='none';
        }
    }
    //
    pg =0;
    eval("parent."+sel_gtype+"_lid_type='3'");

    reload_var("");
}


function StatisticsGty(today,now_gmt,gtype){

    var out=0;
    var array =new Array(0,0,0);
    var tmp =today.split("-");
    var newtoday =tmp[1]+"-"+tmp[2];
    var Months =tmp[1]*1;
    tmp =now_gmt.split(":");
    var newgmt=tmp[0]+":"+tmp[1];
    var tmpgday = new Array(0,0);
    var bf = false;

    trace("gtype===>"+gtype);
    try{
        for (var i=0 ; i < top.ShowLoveIarray[gtype].length ; i++){
            //alert(top.ShowLoveIarray[gtype][i][1]+","+top.ShowLoveIarray[gtype][i][2]+","+top.ShowLoveIarray[gtype][i][3]+","+top.ShowLoveIarray[gtype][i][4]+","+top.ShowLoveIarray[gtype][i][4]);
            tmpday = top.ShowLoveIarray[gtype][i][1].split("<br>")[0];
            tmpgday = tmpday.split("-");
            tmpgmt =top.ShowLoveIarray[gtype][i][1].split("<br>")[1];
            tmpgmt=time_12_24(tmpgmt);
            if(++tmpgday[0] < Months){
                bf = true;
            }else{
                bf = false;
            }
            if(bf){
                array[2]++;
            }else{
                if(newtoday >= tmpday ){
                    if((newtoday+" "+newgmt) >= (tmpday+" "+tmpgmt)){
                        array[0]++;	//走地
                    }else{
                        array[1]++;	//單式
                    }
                }else if(newtoday < tmpday){
                    array[2]++;	//早餐
                }
            }
        }
    }catch(e){};
    if(sel_gtype=="FT"||sel_gtype=="OP"||sel_gtype=="BK"||sel_gtype=="BS"||sel_gtype=="VB"||sel_gtype=="TN"){
        if(rtype=="re"||rtype=="re_main"){
            out=array[0];
        }else{
            out=array[1];
        }
    }else if(sel_gtype=="FU"||sel_gtype=="OM"||sel_gtype=="BU"||sel_gtype=="BSFU"||sel_gtype=="VU"||sel_gtype=="TU"){
        out=array[2];
    }

    return out;
}

function time_12_24(stTime){
    var out="";
    var shour =stTime.split(":")[0]*1;
    var smin=stTime.split(":")[1];
    var aop =smin.substr(smin.length-1,1);
    if(aop =="p"){
        if((shour*1)>0 && (shour*1) < 12)
            shour += 12;
    }
    out=((shour < 10)?"0":"")+shour+":"+smin;
    return out;
}
if (top.keep_LoveI_array_FT==undefined) top.keep_LoveI_array_FT=new Array();
// new array{球類 , new array {gid ,data time ,聯盟,H,C,gidm}}
function addShowLoveI(gid,getDateTime,getLid,team_h,team_c,gidm){
    //trace("addShowLoveI");

    var getGtype =getGtypeShowLoveI();
    var getnum =top.ShowLoveIarray[getGtype].length;
    var sw =true;
    for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
        if((top.ShowLoveIarray[getGtype][i][0]==gid && top.ShowLoveIarray[getGtype][i][1] == getDateTime))
            sw = false;
    }
    //console.log(sw+",gid="+gid+",getDateTime="+getDateTime+",getLid="+getLid+",team_h="+team_h+",team_c="+team_c);
    if(sw){
        top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,new Array(gid,getDateTime,getLid,team_h,team_c,gidm));
        //單式最愛帶進去滾球
        //console.log(rtype);
        if(rtype!="re"&&rtype!="re_main"){
            loveI_has_in=true;
            for (i=0;i < top.keep_LoveI_array_FT.length;i++){
                if(top.keep_LoveI_array_FT[i][0]==gid){
                    loveI_has_in=false;
                    break;
                }
            }
            if(loveI_has_in){
                tmpd=getDateTime.split("<br>");
                tmpDateTime=tmpd[0]+"<br>"+tmpd[1];
                try{
                    top.keep_LoveI_array_FT.push(new Array(gid,tmpDateTime,getLid,team_h,team_c,gidm));
                }catch(e){
                }
            }
        }
        //alert("top.keep_LoveI_array_FT==>"+top.keep_LoveI_array_FT.length);
        chkOKshowLoveI();
    }

    //document.getElementById("sp_"+MM_imgId(getDateTime,gid)).innerHTML = "<div class=\"fov_icon_on\" style=\"cursor:hand\" title=\""+top.str_delShowLoveI+"\" onClick=\"chkDelshowLoveI('"+getDateTime+"','"+gid+"');\"></div>";
    var _id = MM_imgId(getDateTime,gid);
    var myloveObj = document.getElementById("love"+_id);
    var mylove_noneObj = document.getElementById("love"+_id+"_none");
    if(myloveObj!=null){
        myloveObj.setAttribute("onclick", "chkDelshowLoveI('"+getDateTime+"','"+gid+"');");
        myloveObj.setAttribute("id", "love"+_id+"_off");
        myloveObj.setAttribute("title", top.str_delShowLoveI);
        myloveObj.setAttribute("class", "bet_game_star_on");
        mylove_noneObj.setAttribute("id", "love"+_id+"_off_none");
        mylove_noneObj.setAttribute("class", "bet_game_star_none");
    }
}
function auto_re_addShowLoveI(Game_Data){

    var getGtype =getGtypeShowLoveI();

    //var tmpAry = new Array();
    //for (var k=0;k < top.keep_LoveI_array_FT.length;k++){
    //tmpAry[tmpAry.length] = top.keep_LoveI_array_FT[k];
    //}
    //top.keep_LoveI_array_FT.toString();
    //if(top.keep_LoveI_array_FT instanceof Array) alert("true");
    //else alert("false");
    //console.log("tmp.length===>"+arraySort(top.ShowLoveIarray[getGtype] ,top.keep_LoveI_array_FT[0]));
    for (var i=top.keep_LoveI_array_FT.length-1;i >= 0;i--){
        var tmp=top.keep_LoveI_array_FT[i][1].split("<br>");

        newTime=change_time(tmp[1])+":00";
        var tmp_today_gmt=top.today_gmt.split("-");
        chk_date_time=tmp_today_gmt[0]+"-"+tmp[0]+" "+newTime;
        var tmp_find=false;
        var tmp_gid=top.keep_LoveI_array_FT[i][0];
        if(chk_date_time < top.today_gmt+" "+top.now_gmt){
            //檢查賽程
            for(var a=0;a < Game_Data.length;a++){
                //alert(Game_FT[a][3]+"---"+tmp_gid);
                if(Game_Data[a][3]==tmp_gid){
                    tmp_find=true;
                    break;
                }
            }

            if(tmp_find){
                top.ShowLoveIarray[getGtype] = arraySort(top.ShowLoveIarray[getGtype] ,top.keep_LoveI_array_FT[i]);
            }
            //top.keep_LoveI_array_FT.splice(i,1);
            Array.prototype.splice.call(top.keep_LoveI_array_FT,i,1);

        }
    }

    chkOKshowLoveI();
    //top.keep_LoveI_array_FT = tmpAry;
}

function arraySort(array ,data){
    var outarray =new Array();
    var newarray =new Array();
    for(var i=0;i < array.length ;i++){
        if(array[i][1]<= data[1]){
            outarray.push(array[i]);
        }else{
            newarray.push(array[i]);
        }
    }
    outarray.push(data);
    for(var i=0;i < newarray.length ;i++){
        outarray.push(newarray[i]);
    }
    return  outarray;
}


function getGtypeShowLoveI(){
    var Gtype;
    var getGtype =sel_gtype;
    var getRtype =rtype;
    Gtype =getGtype;
    if(getRtype=="re"||getRtype=="re_main"){
        Gtype +="RE";
    }
    /*
     if(getGtype =="FU"||getGtype=="FT"){
     Gtype ="FT";
     }else if(getGtype =="OM"||getGtype=="OP"){
     Gtype ="OP";
     }else if(getGtype =="BU"||getGtype=="BK"){
     Gtype ="BK";
     }else if(getGtype =="BSFU"||getGtype=="BS"){
     Gtype ="BS";
     }else if(getGtype =="VU"||getGtype=="VB"){
     Gtype ="VB";
     }else if(getGtype =="TU"||getGtype=="TN"){
     Gtype ="TN";
     }else {
     Gtype ="FT";
     }
     */

    //alert("in==>"+sel_gtype+",out==>"+Gtype);
    return Gtype;
}
function chkOKshowLoveI(){
    //trace("chkOKshowLoveI");

    var getGtype = getGtypeShowLoveI();
    var getnum =top.ShowLoveIOKarray[getGtype].length ;
    var ibj="" ;
    top.ShowLoveIOKarray[getGtype]="";
    for (var i=0 ; i < top.ShowLoveIarray[getGtype].length ; i++){
        tmp = top.ShowLoveIarray[getGtype][i][1].split("<br>")[0];
        //top.ShowLoveIOKarray[getGtype]+=tmp+top.ShowLoveIarray[getGtype][i][0]+",";
        top.ShowLoveIOKarray[getGtype]+=tmp+top.ShowLoveIarray[getGtype][i][0]+"@"+top.ShowLoveIarray[getGtype][i][5]+",";
    }
    showPicLove();
}


function chkDelshowLoveI(getDateTime,gid){
    //trace("chkDelshowLoveI");
    var getGtype = getGtypeShowLoveI();
    var tmpdata = getDateTime.split("<br>")[0]+gid;
    var tmpdata1 ="";
    var ary = new Array();
    var tmp = new Array();
    tmp = top.ShowLoveIarray[getGtype];
    top.ShowLoveIarray[getGtype] = new Array();
    //top.keep_LoveI_array_FT.toString();//=type(top.keep_LoveI_array_FT);
    //top.keep_LoveI_array_FT=top.keep_LoveI_array_FT.toString().split(",");
    //if(top.keep_LoveI_array_FT instanceof Array) alert("true");
    //else alert("false");
    //alert("1 top.keep_LoveI_array_FT.length="+top.keep_LoveI_array_FT.length);
    for (var i=0 ; i < tmp.length ; i++){
        tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];
        if(tmpdata1 == tmpdata){
            ary = tmp[i];
            for (var s=0;s < top.keep_LoveI_array_FT.length;s++){
                if(top.keep_LoveI_array_FT[s][0]==gid) Array.prototype.splice.call(top.keep_LoveI_array_FT,s,1); //top.keep_LoveI_array_FT.splice(s,1);
            }
            continue;
        }
        top.ShowLoveIarray[getGtype].push(tmp[i]);
    }
    //alert("2 top.keep_LoveI_array_FT.length="+top.keep_LoveI_array_FT.length);
    var sw=top.swShowLoveI;
    chkOKshowLoveI();
    var gtypeNum= StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());
    //trace("top.swShowLoveI===>"+top.swShowLoveI+" gtypeNum===>"+gtypeNum)
    if(top.swShowLoveI){


        if(gtypeNum==0){
            top.swShowLoveI=false;
            eval("parent."+sel_gtype+"_lid_type=top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']");
            reload_var("");
        }else{
            ShowGameList();
        }
    }else{
        if(gtypeNum==0){
            if(sw)
            {
                top.swShowLoveI=false;
                eval("parent."+sel_gtype+"_lid_type=top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']");
                parent.mem_order.initGtypeClass();
                //顯示全部後order要正確亮色william20160222
                if(sel_gtype == "FT" && (rtype == "re" || rtype == "re_main"))//滾球
                {
                    parent.mem_order.Go_RB_page('FT');
                }
                if(sel_gtype == "FT" && (rtype == "r" || rtype == "r_main"))//今日
                {
                    parent.mem_order.chgShowType('today');
                    parent.mem_order.chgTitle('FT');
                    parent.mem_order.chgWtype("wtype_FT_r");
                    parent.mem_order.chg_type("wtype_FT_r",'');
                }
                if(sel_gtype == "FU" && (rtype == "r" || rtype == "r_main"))//早盤
                {
                    parent.mem_order.chgShowType('early');
                    parent.mem_order.chgTitle('FT');
                    parent.mem_order.chgWtype("wtype_FT_r");
                    parent.mem_order.chg_type("wtype_FT_r",'');
                }
            }
            else
            {
                reload_var("");
            }
            //reload_var("");
            //if(document.getElementById("sel_Market").style.display="none") document.getElementById("sel_Market").style.display="";

        }else{
            //document.getElementById("sp_"+MM_imgId(ary[1],ary[0])).innerHTML ="<div id='"+MM_imgId(ary[1],ary[0])+"' class=\"fov_icon_out\" style=\"cursor:hand;display:none;\" title=\""+top.str_ShowMyFavorite+"\" onClick=\"addShowLoveI('"+ary[0]+"','"+ary[1]+"','"+ary[2]+"','"+ary[3]+"','"+ary[4]+"'); \"></div>";
            var _id = MM_imgId(ary[1],ary[0]);
            var myloveObj = document.getElementById("love"+_id+"_off");
            var mylove_noneObj = document.getElementById("love"+_id+"_off_none");
            if(myloveObj!=null){
                myloveObj.setAttribute("onclick", "addShowLoveI('"+ary[0]+"','"+ary[1]+"','"+ary[2]+"','"+ary[3]+"','"+ary[4]+"');");
                myloveObj.setAttribute("id", "love"+_id);
                myloveObj.setAttribute("title", top.str_ShowMyFavorite);
                myloveObj.setAttribute("class", "bet_game_star_out");
                mylove_noneObj.setAttribute("id", "love"+_id+"_none");
                mylove_noneObj.setAttribute("class", "bet_game_star_none");//選兩個最愛後只取消一個,灰色星星要消失
            }
        }
    }
    if (top.swShowLoveI){
        document.getElementById("mylovegtype").style.display="none";
        document.getElementById("mygtype").style.display="";
    }
}

function chkDelAllShowLoveI(){
    var getGtype=getGtypeShowLoveI();
    top.ShowLoveIarray[getGtype]= new Array();
    top.keep_LoveI_array_FT=new Array();
    top.ShowLoveIOKarray[getGtype]="";
    if(top.swShowLoveI){
        top.swShowLoveI=false;
        eval("parent."+sel_gtype+"_lid_type=top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']");
        pg =0;
        reload_var("");
    }else{
        ShowGameList();
    }
}
//檢查所選的最愛賽事是否已經進入滾球或是結束
function checkLoveCount(GameArray){

    var getGtype = getGtypeShowLoveI();
    var tmpdata = "";
    var tmpdata1 ="";
    var ary = new Array();
    var tmp = new Array();
    tmp = top.ShowLoveIarray[getGtype];
    top.ShowLoveIarray[getGtype] = new Array();

    for (s=0;s < GameArray.length;s++){
        tmpdata=GameArray[s].datetime.split("<br>")[0]+GameArray[s].gnum_h;
        for (var i=0;i < tmp.length; i++){
            tmpdata1 =tmp[i][1].split("<br>")[0]+tmp[i][0];

            if(tmpdata1 == tmpdata){
                top.ShowLoveIarray[getGtype].push(tmp[i]);
            }
        }
    }
    chkOKshowLoveI();
}
//背景色
var bg_game_class=" bet_game_bg";
var bg_game_more_class=" bet_game_bg_more";//多類別背景色
var bg_text_class=" bet_game_rbg";
var bg_newtext_class=" bet_game_rbg_l";


function mouseEnter_pointer(tmp){
    //alert("==="+tmp.split("_")[1])
    ////trace(tmp);
    if(!tmp) return;
    try{
        //背景色
        var classset=bg_game_class;
        if(ptype_arr.indexOf(tmp.split("_")[1])!=-1) classset=bg_game_more_class;
        document.getElementById("TR_"+tmp.split("_")[1]).className+=classset;
        document.getElementById("TR1_"+tmp.split("_")[1]).className+=classset;
        document.getElementById("TR2_"+tmp.split("_")[1]).className+=classset;
        document.getElementById("TR3_"+tmp.split("_")[1]).className+=classset;


        document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
        document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
        document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_1").className+=bg_newtext_class;
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_2").className+=bg_text_class;
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_3").className+=bg_text_class;
        //我的最愛
        if(rtype!="p3"){
            var love_id=document.getElementById("love"+tmp.split("_")[1]);
            var love_none=document.getElementById("love"+tmp.split("_")[1]+"_none");
            if(love_id.tagName!=null)love_id.style.display ="";
            if(love_none.tagName!=null)love_none.style.display ="none";
        }
    }catch(E){}
}

function mouseOut_pointer(tmp){
    if(!tmp) return;
    ////trace(tmp);
    try{
        //背景色
        document.getElementById("TR_"+tmp.split("_")[1]).className=document.getElementById("TR_"+tmp.split("_")[1]).className.split(" ")[0];
        document.getElementById("TR1_"+tmp.split("_")[1]).className=document.getElementById("TR1_"+tmp.split("_")[1]).className.split(" ")[0];
        document.getElementById("TR2_"+tmp.split("_")[1]).className=document.getElementById("TR2_"+tmp.split("_")[1]).className.split(" ")[0];
        document.getElementById("TR3_"+tmp.split("_")[1]).className=document.getElementById("TR3_"+tmp.split("_")[1]).className.split(" ")[0];


        document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
        document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
        document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
        document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR1_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
        document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR2_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_1").className=document.getElementById("TR3_"+tmp.split("_")[1]+"_text_1").className.split(" ")[0];
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_2").className=document.getElementById("TR3_"+tmp.split("_")[1]+"_text_2").className.split(" ")[0];
        document.getElementById("TR3_"+tmp.split("_")[1]+"_text_3").className=document.getElementById("TR3_"+tmp.split("_")[1]+"_text_3").className.split(" ")[0];

        //我的最愛
        if(rtype!="p3"){
            var love_out_id=document.getElementById("love"+tmp.split("_")[1]);
            var love_out_none=document.getElementById("love"+tmp.split("_")[1]+"_none");

            if(love_out_id!=null)love_out_id.style.display ="none";
            if(love_out_none!=null)love_out_none.style.display ="";
        }
    }catch(E){}
}

function mouseEnter_other(tmp,rtype){
    var num="";
    if(rtype=="pd")	num=6;
    else if(rtype=="hpd") num=5;
    else if(rtype=="f") num=0;
    else if(rtype=="t") num=0;
    try{
        document.getElementById("TR_"+tmp.split("_")[1]).className+=bg_game_class;
        document.getElementById("TR1_"+tmp.split("_")[1]).className+=bg_game_class+" bet_bor_none";
        // 2017-03-29 68.(需求)新會員端-單獨盤面(ex:波膽)下注的，下注單、下注確認單也要要藍字、單獨盤面上也要秀藍字 (CRM-200)
        document.getElementById("TR2_"+tmp.split("_")[1]).className+=bg_game_class;
        for(i=1;i<num+1;i++){
            document.getElementById("TR_"+tmp.split("_")[1]+"_"+i).className+=bg_newtext_class;
        }
    }catch(E){}
}
function mouseOut_other(tmp,rtype){
    var num="";
    if(rtype=="pd")	num=6;
    else if(rtype=="hpd") num=5;
    else if(rtype=="f") num=0;
    else if(rtype=="t") num=0;
    try{
        document.getElementById("TR_"+tmp.split("_")[1]).className=document.getElementById("TR_"+tmp.split("_")[1]).className.split(" ")[0];
        document.getElementById("TR1_"+tmp.split("_")[1]).className=document.getElementById("TR1_"+tmp.split("_")[1]).className.split(" ")[0]+" bet_bor_none";
        // 2017-03-29 68.(需求)新會員端-單獨盤面(ex:波膽)下注的，下注單、下注確認單也要要藍字、單獨盤面上也要秀藍字 (CRM-200)
        document.getElementById("TR2_"+tmp.split("_")[1]).className=document.getElementById("TR2_"+tmp.split("_")[1]).className.split(" ")[0];
        for(i=1;i<num+1;i++){
            document.getElementById("TR_"+tmp.split("_")[1]+"_"+i).className=document.getElementById("TR_"+tmp.split("_")[1]+"_"+i).className.split(" ")[0];
        }
    }catch(E){}
}

function chkLookShowLoveI(){
    top.swShowLoveI =true;
    eval("parent."+sel_gtype+"_lid_type='3'");
    pg =0;
    reload_var("");
}




function MM_imgId(time,gid){
    //console.log("tmp===>"+tmp+"==="+"gid===>"+gid+"===");
    var tmp = time.split("<br>")[0];
    //alert(tmp+gid);
    return tmp+gid;
}


//----------------------------我的最愛  end----------------------------------




//--------------------------odd_f 	start--------------------
//盤口onclick事件

function ChkOddfDiv(){
    ////trace("ChkOddfDiv===>"+odd_f_str);
    var obj = document.getElementById("myoddType");
    obj.innerHTML = "";

    for(i=0; i<Format.length; i++){
        var _value = Format[i][0];
        var _txt = Format[i][1];
        var liObj = document.createElement("li");
        liObj.setAttribute("id", "odd_"+_value);
        liObj.setAttribute("value", _value);
        liObj.setAttribute("text", _txt);
        liObj.setAttribute("class", "bet_odds_contant");
        //盤口英文要全名 joe 160201=============
        var _str="";
        _str=_txt;
        if(_txt=="HK Odds"&&top.langx=="en-us") _str=top.HK_Odds;
        if(_txt=="Euro Odds"&&top.langx=="en-us") _str=top.Euro_Odds;
        liObj.innerHTML = _str;
        //===================================
        //liObj.innerHTML = _txt;
        setChgOddEvent(liObj, _value,_txt);


        if((odd_f_str.indexOf(Format[i][0])!=-1)&&Format[i][2]=="Y"){
            obj.appendChild(liObj);
            if(top.odd_f_type==Format[i][0])	setOddValue(_value,_txt);
        }
    }

}

function setChgOddEvent(liObj, _value,_txt){
    liObj.onclick=function(){
        setOddValue(_value,_txt);
        chg_odd_type();
        refreshReload();
    };
}

function setOddValue(_value,_txt){
    document.getElementById("myoddType").setAttribute("selValue", _value);
    document.getElementById("myoddType").setAttribute("selText", _txt);
    document.getElementById("chose_odd").innerHTML = _txt;
}



//切換盤口
function chg_odd_type(){
    //trace("chg_odd_type");

    var myOddtype=document.getElementById("myoddType");
    if(top.odd_f_type == myOddtype.getAttribute("selValue")) {
        refreshReload();
        return;
    }
    top.odd_f_type = myOddtype.getAttribute("selValue");
    var tmp = top.uid.match(/m\d*l\d*$/);
    tmp = tmp[0];
    tmp =	tmp.substring(1,tmp.length).split("l")
    tmp = tmp[0];
    top.CM.set("OddType@"+tmp,top.odd_f_type);
    setTimeout("document.getElementById('show_odd').style.display = 'none'",10);

    //refreshReload();
}

function show_oddf(){
    for (i = 0; i < Format.length; i++) {
        if(Format[i][0]==top.odd_f_type){
            document.getElementById("oddftext").innerHTML=Format[i][1];
        }
    }

}
//--------------------------odd_f 	end--------------------
var keep_drop_layers;
var dragapproved=false;
var iex;
var iey;
var tempx;
var tempy;
if (document.all){
    document.onmouseup=new Function("dragapproved=false;");
}
function initializedragie(drop_layers){
    return;
    keep_drop_layers=drop_layers;
    iex=event.clientX
    iey=event.clientY
    eval("tempx="+drop_layers+".style.pixelLeft")
    eval("tempy="+drop_layers+".style.pixelTop")
    dragapproved=true;
    document.onmousemove=drag_dropie;
}
function drag_dropie(){
    if (dragapproved==true){
        eval("document.all."+keep_drop_layers+".style.pixelLeft=tempx+event.clientX-iex");
        eval("document.all."+keep_drop_layers+".style.pixelTop=tempy+event.clientY-iey");
        return false
    }
}

function refreshReload(level,fake){
    var ObjDataFT=new Array();
    //document.getElementById("refresh_right").className='refresh_M_on';
    //document.getElementById("refresh_btn").className='refresh_on';
    //document.getElementById("refresh_down").className='refresh_M_on';

    if(fake && !reload_chk(reloadFakeSec)){
        //trace("a");
        reload_fake();
    }else{
        //trace("b");
        reload_var(level);
    }
}

function parseArray(gameHead,gameData){
    var gameObj=new Object();
    for (var i=0;i<gameHead.length;i++){
        if (gameHead[i]!=""){
            eval("gameObj."+gameHead[i]+"='"+gameData[i]+"'");
        }
    }
    return gameObj;
}



function get_timer(){return (new Date()).getTime();} // 計數器



function Euro(){
    if(top.hot_game!=""){
        top.hot_game="";
        top.swShowLoveI=false;
        //document.getElementById("euro_btn").style.display='';
        //document.getElementById("euro_up").style.display='none';
    }else{
        top.hot_game="HOT_";
        tmp_sel_gtype = (top.sel_gd == "today")?"FT":"FU";
        if(tmp_sel_gtype == "FU"){
            g_date="ALL";
            showDateSel_Future();
        }
        //document.getElementById("euro_btn").style.display='none';
        //document.getElementById("euro_up").style.display='';

    }

    if(top.head_gtype=="FT"){
        try{
            parent.mem_order.goEuro_HOT_btn(top.head_gtype+"_"+top.head_btn);
        }catch(E){}
    }

    pg =0;
    show_page();
    reload_var("");

}

function Eurover(act){
    //alert(act.className)
    if(act.className=="euro_btn"){
        act.className='euro_over';
    }else if(act.className=="euro_up"){
        act.className='euro_up_over';
    }
}

function Eurout(act){
    //alert(act.className)
    if(act.className=="euro_over"){
        act.className='euro_btn';
    }else if(act.className=="euro_up_over"){
        act.className='euro_up';
    }
}


function getObjAbsolute(obj){
    var abs = new Object();

    abs["left"] = obj.offsetLeft;
    abs["top"] = obj.offsetTop;

    while (obj = obj.offsetParent) {
        abs["left"] += obj.offsetLeft;
        abs["top"] += obj.offsetTop;
    }

    return abs;
}

function show_lego_sort(Obj,event){
    if(document.getElementById("SortTable").style.display=="none"){
        abs=getObjAbsolute(Obj);
        document.getElementById("SortTable").style.top=abs["top"]+20;
        document.getElementById("SortTable").style.left=abs["left"]+2;
        document.getElementById("SortTable").style.display ="";
        document.getElementById("uid").value=top.uid;
        document.getElementById("langx").value=top.langx;
        document.getElementById("SortForm").action="../setSortType.php";
    }else{
        document.getElementById("SortTable").style.display ="none";
    }
}

function saveSortType(){
    //trace("saveSortType");
    var SortSel=document.getElementById("SortSel");
    if(top.SortType == SortSel.getAttribute("selValue")) {
        refreshReload();
        return;
    }
    top.SortType = SortSel.getAttribute("selValue");
    var tmp = top.uid.match(/m\d*l\d*$/);
    tmp = tmp[0];
    tmp =	tmp.substring(1,tmp.length).split("l");
    tmp = tmp[0];
    top.CM.set("SortType@"+tmp,top.SortType);
    refreshReload();
}
function gameSort(){
    //trace("[gameSort] SortType"+top.SortType);
    if(top.SortType=="" && top.rtype.indexOf("re")==-1)top.SortType="T";
    else if(top.SortType=="" && top.rtype.indexOf("re")!=-1) top.SortType="C";

    document.getElementById("SortSel").setAttribute("selValue", top.SortType);
    document.getElementById("sel_sort").setAttribute("class",(top.SortType=="T")?"bet_sort_time_btn":"bet_sort_btn");

}


function overInfo(){
    document.getElementById("info").style.display = "";
}

function outInf(){
    document.getElementById("info").style.display = "none";
}

function chgSortValue(_id){

    document.getElementById("SortSel").setAttribute("selValue", _id);
    document.getElementById("sel_sort").setAttribute("class", (_id=="T")?"bet_sort_time_btn":"bet_sort_btn");
    document.getElementById("show_sort").style.display = "none";
    saveSortType();
    setTimeout("document.getElementById('show_sort').style.display = 'none'",10);

}

function showDIv(divname){
    var temp = odd_f_str.split(",");
    if(temp.length == 1 && divname=="odd"){
        return;
    }
    //被選擇排序亮色

    if(top.SortType=="C"){
        document.getElementById("sort_time").className="bet_sort_time";
        document.getElementById("sort_leg").className="bet_sort_comp_choose";
    }else{
        document.getElementById("sort_time").className="bet_sort_time_choose";
        document.getElementById("sort_leg").className="bet_sort_comp";
    }
    //被選擇盤口亮色
    for(i=0;i<temp.length;i++){
        if(top.odd_f_type!=temp[i]){
            document.getElementById("odd_"+temp[i]).className="bet_odds_contant";
        }else{
            document.getElementById("odd_"+top.odd_f_type).className="bet_odds_contant_choose";
        }
    }
    //被選擇頁數亮色
    for(i=0;i<t_page;i++){
        if(pg!=i){
            document.getElementById("page_"+i).className="bet_page_contant";
        }else{
            document.getElementById("page_"+pg).className="bet_page_contant_choose";
        }
    }
    var obj = document.getElementById("show_"+divname);
    //trace("show_"+divname);
    if(obj!=null){
        obj.style.display = (obj.style.display=="")?"none":"";
    }
    var div_id= Array("page","sort","odd");
    for(i=0;i<div_id.length;i++){
        if(div_id[i]!=divname&& obj!=null){
            document.getElementById("show_"+div_id[i]).style.display ="none";
        }
    }

}
//覽看所有盤口
function setMarketPeriod(aRtype){
    if(aRtype=="r_main" || aRtype=="re_main"){Market="Main";}
    else if(aRtype=="r" || aRtype=="re"){Market="All";}
    else if(aRtype=="p3" ){Market="Main";}
}
function chgMarket(event){//Main,All
    trace("chgMarket");
    if(Market=="Main")Market="All";
    else Market="Main";
    MarketPeriod();
    rtype = getRtype(rtype);
    var tmp = top.uid.match(/m\d*l\d*$/);
    tmp = tmp[0];
    tmp = tmp.substring(1,tmp.length).split("l")
    tmp = tmp[0];
    top.CM.set("FTRtype@"+tmp,(rtype.split("_")[1])? rtype.split("_")[1]:"r");
    //日期特早 切換帶回全部
    //if(g_date==1 && rtype != "r_no")g_date="ALL"
    //g_date = "ALL";
    if(top.rtype.indexOf("re")!=-1) chk_heisw=true;//是否檢查高度
    refreshReload();

}
function MarketPeriod(){
    try{
        var spanM=document.getElementById("SpanMarket");
        var Market_str=(Market=="Main")?"All":"Main";
        var selM=document.getElementById("sel_Market");
        selM.className=(Market_str=="Main")?"bet_view_btn":"bet_view_small_btn";
        spanM.innerHTML = top["str_BK_Market_"+Market_str];
    }catch(e){
        try{trace("NaN Market");}catch(e){};
    }
}
function getRtype(aRtype){
    var tmp_str="r";
    if(aRtype.match("re")){
        tmp_str="re"
    }
    if(aRtype.match("p3")){
        tmp_str="p3"
    }
    if(Market=="All" ){
        tmp_str= tmp_str;
    }
    else if(Market=="Main" ){
        tmp_str= tmp_str+"_main";

    }
    return tmp_str
}
//================== mtype =============
function Mtype_TeamName(teamname,mtype){  // 隊名去多type
    return teamname.replace(mtype,"");
}
function show_filters(){
    init_mtype();
    if (document.getElementById("filter_div").style.display=="none"){
        document.getElementById("filter_div").style.display="";
    }else{
        document.getElementById("filter_div").style.display="none";
    }

}
var selset_filters=false;
function set_filters(){ //apply

    var chk_c=document.getElementById("box_C");
    var chk_b=document.getElementById("box_B");

    var tmp_c="X";
    var tmp_b="X";
    if(chk_c.checked) tmp_c=chk_c.value;
    if(chk_b.checked) tmp_b=chk_b.value;

    var tmp_type=tmp_c+tmp_b;

    var tmp = top.uid.match(/m\d*l\d*$/);
    tmp = tmp[0];
    tmp = tmp.substring(1,tmp.length).split("l")
    tmp = tmp[0];

    if(rtype=="re"||rtype=="re_main"){
        top.filterTypeRE=tmp_type;
        top.CM.set("filterTypeRE@"+tmp,top.filterTypeRE);
    }else{
        top.filterType=tmp_type;
        top.CM.set("filterType@"+tmp,top.filterType);
    }
    document.getElementById("filter_div").style.display="none";
    if(top.rtype.indexOf("re")!=-1) chk_heisw=true;//是否檢查高度

    selShowDivStatus=false;
    selset_filters=true;
    refreshReload();
}

function init_mtype(){  // onload

    var tmp_c="X";
    var tmp_b="X";

    if(rtype=="re"||rtype=="re_main"){
        if(top.filterTypeRE!=null){
            tmp_c=top.filterTypeRE.substr(0,1);
            tmp_b=top.filterTypeRE.substr(1,1);
        }
    }else{
        if(top.filterType!=null){
            tmp_c=top.filterType.substr(0,1);
            tmp_b=top.filterType.substr(1,1);
        }
    }
    if(tmp_c=="X") {
        document.getElementById("box_C").checked=false;
    }else{
        document.getElementById("box_C").checked=true;
    }
    if(tmp_b=="X") {
        document.getElementById("box_B").checked=false;
    }
    else{
        document.getElementById("box_B").checked=true;
    }
}
function set_allbox(sel){

    if(sel=="Del"){
        document.getElementById("box_C").checked=false;
        document.getElementById("box_B").checked=false;
    }
    else{
        document.getElementById("box_C").checked=true;
        document.getElementById("box_B").checked=true;
    }
}
function chk_ptype(game_data,gtype){


    var filtype=top.filterType;
    if(gtype=="re")  filtype=top.filterTypeRE;
    if(ptype_str[game_data.ptype_map]=="Corner"||ptype_str[game_data.ptype_map]=="Bookings"){
        switch(filtype){
            case "CB":
                if(ptype_str[game_data.ptype_map]=="Corner"||ptype_str[game_data.ptype_map]=="Bookings") return false;
                else return true;
            case "CX":
                if(ptype_str[game_data.ptype_map]=="Corner") return false;
                else return true;
            case "XB":
                if(ptype_str[game_data.ptype_map]=="Bookings") return false;
                else return true;
            case "XX":
                return true;
        }
    }
    return false;
}

//======================================
function systemMsg(msg){
    util.systemMsg("[PFunction_FT.js]"+msg);
}

function trace(msg){
    //util.trace("[PFunction_FT.js]"+msg);
}

