
<div id="chat" style="display:none; width:671px; height:87px; left:220px; top:20px; position:absolute; z-index: 1000; background-color:#FFFFFF;">
<table width="581" border="0" cellpadding="0" cellspacing="3" bgcolor="#CA6500">
<tr>
<td><img src="/images/kefu.jpg" width="94" height="81"></td>
<td>
<iframe name="chat" src="about:blank" width="580" height="81" frameborder="0" border="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
</td>
</tr>
</table>
</div>
<script>
var refresh='yes';
function refreshChat(){
	if(refresh=='yes'){
		window.frames["chat"].location.href = "huihua/chat_member.php?uid=<?=$uid?>&rnd="+Math.random();
	}
	setTimeout( "refreshChat()", 10000 );
}
refreshChat();
</script>
