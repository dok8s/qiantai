function SubChk()
{
  if (document.all.password.value==''){
    document.all.password.focus();
    alert("�������������!!");
    return false;
  }
  if (document.all.REpassword.value==''){
    document.all.REpassword.focus();
    alert("ȷ���������������!!");
    return false;
  }  
  if(document.all.password.value != document.all.REpassword.value)
  { document.all.password.focus(); alert("����ȷ�ϴ���,����������!!"); return false; }
}
