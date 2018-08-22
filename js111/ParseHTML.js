
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