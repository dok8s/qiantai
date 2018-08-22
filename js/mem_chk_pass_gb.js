function SubChk()
{
  if (document.all.password.value==''){
    document.all.password.focus();
    alert("密码请务必输入!!");
    return false;
  }
  if (document.all.REpassword.value==''){
    document.all.REpassword.focus();
    alert("确认密码请务必输入!!");
    return false;
  }  
  if(document.all.password.value != document.all.REpassword.value)
  { document.all.password.focus(); alert("密码确认错误,请重新输入!!"); return false; }
}
