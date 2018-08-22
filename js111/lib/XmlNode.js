function XmlNode(root){
		_self=this;
		if(root==null) return;
		_self.Root=root;
		parentNode=_self.Root[0];
		
		_self.getParentNode=function(){
				return parentNode;
		}
		
		_self.getNode=function(node,auto){
				retNode=parentNode.getElementsByTagName(node);
				parentNode=retNode[0];
				if (auto==false) return retNode;
				if (retNode.length==1) return retNode[0];
				else return retNode;
				//return retNode;
		}
		
		_self.Node=function(parentNode,node,auto){
				if (parentNode.length>1){
						//alert("DataNode error!!");
						return;
				}
				
				retNode=parentNode.getElementsByTagName(node);
				//if (auto==false) return retNode;
				//if (retNode.length==1) return retNode[0];
				//else return retNode;
		
		
				var newNode = new Object();
				newNode.length = retNode.length;
				
				for(var i=0;i<retNode.length;i++){
						newNode[i]=retNode[i];
						if (newNode[i].getAttribute("id")!=null){
								newNode[newNode[i].getAttribute("id")]=newNode[i];
						}
				}
  			

				if (auto==false) return newNode;
				if (newNode.length==1) return newNode[0];
				else return newNode;
				
				

		}
		
		_self.removeMC=function(){
			
		}
		
		_self.getNodeVal=function(Node){
			
				if(Node!=null){
					
						if(Node.childNodes!=null){ //tag not exist
							
								if(Node.childNodes[0]!=null){ //content of tag is empty
									
										if(Node.childNodes[0].nodeValue!=null){
												return Node.childNodes[0].nodeValue;
										}
										
								}else{
										return "";
								}
								
						}
				}
				return null;
		}
		
	
}	