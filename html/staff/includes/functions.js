function changecolor( $id, $color){
 obj = document.getElementById( $id );
 obj.style.color = $color;
}
function changeimg( $id, $url){
 obj = document.getElementById( $id );
 obj.src = $url;
}
function getheight(){
	$h=document.documentElement.clientHeight;
	$h=$h-120;
}
function verif(theform,theval){
	if(document.theform.theval.value==""){
		alert("Please fill the "+theval);
	}
}