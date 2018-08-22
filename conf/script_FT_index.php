function HttpRequest(){
		var _self=this;
		var req;
		var eventHandler=new Array();
		var parentClass;
		_self.init=function(){
				_self.addEventListener("LoadComplete",_self.cmd_proc);
				//_self.removeEventListener("LoadComplete");
				//alert("onload");
				}
		_self.help=function(){
				var str="";
				str+="EventName:LoadComplete Method:function(html)\n";
				str+="Method:loadURL(url,post/get,pamam)\n";
				return str;
		}
		
		_self.setParentclass=function(parentclass){
				parentClass=parentclass;
				//util=parentClass.util;
		}
		
		_self.getThis=function(varible){
				return eval(varible);
		}
	
		
		
		_self.loadURL=function(url,method,params) {
				req = false;
		    // branch for native XMLHttpRequest object
		   
		    if(window.XMLHttpRequest && !(window.ActiveXObject)) {
			    	try{
								req = new XMLHttpRequest();
			      }catch(e){
								req = false;
			      }
			    // branch for IE/Windows ActiveX version
		    }else if(window.ActiveXObject){
		       	try{
		        		req = new ActiveXObject("Msxml2.XMLHTTP");
		      	}catch(e){
			        	try{
			          		req = new ActiveXObject("Microsoft.XMLHTTP");
			        	}catch(e){
			          		req = false;
			        	}
						}
		    }
		    
		 
				if(req){
				
						req.onreadystatechange = _self.processReqChange;
						if(method==undefined) method="POST";
						if(method.toUpperCase()=="POST"){
								req.open("POST", url, true);
								  //req.setRequestHeader("Content-Type","text/xml;charset=utf8");
								// xmlHttp.setRequestHeader("Content-Type","text/xml;charset="+charset);
								// params = "lorem=ipsum&name=binny";
					  		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
								//php:·í½s½X¤£¬°utf-8®É­n¥[¦bphp  header('Content-Type:text/html;charset=big5');
								//	req.setRequestHeader("Content-length", params.length);
								//	if (params!="" && params!=undefined)
								req.send(params);
				
						}else{
								req.open("GET", url+"?"+params, true);
								req.send("");
						}
				}
		}
		
		_self.processReqChange=function() {
				// only if req shows "loaded"
		 		//   alert(req.status);
		    if(req.readyState == 4){
		        // only if "OK"
		        //alert("req.status="+req.status);
		        if(req.status == 200){
		            // ...processing statements go here...
		            //_self.cmd_proc(req.responseText);
		          	_self.eventhandler("LoadComplete",req.responseText);
		            //_self.eventhandler("LoadComplete",req.responseXML);
		        }else{
		           //_self.eventhandler("onError",req.statusText);
		           _self.eventhandler("onError",req.responseText);
		        }
		    }
		}
		
		_self.addEventListener=function(eventname,eventFunction){
				eventHandler[eventname]=eventFunction;
		}
		
		_self.removeEventListener=function(eventname){
				EventHandler[eventname]=undefined;
		}
		
		_self.eventhandler=function(eventname,param){
				if(eventHandler[eventname]!=undefined){
						eventHandler[eventname](param);
				}
		}
		
		_self.cmd_proc=function(html){
				alert(html);
				//return html;
		}
		//_self.addEventLisition("LoadComplete",_self.cmd_proc);
		_self.init();
}

//html Class
function ParseHTML(html){
		//alert(html)
		var _self=this;
		
		var divObj=document.createElement("div");
		
		divObj.innerHTML="<body>"+html+"</body>";
		
		_self.getTag=function(tagID,divobj){
			
				if (divobj==undefined) divobj=divObj;
				var retobj=new Array();
				//alert("divObj.innerHTML="+divObj.innerHTML);
				for(var i=0;i<divobj.children.length;i++){
					
						if (divobj.children[i].tagName.toUpperCase()==tagID.toUpperCase()){
								//alert(divobj.children[i].tagName+"==>"+ divobj.children[i].id);
								retobj.push(divobj.children[i]);
								//alert(retobj.length+"==>"+ divobj.children[i].tagName);
						}
				}
				
				return retobj;
		
		}
		_self.getChildren=function(){
				return divObj.children;
		}
		//document.body.appChild(divObj);
	 	_self.getObj=function(tagID,divobj){
	 			if(divobj==undefined) divobj=divObj;
				var obj=null;
				try{
						obj=divobj.children[tagID];
				}catch(e){
						obj=null;
				}
					
				return obj;
		}

     _self.remove=function(){
	   		divObj=null;
	   	
   	}
    _self.removeMC=function(){}
}
top.isTestSite = false;
var gtypeAry = new Array("FT","BK","TN","VB","BS","OP","TT","BM","SK");
var notfind = new Object();
var JQ;
var load_jq_complet = false;
var fade_out_sec = 5000;  //賠率變色畫動秒數
var slide_sec = 100; //slide動畫秒數

try{
		if(console){
				//if(!top.isTestSite) setEmpty(console);
				/*
				console.log = emptyFun;
				console.trace = emptyFun;
				console.error = emptyFun;
				console.info = emptyFun;
				console.warn = emptyFun;
				console.table = emptyFun;*/
				//
		}


}catch(e){
		console = new Object();
		//setEmpty(console);

		console.log = emptyFun;
		console.trace = emptyFun;
		console.error = emptyFun;
		console.info = emptyFun;
		console.warn = emptyFun;
		console.table = emptyFun;
}

function emptyFun(){

}

function setEmpty(console){
		console.log = emptyFun;
		console.trace = emptyFun;
		console.error = emptyFun;
		console.info = emptyFun;
		console.warn = emptyFun;
		console.table = emptyFun;
}



var util = new Object();
util.classname = "[util.js]";
try{ util.HttpRequest = HttpRequest; }catch(e){}
try{ util.ParseHTML = ParseHTML; }catch(e){}
util.fail_count = new Object();
util.fail_limit = 10;
util.timeout_sec = 3000;
util.reload_sw = true;
var load_css = false;
var load_js = false;


//go to page
util.goToPage=function(filename, paramObj){
		util.trace(util.classname+"goToPage: "+filename);
		//if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

		util.fail_count[filename] = 0;

		paramObj.targetWindow = paramObj.targetWindow || document.getElementsByTagName("body")[0];
		paramObj.targetHead = paramObj.targetHead || document.getElementsByTagName("head")[0];
		paramObj.loadComplete = paramObj.loadComplete || function(){};
		paramObj.param = paramObj.param||"";

		if(paramObj.filename.indexOf(".php")!=-1){
				paramObj.filepath = filename;
				paramObj.method = "POST";
		}else if(paramObj.filename.indexOf(".html")!=-1){
				paramObj.filepath = "/tpl/member/"+top.langx+"/"+filename+".html";
				paramObj.method = "GET";
		}else{
					util.systemMsg("[type error] "+filename);
		}

		var getHttp = new util.HttpRequest();
		getHttp.addEventListener("LoadComplete", function(html){
				util.loadHtmlFinish(html, paramObj);
		});

		getHttp.addEventListener("onError", function(html){
				if(util.reload_sw){
						util.fail_count[filename]++;

						if(util.fail_count[filename]<util.fail_limit){
								window.setTimeout(function(){
										getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);
								}, util.timeout_sec);
						}else{
								util.systemMsg("[load html fail] "+filename+".html");
						}
				}
		});

		getHttp.loadURL(paramObj.filepath, paramObj.method, paramObj.param);

}


//load html finish
util.loadHtmlFinish=function(html, paramObj){
		//util.trace(util.classname+"loadHtmlFinish");
		//if(!util.ParseHTML) util.systemMsg("ParseHTML does not load.");

		var tempHtml = new util.ParseHTML(html);

		//HTML
		dbody = tempHtml.getTag("div")[0];
		paramObj.targetWindow.innerHTML = "";
		if(dbody)paramObj.targetWindow.appendChild(dbody);




		//===== load JS =====
		var js_count = 0;
		jsAry = tempHtml.getTag("script");
		if(jsAry==0){
			
				//paramObj.loadComplete();
				
				
				//===== load CSS =====
				var css_count = 0;
				cssAry = tempHtml.getTag("link");
				if(cssAry.length==0){
					
						paramObj.loadComplete();
						
				}else{
						for(i=0;i<cssAry.length;i++) {
								var cssObj = cssAry[i];
								var _src = cssObj.href;
				
								//util.trace(_src);
				
								util.fail_count[_src] = 0;
				
				
								util.loadCSS(_src, paramObj, function(){
										css_count++;
				
										if(css_count>=cssAry.length){
												//util.trace("[load css finish]");
												//console.log("[load css finish]");
												paramObj.loadComplete();
		
										}
				
								});
				
						}
				}
				//===== load CSS =====
										
		}else{
				for(i=0;i<jsAry.length;i++) {
						var jsObj = jsAry[i];
						var _src = jsObj.src;

						util.fail_count[_src] = 0;
						//util.trace(_src);

						util.loadScript(_src, paramObj, function(){


								js_count++;
								//util.trace("load js: "+js_count);

								if(js_count>=jsAry.length){
										//console.log("[load js finish]");
										//paramObj.loadComplete();
										
										
										
										//===== load CSS =====
										var css_count = 0;
										cssAry = tempHtml.getTag("link");
										if(cssAry.length==0){
											
												paramObj.loadComplete();
												
										}else{
												for(i=0;i<cssAry.length;i++) {
														var cssObj = cssAry[i];
														var _src = cssObj.href;
										
														//util.trace(_src);
										
														util.fail_count[_src] = 0;
										
										
														util.loadCSS(_src, paramObj, function(){
																css_count++;
										
																if(css_count>=cssAry.length){
																		//util.trace("[load css finish]");
																		//console.log("[load css finish]");
																		paramObj.loadComplete();
								
																}
										
														});
										
												}
										}
										//===== load CSS =====
										
								}

						});
				}
		}
		//===== load JS =====



		

		
		

}

/*
function load_complete(_type, loadFun){
	
		//load_count++;
		
		switch(_type){
			case "css":
				load_css = true;
				break;
			case "js":
				load_js = true;
				break;
			default:
				break;
		}
		
		console.log("[load_complete]"+_type+",css="+load_css+",js="+load_js);
		
		if(load_css && load_js){
		//if(load_count>=2){
				console.log("[load_complete]");
				loadFun();
				load_css = false;
				load_js = false;
				//load_count = 0;
		}
}
*/

//load css
util.loadCSS=function(_src, paramObj, loadFun){
		//util.trace(util.classname+"loadCSS: "+_src);
		var css = document.createElement("link");
		css.setAttribute("rel", "stylesheet");
		css.setAttribute("type", "text/css");
		css.setAttribute("href", _src);

		css.onload=function(){
				//util.trace("load css finish: "+_src);
				//console.log("load css finish: "+_src);
				if(loadFun) loadFun();
		};

		//IE is not working
		css.onerror=function(){
				//util.trace("load css fail: "+_src);

				if(util.reload_sw){
						util.fail_count[_src]++;

						if(util.fail_count[_src]<util.fail_limit){

							window.setTimeout(function(){
									paramObj.targetHead.removeChild(css);
									util.loadCSS(_src, paramObj, loadFun);
							},util.timeout_sec);

						}else{
								var tmp_src = _src.split("/");
								util.systemMsg("[load css fail] "+tmp_src[tmp_src.length-1]);
						}
				}
		};

		paramObj.targetHead.appendChild(css);


}

//load script
util.loadScript=function(_src, paramObj, loadFun){
		//util.trace(util.classname+"loadScript: "+_src);
		//if(!util.HttpRequest) util.systemMsg("HttpRequest does not load.");

		var getHttp = new util.HttpRequest();
		getHttp.addEventListener("LoadComplete",function(html){

				var script = document.createElement("script");
				script.setAttribute("type","text/javascript");
				script.text = html;
				paramObj.targetHead.appendChild(script);

				if(loadFun) loadFun();

		});

		getHttp.addEventListener("onError", function(html){

				if(util.reload_sw){
						util.fail_count[_src]++;

						if(util.fail_count[_src]<util.fail_limit){
								window.setTimeout(function(){getHttp.loadURL(_src,"GET","");}, util.timeout_sec);
						}else{
								var tmp_src = _src.split("/");
								util.systemMsg("[load script fail] "+tmp_src[tmp_src.length-1]);
						}
				}
		});

		getHttp.loadURL(_src,"GET","");

}


//print stack trace
util.printStackTrace=function(code){
	/*
		var _this = arguments.callee.caller;
		var msg = "Stack trace:";
		var base = "\n";
		if(code) msg=code+base+msg;
		while(_this.caller){
				var param = util.getArguments(_this.caller.arguments);
				msg+=base+"function "+_this.caller.name+"("+param+")";
				//msg+=base+"function "+_this.caller.name;
				//msg+=base+"function "+_this.caller;
				_this = _this.caller;
		}

		console.log(msg);
	*/
	console.trace();
}

//get arguments
util.getArguments=function(obj){
		var ret = new Array();
		for(var _key in obj){
				var content = obj[_key];
				if(content!=null){
						if(content.length > 10) content=content.substr(0,10)+"...";
				}
				ret.push(typeof(obj[_key])+" ["+content+"]");


				//ret.push(typeof(obj[_key]));
		}
		return ret.join(",");
}

//print Hash
util.printHash=function(obj, _title){

		var count = 0;
		var str = "";

		if(_title!=null) str+="["+_title+"]\n";

		for(key in obj){
				str+=key+"======>"+obj[key]+"\n";
				count++;
		}
		str+="length======>"+count+"\n";
		util.trace(util.classname+str);
}


//http or https
util.getProtocal=function(){
		return document.location.protocol;
}


util.getWebDomain=function(){
		return document.domain;
}


util.getNowDomain=function(){
		return util.getProtocal()+"//"+util.getWebDomain();
}


//system msg
util.systemMsg=function(msg, isStack){
		console.warn(msg);
		if(isStack!=false) util.printStackTrace();
}

//trace
util.trace=function(msg, isStack){
		if(top.isTestSite){
				console.log(msg);
				//isStack = true;
				if(isStack) util.printStackTrace();
		}
}

util.showTxt=function(txt){
		if(txt+""=="undefined"||txt+""=="null"||txt+""=="NaN")  return "";
		return txt;
}

util.isIPad=function(){
		var agent = navigator.userAgent;
		if(agent.indexOf("iPad")!=-1){
				return true;
		}		
		return false;		
}

//含IE8以下
util.isIE8=function(){
		var ret = false;
		var agent = navigator.userAgent;
		var ie = "MSIE";
		var pos = agent.indexOf(ie);
		//Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET4.0C)

		if(pos!=-1){
				var tmp_agent = agent.substring(pos+ie.length,agent.length);
				var str = tmp_agent.indexOf(".");
				var version = tmp_agent.substring(0, str);
				if(version*1<=8) ret = true;
		}
		return ret;
}
util.checkBrowser=function (){
	var ret = false;
	var agent = navigator.userAgent;

	if(agent.indexOf("rv:11")!=-1||agent.indexOf("Firefox")!=-1||agent.indexOf("Edge")!=-1){
		//if(agent.indexOf("Firefox")!=-1){
		ret=true;
	}
	return ret;
}
util.isIE11=function(){//ie11 edge
var ret = true;
var agent = navigator.userAgent;
var ie = "MSIE";
var pos = agent.indexOf(ie);
var brows = new Array("Chrome","Safari","Firefox");
	if(agent.indexOf("Edge")== -1){
		for(var i=0;i<brows.length;i++){
				if(agent.indexOf(brows[i]) != -1){
					ret = false;
					break;
				}
		}
	}
	return ret;
}

//set obj class
util.setObjectClass=function(targetObj,classStr){
		if(targetObj.className!=undefined){
				targetObj.className = classStr;
		}else{
			try{
				targetObj.setAttribute("class", classStr);
			}catch(e){}
		}
}


//get obj class
util.getObjectClass=function(targetObj){
		if(targetObj.className!=undefined){
				return targetObj.className;
		}else{
				return targetObj.getAttribute("class");
		}
}

util.reachBottom=function(DOC){
    var scrollTop = 0;
    var clientHeight = 0;
    var scrollHeight = 0;
    if (DOC.documentElement && DOC.documentElement.scrollTop) {
        scrollTop = DOC.documentElement.scrollTop;
    } else if (DOC.body) {
        scrollTop = DOC.body.scrollTop;
    }
    if (DOC.body.clientHeight && DOC.documentElement.clientHeight) {
        clientHeight = (DOC.body.clientHeight < DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    } else {
        clientHeight = (DOC.body.clientHeight > DOC.documentElement.clientHeight) ? DOC.body.clientHeight: DOC.documentElement.clientHeight;
    }
    scrollHeight = Math.max(DOC.body.scrollHeight, DOC.documentElement.scrollHeight);
    if (scrollTop + clientHeight == scrollHeight) {
        return true;
    } else {
        return false;
    }
}

util.getObjAbsolute_new=function(obj,stop_name){
		var abs = new Object();

		abs["left"] = obj.offsetLeft;
		abs["top"] = obj.offsetTop;

		while(obj = obj.offsetParent){
			////console.log(obj);
			////console.log(obj.offsetLeft+" >> "+obj.offsetTop);
				if(util.getStyle(obj,"position") == "relative"){
						////console.log(obj.id+"|"+obj.offsetParent.id+"|"+_self.getStyle(obj,"top")+"|"+_self.getStyle(obj,"margin-top")+"|"+obj.offsetTop);
						if((obj.id!="" && obj.offsetParent.id!="") && util.getStyle(obj,"top")!="auto" && util.getStyle(obj,"margin-top")!="auto" && util.getStyle(obj,"margin-top")!="0px"){
								abs["top"] += -obj.offsetTop;
								continue;
						}
				}

				if(stop_name!=undefined && obj.id==stop_name){
						break;
				}else if(util.getStyle(obj,"position") == "absolute"){
						break;
				}

				abs["left"] += obj.offsetLeft;
				abs["top"] += obj.offsetTop;
		}

	return abs;
}


util.getObjAbsolute=function(obj){
		var _abs = new Object();

		_abs["left"] = obj.offsetLeft;
		_abs["top"] = obj.offsetTop;

		while (obj = obj.offsetParent) {
			_abs["left"] += obj.offsetLeft;
			_abs["top"] += obj.offsetTop;
		}

		return _abs;
}


util.getStyle=function(oElm,strCssRule){
		var strValue = "";
		if(document.defaultView && document.defaultView.getComputedStyle){
				strValue = document.defaultView.getComputedStyle(oElm,"").getPropertyValue(strCssRule);
		}else if(oElm.currentStyle){
				strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
						return p1.toUpperCase();
				});
				strValue = oElm.currentStyle[strCssRule];
		}else{
				return "error";
		}
		return strValue;
}


util.clearObject=function(obj){
		for(var key in obj){
				delete obj[key];
		}
		return obj;
}

util.clearArray=function(ary){
		ary.length = 0;
		return ary;
}


function getChildAry(objAry, _id, newAry){

		for(var i=0; i<objAry.length; i++){
				var obj = objAry[i];

				if(obj.getAttribute("id")==_id){
						newAry.push(obj);
				}

				if(obj.children.length > 0){
						getChildAry(obj.children, _id, newAry);
				}

		}
		return newAry;
}

function iframe_onError(iframe,errorfunc){
	try{
		check = iframe.contentWindow.document.body.onload;
	}catch(e){
		check = null;
	}
	if(check == null && iframe.loadsrc != undefined ){
		iframe.times = iframe.times || 0;
		errorfunc(iframe);
	}else{
		iframe.times = 0;
		try{
			iframe.loadsrc = ""+iframe.contentWindow.location;
		}catch(e){}
	}
}

function showerror(e){
	e.times+=1;
  if(e.times > 10)	return;
	setTimeout(function(){e.contentWindow.location=e.loadsrc;},5000);
}


function iframe_src(obj, url){

		if(obj!=null&&obj.tagName!=null&&url!=null){
     //2017.0112 johnson 斷線時記錄url
        obj.loadsrc = url;
        
				obj.contentWindow.location = url;
		}
}
function divOnBlur(showdiv,selid){
	//console.log("divOnBlur======>"+showdiv.id);
	selid.onclick=null;
	showdiv.style.display='';
	showdiv.focus();

}

function initDivBlur(showdiv,selid){
	showdiv.tabIndex=100;
	showdiv.onblur=function(){
		showdiv.style.display='none';
		setTimeout(function(){
			selid.onclick=function(){
				//alert("onblur");
				divOnBlur(showdiv,selid);
				document.body.scrollTop = "0";
				}
		},300);
	};

}

function iframe_src_new(obj, url){
	//console.log("util iframe_src_new"+obj+","+obj.tagName+","+url);
		if(obj!=null&&obj.tagName!=null&&url!=null){
				
				//console.log("util.checkBrowser()"+util.checkBrowser());
				if(util.checkBrowser()){
					iframe_src(obj, url);
				return;
				}

				var _id = obj.getAttribute("id");
				var bakObj = document.getElementById(_id+"_bak");

				if(bakObj==null||bakObj.tagName==null){
						trace("obj"+obj);
						bakObj = obj.cloneNode(false);
						bakObj.setAttribute("id", _id+"_bak");
						bakObj.style.display = "none";
						obj.parentNode.appendChild(bakObj);

				}
				bakObj.contentWindow.location = url;
				//console.error(bakObj.innerHTML);
		}
}

//when iframe loaded and parse screen finish
function iframe_rename(_id, Parent){
	if(util.checkBrowser()){

		var dom = (Parent)?Parent.document:document;
		var orgObj = dom.getElementById(_id);
		orgObj.style.display = "";
				return;
				}



		var dom = (Parent)?Parent.document:document;
		var orgObj = dom.getElementById(_id);
		var bakObj = dom.getElementById(_id+"_bak");


		if(orgObj==null||orgObj.tagName==null||bakObj==null||bakObj.tagName==null){
				return;
		}


		var orgName = _id;
		var bakName = _id+"_bak";

		orgObj.setAttribute("id", bakName);
		bakObj.setAttribute("id", orgName);


		dom.getElementById(_id).style.display = "";
		dom.getElementById(_id+"_bak").style.display = "none";

		//iframe_src(dom.getElementById(_id+"_bak"), "about:blank");
		dom.getElementById(_id+"_bak").parentNode.removeChild(dom.getElementById(_id+"_bak"));

}
function getKeyCode(e){
		return (window.event)?window.event.keyCode:e.which;
}
function iframe_onload(iframe, fun){
		//if(fun==null) return;

		//IE (before finish init)
		/*
		iframe.onreadystatechange = function(){
        if (iframe.readyState == "complete"){
            alert("Local iframe is now loaded.");
        }
    };
    */

    //IE (after finish init)
		if(iframe.attachEvent){
		    iframe.attachEvent("onload", function(){
		        //trace("attachEvent");
		        if(fun) fun();
		    });

		//other (after finish init)
		}else{
		    iframe.onload=function(){
		        //trace("onload");
		        if(fun) fun();
		    };
		}
}

function echo(msg){
		if(document.all){
				alert(msg);
		}else{
				console.log(msg);
		}
}
var elemtAll=null;
var aa = false;
var bb = this.name;
document.getElementById=function(_id){
	if(bb=="body"){
			if (elemtAll==null) elemtAll=document.getElementsByTagName("*");
			obj=elemtAll[_id];
	}else{
			obj=document.getElementsByTagName("*")[_id];
	}
	if(obj==null){
			if(notfind[_id]==null){
					obj = new Object();
					obj.style = new Object();
					obj.getAttribute = emptyFun;
					obj.setAttribute = emptyFun;
					obj.innerHTML = emptyFun;
					notfind[_id] = obj;
			}else{
				obj = notfind[_id];
			}
	}
	return obj;
}

function clearElementAll(){
		elemtAll=null;
}

/*
document.getElementById=function(_id){
 		var newAry = new Array();
 		var bodyObj = document.getElementsByTagName("body")[0];
 		var objAry = null;
 		var obj = null;

 		if(bodyObj!=null&&_id!=null){
 				objAry = bodyObj.children;
 				if(bodyObj.getAttribute("id")==_id){
 						obj = bodyObj;
 				}else{
 						obj = getChildAry(objAry, _id, newAry)[0];
 				}
		}

		if(obj==null){

				if(notfind[_id]==null){
						obj = new Object();

						obj.style = new Object();
						obj.getAttribute = emptyFun;
						obj.setAttribute = emptyFun;
						obj.innerHTML = emptyFun;
						notfind[_id] = obj;
				}

				obj = notfind[_id];
				//console.warn("Object \""+_id+"\" is not exist.");
				//if(top.isTestSite) console.trace();
				////util.systemMsg("Object \""+_id+"\" is not exist.");

		}

		return obj;
}
*/

function loadComplet(){
		load_jq_complet = true;
}
/*
try{
		var _src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js";
		var paramObj = new Object();
		paramObj["targetHead"] = document.getElementsByTagName("head")[0];
		util.loadScript(_src, paramObj, loadComplet);
}catch(e){
		//console.error(e.toString());
}
*/
JQ = new JQAnimate();

function JQAnimate(){
  var _self = this;
  _self.init=function(){

  }

  //hide
  _self.hide=function(divname, speed, callback){
  		try{
	  			$(divname).hide(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //show
  _self.show=function(divname, speed, callback){
  		try{
	  			$(divname).show(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //hide/show
  _self.toggle=function(divname, speed, callback){
  		try{
	  			$(divname).toggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide up
  _self.slideUp=function(divname, speed, callback){
  		try{
	  			$(divname).slideUp(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide down
  _self.slideDown=function(divname, speed, callback){
  		try{
	  			$(divname).slideDown(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//slide up/down
  _self.slideToggle=function(divname, speed, callback){
  		try{
	  			$(divname).slideToggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade in
  _self.fadeIn=function(divname, speed, callback){
  		try{
	  			$(divname).fadeIn(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade out
  _self.fadeOut=function(divname, speed, callback){
  		try{
	  			$(divname).fadeOut(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade in/out
  _self.fadeToggle=function(divname, speed, callback){
  		try{
	  			$(divname).fadeToggle(speed, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

	//fade to
  _self.fadeTo=function(divname, speed, opacity, callback){
  		try{
	  			$(divname).fadeTo(speed, opacity, callback);
	  	}catch(e){
	  			console.error(e.toString());
	  			throw new Error("error");
	  	}
  }

  //focus out
  _self.focusOut=function(divname, callback){
  		//console.log("set focus out=====>"+divname+","+callback);
  		try{
	  			$(divname).focusout(function(){
	  					return _self.transFun(callback);
	  			});

	  	}catch(e){
	  			console.error(e.toString());
	  			/*
	  			if(!load_jq_complet){
	  					setTimeout(function(){_self.focusOut(divname, callback)}, 1000);
	  			}
	  			*/
	  	}
  }

  _self.transFun=function(callback){

			//if(typeof callback=="function"){
			//		return callback();
			//}
			if(typeof callback=="string"){
					return new Function("return "+callback)();
			}
			return null;
	}

}
function getView(){
	 	var view=new Object();
	 	var viewportwidth;
	 	var viewportheight;
	 
	 	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	 
		if(typeof window.innerWidth != 'undefined'){
			
	  		viewportwidth = window.innerWidth,
	 			viewportheight = window.innerHeight;
	 	
	 	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)		
		}else if(typeof document.documentElement != 'undefined'&& typeof document.documentElement.clientWidth !='undefined' && document.documentElement.clientWidth != 0){

	       viewportwidth = document.documentElement.clientWidth,
	       viewportheight = document.documentElement.clientHeight;
	       
	 	// older versions of IE
	 	}else{
	 		
	       viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
	       viewportheight = document.getElementsByTagName('body')[0].clientHeight;
	       
	 	}
		view.viewportwidth=viewportwidth;
		view.viewportheight=viewportheight;
	 	return view;
}hot_header = this;
var resize = 0;
var display_loadTime="";
top.countLoading = 0;
var chk_Obj = new Object();
chk_Obj["tv"]=0;
chk_Obj["body"]=0;
chk_Obj["head"]=0;
chk_Obj["order"]=0;
var g_count=0;
var last_w = null; //last width of window small than 1359
var head_finish = false;

// 2017-03-02 更正header與body 同時載入 造成 top.ShowLoveIarray --> undefined 的問題
initDate();
initlid_FT();
initlid_BK();
initlid_BS();
initlid_TN();
initlid_VB();
initlid_BM();
initlid_TT();
initlid_OP();
initlid_SK();
showGtype = top.gtypeShowLoveI;

function init(){
		trace("init");
		

		if(!top.showKR) top.showKR="N";
		
		var tmp_url = document.getElementById("header").getAttribute("url").split("?");
		filename = tmp_url[0];
		param = tmp_url[1];
		
		if(top.mem_status=="S"){
				var obj = document.getElementById("status_s_"+top.langx)||document.getElementById("status_s_en-us");
				obj.style.display = "";
				display_loadingMain("tv");
		}
		
		/*
		var orderObj = document.getElementById("mem_order");
		var order_url = (orderObj)?orderObj.getAttribute("url"):null;
		if(order_url!=null) orderObj.src=order_url;
		
		
		
		var tvObj = document.getElementById("show_tv");
		var par = "";
		par+="uid="+top.uid;
		par+="&langx="+top.langx;
		par+="&liveid="+top.liveid;
		par+="&autoOddCheck="+top.autoOddCheck;
		par+="&opentype=self";

		var tv_url = util.getNowDomain()+"/app/member/live/live.php?"+par;
		
		*/
		
		var tvObj = document.getElementById("show_tv");
		
		if(tvObj!=null && top.mem_status !="S") {
			if(top.showKR!="Y"){
				//tvObj.src=tv_url;
			}else{
				chk_Obj["tv"]++;
			}
		}else {
			// 2017-03-03 3039.新會員端-只能看帳-右邊tv有loading畫面，應該秀廣告(BGM-328)(可參考crm-132)
			//document.getElementById("noTV").style.display="";
		}

		loadHead(filename, param, function(){
				
				head_finish = true;
				
				//console.log("loadHead finish");
				try{
					initHeader();
				}catch(e){}
				
		});

		

		display_loadTime = setTimeout("display_loadingMain('over')",1000*8);

		
		
		/*try{	
			FT_lid_ary=top.FT_lid['FT_lid_ary'];
			FT_lid_type=top.FT_lid['FT_lid_type'];
			FT_lname_ary=top.FT_lid['FT_lname_ary'];
			FT_lid_ary_RE=top.FT_lid['FT_lid_ary_RE'];
			FT_lname_ary_RE=top.FT_lid['FT_lname_ary_RE'];
			FU_lid_ary=top.FU_lid['FU_lid_ary'];
			FU_lid_type=top.FU_lid['FU_lid_type'];
			FU_lname_ary=top.FU_lid['FU_lname_ary'];
			FSFT_lid_ary=top.FSFT_lid['FSFT_lid_ary'];
			FSFT_lname_ary=top.FSFT_lid['FSFT_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			FT_HOT_lid_ary=top.FT_lid['FT_HOT_lid_ary'];
			FT_HOT_lid_type=top.FT_lid['FT_HOT_lid_type'];
			FT_HOT_lname_ary=top.FT_lid['FT_HOT_lname_ary'];
			FT_HOT_lid_ary_RE=top.FT_lid['FT_HOT_lid_ary_RE'];
			FT_HOT_lname_ary_RE=top.FT_lid['FT_HOT_lname_ary_RE'];
			FU_HOT_lid_ary=top.FU_lid['FU_HOT_lid_ary'];
			FU_HOT_lid_type=top.FU_lid['FU_HOT_lid_type'];
			FU_HOT_lname_ary=top.FU_lid['FU_HOT_lname_ary'];
			FSFT_HOT_lid_ary=top.FSFT_lid['FSFT_HOT_lid_ary'];
			FSFT_HOT_lname_ary=top.FSFT_lid['FSFT_HOT_lname_ary'];

			// 特別賽事
			FT_SP_lid_ary=top.FT_lid['FT_SP_lid_ary'];
			FT_SP_lid_type=top.FT_lid['FT_SP_lid_type'];
			FT_SP_lname_ary=top.FT_lid['FT_SP_lname_ary'];
			FT_SP_lid_ary_RE=top.FT_lid['FT_SP_lid_ary_RE'];
			FT_SP_lname_ary_RE=top.FT_lid['FT_lsp_name_ary_RE'];
			FU_SP_lid_ary=top.FU_lid['FU_SP_lid_ary'];
			FU_SP_lid_type=top.FU_lid['FU_SP_lid_type'];
			FU_SP_lname_ary=top.FU_lid['FU_SP_lname_ary'];
			FSFT_SP_lid_ary=top.FSFT_lid['FSFT_SP_lid_ary'];
			FSFT_SP_lname_ary=top.FSFT_lid['FSFT_SP_lname_ary'];
		}catch(E){
			initlid_FT();
		}  
		try{	
			BK_lid_ary=top.BK_lid['BK_lid_ary'];
			BK_lid_type=top.BK_lid['BK_lid_type'];
			BK_lname_ary=top.BK_lid['BK_lname_ary'];
			BK_lid_ary_RE=top.BK_lid['BK_lid_ary_RE'];
			BK_lname_ary_RE=top.BK_lid['BK_lname_ary_RE'];
			BU_lid_ary=top.BU_lid['BU_lid_ary'];
			BU_lid_type=top.BU_lid['BU_lid_type'];
			BU_lname_ary=top.BU_lid['BU_lname_ary'];
			FSBK_lid_ary=top.FSBK_lid['FSBK_lid_ary'];
			FSBK_lname_ary=top.FSBK_lid['FSBK_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			BK_HOT_lid_ary=top.BK_lid['BK_HOT_lid_ary'];
			BK_HOT_lid_type=top.BK_lid['BK_HOT_lid_type'];
			BK_HOT_lname_ary=top.BK_lid['BK_HOT_lname_ary'];
			BK_HOT_lid_ary_RE=top.BK_lid['BK_HOT_lid_ary_RE'];
			BK_HOT_lname_ary_RE=top.BK_lid['BK_HOT_lname_ary_RE'];
			BU_HOT_lid_ary=top.BU_lid['BU_HOT_lid_ary'];
			BU_HOT_lid_type=top.BU_lid['BU_HOT_lid_type'];
			BU_HOT_lname_ary=top.BU_lid['BU_HOT_lname_ary'];
			FSBK_HOT_lid_ary=top.FSBK_lid['FSBK_HOT_lid_ary'];
			FSBK_HOT_lname_ary=top.FSBK_lid['FSBK_HOT_lname_ary'];

			// 特別賽事
			BK_SP_lid_ary=top.BK_lid['BK_SP_lid_ary'];
			BK_SP_lid_type=top.BK_lid['BK_SP_lid_type'];
			BK_SP_lname_ary=top.BK_lid['BK_SP_lname_ary'];
			BK_SP_lid_ary_RE=top.BK_lid['BK_SP_lid_ary_RE'];
			BK_SP_lname_ary_RE=top.BK_lid['BK_SP_lname_ary_RE'];
			BU_SP_lid_ary=top.BU_lid['BU_SP_lid_ary'];
			BU_SP_lid_type=top.BU_lid['BU_SP_lid_type'];
			BU_SP_lname_ary=top.BU_lid['BU_SP_lname_ary'];
			FSBK_SP_lid_ary=top.FSBK_lid['FSBK_SP_lid_ary'];
			FSBK_SP_lname_ary=top.FSBK_lid['FSBK_SP_lname_ary'];
		}catch(E){
			initlid_BK();
		}  	
		try{
			BS_lid_ary=top.BS_lid['BS_lid_ary'];
			BS_lid_type=top.BS_lid['BS_lid_type'];
			BS_lname_ary=top.BS_lid['BS_lname_ary'];
			BS_lid_ary_RE=top.BS_lid['BS_lid_ary_RE'];
			BS_lname_ary_RE=top.BS_lid['BS_lname_ary_RE'];
			BSFU_lid_ary=top.BSFU_lid['BSFU_lid_ary'];
			BSFU_lid_type=top.BSFU_lid['BSFU_lid_type'];
			BSFU_lname_ary=top.BSFU_lid['BSFU_lname_ary'];
			FSBS_lid_ary=top.FSBS_lid['FSBS_lid_ary'];	
			FSBS_lname_ary=top.FSBS_lid['FSBS_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			BS_HOT_lid_ary=top.BS_lid['BS_HOT_lid_ary'];
			BS_HOT_lid_type=top.BS_lid['BS_HOT_lid_type'];
			BS_HOT_lname_ary=top.BS_lid['BS_HOT_lname_ary'];
			BS_HOT_lid_ary_RE=top.BS_lid['BS_HOT_lid_ary_RE'];
			BS_HOT_lname_ary_RE=top.BS_lid['BS_HOT_lname_ary_RE'];
			BSFU_HOT_lid_ary=top.BSFU_lid['BSFU_HOT_lid_ary'];
			BSFU_HOT_lid_type=top.BSFU_lid['BSFU_HOT_lid_type'];
			BSFU_HOT_lname_ary=top.BSFU_lid['BSFU_HOT_lname_ary'];
			FSBS_HOT_lid_ary=top.FSBS_lid['FSBS_HOT_lid_ary'];	
			FSBS_HOT_lname_ary=top.FSBS_lid['FSBS_HOT_lname_ary'];

			// 特別賽事
			BS_SP_lid_ary=top.BS_lid['BS_SP_lid_ary'];
			BS_SP_lid_type=top.BS_lid['BS_SP_lid_type'];
			BS_SP_lname_ary=top.BS_lid['BS_SP_lname_ary'];
			BS_SP_lid_ary_RE=top.BS_lid['BS_SP_lid_ary_RE'];
			BS_SP_lname_ary_RE=top.BS_lid['BS_SP_lname_ary_RE'];
			BSFU_SP_lid_ary=top.BSFU_lid['BSFU_SP_lid_ary'];
			BSFU_SP_lid_type=top.BSFU_lid['BSFU_SP_lid_type'];
			BSFU_SP_lname_ary=top.BSFU_lid['BSFU_SP_lname_ary'];
			FSBS_SP_lid_ary=top.FSBS_lid['FSBS_SP_lid_ary'];	
			FSBS_SP_lname_ary=top.FSBS_lid['FSBS_SP_lname_ary'];
		}catch(E){
			initlid_BS();
		}
		try{
			TN_lid_ary=top.TN_lid['TN_lid_ary'];
			TN_lid_type=top.TN_lid['TN_lid_type'];
			TN_lname_ary=top.TN_lid['TN_lname_ary'];
			TN_lid_ary_RE=top.TN_lid['TN_lid_ary_RE'];
			TN_lname_ary_RE=top.TN_lid['TN_lname_ary_RE'];
			TU_lid_ary=top.TU_lid['TU_lid_ary'];
			TU_lid_type=top.TU_lid['TU_lid_type'];
			TU_lname_ary=top.TU_lid['TU_lname_ary'];
			FSTN_lid_ary=top.FSTN_lid['FSTN_lid_ary'];	
			FSTN_lname_ary=top.FSTN_lid['FSTN_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			TN_HOT_lid_ary=top.TN_lid['TN_HOT_lid_ary'];
			TN_HOT_lid_type=top.TN_lid['TN_HOT_lid_type'];
			TN_HOT_lname_ary=top.TN_lid['TN_HOT_lname_ary'];
			TN_HOT_lid_ary_RE=top.TN_lid['TN_HOT_lid_ary_RE'];
			TN_HOT_lname_ary_RE=top.TN_lid['TN_HOT_lname_ary_RE'];
			TU_HOT_lid_ary=top.TU_lid['TU_HOT_lid_ary'];
			TU_HOT_lid_type=top.TU_lid['TU_HOT_lid_type'];
			TU_HOT_lname_ary=top.TU_lid['TU_HOT_lname_ary'];
			FSTN_HOT_lid_ary=top.FSTN_lid['FSTN_HOT_lid_ary'];	
			FSTN_HOT_lname_ary=top.FSTN_lid['FSTN_HOT_lname_ary'];

			// 特別賽事
			TN_SP_lid_ary=top.TN_lid['TN_SP_lid_ary'];
			TN_SP_lid_type=top.TN_lid['TN_SP_lid_type'];
			TN_SP_lname_ary=top.TN_lid['TN_SP_lname_ary'];
			TN_SP_lid_ary_RE=top.TN_lid['TN_SP_lid_ary_RE'];
			TN_SP_lname_ary_RE=top.TN_lid['TN_SP_lname_ary_RE'];
			TU_SP_lid_ary=top.TU_lid['TU_SP_lid_ary'];
			TU_SP_lid_type=top.TU_lid['TU_SP_lid_type'];
			TU_SP_lname_ary=top.TU_lid['TU_SP_lname_ary'];
			FSTN_SP_lid_ary=top.FSTN_lid['FSTN_SP_lid_ary'];	
			FSTN_SP_lname_ary=top.FSTN_lid['FSTN_SP_lname_ary'];
		}catch(E){
			initlid_TN();
		}  
		try{
			VB_lid_ary=top.VB_lid['VB_lid_ary'];
			VB_lid_type=top.VB_lid['VB_lid_type'];
			VB_lname_ary=top.VB_lid['VB_lname_ary'];
			VB_lid_ary_RE=top.VB_lid['VB_lid_ary_RE'];
			VB_lname_ary_RE=top.VB_lid['VB_lname_ary_RE'];
			VU_lid_ary=top.VU_lid['VU_lid_ary'];
			VU_lid_type=top.VU_lid['VU_lid_type'];
			VU_lname_ary=top.VU_lid['VU_lname_ary'];
			FSVB_lid_ary=top.FSVB_lid['FSVB_lid_ary'];
			FSVB_lname_ary=top.FSVB_lid['FSVB_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			VB_HOT_lid_ary=top.VB_lid['VB_HOT_lid_ary'];
			VB_HOT_lid_type=top.VB_lid['VB_HOT_lid_type'];
			VB_HOT_lname_ary=top.VB_lid['VB_HOT_lname_ary'];
			VB_HOT_lid_ary_RE=top.VB_lid['VB_HOT_lid_ary_RE'];
			VB_HOT_lname_ary_RE=top.VB_lid['VB_HOT_lname_ary_RE'];
			VU_HOT_lid_ary=top.VU_lid['VU_HOT_lid_ary'];
			VU_HOT_lid_type=top.VU_lid['VU_HOT_lid_type'];
			VU_HOT_lname_ary=top.VU_lid['VU_HOT_lname_ary'];
			FSVB_HOT_lid_ary=top.FSVB_lid['FSVB_HOT_lid_ary'];
			FSVB_HOT_lname_ary=top.FSVB_lid['FSVB_HOT_lname_ary'];

			// 特別賽事
			VB_SP_lid_ary=top.VB_lid['VB_SP_lid_ary'];
			VB_SP_lid_type=top.VB_lid['VB_SP_lid_type'];
			VB_SP_lname_ary=top.VB_lid['VB_SP_lname_ary'];
			VB_SP_lid_ary_RE=top.VB_lid['VB_SP_lid_ary_RE'];
			VB_SP_lname_ary_RE=top.VB_lid['VB_SP_lname_ary_RE'];
			VU_SP_lid_ary=top.VU_lid['VU_SP_lid_ary'];
			VU_SP_lid_type=top.VU_lid['VU_SP_lid_type'];
			VU_SP_lname_ary=top.VU_lid['VU_SP_lname_ary'];
			FSVB_SP_lid_ary=top.FSVB_lid['FSVB_SP_lid_ary'];
			FSVB_SP_lname_ary=top.FSVB_lid['FSVB_SP_lname_ary'];
		}catch(E){
			initlid_VB();
		}  
		try{
			BM_lid_ary=top.BM_lid['BM_lid_ary'];
			BM_lid_type=top.BM_lid['BM_lid_type'];
			BM_lname_ary=top.BM_lid['BM_lname_ary'];
			BM_lid_ary_RE=top.BM_lid['BM_lid_ary_RE'];
			BM_lname_ary_RE=top.BM_lid['BM_lname_ary_RE'];
			BMFU_lid_ary=top.BMFU_lid['BMFU_lid_ary'];
			BMFU_lid_type=top.BMFU_lid['BMFU_lid_type'];
			BMFU_lname_ary=top.BMFU_lid['BMFU_lname_ary'];
			FSBM_lid_ary=top.FSBM_lid['FSBM_lid_ary'];
			FSBM_lname_ary=top.FSBM_lid['FSBM_lname_ary'];	

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			BM_HOT_lid_ary=top.BM_lid['BM_HOT_lid_ary'];
			BM_HOT_lid_type=top.BM_lid['BM_HOT_lid_type'];
			BM_HOT_lname_ary=top.BM_lid['BM_HOT_lname_ary'];
			BM_HOT_lid_ary_RE=top.BM_lid['BM_HOT_lid_ary_RE'];
			BM_HOT_lname_ary_RE=top.BM_lid['BM_HOT_lname_ary_RE'];
			BMFU_HOT_lid_ary=top.BMFU_lid['BMFU_HOT_lid_ary'];
			BMFU_HOT_lid_type=top.BMFU_lid['BMFU_HOT_lid_type'];
			BMFU_HOT_lname_ary=top.BMFU_lid['BMFU_HOT_lname_ary'];
			FSBM_HOT_lid_ary=top.FSBM_lid['FSBM_HOT_lid_ary'];
			FSBM_HOT_lname_ary=top.FSBM_lid['FSBM_HOT_lname_ary'];	

			// 特別賽事
			BM_SP_lid_ary=top.BM_lid['BM_SP_lid_ary'];
			BM_SP_lid_type=top.BM_lid['BM_SP_lid_type'];
			BM_SP_lname_ary=top.BM_lid['BM_SP_lname_ary'];
			BM_SP_lid_ary_RE=top.BM_lid['BM_SP_lid_ary_RE'];
			BM_SP_lname_ary_RE=top.BM_lid['BM_SP_lname_ary_RE'];
			BMFU_SP_lid_ary=top.BMFU_lid['BMFU_SP_lid_ary'];
			BMFU_SP_lid_type=top.BMFU_lid['BMFU_SP_lid_type'];
			BMFU_SP_lname_ary=top.BMFU_lid['BMFU_SP_lname_ary'];
			FSBM_SP_lid_ary=top.FSBM_lid['FSBM_SP_lid_ary'];
			FSBM_SP_lname_ary=top.FSBM_lid['FSBM_SP_lname_ary'];	
		}catch(E){
			initlid_BM();
		}  
		
		try{
			TT_lid_ary=top.TT_lid['TT_lid_ary'];
			TT_lid_type=top.TT_lid['TT_lid_type'];
			TT_lname_ary=top.TT_lid['TT_lname_ary'];
			TT_lid_ary_RE=top.TT_lid['TT_lid_ary_RE'];
			TT_lname_ary_RE=top.TT_lid['TT_lname_ary_RE'];
			TTFU_lid_ary=top.TTFU_lid['TTFU_lid_ary'];
			TTFU_lid_type=top.TTFU_lid['TTFU_lid_type'];
			TTFU_lname_ary=top.TTFU_lid['TTFU_lname_ary'];
			FSTT_lid_ary=top.FSTT_lid['FSTT_lid_ary'];
			FSTT_lname_ary=top.FSTT_lid['FSTT_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			TT_HOT_lid_ary=top.TT_lid['TT_HOT_lid_ary'];
			TT_HOT_lid_type=top.TT_lid['TT_HOT_lid_type'];
			TT_HOT_lname_ary=top.TT_lid['TT_HOT_lname_ary'];
			TT_HOT_lid_ary_RE=top.TT_lid['TT_HOT_lid_ary_RE'];
			TT_HOT_lname_ary_RE=top.TT_lid['TT_HOT_lname_ary_RE'];
			TTFU_HOT_lid_ary=top.TTFU_lid['TTFU_HOT_lid_ary'];
			TTFU_HOT_lid_type=top.TTFU_lid['TTFU_HOT_lid_type'];
			TTFU_HOT_lname_ary=top.TTFU_lid['TTFU_HOT_lname_ary'];
			FSTT_HOT_lid_ary=top.FSTT_lid['FSTT_HOT_lid_ary'];
			FSTT_HOT_lname_ary=top.FSTT_lid['FSTT_HOT_lname_ary'];

			// 特別賽事
			TT_SP_lid_ary=top.TT_lid['TT_SP_lid_ary'];
			TT_SP_lid_type=top.TT_lid['TT_SP_lid_type'];
			TT_SP_lname_ary=top.TT_lid['TT_SP_lname_ary'];
			TT_SP_lid_ary_RE=top.TT_lid['TT_SP_lid_ary_RE'];
			TT_SP_lname_ary_RE=top.TT_lid['TT_SP_lname_ary_RE'];
			TTFU_SP_lid_ary=top.TTFU_lid['TTFU_SP_lid_ary'];
			TTFU_SP_lid_type=top.TTFU_lid['TTFU_SP_lid_type'];
			TTFU_SP_lname_ary=top.TTFU_lid['TTFU_SP_lname_ary'];
			FSTT_SP_lid_ary=top.FSTT_lid['FSTT_SP_lid_ary'];
			FSTT_SP_lname_ary=top.FSTT_lid['FSTT_SP_lname_ary'];
		}catch(E){
			initlid_TT();
		}  
		
		try{
			OP_lid_ary=top.OP_lid['OP_lid_ary'];
			OP_lid_type=top.OP_lid['OP_lid_type'];
			OP_lname_ary=top.OP_lid['OP_lname_ary'];
			OP_lid_ary_RE=top.OP_lid['OP_lid_ary_RE'];
			OP_lname_ary_RE=top.OP_lid['OP_lname_ary_RE'];
			OM_lid_ary=top.OM_lid['OM_lid_ary'];
			OM_lid_type=top.OM_lid['OM_lid_type'];
			OM_lname_ary=top.OM_lid['OM_lname_ary'];
			FSOP_lid_ary=top.FSOP_lid['FSOP_lid_ary'];
			FSOP_lname_ary=top.FSOP_lid['FSOP_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			OP_HOT_lid_ary=top.OP_lid['OP_HOT_lid_ary'];
			OP_HOT_lid_type=top.OP_lid['OP_HOT_lid_type'];
			OP_HOT_lname_ary=top.OP_lid['OP_HOT_lname_ary'];
			OP_HOT_lid_ary_RE=top.OP_lid['OP_HOT_lid_ary_RE'];
			OP_HOT_lname_ary_RE=top.OP_lid['OP_HOT_lname_ary_RE'];
			OM_HOT_lid_ary=top.OM_lid['OM_HOT_lid_ary'];
			OM_HOT_lid_type=top.OM_lid['OM_HOT_lid_type'];
			OM_HOT_lname_ary=top.OM_lid['OM_HOT_lname_ary'];
			FSOP_HOT_lid_ary=top.FSOP_lid['FSOP_HOT_lid_ary'];
			FSOP_HOT_lname_ary=top.FSOP_lid['FSOP_HOT_lname_ary'];

			// 特別賽事
			OP_SP_lid_ary=top.OP_lid['OP_SP_lid_ary'];
			OP_SP_lid_type=top.OP_lid['OP_SP_lid_type'];
			OP_SP_lname_ary=top.OP_lid['OP_SP_lname_ary'];
			OP_SP_lid_ary_RE=top.OP_lid['OP_SP_lid_ary_RE'];
			OP_SP_lname_ary_RE=top.OP_lid['OP_SP_lname_ary_RE'];
			OM_SP_lid_ary=top.OM_lid['OM_SP_lid_ary'];
			OM_SP_lid_type=top.OM_lid['OM_SP_lid_type'];
			OM_SP_lname_ary=top.OM_lid['OM_SP_lname_ary'];
			FSOP_SP_lid_ary=top.FSOP_lid['FSOP_SP_lid_ary'];
			FSOP_SP_lname_ary=top.FSOP_lid['FSOP_SP_lname_ary'];
		}catch(E){
			initlid_OP();
		}
		try{
			SK_lid_ary=top.SK_lid['SK_lid_ary'];
			SK_lid_type=top.SK_lid['SK_lid_type'];
			SK_lname_ary=top.SK_lid['SK_lname_ary'];
			SK_lid_ary_RE=top.SK_lid['SK_lid_ary_RE'];
			SK_lname_ary_RE=top.SK_lid['SK_lname_ary_RE'];
			SKFU_lid_ary=top.SKFU_lid['SKFU_lid_ary'];
			SKFU_lid_type=top.SKFU_lid['SKFU_lid_type'];
			SKFU_lname_ary=top.SKFU_lid['SKFU_lname_ary'];
			FSSK_lid_ary=top.FSSK_lid['FSSK_lid_ary'];
			FSSK_lname_ary=top.FSSK_lid['FSSK_lname_ary'];

			// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
			// 精選賽事
			SK_HOT_lid_ary=top.SK_lid['SK_HOT_lid_ary'];
			SK_HOT_lid_type=top.SK_lid['SK_HOT_lid_type'];
			SK_HOT_lname_ary=top.SK_lid['SK_HOT_lname_ary'];
			SK_HOT_lid_ary_RE=top.SK_lid['SK_HOT_lid_ary_RE'];
			SK_HOT_lname_ary_RE=top.SK_lid['SK_HOT_lname_ary_RE'];
			SKFU_HOT_lid_ary=top.SKFU_lid['SKFU_HOT_lid_ary'];
			SKFU_HOT_lid_type=top.SKFU_lid['SKFU_HOT_lid_type'];
			SKFU_HOT_lname_ary=top.SKFU_lid['SKFU_HOT_lname_ary'];
			FSSK_HOT_lid_ary=top.FSSK_lid['FSSK_HOT_lid_ary'];
			FSSK_HOT_lname_ary=top.FSSK_lid['FSSK_HOT_lname_ary'];

			// 特別賽事
			SK_SP_lid_ary=top.SK_lid['SK_SP_lid_ary'];
			SK_SP_lid_type=top.SK_lid['SK_SP_lid_type'];
			SK_SP_lname_ary=top.SK_lid['SK_SP_lname_ary'];
			SK_SP_lid_ary_RE=top.SK_lid['SK_SP_lid_ary_RE'];
			SK_SP_lname_ary_RE=top.SK_lid['SK_SP_lname_ary_RE'];
			SKFU_SP_lid_ary=top.SKFU_lid['SKFU_SP_lid_ary'];
			SKFU_SP_lid_type=top.SKFU_lid['SKFU_SP_lid_type'];
			SKFU_SP_lname_ary=top.SKFU_lid['SKFU_SP_lname_ary'];
			FSSK_SP_lid_ary=top.FSSK_lid['FSSK_SP_lid_ary'];
			FSSK_SP_lname_ary=top.FSSK_lid['FSSK_SP_lname_ary'];
		}catch(E){
			initlid_SK();
		}    */	
}



function loadHead(filename, param, loadFun){
	
		var paramObj = new Object();
		paramObj.targetWindow = document.getElementById("header");
		paramObj.targetHead = document.getElementsByTagName("head")[0];
		paramObj.filename = filename;
		paramObj.param = param;
		paramObj.loadComplete = loadFun;
		
		util.goToPage(paramObj.filename, paramObj);
}

function initlid_FT(){
	top.FT_lid = new Array();
	top.FU_lid = new Array();
	top.FSFT_lid = new Array();
	top.FT_lid['FT_lid_ary']= FT_lid_ary='ALL';
	top.FT_lid['FT_lid_type']= FT_lid_type='';
	top.FT_lid['FT_lname_ary']= FT_lname_ary='ALL';
	top.FT_lid['FT_lid_ary_RE']= FT_lid_ary_RE='ALL';
	top.FT_lid['FT_lname_ary_RE']= FT_lname_ary_RE='ALL';
	top.FU_lid['FU_lid_ary']= FU_lid_ary='ALL';
	top.FU_lid['FU_lid_type']= FU_lid_type='';
	top.FU_lid['FU_lname_ary']= FU_lname_ary='ALL';
	top.FSFT_lid['FSFT_lid_ary']= FSFT_lid_ary='ALL';
	top.FSFT_lid['FSFT_lname_ary']= FSFT_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.FT_lid['FT_HOT_lid_ary']= FT_HOT_lid_ary='ALL';
	top.FT_lid['FT_HOT_lid_type']= FT_HOT_lid_type='';
	top.FT_lid['FT_HOT_lname_ary']= FT_HOT_lname_ary='ALL';
	top.FT_lid['FT_HOT_lid_ary_RE']= FT_HOT_lid_ary_RE='ALL';
	top.FT_lid['FT_HOT_lname_ary_RE']= FT_HOT_lname_ary_RE='ALL';
	top.FU_lid['FU_HOT_lid_ary']= FU_HOT_lid_ary='ALL';
	top.FU_lid['FU_HOT_lid_type']= FU_HOT_lid_type='';
	top.FU_lid['FU_HOT_lname_ary']= FU_HOT_lname_ary='ALL';
	top.FSFT_lid['FSFT_HOT_lid_ary']= FSFT_HOT_lid_ary='ALL';
	top.FSFT_lid['FSFT_HOT_lname_ary']= FSFT_HOT_lname_ary='ALL';

	// 特別賽事
	top.FT_lid['FT_SP_lid_ary']= FT_SP_lid_ary='ALL';
	top.FT_lid['FT_SP_lid_type']= FT_SP_lid_type='';
	top.FT_lid['FT_SP_lname_ary']= FT_SP_lname_ary='ALL';
	top.FT_lid['FT_SP_lid_ary_RE']= FT_SP_lid_ary_RE='ALL';
	top.FT_lid['FT_SP_lname_ary_RE']= FT_SP_lname_ary_RE='ALL';
	top.FU_lid['FU_SP_lid_ary']= FU_SP_lid_ary='ALL';
	top.FU_lid['FU_SP_lid_type']= FU_SP_lid_type='';
	top.FU_lid['FU_SP_lname_ary']= FU_SP_lname_ary='ALL';
	top.FSFT_lid['FSFT_SP_lid_ary']= FSFT_SP_lid_ary='ALL';
	top.FSFT_lid['FSFT_SP_lname_ary']= FSFT_SP_lname_ary='ALL';
}
function initlid_BK(){
	top.BK_lid = new Array();
	top.BU_lid = new Array();
	top.FSBK_lid = new Array();
	top.BK_lid['BK_lid_ary']= BK_lid_ary='ALL';
	top.BK_lid['BK_lid_type']= BK_lid_type='';
	top.BK_lid['BK_lname_ary']= BK_lname_ary='ALL';
	top.BK_lid['BK_lid_ary_RE']= BK_lid_ary_RE='ALL';
	top.BK_lid['BK_lname_ary_RE']= BK_lname_ary_RE='ALL';
	top.BU_lid['BU_lid_ary']= BU_lid_ary='ALL';
	top.BU_lid['BU_lid_type']= BU_lid_type='';
	top.BU_lid['BU_lname_ary']= BU_lname_ary='ALL';
	top.FSBK_lid['FSBK_lid_ary']= FSBK_lid_ary='ALL';
	top.FSBK_lid['FSBK_lname_ary']= FSBK_lname_ary='ALL';	

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.BK_lid['BK_HOT_lid_ary']= BK_HOT_lid_ary='ALL';
	top.BK_lid['BK_HOT_lid_type']= BK_HOT_lid_type='';
	top.BK_lid['BK_HOT_lname_ary']= BK_HOT_lname_ary='ALL';
	top.BK_lid['BK_HOT_lid_ary_RE']= BK_HOT_lid_ary_RE='ALL';
	top.BK_lid['BK_HOT_lname_ary_RE']= BK_HOT_lname_ary_RE='ALL';
	top.BU_lid['BU_HOT_lid_ary']= BU_HOT_lid_ary='ALL';
	top.BU_lid['BU_HOT_lid_type']= BU_HOT_lid_type='';
	top.BU_lid['BU_HOT_lname_ary']= BU_HOT_lname_ary='ALL';
	top.FSBK_lid['FSBK_HOT_lid_ary']= FSBK_HOT_lid_ary='ALL';
	top.FSBK_lid['FSBK_HOT_lname_ary']= FSBK_HOT_lname_ary='ALL';

	// 特別賽事
	top.BK_lid['BK_SP_lid_ary']= BK_SP_lid_ary='ALL';
	top.BK_lid['BK_SP_lid_type']= BK_SP_lid_type='';
	top.BK_lid['BK_SP_lname_ary']= BK_SP_lname_ary='ALL';
	top.BK_lid['BK_SP_lid_ary_RE']= BK_SP_lid_ary_RE='ALL';
	top.BK_lid['BK_SP_lname_ary_RE']= BK_SP_lname_ary_RE='ALL';
	top.BU_lid['BU_SP_lid_ary']= BU_SP_lid_ary='ALL';
	top.BU_lid['BU_SP_lid_type']= BU_SP_lid_type='';
	top.BU_lid['BU_SP_lname_ary']= BU_SP_lname_ary='ALL';
	top.FSBK_lid['FSBK_SP_lid_ary']= FSBK_SP_lid_ary='ALL';
	top.FSBK_lid['FSBK_SP_lname_ary']= FSBK_SP_lname_ary='ALL';	
}
function initlid_BS(){
	top.BS_lid = new Array();
	top.BSFU_lid = new Array();
	top.FSBS_lid = new Array();	
	top.BS_lid['BS_lid_ary']= BS_lid_ary='ALL';
	top.BS_lid['BS_lid_type']= BS_lid_type='';
	top.BS_lid['BS_lname_ary']= BS_lname_ary='ALL';
	top.BS_lid['BS_lid_ary_RE']= BS_lid_ary_RE='ALL';
	top.BS_lid['BS_lname_ary_RE']= BS_lname_ary_RE='ALL';
	top.BSFU_lid['BSFU_lid_ary']= BSFU_lid_ary='ALL';
	top.BSFU_lid['BSFU_lid_type']= BSFU_lid_type='';
	top.BSFU_lid['BSFU_lname_ary']= BSFU_lname_ary='ALL';
	top.FSBS_lid['FSBS_lid_ary']= FSBS_lid_ary='ALL';
	top.FSBS_lid['FSBS_lname_ary']= FSBS_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.BS_lid['BS_HOT_lid_ary']= BS_HOT_lid_ary='ALL';
	top.BS_lid['BS_HOT_lid_type']= BS_HOT_lid_type='';
	top.BS_lid['BS_HOT_lname_ary']= BS_HOT_lname_ary='ALL';
	top.BS_lid['BS_HOT_lid_ary_RE']= BS_HOT_lid_ary_RE='ALL';
	top.BS_lid['BS_HOT_lname_ary_RE']= BS_HOT_lname_ary_RE='ALL';
	top.BSFU_lid['BSFU_HOT_lid_ary']= BSFU_HOT_lid_ary='ALL';
	top.BSFU_lid['BSFU_HOT_lid_type']= BSFU_HOT_lid_type='';
	top.BSFU_lid['BSFU_HOT_lname_ary']= BSFU_HOT_lname_ary='ALL';
	top.FSBS_lid['FSBS_HOT_lid_ary']= FSBS_HOT_lid_ary='ALL';
	top.FSBS_lid['FSBS_HOT_lname_ary']= FSBS_HOT_lname_ary='ALL';

	// 特別賽事
	top.BS_lid['BS_SP_lid_ary']= BS_SP_lid_ary='ALL';
	top.BS_lid['BS_SP_lid_type']= BS_SP_lid_type='';
	top.BS_lid['BS_SP_lname_ary']= BS_SP_lname_ary='ALL';
	top.BS_lid['BS_SP_lid_ary_RE']= BS_SP_lid_ary_RE='ALL';
	top.BS_lid['BS_SP_lname_ary_RE']= BS_SP_lname_ary_RE='ALL';
	top.BSFU_lid['BSFU_SP_lid_ary']= BSFU_SP_lid_ary='ALL';
	top.BSFU_lid['BSFU_SP_lid_type']= BSFU_SP_lid_type='';
	top.BSFU_lid['BSFU_SP_lname_ary']= BSFU_SP_lname_ary='ALL';
	top.FSBS_lid['FSBS_SP_lid_ary']= FSBS_SP_lid_ary='ALL';
	top.FSBS_lid['FSBS_SP_lname_ary']= FSBS_SP_lname_ary='ALL';	
}
function initlid_TN(){
	top.TN_lid = new Array();
	top.TU_lid = new Array();
	top.FSTN_lid = new Array();	
	top.TN_lid['TN_lid_ary']= TN_lid_ary='ALL';
	top.TN_lid['TN_lid_type']= TN_lid_type='';
	top.TN_lid['TN_lname_ary']= TN_lname_ary='ALL';
	top.TN_lid['TN_lid_ary_RE']= TN_lid_ary_RE='ALL';
	top.TN_lid['TN_lname_ary_RE']= TN_lname_ary_RE='ALL';
	top.TU_lid['TU_lid_ary']= TU_lid_ary='ALL';
	top.TU_lid['TU_lid_type']= TU_lid_type='';
	top.TU_lid['TU_lname_ary']= TU_lname_ary='ALL';
	top.FSTN_lid['FSTN_lid_ary']= FSTN_lid_ary='ALL';	
	top.FSTN_lid['FSTN_lname_ary']= FSTN_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.TN_lid['TN_HOT_lid_ary']= TN_HOT_lid_ary='ALL';
	top.TN_lid['TN_HOT_lid_type']= TN_HOT_lid_type='';
	top.TN_lid['TN_HOT_lname_ary']= TN_HOT_lname_ary='ALL';
	top.TN_lid['TN_HOT_lid_ary_RE']= TN_HOT_lid_ary_RE='ALL';
	top.TN_lid['TN_HOT_lname_ary_RE']= TN_HOT_lname_ary_RE='ALL';
	top.TU_lid['TU_HOT_lid_ary']= TU_HOT_lid_ary='ALL';
	top.TU_lid['TU_HOT_lid_type']= TU_HOT_lid_type='';
	top.TU_lid['TU_HOT_lname_ary']= TU_HOT_lname_ary='ALL';
	top.FSTN_lid['FSTN_HOT_lid_ary']= FSTN_HOT_lid_ary='ALL';
	top.FSTN_lid['FSTN_HOT_lname_ary']= FSTN_HOT_lname_ary='ALL';

	// 特別賽事
	top.TN_lid['TN_SP_lid_ary']= TN_SP_lid_ary='ALL';
	top.TN_lid['TN_SP_lid_type']= TN_SP_lid_type='';
	top.TN_lid['TN_SP_lname_ary']= TN_SP_lname_ary='ALL';
	top.TN_lid['TN_SP_lid_ary_RE']= TN_SP_lid_ary_RE='ALL';
	top.TN_lid['TN_SP_lname_ary_RE']= TN_SP_lname_ary_RE='ALL';
	top.TU_lid['TU_SP_lid_ary']= TU_SP_lid_ary='ALL';
	top.TU_lid['TU_SP_lid_type']= TU_SP_lid_type='';
	top.TU_lid['TU_SP_lname_ary']= TU_SP_lname_ary='ALL';
	top.FSTN_lid['FSTN_SP_lid_ary']= FSTN_SP_lid_ary='ALL';
	top.FSTN_lid['FSTN_SP_lname_ary']= FSTN_SP_lname_ary='ALL';	
}
function initlid_VB(){
	top.VB_lid = new Array();
	top.VU_lid = new Array();
	top.FSVB_lid = new Array();	
	top.VB_lid['VB_lid_ary']= VB_lid_ary='ALL';
	top.VB_lid['VB_lid_type']= VB_lid_type='';
	top.VB_lid['VB_lname_ary']= VB_lname_ary='ALL';
	top.VB_lid['VB_lid_ary_RE']= VB_lid_ary_RE='ALL';
	top.VB_lid['VB_lname_ary_RE']= VB_lname_ary_RE='ALL';
	top.VU_lid['VU_lid_ary']= VU_lid_ary='ALL';
	top.VU_lid['VU_lid_type']= VU_lid_type='';
	top.VU_lid['VU_lname_ary']= VU_lname_ary='ALL';
	top.FSVB_lid['FSVB_lid_ary']= FSVB_lid_ary='ALL';
	top.FSVB_lid['FSVB_lname_ary']= FSVB_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.VB_lid['VB_HOT_lid_ary']= VB_HOT_lid_ary='ALL';
	top.VB_lid['VB_HOT_lid_type']= VB_HOT_lid_type='';
	top.VB_lid['VB_HOT_lname_ary']= VB_HOT_lname_ary='ALL';
	top.VB_lid['VB_HOT_lid_ary_RE']= VB_HOT_lid_ary_RE='ALL';
	top.VB_lid['VB_HOT_lname_ary_RE']= VB_HOT_lname_ary_RE='ALL';
	top.VU_lid['VU_HOT_lid_ary']= VU_HOT_lid_ary='ALL';
	top.VU_lid['VU_HOT_lid_type']= VU_HOT_lid_type='';
	top.VU_lid['VU_HOT_lname_ary']= VU_HOT_lname_ary='ALL';
	top.FSVB_lid['FSVB_HOT_lid_ary']= FSVB_HOT_lid_ary='ALL';
	top.FSVB_lid['FSVB_HOT_lname_ary']= FSVB_HOT_lname_ary='ALL';

	// 特別賽事
	top.VB_lid['VB_SP_lid_ary']= VB_SP_lid_ary='ALL';
	top.VB_lid['VB_SP_lid_type']= VB_SP_lid_type='';
	top.VB_lid['VB_SP_lname_ary']= VB_SP_lname_ary='ALL';
	top.VB_lid['VB_SP_lid_ary_RE']= VB_SP_lid_ary_RE='ALL';
	top.VB_lid['VB_SP_lname_ary_RE']= VB_SP_lname_ary_RE='ALL';
	top.VU_lid['VU_SP_lid_ary']= VU_SP_lid_ary='ALL';
	top.VU_lid['VU_SP_lid_type']= VU_SP_lid_type='';
	top.VU_lid['VU_SP_lname_ary']= VU_SP_lname_ary='ALL';
	top.FSVB_lid['FSVB_SP_lid_ary']= FSVB_SP_lid_ary='ALL';
	top.FSVB_lid['FSVB_SP_lname_ary']= FSVB_SP_lname_ary='ALL';	
}
function initlid_BM(){
	top.BM_lid = new Array();
	top.BMFU_lid = new Array();
	top.FSBM_lid = new Array();	
	top.BM_lid['BM_lid_ary']= BM_lid_ary='ALL';
	top.BM_lid['BM_lid_type']= BM_lid_type='';
	top.BM_lid['BM_lname_ary']= BM_lname_ary='ALL';
	top.BM_lid['BM_lid_ary_RE']= BM_lid_ary_RE='ALL';
	top.BM_lid['BM_lname_ary_RE']= BM_lname_ary_RE='ALL';
	top.BMFU_lid['BMFU_lid_ary']= BMFU_lid_ary='ALL';
	top.BMFU_lid['BMFU_lid_type']= BMFU_lid_type='';
	top.BMFU_lid['BMFU_lname_ary']= BMFU_lname_ary='ALL';
	top.FSBM_lid['FSBM_lid_ary']= FSBM_lid_ary='ALL';
	top.FSBM_lid['FSBM_lname_ary']= FSBM_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.BM_lid['BM_HOT_lid_ary']= BM_HOT_lid_ary='ALL';
	top.BM_lid['BM_HOT_lid_type']= BM_HOT_lid_type='';
	top.BM_lid['BM_HOT_lname_ary']= BM_HOT_lname_ary='ALL';
	top.BM_lid['BM_HOT_lid_ary_RE']= BM_HOT_lid_ary_RE='ALL';
	top.BM_lid['BM_HOT_lname_ary_RE']= BM_HOT_lname_ary_RE='ALL';
	top.BMFU_lid['BMFU_HOT_lid_ary']= BMFU_HOT_lid_ary='ALL';
	top.BMFU_lid['BMFU_HOT_lid_type']= BMFU_HOT_lid_type='';
	top.BMFU_lid['BMFU_HOT_lname_ary']= BMFU_HOT_lname_ary='ALL';
	top.FSBM_lid['FSBM_HOT_lid_ary']= FSBM_HOT_lid_ary='ALL';
	top.FSBM_lid['FSBM_HOT_lname_ary']= FSBM_HOT_lname_ary='ALL';

	// 特別賽事
	top.BM_lid['BM_SP_lid_ary']= BM_SP_lid_ary='ALL';
	top.BM_lid['BM_SP_lid_type']= BM_SP_lid_type='';
	top.BM_lid['BM_SP_lname_ary']= BM_SP_lname_ary='ALL';
	top.BM_lid['BM_SP_lid_ary_RE']= BM_SP_lid_ary_RE='ALL';
	top.BM_lid['BM_SP_lname_ary_RE']= BM_SP_lname_ary_RE='ALL';
	top.BMFU_lid['BMFU_SP_lid_ary']= BMFU_SP_lid_ary='ALL';
	top.BMFU_lid['BMFU_SP_lid_type']= BMFU_SP_lid_type='';
	top.BMFU_lid['BMFU_SP_lname_ary']= BMFU_SP_lname_ary='ALL';
	top.FSBM_lid['FSBM_SP_lid_ary']= FSBM_SP_lid_ary='ALL';
	top.FSBM_lid['FSBM_SP_lname_ary']= FSBM_SP_lname_ary='ALL';	
}

function initlid_TT(){
	top.TT_lid = new Array();
	top.TTFU_lid = new Array();
	top.FSTT_lid = new Array();	
	top.TT_lid['TT_lid_ary']= TT_lid_ary='ALL';
	top.TT_lid['TT_lid_type']= TT_lid_type='';
	top.TT_lid['TT_lname_ary']= TT_lname_ary='ALL';
	top.TT_lid['TT_lid_ary_RE']= TT_lid_ary_RE='ALL';
	top.TT_lid['TT_lname_ary_RE']= TT_lname_ary_RE='ALL';
	top.TTFU_lid['TTFU_lid_ary']= TTFU_lid_ary='ALL';
	top.TTFU_lid['TTFU_lid_type']= TTFU_lid_type='';
	top.TTFU_lid['TTFU_lname_ary']= TTFU_lname_ary='ALL';
	top.FSTT_lid['FSTT_lid_ary']= FSTT_lid_ary='ALL';
	top.FSTT_lid['FSTT_lname_ary']= FSTT_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.TT_lid['TT_HOT_lid_ary']= TT_HOT_lid_ary='ALL';
	top.TT_lid['TT_HOT_lid_type']= TT_HOT_lid_type='';
	top.TT_lid['TT_HOT_lname_ary']= TT_HOT_lname_ary='ALL';
	top.TT_lid['TT_HOT_lid_ary_RE']= TT_HOT_lid_ary_RE='ALL';
	top.TT_lid['TT_HOT_lname_ary_RE']= TT_HOT_lname_ary_RE='ALL';
	top.TTFU_lid['TTFU_HOT_lid_ary']= TTFU_HOT_lid_ary='ALL';
	top.TTFU_lid['TTFU_HOT_lid_type']= TTFU_HOT_lid_type='';
	top.TTFU_lid['TTFU_HOT_lname_ary']= TTFU_HOT_lname_ary='ALL';
	top.FSTT_lid['FSTT_HOT_lid_ary']= FSTT_HOT_lid_ary='ALL';
	top.FSTT_lid['FSTT_HOT_lname_ary']= FSTT_HOT_lname_ary='ALL';

	// 特別賽事
	top.TT_lid['TT_SP_lid_ary']= TT_SP_lid_ary='ALL';
	top.TT_lid['TT_SP_lid_type']= TT_SP_lid_type='';
	top.TT_lid['TT_SP_lname_ary']= TT_SP_lname_ary='ALL';
	top.TT_lid['TT_SP_lid_ary_RE']= TT_SP_lid_ary_RE='ALL';
	top.TT_lid['TT_SP_lname_ary_RE']= FT_SP_lname_ary_RE='ALL';
	top.TTFU_lid['TTFU_SP_lid_ary']= TTFU_SP_lid_ary='ALL';
	top.TTFU_lid['TTFU_SP_lid_type']= TTFU_SP_lid_type='';
	top.TTFU_lid['TTFU_SP_lname_ary']= TTFU_SP_lname_ary='ALL';
	top.FSTT_lid['FSTT_SP_lid_ary']= FSTT_SP_lid_ary='ALL';
	top.FSTT_lid['FSTT_SP_lname_ary']= FSTT_SP_lname_ary='ALL';	
}
function initlid_OP(){
	top.OP_lid = new Array();
	top.OM_lid = new Array();
	top.FSOP_lid = new Array();	
	top.OP_lid['OP_lid_ary']= OP_lid_ary='ALL';
	top.OP_lid['OP_lid_type']= OP_lid_type='';
	top.OP_lid['OP_lname_ary']= OP_lname_ary='ALL';
	top.OP_lid['OP_lid_ary_RE']= OP_lid_ary_RE='ALL';
	top.OP_lid['OP_lname_ary_RE']= OP_lname_ary_RE='ALL';
	top.OM_lid['OM_lid_ary']= OM_lid_ary='ALL';
	top.OM_lid['OM_lid_type']= OM_lid_type='';
	top.OM_lid['OM_lname_ary']= OM_lname_ary='ALL';
	top.FSOP_lid['FSOP_lid_ary']= FSOP_lid_ary='ALL';
	top.FSOP_lid['FSOP_lname_ary']= FSOP_lname_ary='ALL';	

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.OP_lid['OP_HOT_lid_ary']= OP_HOT_lid_ary='ALL';
	top.OP_lid['OP_HOT_lid_type']= OP_HOT_lid_type='';
	top.OP_lid['OP_HOT_lname_ary']= OP_HOT_lname_ary='ALL';
	top.OP_lid['OP_HOT_lid_ary_RE']= OP_HOT_lid_ary_RE='ALL';
	top.OP_lid['OP_HOT_lname_ary_RE']= OP_HOT_lname_ary_RE='ALL';
	top.OM_lid['OM_HOT_lid_ary']= OM_HOT_lid_ary='ALL';
	top.OM_lid['OM_HOT_lid_type']= OM_HOT_lid_type='';
	top.OM_lid['OM_HOT_lname_ary']= OM_HOT_lname_ary='ALL';
	top.FSOP_lid['FSOP_HOT_lid_ary']= FSOP_HOT_lid_ary='ALL';
	top.FSOP_lid['FSOP_HOT_lname_ary']= FSOP_HOT_lname_ary='ALL';

	// 特別賽事
	top.OP_lid['OP_SP_lid_ary']= OP_SP_lid_ary='ALL';
	top.OP_lid['OP_SP_lid_type']= OP_SP_lid_type='';
	top.OP_lid['OP_SP_lname_ary']= OP_SP_lname_ary='ALL';
	top.OP_lid['OP_SP_lid_ary_RE']= OP_SP_lid_ary_RE='ALL';
	top.OP_lid['OP_SP_lname_ary_RE']= OP_SP_lname_ary_RE='ALL';
	top.OM_lid['OM_SP_lid_ary']= OM_SP_lid_ary='ALL';
	top.OM_lid['OM_SP_lid_type']= OM_SP_lid_type='';
	top.OM_lid['OM_SP_lname_ary']= OM_SP_lname_ary='ALL';
	top.FSOP_lid['FSOP_SP_lid_ary']= FSOP_SP_lid_ary='ALL';
	top.FSOP_lid['FSOP_SP_lname_ary']= FSOP_SP_lname_ary='ALL';
}
function initlid_SK(){
	top.SK_lid = new Array();
	top.SKFU_lid = new Array();
	top.FSSK_lid = new Array();
	top.SK_lid['SK_lid_ary']= OP_lid_ary='ALL';
	top.SK_lid['SK_lid_type']= OP_lid_type='';
	top.SK_lid['SK_lname_ary']= OP_lname_ary='ALL';
	top.SK_lid['SK_lid_ary_RE']= OP_lid_ary_RE='ALL';
	top.SK_lid['SK_lname_ary_RE']= OP_lname_ary_RE='ALL';
	top.SKFU_lid['SKFU_lid_ary']= OM_lid_ary='ALL';
	top.SKFU_lid['SKFU_lid_type']= OM_lid_type='';
	top.SKFU_lid['SKFU_lname_ary']= OM_lname_ary='ALL';
	top.FSSK_lid['FSSK_lid_ary']= FSOP_lid_ary='ALL';
	top.FSSK_lid['FSSK_lname_ary']= FSOP_lname_ary='ALL';

	// 2017-03-17 特別賽事 精選賽事的聯盟記憶須分開
	// 精選賽事	
	top.SK_lid['SK_HOT_lid_ary']= SK_HOT_lid_ary='ALL';
	top.SK_lid['SK_HOT_lid_type']= SK_HOT_lid_type='';
	top.SK_lid['SK_HOT_lname_ary']= SK_HOT_lname_ary='ALL';
	top.SK_lid['SK_HOT_lid_ary_RE']= SK_HOT_lid_ary_RE='ALL';
	top.SK_lid['SK_HOT_lname_ary_RE']= SK_HOT_lname_ary_RE='ALL';
	top.SKFU_lid['SKFU_HOT_lid_ary']= SKFU_HOT_lid_ary='ALL';
	top.SKFU_lid['SKFU_HOT_lid_type']= SKFU_HOT_lid_type='';
	top.SKFU_lid['SKFU_HOT_lname_ary']= SKFU_HOT_lname_ary='ALL';
	top.FSSK_lid['FSSK_HOT_lid_ary']= FSSK_HOT_lid_ary='ALL';
	top.FSSK_lid['FSSK_HOT_lname_ary']= FSSK_HOT_lname_ary='ALL';

	// 特別賽事
	top.SK_lid['SK_SP_lid_ary']= SK_SP_lid_ary='ALL';
	top.SK_lid['SK_SP_lid_type']= SK_SP_lid_type='';
	top.SK_lid['SK_SP_lname_ary']= SK_SP_lname_ary='ALL';
	top.SK_lid['SK_SP_lid_ary_RE']= SK_SP_lid_ary_RE='ALL';
	top.SK_lid['SK_SP_lname_ary_RE']= SK_SP_lname_ary_RE='ALL';
	top.SKFU_lid['SKFU_SP_lid_ary']= SKFU_SP_lid_ary='ALL';
	top.SKFU_lid['SKFU_SP_lid_type']= SKFU_SP_lid_type='';
	top.SKFU_lid['SKFU_SP_lname_ary']= SKFU_SP_lname_ary='ALL';
	top.FSSK_lid['FSSK_SP_lid_ary']= FSSK_SP_lid_ary='ALL';
	top.FSSK_lid['FSSK_SP_lname_ary']= FSSK_SP_lname_ary='ALL';
	
}
function display_loading(_visible){
		//console.log("display_loading===>"+_visible);
	
		
		//document.getElementById("noBet").style.height=document.getElementById("body_view").scrollHeight;
		//console.log("load height "+document.getElementById("loading").scrollHeight);
		//console.log("body_view "+document.getElementById("body_view").scrollHeight);
	
	document.getElementById("loading").style.display=(_visible)?"":"none";
	if(!_visible)display_loadingMain("body");
	
	//document.getElementById("body_view").style.display=(visible!=true?"":"none");
	//document.getElementById("loading").style.display="none";
	//document.getElementById("body_view").style.display="";
}
function iframe_onErrorFT(iframe,errorfunc){

	try{
		check = iframe.contentWindow.document.body.onload;
	}catch(e){
		check = null;
	}
	//console.log(iframe.id+"|"+iframe.contentWindow.location);
//	try{
	//		iframe.loadsrc = ""+iframe.contentWindow.location;
	//	}catch(e){}
	

	if(check == null && iframe.loadsrc != undefined ){
		iframe.times = iframe.times || 0;
		//console.log("errostart");
		errorfunc(iframe);
	}else{
		iframe.times = 0;
		
	}
}

function showerrorFT(e){
	//e.times+=1;
//	if(e.times > 10)	return;
 
	setTimeout(function(){e.contentWindow.location=e.loadsrc;},5000);
}

function setSizeTV(div){
		trace("onresize");
		setResize(div);
		doResize();
}

function setResize(div){				
		trace("setSizeTV=====>"+div);
		trace("init resize=====>"+div);
		
		var view_w;
		try{
				view_w = getView().viewportwidth;
		}catch(e){
				systemMsg(e.toString());
				return;
		}
		
		var top_div = document.getElementById("top_div");
		var top_tv = document.getElementById("top_tv");
		
		if(view_w <= 1359){
			
				trace("目前寬度: "+view_w+",小於 1359=======>隱藏,"+last_w);
				trace("目前寬度: "+view_w+",小於 1359=======>隱藏,"+last_w);
				top_tv.style.display = "none";
				top_div.setAttribute("class", "indexMain_DIV indexW_min");
				clearTV();
				last_w = true;
				
		}else if(view_w >= 1530){
			
				trace("目前寬度: "+view_w+",大於 1530=======>480px,"+last_w);
				trace("目前寬度: "+view_w+",大於 1530=======>480px,"+last_w);
				top_tv.style.display = "";
				//top_tv.style.width = "480px";
				top_div.setAttribute("class", "indexMain_DIV indexW_max");
				resize = 480;
				last_w = false;
												
		}else{
							
				trace("目前寬度: "+view_w+",介於1360~1529=======>320px,"+last_w);
				trace("目前寬度: "+view_w+",介於1360~1529=======>320px,"+last_w);
				top_tv.style.display = "";
				//top_tv.style.width = "320px";	
				top_div.setAttribute("class", "indexMain_DIV indexW_mid");			
				resize = 320;
				if(last_w) loadTV();
				last_w = false;
				
		}
	
}

function clearTV(){
		trace("clearTV");
		try{
				document.getElementById("show_tv").contentWindow.clearTV();				
		}catch(e){
				systemMsg(e.toString());
		}
}

function loadTV(){
		trace("loadTV");
		try{
				document.getElementById("show_tv").contentWindow.loadTV();				
		}catch(e){
				systemMsg(e.toString());
		}
}

function setVisibleTV(isShow){
		try{
				document.getElementById("show_tv").contentWindow.setVisibleTV(isShow);				
		}catch(e){
				systemMsg(e.toString());
		}
}

function setEventId(obj){
		try{				
				document.getElementById("show_tv").contentWindow.setEventId(obj);				
		}catch(e){
				systemMsg(e.toString());
		}
}

function doResize(){
		try{
				if(resize > 0){
						document.getElementById("show_tv").contentWindow.resetSize(resize);
				}
		}catch(e){
				//systemMsg(e.toString());
		}
}





function display_loadingMain(obj){
	if(document.getElementById("loadingMain").style.display=="none")return;
	try{
		chk_Obj[obj]++;
		//console.log("[loadMain mun] >> "+obj+"="+chk_Obj[obj]);
	}catch(e){
		trace("[loadMain mun] >> "+obj);
	}
	//today or early or parlay

	
	/*if((chk_Obj["tv"]>0 && chk_Obj["body"]>=2 && chk_Obj["order"]>0) || 
		(top.mem_status=="S" && chk_Obj["body"]>=2 && chk_Obj["order"]>0) ||
		obj == "over"){*/
	if((chk_Obj["head"]>0 && chk_Obj["tv"]>0 && chk_Obj["body"]>0 && chk_Obj["order"]>0) || obj == "over"){			
			
			//setTimeout('document.getElementById("loadingMain").style.display="none";',1000);
			document.getElementById("loadingMain").style.display="none";

			clearTimeout(display_loadTime);
			
			if(obj=="over" && !head_finish){
				head_finish = true;
				try{
					initHeader();
				}catch(e){}
				
			}
			
			
		}
}



function systemMsg(msg){
		util.systemMsg("[FT_index]"+msg);
}

function trace(msg){
		util.trace("[FT_index]"+msg);
}

function initDate(){
	top.gtypeShowLoveI =new Array("FTRE","FT","FU","BKRE","BK","BU","BSRE","BS","BSFU","TNRE","TN","TU","VBRE","VB","VU","BMRE","BM","BMFU","TTRE","TT","TTFU","OPRE","OP","OM","SKRE","SK","SKFU");
	top.ShowLoveIarray = new Array();
	top.ShowLoveIOKarray = new Array();
	for (var i=0 ; i < top.gtypeShowLoveI.length ; i++){
		top.ShowLoveIarray[top.gtypeShowLoveI[i]]= new Array();
		top.ShowLoveIOKarray[top.gtypeShowLoveI[i]]= new Array();
	}
}

