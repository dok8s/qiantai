var count_win=false;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	self.location='../select.php?uid='+i;
}
function CheckKey(){
	if(event.keyCode == 13) return false;
	//if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("�U�`���B�ȯ��J�Ʀr!!"); return false;}
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("only accept numbers on wager amount!!"); return false;}
	//if (isNaN(event.keyCode) == true)){alert("�U�`���B�ȯ��J�Ʀr!!"); return false;}
}

function SubChk()
{
 if(document.all.gold.value=='')
 {
  document.all.gold.focus();
  alert("please key in wager amount!!");//�п�J�U�`���B
  return false;
 }
 if(isNaN(document.all.gold.value) == true)
 {
  document.all.gold.focus();
  alert("only numbers acceptable!!");//�u���J�Ʀr
  return false;
 }

    if(eval(document.all.gold.value) < eval(document.all.gmin_single.value))
    {
     document.all.gold.focus();
     alert("Your wager amount cannot be under the minimum wager amount!!");//�U�`���B���i�p��̧C�U�`���B
     return false;
     }
   // if (document.all.rtype.value=="ODD" || document.all.rtype.value=="EVEN")
    //{
      if(eval(document.all.gold.value) > eval(document.all.gmax_single.value))
      {
       document.all.gold.focus();
       alert("Sorry,you have exceeded your maximum wager limit "+document.all.gmax_single.value+"!!Please key your wager again!!");
       return false;
      }
    //}
  if (document.all.pay_type.value!='1') //���ˬd�{���U��
  {
   // if (document.all.rtype.value=="ODD" || document.all.rtype.value=="EVEN")
    //{
      if(eval(document.all.gold.value) > eval(document.all.singleorder.value))
      {
       document.all.gold.focus();
       alert("You are not allowed to place wager more than your maximum wager limitation!!");//�U�`���B���i�j���`���B
       return false;
      }
    //}
    if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value)) > eval(document.all.singlecredit.value))
    {
     document.all.gold.focus();
     if (eval(document.all.restsinglecredit.value)==0)
     {
     	alert("Exceeded your maximum wager limitation!!");
     }else{
     	alert("The total of your wager on this game: "+document.all.restsinglecredit.value+"\n has exceeded your maximum wager limitation!!");
     }
     return false;
    }
  }
  
    if(eval(document.all.gold.value) > eval(document.all.restcredit.value))
    {
     document.all.gold.focus();
     alert("You are not allowed to place wager more than your credit limit!!");//�U�`���B���i�j��i���B��
     return false;
    }

if(!confirm("To Estimated:"+document.all.pc.innerHTML+"\n\n confirm your wager?")){return false;}
document.all.btnCancel.disabled = true; 
document.all.Submit.disabled = true;
document.forms[0].submit();

}
function CountWinGold(){
	if(document.all.gold.value==''){
		document.all.gold.focus();
		alert('Please key in the Amount!!!');//����J�U�`���B
	}else{
		var tmp_var=document.all.gold.value * document.all.ioradio_pd.value-document.all.gold.value;
		tmp_var=Math.round(tmp_var*100);
		tmp_var=tmp_var/100;	
		document.all.pc.innerHTML=tmp_var;
		count_win=true;
	}
}