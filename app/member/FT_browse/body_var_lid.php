<?
include "../include/library.mem.php";

require ("../include/config.inc.php");
require ("../include/define_function_list.inc.php");
$uid=$_REQUEST['uid'];
$mtype=$_REQUEST['mtype'];
$rtype=trim($_REQUEST['rtype']);
$langx=$_REQUEST['langx'];
require ("../include/traditional.$langx.inc.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title></title>
	<link href="/style/member/reset.css" rel="stylesheet" type="text/css">
	<link href="/style/member/bet_maincortol.css" rel="stylesheet" type="text/css">
</head>
<script>
	var sel_gtype=parent.parent.sel_gtype;
	<? if($rtype<>'re'){?>
	function onLoad(){
		if (""+eval("parent.parent.parent."+sel_gtype+"_lid_ary")=="undefined") eval("parent.parent.parent."+sel_gtype+"_lid_ary='ALL'");
		var len =lid_form.elements.length;

		parent.setleghi(document.body.scrollHeight);
		if(eval("parent.parent.parent."+sel_gtype+"_lid_ary")=='ALL'){
			lid_form.sall.checked='true';
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if (e.id.substr(0,3)=="LID") e.checked = 'true';
			}
		}else{
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if(e.id.substr(0,3)=="LID"&&e.type=='checkbox') {
					if(eval("parent.parent.parent."+sel_gtype+"_lid_ary").indexOf(e.id.substr(3,e.id.length)+"|",0)!=-1){
						e.checked='true';
					}
				}
			}
		}
		count_down();
	}
	function selall(){
		var len =lid_form.elements.length;
		var does=true;
		does=lid_form.sall.checked;
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = does;
		}
	}
	function select_all(b){
		var len =lid_form.elements.length;
		var does=b;
		lid_form.sall.checked=does;
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = does;
		}
	}
	function chk_all(e){
		if(!e) lid_form.sall.checked=e;
	}
	function chk_league(){
		var len =lid_form.elements.length;
		var strlid='';
		var strlname='';
		var gcount=0;
		if(lid_form.sall.checked) {
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent.parent."+sel_gtype+"_lid_type='"+((top.swShowLoveI)?"3":"")+"'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent.parent."+sel_gtype+"_lid_ary='ALL'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent.parent."+sel_gtype+"_lname_ary='ALL'");
		}else{
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if (e.id.substr(0,3)=="LID"&&e.type=='checkbox'&&e.checked) {
					strlid+=e.id.substr(3,e.id.length)+'|';
					strlname+=e.value+'|';
					gcount++;
				}
			}
			if(gcount>0){
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent.parent."+sel_gtype+"_lid_type='2'");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent.parent."+sel_gtype+"_lid_ary=strlid");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent.parent."+sel_gtype+"_lname_ary=strlname");
			}else{
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_type']=parent.parent.parent."+sel_gtype+"_lid_type='"+((top.swShowLoveI)?"3":"")+"'");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary']=parent.parent.parent."+sel_gtype+"_lid_ary='ALL'");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary']=parent.parent.parent."+sel_gtype+"_lname_ary='ALL'");
			}
		}
		back();
	}
	<?
    }else{
    ?>
	function onLoad(){
		if (""+eval("parent.parent.parent."+sel_gtype+"_lid_ary_RE")=="undefined") eval("parent.parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");
		var len =lid_form.elements.length;
		parent.setleghi(document.body.scrollHeight);
		if(eval("parent.parent.parent."+sel_gtype+"_lid_ary_RE")=='ALL'){
			lid_form.sall.checked='true';
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if (e.id.substr(0,3)=="LID") e.checked = 'true';
			}
		}else{
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if(e.id.substr(0,3)=="LID"&&e.type=='checkbox') {
					if(eval("parent.parent.parent."+sel_gtype+"_lid_ary_RE").indexOf(e.id.substr(3,e.id.length)+"|",0)!=-1){
						e.checked='true';
					}
				}
			}
		}
		count_down();

	}
	function selall(){
		var len =lid_form.elements.length;
		var does=true;
		does=lid_form.sall.checked;
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = does;
		}
	}


	function select_all(b){
		var len =lid_form.elements.length;
		var does=b;
		lid_form.sall.checked=does;
		for (var i = 1; i < len; i++) {
			var e = lid_form.elements[i];
			if (e.id.substr(0,3)=="LID") e.checked = does;
		}
	}


	function chk_all(e){
		if(!e) lid_form.sall.checked=e;
	}
	function chk_league(){
		var len =lid_form.elements.length;
		var strlid='';
		var strlname='';
		var gcount=0;
		if(lid_form.sall.checked) {
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");
			eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent.parent."+sel_gtype+"_lname_ary_RE='ALL'");
		}else{
			for (var i = 1; i < len; i++) {
				var e = lid_form.elements[i];
				if (e.id.substr(0,3)=="LID"&&e.type=='checkbox'&&e.checked) {
					strlid+=e.id.substr(3,e.id.length)+'|';
					strlname+=e.value+'|';
					gcount++;
				}
			}
			if(gcount>0){
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent.parent."+sel_gtype+"_lid_ary_RE=strlid");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent.parent."+sel_gtype+"_lname_ary_RE=strlname");
			}else{
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lid_ary_RE']=parent.parent.parent."+sel_gtype+"_lid_ary_RE='ALL'");
				eval("top."+sel_gtype+"_lid['"+sel_gtype+"_lname_ary_RE']=parent.parent.parent."+sel_gtype+"_lname_ary_RE='ALL'");
			}
		}
		back();
	}
	function back(){
		parent.parent.parent.leg_flag="Y";
		//self.location.href=links;
		parent.LegBack();
	}
	<? }?>
	var reload_Timer;
	function count_down(){
		if(reload_Timer) clearTimeout(reload_Timer);
		var rt=document.getElementById('retime');
		var retime=rt.innerHTML;
		reload_Timer = setTimeout('count_down()',1000);
		//if (retime_flag == 'Y'){
		if(retime <= 0){
			//if(loading_var == 'N')
			reloadGameData();
			return;
		}
		retime--;
		rt.innerHTML=retime;
		//}
	}

	function back(){
		parent.parent.parent.leg_flag="Y";
		//parent.location.href=links;
		parent.LegBack();
	}

	//buttons
	function btnClickEvent(eventName){
		//alert(eventName);
		if(eventName == "BackToTop" ){
			//parent.parent.body_browse.scrollTo(0,0)
			document.getElementById("div_show").scrollTop = "0";
		}
		if(eventName == "Close" ) closeClickEvent();
		if(eventName == "Refresh" ) reloadGameData();
	}

	//close

	function closeClickEvent(){
		//alert("close");
		parent.parent.show_more_gid='';

		parent.document.getElementById('more_window').style.display='none';
		parent.parent.body_browse.document.getElementById('max_leg').style.display='';

		parent.parent.body_browse.scrollTo(0,top.browse_ScrollY);
		retime_flag ="N";
		parent.parent.retime_flag = "Y";
	}
	//reload game data
	function reloadGameData(){
		location.reload();
		//document.frames('ifrmname').location.reload()
	}
</script>


<body id="LEG" onLoad="onLoad();"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false">

<div id="div_show" class="bet_select_bg"><!--最外层-->
	<!--right buttons-->
	<div id="right_div" class="bet_right_btn">
		<ul class="bet_right_ul">
			<li class="bet_right_refresh" onClick="btnClickEvent('Refresh');">Làm mới</li>
			<li class="bet_right_close" onClick="back();"><?=$lang_msg_close?></li>
			<li class="bet_right_top" onClick="btnClickEvent('BackToTop');">Về đầu trang</li>
		</ul>
	</div>
	<div class="bet_select_content" id="bet_select">
		<!--right buttons-->
		<form name='lid_form'>
			<table class="bet_select_table" cellpadding="0" cellspacing="0" border="0">
				<tbody>
				<tr class="bet_select_title">
					<td colspan="6">
						<div class="bet_select_left">Chọn giải đấu</div>

						<div class="bet_select_right">
							<label><input type="checkbox" class="bet_selsect_box" value="all" id="sall" onclick="selall();"><span></span><?=$quanxuan?></label>

							<span class="bet_select_time_btn" onClick="btnClickEvent('Refresh');"><tt id="retime">99</tt></span>
							<span class="bet_select_close" onclick="back();"></span>
						</div>

					</td>
				</tr>
				</tbody>
				<tr>
					<td colspan="6" class="bet_select_text">Giải đấu nổi tiếng</td>
				</tr>
				<?
				$mDate=date('m-d');
				if ($rtype<>'re'){
					$mysql = "select distinct M_League FROM foot_match WHERE M_Start > now() AND m_Date ='$mDate' and r_show=1";
				}else{
					$mysql = "select distinct M_League FROM foot_match WHERE m_Date ='$mDate' and re_show=1";
				}
				$result = mysql_db_query($dbname, $mysql);
				$cou=mysql_num_rows($result);
				if ($cou>0){
                $k=0;

                while ($league=mysql_fetch_array($result)){
                $leageue_name=trim($league['M_League'],"");
                 if($k%2==0 or $k==0){
                    ?>
                    <tr class="bet_select_all">
                    <? } ?>
                    <td class="bet_box_w"><label><input type="checkbox" value="<?=$leageue_name?>" id="LID<?=$leageue_name?>" onclick="chk_all(this.checked);" class="bet_selsect_box"><span></span></label></td>
                    <td class="bet_team_w"><span class="bet_select_team"><?=$leageue_name?></span></td>
                    <? if($k==$cou-1){
                            if($k%2==0){
                    ?>
                    <td class="league">&nbsp;</td>
                    <td class="league">&nbsp;</td>
                    </tr>
                    <? } else if($k%2==1){?>
                    <td class="league">&nbsp;</td>
                    </tr>
                    <? } else{?>
                    </tr>
                     <? } } else{
                    if($k%2==1){
                    ?>
                    </tr>
                    <?
                    }
                    }
                    $k=$k+1;
                    }
                    }else{
                    ?>
                    <tr class="bet_select_toph"><td colspan="6"></td></tr>
                    <tr style="display:none;">
                        <td colspan="6" class="bet_no_game_lid">Mục bạn đã chọn hiện không được liên kết.</td>
                    </tr>
                <? } ?>
				<tr>
					<td>
						<div class="leg_mem">
							<table border="0" cellspacing="1" cellpadding="0" class="leg_game">

							</table>
						</div>
					</td>
				</tr>
			</table>
			<div allowtransparency="true" class="bet_select_center"><span class="bet_select_submit" onclick="chk_league();">Gửi đi</span></div>
		</form>
	</div>
</div>

</body>
</html>

