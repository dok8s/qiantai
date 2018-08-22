/**
 * Created by LIYUQING on 2017-8-30.
 */

function divOnBlur(showdiv){
    document.getElementById(showdiv).style.display='';
}
function hideDiv(obj){
    obj.style.display ="none";
}
// showDateSel 时间 ***************
function selgdate(rtype,cdate){
    var weekday=new Array(7);
    weekday[0]="星期天";
    weekday[1]="星期一";
    weekday[2]="星期二";
    weekday[3]="星期三";
    weekday[4]="星期四";
    weekday[5]="星期五";
    weekday[6]="星期六";
    //賽事分日期
    var date_opt ='';
    var sel_class='';
    var dateList = 8;
    var mydate = '';
    var myweekday = '';
    for(var i=0; i<dateList; i++){
        mydate=new Date(DateAry[i]);
        myweekday=mydate.getDay();
        sel_class = '';
        if(DateAry[i]== top.sel_gd)sel_class = 'class="bet_date_color"';
        if(i == 7){
            if(''== top.sel_gd)sel_class = 'class="bet_date_color"';
            date_opt += '<span onclick="new_chg_gdate(this,\''+'all'+'\')" '+sel_class+'>'+'所有日期 '+'</span>';
        }else if(i == 0){
            date_opt += '<span onclick="new_chg_gdate(this,\''+DateAry[i]+'\')" '+sel_class+'>'+'明天'+'</span>';
        }else{
            date_opt += '<span onclick="new_chg_gdate(this,\''+DateAry[i]+'\')" '+sel_class+'>'+weekday[myweekday]+' '+showdate(DateAry[i])+'</span>';
        }
    }
    document.getElementById("showDateSel").innerHTML = date_opt;
    document.getElementById("showDateSel").style.display = '';
}
function new_chg_gdate(obj,gdate){
    if(gdate == 'all')gdate='';
    parent.g_date = gdate;
    top.sel_gd=gdate;
    parent.pg = 0;

    //2015-02-09 綜合過關 選日期換色
    var tmpObj = document.getElementById("showDateSel");
    for(var i=0; i<tmpObj.children.length; i++){
        tmpObj.children[i].className = "";
    }
    obj.className = "bet_date_color";

    reload_var("");
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
//切換日期
function chg_gdate(){
    var obj_gdate = document.getElementById("g_date");

    parent.g_date=obj_gdate.value;
    parent.pg=0;
    reload_var("");
}
/******** 联赛  ***************/

//選擇聯盟=================start
function chg_league(){
    var legview =document.getElementById('legView');
    try{
        legFrame.location.href="./body_var_lid.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype;
    }catch(e){
        legFrame.src="./body_var_lid.php?uid="+parent.uid+"&rtype="+parent.rtype+"&langx="+parent.langx+"&mtype="+parent.ltype;

    }
    document.getElementById('max_leg').style.display="none";
    legview.style.display="";
    legview.style.top="0px";
}
function setleghi(leghight){
    var legview =document.getElementById('legFrame');
    //alert(legview.Height);
    //legview.Height = 800;
    //alert(legview.Height);
    //alert("-----"+leghight);
    //alert("-----"+legview.scrollHeight);
    //legview.Height=0;
    //legview.height = document.body.scrollHeight;
    if((leghight*1) > 95){
        legview.height = leghight;
    }else{

        legview.height = 95;
    }
    //legview.height =legview.scrollHeight;
    //alert("222-----"+legview.height);
    //legview.height=legview.scrollHeight;
}
function LegBack(){
    document.getElementById('max_leg').style.display="";
    var legview =document.getElementById('legView');
    legview.style.display='none';
    reload_var("");
}
//----------------------------我的最愛  start----------------------------------
top.swShowLoveI=false;
function showPicLove(){
    gtypeNum = StatisticsGty(top.today_gmt,top.now_gmt,getGtypeShowLoveI());

    // 2017-03-08 1949.當盤面停留在我的最愛盤-左上的星星有多加統計 ex:畫面在滾球足球的我的最愛 左上的統計要是秀目前滾球統計量 (此統計要是不包括冠軍的) (PJM-723)
    var dis_none = "none";
    var dis_block = "";
    try{
        document.getElementById("showNull").style.display = dis_none;
        document.getElementById("live_num").innerHTML =gtypeNum;
        if(top.swShowLoveI){
            document.getElementById("fav_num").style.display = dis_none;
            document.getElementById("showNull").style.display = dis_block;
        }else{
            document.getElementById("fav_num").style.display = dis_block;
            document.getElementById("showNull").style.display = dis_none;
        }
        if(gtypeNum!=0){
            document.getElementById("fav_num").className='bet_star_btn_on';
        }else{
            document.getElementById("fav_num").className='bet_star_btn_out';
        }
    }catch(e){
    }
}

//我的最愛中的顯示全部
function showAllGame(gtype){
    top.swShowLoveI=false;
    //eval("parent.parent."+parent.sel_gtype+"_lid_type=''");
    eval("parent.parent."+parent.sel_gtype+"_lid_type=top."+parent.sel_gtype+"_lid['"+parent.sel_gtype+"_lid_type']");
    reload_var("");
}

//單式盤面點下我的最愛
function showMyLove(gtype){
    top.swShowLoveI =true;
    parent.pg =0;
    eval("parent.parent."+parent.sel_gtype+"_lid_type='3'");
    reload_var("");
}

/******** 排序  ******************/

function chgSortValue(_id){
    document.getElementById("SortSel").setAttribute("selvalue", _id);
    document.getElementById("sel_sort").setAttribute("class", (_id=="T")?"bet_sort_time_btn":"bet_sort_btn");
    document.getElementById("show_sort").style.display = "none";
    saveSortType();
    setTimeout("document.getElementById('show_sort').style.display = 'none'",10);
}
function saveSortType(){
    var selValue = $("#SortSel").attr("selvalue");
    if(top.SortType != selValue){
        top.SortType = selValue;
        reload_var('');
    }else{
        refreshReload();
    }
}
function gameSort(){
    document.getElementById("SortSel").value = top.SortType;
}
/******** 盘口  ******************/
//切換盤口
function chg_odd_type(obj, value){
    if(parent.top.odd_f_type != value){
        parent.top.odd_f_type=value;
        $("#chose_odd").html($(obj).html());
        reload_var('');
    }
    setTimeout("document.getElementById('show_odd').style.display = 'none'",10);
}
/******** 刷新  ******************/
//倒數自動更新時間
function count_down(){
    //alert(parent.retime);
    setTimeout('count_down()',1000);
    if(parent.retime <= 0){
        if(parent.loading_var == 'N'){
            reload_var("");
        }
        return;
    }
    parent.retime--;
    var rt=document.getElementById('refreshTime');
    rt.innerHTML=parent.retime;
}


function reload_fake(){
    //console.log(" under 10 ");
    parent.reTimeNow = parent.retime;
    ReloadTimeFake = setTimeout("parent.ShowGameList()",200);
}

/*********  分页  ************/

function show_page(){
    //alert(rtype)
    pg_str='';
    obj_pg = body_browse.document.getElementById('pg_txt');
//	alert(t_page);
    if (t_page==0){
        t_page=1;
        //obj_pg.innerHTML = "";
        //return;
    }
    var tmp_lid="";
    if (rtype=="re"){
        tmp_lid=eval("parent."+sel_gtype+"_lid_ary_RE");
    }else{
        tmp_lid=eval("parent."+sel_gtype+"_lid_ary");
    }
    //alert(tmp_lid+"--"+top.swShowLoveI+"--"+t_page)
    if(tmp_lid=='ALL'&&!top.swShowLoveI){
        var disabled="";
        if (t_page==1){
            disabled="disabled";
        }
        var pghtml=(pg*1+1)+" / " +t_page+" "+top.page+"&nbsp;&nbsp; <select  onchange='chg_pg(this.options[this.selectedIndex].value)' "+disabled+">";
        for(var i=0;i<t_page;i++){
            if (pg==i){
                pghtml+="<option value='"+i+"' selected>"+(i+1)+"</option>";
            }else{
                pghtml+="<option value='"+i+"' >"+(i+1)+"</option>";
            }
        }
        pghtml+="</select>";
        obj_pg.innerHTML = pghtml;
    }else{
        obj_pg.innerHTML = "";
    }
}
