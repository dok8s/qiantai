
function changePage(page){
	var pages=document.getElementById('page').length;
	//alert(">===");
	var now_page=document.getElementById('page').selectedIndex;
	if (now_page+page+1 > pages || now_page+page < 0){
	    
		//alert("超出範圍");
	}else{
		document.getElementById('page').selectedIndex=now_page+page;
		LAYOUTFORM.submit();	
	} 
}
//有頁次：class="page_lis"
//無頁次：class="page_none"
function onLoad(){

    var pages=document.getElementById('page').length;
    var now_page=document.getElementById('page').selectedIndex;
	
    if(pages == 1){
          document.getElementById("no_page").style.display = "";
      		
      		document.getElementById("page_show").style.display = "none";
	  
        
    }else{   
       
           document.getElementById("no_page").style.display = "none";
      		document.getElementById("page_show").style.display = "";
    }
    
    
}
