function SubChk()
{
  if (document.all.password.value==''){
    document.all.password.focus();
    alert("Please key in you password!!");//密碼請務必輸入
    return false;
  }
  if (document.all.REpassword.value==''){
    document.all.REpassword.focus();
    alert("Please key in your confirm password!!");//確認密碼請務必輸入
    return false;
  }  
  if(document.all.password.value != document.all.REpassword.value)
  { document.all.password.focus(); alert("password confirm error!!  please key in again"); return false; }//密碼確認錯誤,請重新輸入
}
