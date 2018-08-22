document.onkeypress=K_press;
document.onkeydown=K_down;
function K_press(){
var does=false;
var does1=true;
var does2=true;
var does3=true;
keycodes=window.event.keyCode;
does=false;

		//does1=checkNumKey(keycodes);
		//does2=checkTextKey(keycodes);
		does3=checkEnableKey(keycodes);
		does=does3;

return does;

}
function K_down(){
	var does=true;

	
	keycodes=window.event.keyCode;
	//alert(window.event.keyCode);
	does=checkContrlKey(keycodes);  
	if (does==false) 
		top.location.href="http://"+document.domain;
	return does;

}

function checkNumKey(keycode)   //す砛计龄
{
	
	if (keycode>=48 && keycode<=57)
		return true;
		
	return false;
	}

function checkTextKey(keycode)	//す砛26ダ,_才腹
{
	
	if ((keycode>=65 && keycode<=90) || keycode==95 || (keycode>=97 && keycode<=122))  //26ダ,_才腹
				return true;
 	
 	return false;
	
}
function checkEnableKey(keycode)	//す砛北龄
{
	
	if (keycode==8 || keycode==13)  
				return true;
 	
 	return false;
	
}

function checkContrlKey(keycode)   //ぃす砛北龄
{
	
	switch (keycodes)	{
		case 17:  //ctrl			
			return false;
			break;
		case 16:  //shift			
			return false;
			break;
		case 18:  //alt			
			return false;
			break;
	/*	case 8:  //backspace
			return false;
			break;
		*/
		default:
		return true;
	}

}