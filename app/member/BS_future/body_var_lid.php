<?
include "../include/library.mem.php";

echo "<script>if(self == top) parent.location='".BROWSER_IP."'</script>\n";

require ("../include/config.inc.php");
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
	<link rel="stylesheet" href="/style/member/mem_body_ft.css" type="text/css">
</head>
<script>
	<!--
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
	function back(){
		parent.parent.parent.leg_flag="Y";
		//parent.location.href=links;
		parent.LegBack();
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
	//--></script>


<body id="LEG" onLoad="onLoad();"  onSelectStart="self.event.returnValue=false" oncontextmenu="self.event.returnValue=false">
<form name='lid_form'>
	<table border="0" cellpadding="0" cellspacing="0" id="box">
		<tr>
			<td class="leg_top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="30%"><h1><input type=checkbox value=all id=sall onClick="selall();"><?=$quanxuan?></h1></td>
						<td class="btn_td">
							<input type="submit" name="button" id="button" value="<?=$acc_cancle?>" class="enter_btn" onClick="back();">&nbsp;
							<input type="submit" name="button" id="button" value="<?=$tijiao?>" class="enter_btn" onClick="chk_league();">
						</td>
						<td class="close_td"><span class="close_box" onClick="back();"><?=$lang_msg_close?></span></td>
					</tr>
				</table>

			</td>
		</tr>
		<tr>
			<td>
				<div class="leg_mem">
					<table border="0" cellspacing="1" cellpadding="0" class="leg_game">
						<?
						$mDate=date('m-d');
						if ($rtype<>'re'){
							$mysql = "select distinct  M_League FROM `baseball` WHERE `M_Start` > now( ) AND `m_Date` >'$mDate' and r_show=3";
						}else{
							$mysql = "select distinct  M_League FROM `baseball` WHERE `m_Date` >'$mDate' and re_show=1";
						}
						$result = mysql_db_query($dbname, $mysql);
						$cou=mysql_num_rows($result);
						if ($cou>0){
                        $k=0;

                        while ($league=mysql_fetch_array($result)){
                        $leageue_name=trim($league['M_League'],"");
                         if($k%3==0 or $k==0){
                            ?>
                            <tr>
                            <? } ?>
                            <td class="league"><input type="checkbox" value="<?=$leageue_name?>" id="LID<?=$leageue_name?>" onClick="chk_all(this.checked);"><font title="<?=$leageue_name?>"><?=$leageue_name?></font></td>
                            <? if($k==$cou-1){
                                    if($k%3==0){
                            ?>
                            <td class="league">&nbsp;</td>
                            <td class="league">&nbsp;</td>
                            </tr>
                            <? } else if($k%3==1){?>
                            <td class="league">&nbsp;</td>
                            </tr>
                            <? } else{?>
                            </tr>
                             <? } } else{
                            if($k%3==2){
                            ?>
                            </tr>
                            <?
                            }
                            }
                            $k=$k+1;
                            }
                            }
                             else{
                             ?>
                             <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                            <tr>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                              <td class="league"><div style='display:none;'><input type=checkbox value="" id="LID" onClick="chk_all(this.checked);"><font title=""></font></div></td>
                            </tr>
                             <? }?>
					</table>
				</div>
			</td>
		</tr>

	</table>
	<div class="btn_box">
		<input type="submit" name="button" id="button" value="<?=$acc_cancle?>" class="enter_btn" onClick="back();">&nbsp;
		<input type="submit" name="button" id="button" value="<?=$tijiao?>" class="enter_btn" onClick="chk_league();">
	</div>
</form>


</body>
</html>
