var count_win=false;
if (self==top) 	self.location.href="http://"+document.domain;
//window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
    var i=document.all.uid.value;
    self.location='../order/order.php?uid='+i;
}

function CheckKey(){
    if(event.keyCode == 13) return false;
    if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("�U�`���B�ȯ��J�Ʀr!!"); return false;}
    //if (isNaN(event.keyCode) == true)){alert("�U�`���B�ȯ��J�Ʀr!!"); return false;}
}

function SubChk()
{
    if(document.all.gold.value=='')
    {
        document.all.gold.focus();
        alert("请输入金额!!");
        return false;
    }
    if(isNaN(document.all.gold.value) == true)
    {
        document.all.gold.focus();
        alert("请输入正整数金额!!");
        return false;
    }

    if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
    {
        document.all.gold.focus();
        alert("输入金额过小!!");
        return false;
    }
    if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
    {
        document.all.gold.focus();
        alert("输入金额不得操过: "+document.all.gmax_single.value+"!!");
        return false;
    }
    if (document.all.pay_type.value!='1') //���ˬd�{���U��
    {
        if(eval(document.all.gold.value*1) > eval(document.all.singleorder.value))
        {
            document.all.gold.focus();
            alert("�U�`���B���i�j���`���B!!");
            return false;
        }

        if((eval(document.all.restsinglecredit.value)+eval(document.all.gold.value*1)) > eval(document.all.singlecredit.value))
        {
            document.all.gold.focus();
            if (eval(document.all.restsinglecredit.value)==0)
            {
                alert("�U�`���B�w�W�L����̰����B!!");
            }else{
                alert("�����֭p�U�`�@: "+document.all.restsinglecredit.value+"\n�U�`���B�w�W�L������B!!");
            }
            return false;
        }
    }
    if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
    {
        document.all.gold.focus();
        alert("�U�`���B���i�j��i���B��!!");
        return false;
    }

// if (document.all.pc.innerHTML!='0'){
// 	if(!confirm("�iĹ���B�G"+document.all.pc.innerHTML+"\n\n�O�_�T�w�U�`?")){return false;}
// 	return false;	
// }else{
// 	if(!confirm("�O�_�T�w�U�`?")){return false;}
// 	return false;
// }
    Open_div();
}
function CountWinGold(){
    if(document.all.gold.value==''){
        document.all.gold.focus();
        document.all.pc.innerHTML="0.00";
        alert('请输入金额!!!');
    }else{
        var tmpior =document.all.ioradio_r_h.value;
        if(document.all.odd_f_type.value == "E"){
            tmpior -=1
        };
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
        alert('请输入金额!!!');
    }else{
        var tmp_var=document.all.gold.value * document.all.ioradio_r_h.value;
        tmp_var=tmp_var-document.all.gold.value;
        tmp_var=Math.round(tmp_var*100);
        tmp_var=tmp_var/100;
        //alert("bbb===>"+tmp_var);
        document.all.pc.innerHTML=tmp_var;
        count_win=true;
    }
}
function Open_div(){
    if (confirm(top.message011+document.all.pc.innerHTML+top.message016)){
        document.all.gold.blur();
        document.all.btnCancel.disabled = true;
        document.all.Submit.disabled = true;
        document.all.gold.readOnly=true;
        Sure_wager();
    }else{
        Close_div();
    }
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
    parent.onloadSet(document.body.scrollWidth,document.body.scrollHeight,"bet_order_frame");
}