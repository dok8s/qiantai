
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
    if(frame_broke)
        body_browse = this;
    else
        body_browse = body_browse;
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
function showLeg(leg){


    for (var i=0;i<myLeg[leg].length;i++){
        if ( body_browse.document.getElementById("TR_"+myLeg[leg][i]).style.display!="none"){
            showLegIcon(leg,"LegClose",myLeg[leg][i],"none");

        }else{
            showLegIcon(leg,"LegOpen",myLeg[leg][i],"");
        }
    }
    if ((""+NoshowLeg[leg])=="undefined"){
        NoshowLeg[leg]=-1;
    }else{
        NoshowLeg[leg]=NoshowLeg[leg]*-1;
    }

    document.body.onscroll = function (){}
    setTimeout(function(){
        getback_top();
        setshowfixhead();
    },50);
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