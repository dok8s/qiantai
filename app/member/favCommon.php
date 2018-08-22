<?
switch($_REQUEST["i"]){
case "browseScript":
?>
<script type="text/javascript" language="javascript" src="/js/jq132.js"></script>
<script type="text/javascript">
	//初始化top global变量
	if(typeof(top.favGid)=="undefined"){
		top.favGid="";
	}
	if(typeof(top.isFilterFav)=="undefined"){
		top.isFilterFav={FT:false,BK:false,BS:false,TN:false,VB:false,OP:false};
	}
	if(typeof(top.MTypeName)=="undefined"){
		top.MTypeName=["FT","BK","BS","TN","VB","OP"];
	}
	top.curMType=getMType();
	initFav();
	

	function newID(prefix){
		if(!prefix) prefix="Ysn";
		do{
			var id=prefix+"_"+(new Date).getTime()+"_"+Math.floor(Math.random()*1000);
		}while(typeof($("#"+id+"").get(0))==undefined);
		return id;
	}
	function initFav(){
		if(typeof($)!="undefined"&&$("#game_table").children().size()){
			$("#game_table tr[class=b_cen]").mouseover(function(){
				var gid=$(this).attr("gid");
				if(!isFavGid(gid)){
					$("#starDiv_"+gid).show();
				}
			})
			.mouseout(function(){
				var gid=$(this).attr("gid");
				if(!isFavGid(gid)){
					$("#starDiv_"+gid).hide();
				}
			});
			refreshBtn("rebuildHead");
			//refreshBtn("rebuild");
		}else{
			var t=setTimeout("initFav()",500);
		}
	}
	function getMType(){
		var mtype=document.location.toString().match(/member\/(.*?)_[browse|future]/i)[1];
		if(mtype){
			mtype=mtype.toUpperCase();
		}else{
			mtype="FT";
		}
		if("FT,BK,BS,TN,VB,OP".indexOf(mtype)<0){mtype="FT";}
		return mtype;
	}
	function getRType(){
		return parent.rtype
	}
	function refreshBtn(){
		
		var nowMType=top.curMType;
		var isRebuild=false;
		
		if(typeof(arguments[0])!="undefined"){
			var arg=arguments[0];
			switch(arg){
				case "rebuild":
					isRebuild=true;
					break;
				case "rebuildHead":
					for(var i=0;i<top.MTypeName.length;i++){
						refreshBtn(top.MTypeName[i]);
					}
					break;
				default:
					isRebuild=true;
					nowMType=arg;
					break;
			}
		}
		var obj=eval("top.SI2_mem_index.header.imp_"+nowMType);
		jobj=$(obj);
		if(top.favGid.indexOf(nowMType+"_")>-1){
			if(!top.isFilterFav[nowMType]||isRebuild){
				jobj.unbind("mouseover")
				.unbind("mouseout")
				.unbind("click")
				.css({
						"background":"url(/images/member/head_L"+nowMType+".gif)",
						"cursor":"hand"
					})
					.mouseover(function(){
						$(this).children().show();
					})
					.mouseout(function(){
						$(this).children().hide();
					})
					.click(function(){
						var myMType=$(this).attr("id").replace("imp_","");
						if(top.curMType!=myMType){
							var url="/app/member/"+myMType+"_index.php?rtype=r&uid="+parent.uid+"&langx="+parent.langx;
							top.SI2_mem_index.location=url;
						}else{
							if(top.isFilterFav[nowMType]){
								top.isFilterFav[nowMType]=false;
							}else{
								top.isFilterFav[nowMType]=true;
							}
							reload_var();
						}
					});
				jobj.children().unbind("click").click(function(){
					var regEx=new RegExp(","+nowMType+".*?,","ig");
					top.favGid=top.favGid.replace(regEx,"");
					top.isFilterFav[nowMType]=false;
					reload_var();
					refreshBtn();
				});
			}
		}else{
			if(top.isFilterFav[nowMType]||isRebuild){
				jobj.css({
						"background":"url(/images/member/head_L"+nowMType+"_2.gif)",
						"cursor":"default"
					})
					.unbind("mouseover")
					.unbind("mouseout")
					.unbind("click");
				jobj.children().hide();
				jobj.children().unbind("click");
				if(top.isFilterFav[nowMType]){
					top.isFilterFav[nowMType]=false;
					reload_var();
				}
			}
		}
	}
	function clickStarDiv(gid,obj){
		toggleFavGid(gid);
		if(isFavGid(gid)){
			$(obj).attr("src","/images/member/star1.gif");
		}else{
			$(obj).attr("src","/images/member/star0.gif");
		}
		refreshBtn();
		if(top.isFilterFav[top.curMType]){
			reload_var();
		}
		//alert($(this).attr("src"));
	}
	function newStarDiv(gid){
		var StarDiv="";
		if(isFavGid(gid)){
			StarDiv="<div style=\"position:absolute;width:100%;display:block;text-align:right\" id=\"starDiv_"+gid+"\" class=\"starDiv\"><div style=\"position:relative;cursor:hand;\"><img src=\"/images/member/star1.gif\" width=15 height=15 border=0 onclick=\"clickStarDiv("+gid+",this)\" gid=\""+gid+"\" /></div></div>"

		}else{
			StarDiv="<div style=\"position:absolute;width:100%;display:none;text-align:right\" id=\"starDiv_"+gid+"\" class=\"starDiv\"><div style=\"position:relative;cursor:hand;\"><img src=\"/images/member/star0.gif\" width=15 height=15 border=0 onclick=\"clickStarDiv("+gid+",this)\" gid=\""+gid+"\" /></div></div>"
		}
		return StarDiv;
	}
	//Begin FavGid
	function toggleFavGid(gid){
		if(isFavGid(gid)){
			delFavGid(gid);
		}else{
			addFavGid(gid);
		}
	}
	function addFavGid(gid){
		var trueGid=trueFavGid(gid);
		if(!isFavGid(gid)){
			top.favGid+=trueGid;
		}
	}
	function isFavGid(gid){
		var trueGid=trueFavGid(gid);
		//alert(trueGid+"_"+top.favGid);
		if(top.favGid.indexOf(trueGid)>-1){
			return true;
		}else{
			return false;
		}
	}
	function delFavGid(gid){
		var trueGid=trueFavGid(gid);
		top.favGid=top.favGid.replace(trueGid,"")
	}
	function trueFavGid(gid){
		var trueGid=","+top.curMType+"_"+parent.rtype+"_"+gid+",";
		return trueGid;
	}
	//End FavGid
</script>
<?
	break;
case "headerBtn"
?>
<!--favorite----->
<div id="LIKE">
<div class="favButton" id="imp_FT"><div></div></div>
<div class="favButton" id="imp_BK"><div></div></div>
<div class="favButton" id="imp_BS"><div></div></div>
<div class="favButton" id="imp_TN"><div></div></div>
<div class="favButton" id="imp_VB"><div></div></div>
<div class="favButton" id="imp_OP"><div></div></div>
</div>
<?
	break;
default:
	echo "";
}
?>