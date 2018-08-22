
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
