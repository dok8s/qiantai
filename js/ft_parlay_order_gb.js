var count_win=false;
window.setTimeout("Win_Redirect()", 45000);
function Win_Redirect(){
	var i=document.all.uid.value;
	var pdate=document.all.pdate.value;
	var page=document.URL;
	go_page="../select.php?uid="+i;
	self.location=go_page;
}
function delteams(teamid){
	eval("TR"+teamid+".style.display='none'");
	document.all.teamcount.value=document.all.teamcount.value-1;
	scripts[teamid-1][0]="0";
	LoadSelect();
}

function LoadSelect(){
	if(rtype=="P"){
	   var mode = 0;				
	} else if(rtype=="PR") {
		var mode = 1;
	} else if(rtype=="P3"){
		var mode = 3;
	}	
 	for (s=0;s < scripts.length ;s++){
 		for (i=0;i < top.paramData.length ;i++){
 			//���P�_GID
 			if (top.paramData[i][0]==scripts[s][0]){
 				if (top.paramData[i][3]!=scripts[s][3]||top.paramData[i][4]!=scripts[s][4]||top.paramData[i][5]!=scripts[s][5]){
 					eval("document.getElementById('P"+(s+1)+"').style.background='#FFDFDF'");
 					//�a���B�L�h
 					if(document.all.gold.value==""){
						document.all.gold.value=top.goldData;
						document.all.gold.focus();
						CountWinGold(iorstr,mode);
				 	}
 				}	
 			}
 		}
 	}
 	top.paramData=new Array();	
	document.all.wteam.style.display="none"
	if(document.all.teamcount.value <= 1){
	 	document.all.btnCancel.disabled = true;
	 	document.all.SUBMIT.disabled = true;
	 	document.all.wkind.style.display="none"
	 	document.all.wstar.style.display="none"
	 	document.all.gold.style.display="none"
	}else{
		document.all.wstar.length = 1;
		document.all.wstar.options[0]=new Option(document.all.teamcount.value+"��1",document.all.teamcount.value);
	}
}

function chiang_wkind()
{
 if(document.all.wkind.value == 'M')
 {
  document.all.wstar.length = document.all.teamcount.value-2;
  for(i=2; i<document.all.teamcount.value; i++)
   document.all.wstar.options[i-2]=new Option(i+"��1",i);
  document.all.wteam.style.display="block";
  document.all.wteam.length = 1;
  var count=0;
  var start=eval(document.all.wstar.value)+1;
   document.all.wteam.options[count++]=new Option(document.all.teamcount.value+"������",document.all.teamcount.value)
 }
 else
 {
  document.all.wstar.length = 1;
  document.all.wstar.options[0]=new Option(document.all.teamcount.value+"��1",document.all.teamcount.value);
  document.all.wteam.style.display="none";
 }
}

function chiang_wstar()
{
 if(document.all.wkind.value == 'M')
 {
  document.all.wteam.style.display="block";
  document.all.wteam.length = 1;
  var count=0;
  var start=eval(document.all.wstar.value)+1;
  document.all.wteam.options[0]=new Option(document.all.teamcount.value+"������",document.all.teamcount.value)
 }
 else
 {
  document.all.wteam.style.display="none";
 }
}

function CheckKey(){
	if(event.keyCode == 13) return false;
	if((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode > 95 || event.keyCode < 106)){alert("��ע��������������!!"); return false;}
}

function CheckSubmit()
{
// if((document.all.teamcount.value <= 1 && scripts[0][4].length ==1))
// {
//  alert("�����ٱ���ѡ��2������,��������ע!!");
//  return false;
// }
 	//�N��Ʃ����s
	if (top.paramData.length == 0||(""+top.paramData.length=="undefined")){ 
		top.paramData=scripts;
 	}
	if(document.all.teamcount.value <= (minlimit*1-1)){
		alert("������ѡ������"+minlimit+"������,��������ע!!");
		return false;
	}
	if(document.all.teamcount.value > maxlimit*1){
		alert("������" + document.all.teamcount.value + "������Ͷע!!");
		return false;
	}
 if(document.all.gold.value=='')
 {
  alert("����������ע���!!");
  document.all.gold.focus();
  return false;
 }
 if(eval(document.all.gold.value*1) < eval(document.all.gmin_single.value))
 {
  document.all.gold.focus();
  alert("��ע����С�������ע���!!");
  return false;
 }
 if (document.all.pay_type.value =='1') //����ֽ�˿�
{
	 if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
 {
  document.all.gold.focus();
  alert("�ѳ���ĳ����֮����ע���޶�!!");
  return false;
  }
}
//if (document.all.pay_type.value !='1') //������ù˿�
//{
//	var sc=document.all.sc.value;
//       	if (sc==''){
//       		alert ('���������ÿհ�');
//       		return false;
//       	}
//	sc=sc.split(' ');
//	counttmp=document.all.teamcount.value;
//	tmp_gold=parseInt(document.all.gold.value);
//	if(counttmp>1){
//		tmp=1;
//		for(var q=0;q<counttmp;q++){
//			var tmp_count=tmp_gold+parseInt(sc[q]);
//			if (tmp_count > eval(document.all.singlecredit.value) ){
//			  alert("��ע����ѳ�����Ա�����޶�!!");
//			  return false;
//			  //self.location=document.location+'&active=4';;
//			}
//		}
//	}
if (document.all.pay_type.value !='1') //������ù˿�
{
	if(eval(document.all.gold.value*1) > eval(document.all.gmax_single.value))
	{
	document.all.gold.focus();
	alert("�ѳ���ĳ����֮����ע���޶�!!");
	return false;
	}
}
 if((eval(document.all.wagerstotal.value)+eval(document.all.gold.value*1)) >= eval(document.all.singlecredit.value))
 {
  document.all.gold.focus();
  alert("����ע���ۼƹ�: "+document.all.wagerstotal.value+"\n����ѳ�������ע���޶�!!");
  return false;
 }
//}//������ù˿ͽ���---------------------------------
 if(eval(document.all.gold.value*1) > eval(document.all.restcredit.value))
 {
  document.all.gold.focus();
  alert("��ע���ɴ������ö��!!");
  return false;
  }

  if(!confirm("��Ӯ��"+document.all.pc.innerHTML+"\n\n�Ƿ�ȷ����ע?")){return false;}
  document.all.btnCancel.disabled = true;
  document.all.SUBMIT.disabled = true;
  document.all.wagerDatas.value="";
  for (kk=0;kk<scripts.length;kk++){
  	if (scripts[kk][0]!="0")  document.all.wagerDatas.value+=scripts[kk].toString()+"|";
  }
	//�N���B���Ȧs
	top.goldData=gold1;  
  document.forms[0].submit();
}

//����ʽ�
function CountWinGold(chk,mode){
   /*------------------------------------------------
   * edit date --- 2005/7/14						*
   * From anson										*
   * Content --- from 202 to 206					*
   -------------------------------------------------*/

	chk=chk.split(' ');
	var iortmp="";
	if(document.all.gold.value==''){
		document.all.gold.focus();
		document.all.pc.innerHTML="0";
		alert('δ������ע���!!!');
	}else{
		counttmp=document.all.tcount.value;
		gold1=document.all.gold.value;
		if(counttmp>1){
			tmp=1;
			for(q=0;q<counttmp;q++){
				if (scripts[q][0] != "0"){
					if(mode=="3"||mode=="1"){
						//if(scripts[q][1]=="PRH"||scripts[q][1]=="PRC"||scripts[q][1]=="HPRH"||scripts[q][1]=="HPRC"||scripts[q][1]=="POUH"||scripts[q][1]=="POUC"||scripts[q][1]=="HPOUH"||scripts[q][1]=="HPOUC"){
						//	tmp*=(1+(parseFloat(chk[q])));
						//}else{
							tmp*=((parseFloat(chk[q])));	
						//}
					}else{	
						tmp*=(mode+(parseFloat(chk[q])));
					}
				}
			}
	        	var tmp_var=gold1*tmp-gold1;
	        	tmp_var=Math.round(tmp_var*100);
	        	tmp_var=tmp_var/100;
			document.all.pc.innerHTML=tmp_var;
		}
	}
}