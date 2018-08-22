var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}
function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert(top.message015); return false;}
	//if (isNaN(event.keyCode) == true)){alert(top.message015); return false;}
}

function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert(top.message001);
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert(top.message002);
  return false;
 }

    if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert(top.message003);
     return false;
     }
    //if (document.all.rtype.value=="ODD" || document.all.rtype.value=="EVEN")
    //{
      if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
      {
       document.all.gold.focus();
       alert(top.message004+document.all.gmax_single.value+top.message005);
       return false;
      }
    //}
  if (document.all.pay_type.value!='1') //不檢查現金顧客
  {
      if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
      {
       document.all.gold.focus();
       alert(top.message006);
       return false;
      }
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0)
     {
     	alert(top.message007);
     }else{
     	alert(top.message008+document.all.restsinglecredit.value+top.message009);
     }
     return false;
    }
  }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
     alert(top.message010);
     return false;
    }


if(!confirm(top.message011+document.all.pc.innerHTML+top.message016)){return false;}
document.all.btnCancel.disabled = true;
document.all.Submit.disabled = true;
document.forms[0].submit();

}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert(top.message014);
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_fs.value-document.all.gold.value;
		tmp_var=Math.round(tmp_var*100);
		tmp_var=tmp_var/100;
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}