function onclickDown(){
	//parent.SI2_func.location.href="./MemGetfile.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
	window.open("./MemGetfile.php?uid="+uid+"&langx="+langx,"ddd");
	window.location.href = "./FT_index.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
	//window.location.href = "./getVworldhome.php?uid="+uid+"&langx="+langx;
	//parent.SI2_func.location.href="./MemGetfile.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
}
function noDown(){
	window.location.href = "./FT_index.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
}

function checkloaded(){
	//document.getElementById("vworld").onload=checkSrc;
	//if ((navigator.appVersion).indexOf("MSIE 6")==-1){
	//	window.location.href = "./FT_index.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
	//	return ;
	//}	
	//alert(document.getElementById("vworld").complete);
	try{
		if (document.getElementById("vworld").complete){
			window.location.href = "./FT_index.php?mtype="+mtype+"&uid="+uid+"&langx="+langx;
		}else{
			document.getElementById("showlayer").visibility="visible";
		}
	}catch(e){}
}
function checkSrc(){
	alert("error");
}
