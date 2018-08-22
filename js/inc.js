function inc_js_remoteHTML(url){
	if(url==""||url==null){
		return "";
	};
	var req=false;
	if(window.XMLHttpRequest){
		try{
			req=new XMLHttpRequest();
		}catch(e){
			req=false;
		}
	}else if(window.ActiveXObject){
		try{
			req=new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				req=new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				req=false;
			}
		}
	}
	if(req){
		req.onreadystatechange = function() {
			if (req.readyState == 4 && (req.status == 200 || req.status == 304)) {
				//async=true
			}
		};
		req.open('GET',url,false);
		req.send(null);
		return gb2utf8(req.responseBody);
	}
}
function inc_js_function(file){
	var path="";
	if(file.substr(0,1)!="/"){
		path=location.pathname.match(/(.*)([\/\?\$])/)[0];
	}
	//alert(path.substring(1,path.length)+file);
	var url="?";
	if(file.indexOf("?")>-1){
		url="&inc_js_rand=";
	}
	url=path+file+url+Math.random();
	return {content:inc_js_remoteHTML(url).replace(/\{img\}\/\.\.\/\.\.\//ig,""),file:file}
};
function inc_js_getPara(){
	var scripts=document.getElementsByTagName("script");
	for(var i=0;i<scripts.length;i++){
		var script=scripts[i];
		//alert(script.src+script.src.indexOf("/inc.js"));
		if(script.src.indexOf("/inc.js")>-1&&script.inc.length!=0){
			var inc=script.inc;
			script.src="";
			script.inc="";
			return inc;
		};
	};
	return "";
};


var inc_js_content={content:"",file:""};
inc_js_content=inc_js_function(inc_js_getPara());

//alert(document.body.parentNode.parentNode.firstChild.tagName)//.parentNode.firstChild.nodeValue = 'DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd';
//alert(document.firstChild.tagName);

//var node=document.createElement('!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"');
//document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');

//alert(document.doctype);
//var node=document.createElement("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">");
//document.firstChild.nodeValue=node;
//document.firstChild.appendChild(node);
//alert(document.firstChild.tagName);
//document.firstChild.nodeValue='';
//document.firstChild.nodeValue='DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"';
document.write(inc_js_content.content);//+"<!--"+inc_js_content.file+"-->"
//alert(document.firstChild.nodeValue);
//alert(document.doctype);

function gb2utf8(inp_tmp){
	var glbEncode=[];
	inp_count=inp_tmp;
	execScript("inp_count=LenB(inp_count)", "VBScript");
	inp=inp_tmp;
	if(inp_count%2==0){
		execScript("inp=MidB(inp,1)", "VBScript");
	}else{
		execScript("inp=MidB(inp,1)&Chr(&H20)", "VBScript");//单数length要多加一个空格，否则后面少一字符
	};
	
	var t=escape(inp).replace(/%u/g,"").replace(/(.{2})(.{2})/g,"%$2%$1").replace(/%([A-Z].)%(.{2})/g,"@$1$2");
	t=t.split("@");
	var i=0,j=t.length,k;
	while(++i<j){
		k=t[i].substring(0,4);
		if(!glbEncode[k]){
			inp_chr=eval("0x"+k);
			execScript("inp_chr=Chr(inp_chr)", "VBScript");
			glbEncode[k]=escape(inp_chr).substring(1,6);
		}
		t[i]=glbEncode[k]+t[i].substring(4);
	}
	inp=inp_chr=null;
	return unescape(t.join("%"));
}