var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("��ע��������������!!"); return false;}
}

function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert("��������ע���!!");
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert("ֻ����������!!");
  return false;
 }

    if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert("��ע����С�������ע���!!");
     return false;
     }
    if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
    {
     document.all.gold.focus();
     alert("�Բ���,��������ע������: "+document.all.gmax_single.value+" Ԫ����!!");
     return false;
     }
  if (document.all.pay_type.value!='1') //������ֽ�˿�
  {
    if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
    {
     document.all.gold.focus();
     alert("��ע���ɴ��ڵ�ע�޶�!!");
     return false;
    }
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0){
     	alert("��ע����ѳ��������޶�!!");
     }else{
     	alert("�����ۼ���ע��: "+document.all.restsinglecredit.value+"\n��ע����ѳ��������޶�!!");
     }
     return false;
    }
 }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
     alert("��ע���ɴ��ڿ��ö��!!");
     return false;
    }

// if (document.all.pc.innerHTML!='0'){
// 	if(!confirm("��Ӯ��"+document.all.pc.innerHTML+"\n\n�Ƿ�ȷ����ע?")){return false;}
// 	return false;	
// }else{
// 	if(!confirm("�Ƿ�ȷ����ע?")){return false;}
// 	return false;
// }
Open_div();
document.all.btnCancel.disabled = true;
document.all.Submit.disabled = true;
document.all.gold.readOnly=true;
return false;
//document.forms[0].submit();
}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('δ������ע���!!!');
	}else{
		var tmpior =document.all.ioradio_r_h.value;
		if(document.all.odd_f_type.value == "E") tmpior -=1;
	    	var tmp_var=document.all.gold.value * ((tmpior < 0)? 1 : tmpior);
		tmp_var=Math.round(tmp_var*100);
		tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}
function CountWinGold1(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('δ������ע���!!!');
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_r_h.value;
        tmp_var=tmp_var-document.all.gold.value;
        tmp_var=Math.round(tmp_var*100);
        tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}
function Open_div(){
	var show_str;
	if (document.all.pc.innerHTML!='0'){
		show_str="��Ӯ��"+document.all.pc.innerHTML+"<br>�Ƿ�ȷ����ע?";
	}else{	
		show_str="�Ƿ�ȷ����ע?<br>";
	}	
	var obj_show_table = document.getElementById('line_window');	
	var obj_gWager = document.getElementById('gWager');
	obj_gWager.innerHTML='';
	obj_gWager.innerHTML=obj_show_table.innerHTML;
	obj_gWager.innerHTML=obj_gWager.innerHTML.replace("*SHOW_STR*",show_str);	
	document.all['gWager'].style.display = "block";
}
function Close_div(){
	document.all['gWager'].style.display = "none";
	document.all.btnCancel.disabled = false;
	document.all.Submit.disabled = false;
	document.all.gold.readOnly=false;
	return false;
}
function Sure_wager(){
	document.all['gWager'].style.display = "none";
	document.forms[0].submit();
}