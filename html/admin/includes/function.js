// JavaScript Document
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_openBrWindow(theURL,winName,features) { 
	f=document.support;
	if(f.faq.value > 0){
		window.open(theURL+'?FAQID='+f.faq.value,winName,features);
		return true;
	}else{
		return false;
	}
}
function implode(g, p){
	i  = ""; i += p[0];
	for(c = 1 ; c < p.length ; c++){
    	i += g + p[c];
	}
	return i;
}
function completeorder() {
	f=document.frmcompleteorder;
		if (f.CName.value=="") {
			alert("Name is required.");
			f.CName.focus();
			return false;
		}
		if (f.CEmail.value=="") {
			alert("Email is required.");
			f.CEmail.focus();
			return false;
		}
		if (f.CZip.value=="") {
			alert("Zip is required.");
			f.CZip.focus();
			return false;
		}
	else document.frmcompleteorder.submit();
}
function ccompleteorder() {
	f=document.frmcompleteorder;
		if (f.CName.value=="") {
			alert("Name is required.");
			f.CName.focus();
			return false;
		}
		if (f.CEmail.value=="") {
			alert("Email is required.");
			f.CEmail.focus();
			return false;
		}
	else document.frmcompleteorder.submit();
}
function SupportOK() {
	f=document.support;
	if (f.email.value=="") {
		alert("Email is required.");
		f.email.focus();
		return false;
		}
	f=document.support;
	if (f.subject.value=="") {
		alert("Subject is required.");
		f.subject.focus();
		return false;
		}
	f=document.support;
	if (f.content.value=="") {
		alert("Message is required.");
		f.content.focus();
		return false;
		}
	return true;
}

function AdminOK() {
	f=document.loginfrm;
	if (f.username.value=="") {
		alert("User Name is required.");
		f.username.focus();
		return false;
		}
	f=document.loginfrm;
	if (f.pass.value=="") {
		alert("Password is required.");
		f.pass.focus();
		return false;
		}
	return true;
}

function UserOK() {
	f=document.userlogin;
	if (f.username.value=="") {
		alert("E-mail is required.");
		f.username.focus();
		return false;
		}
	f=document.userlogin;
	if (f.pass.value=="") {
		alert("Password is required.");
		f.pass.focus();
		return false;
		}
	return true;
}
// -->
<!--
function deleteconfirm_ticket(id,value_search){
	val=confirm("Delete ticket?")
	if(val)
		{document.location.href='deleteticket.php?value_search='+value_search+'&MessagesID='+id;}
}

function deleteconfirm_qa(id){
	val=confirm("Delete Q&A?")
	if(val)
		{document.location.href='deleteqa.php?FAQID='+id;}
}

function deleteconfirm(id,value_search){
	val=confirm("Delete member?")
	if(val)
		{document.location.href='deletemembers.php?value_search='+value_search+'&ClientsID='+id;}
}

function check_step1(){
	var campaignname_field=document.getElementById('campaignname_field');
	if (campaignname_field.value==''){
		alert ('You have to enter a campaign name');
		campaignname_field.focus();
		return false;
	}	
	var fakeuser_field=document.getElementById('fakeuser_field');
	if (fakeuser_field.value==0){
		alert ('You have to select a sender');
		fakeuser_field.focus();
		return false;
	}
	var domail_field=document.getElementById('domain_field');
	if (domain_field.value==0){
		alert ('You have to select a domain and ip');
		domain_field.focus();
		return false;
	}
	var mail_name=document.getElementById('mail_name');
	if (mail_name.value==0){
		alert ('You have to enter mail subject');
		mail_name.focus();
		return false;
	}	
	var mail_body=document.getElementById('mail_body');
	if (mail_body.value==0){
		alert ('You have to enter mail body');
		mail_body.focus();
		return false;
	}

		
	document.frm_camp_add.submit();
}

function search_staffaccuser(user,type){
	document.frm_camp_add.action="index.php?content=campaign"+type+"_step1&fakeuser="+user;
	document.frm_camp_add.submit();
}

// check for valid numeric strings	
function IsNumeric(strString){
   var strValidChars = "0123456789";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++){
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1){
         blnResult = false;
      }
   }
   return blnResult;
}
/*
(C) AEwebworks Software Development Ltd., 2002-2003
IMPORTANT: This is a commercial software product and any kind of using it must agree
to the AEwebworks Software Development Ltd. license agreement. It can be found at
http://www.aewebworks.com/license.htm
This notice may not be removed from the source code.
*/

/**
 * Checks/unchecks all tables
 *
 * @param   string   the form name
 * @param   boolean  whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function setCheckboxes(the_form, do_check)
{
    var elts      = document.forms[the_form].elements;
    var elts_cnt  = elts.length;
	
    for (var i = 0; i < elts_cnt; i++) {
        elts[i].checked = do_check;
		if (the_form + "_submit" == elts[i].name) {
			elts[i].disabled = !do_check;
		}
    } // end for

    return true;
} // end of the 'setCheckboxes()' function

function setCheckboxess(the_form, do_check)
{
    var elts      = document.forms[the_form].elements;
    var elts_cnt  = elts.length;

    for (var i = 0; i < elts_cnt; i++) {
        elts[i].checked = do_check;
    } // end for

    return true;
} // end of the 'setCheckboxes()' function

function setCheckbox(the_form)
{
    var elts      = document.forms[the_form].elements;
    var elts_cnt  = elts.length;
    
    var allUnchecked = true;
	
    for (var i = 0; i < elts_cnt; i++)
    {
        if(elts[i].checked) allUnchecked = false;
    }
    
    for (var i = 0; i < elts_cnt; i++)
    {
        if(elts[i].name == (the_form + "_submit")) elts[i].disabled = allUnchecked;
    }

    return true;
}


var win = "width=400,height=500,left=100,top=100,copyhistory=no,directories=no,menubar=no,location=no,resizable=no,scrollbars=yes";
function get_gallery(id_prof)
{
   window.open("photos_gallery.php?ID="+id_prof,'gallery',win);
}

function launchTellFriend ()
{   
    var win = "width=250,height=260,left=200,top=100,copyhistory=no,directories=no,menubar=no,location=no,resizable=no,scrollbars=no";
    window.open("tellfriend.php",'tellfriend',win);
    return false;
}

function launchTellFriendProfile ( sID )
{
    var win = "width=300,height=300,left=0,top=100,copyhistory=no,directories=no,menubar=no,location=no,resizable=no,scrollbars=yes";
    window.open("tellfriend.php?ID="+sID,'tellfriendprofile',win);
    return false;
}

function ShowShowHide ( show_name, show_name2, hide_name )
{
    if (hide_name) hide_name.style.display = 'none';
    if (show_name) show_name.style.display = 'inline';
    if (show_name2) show_name2.style.display = 'inline';
}

function ShowHideHide ( show_name, hide_name, hide_name2 )
{
    if (hide_name) hide_name.style.display = 'none';
    if (hide_name2) hide_name2.style.display = 'none';
    if (show_name) show_name.style.display = 'inline';
}


/**
 * change images onHover mouse action
 */
function show(FileName,jpg1Name)
{
	document.images[FileName].src = jpg1Name;
}

/**
 * set status of the browser window to 's'
 */
function ss(s) 
{
	window.status = s;
	return true;
}

/**
 * set status of the browser window to empty
 */
function ce()
{
	window.status='';
}


/**
 * insert emotion item
 */
function emoticon( txtarea, text ) {

	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text + ' ' : text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function launchAddToIM (id)
{
    var win = "width=600,height=160,left=100,top=100,copyhistory=no,directories=no,menubar=no,location=no,resizable=no,scrollbars=yes";
    window.open("explanation.php?explain=imadd&ID="+id,'add_to_im',win);
    return false;
}

function docOpen(text)
{
	newWindow=window.open('','','toolbar=no,resizable=yes,scrollbars=yes,width=400,height=300');
	newWindow.document.open("text/html");
	newWindow.document.write(unescape(text));
	newWindow.document.close();
}
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
function tdcolor($id){
	obj = document.getElementById( $id );
	obj.style.backgroundColor= '#CCCCCC';
}
//-->
function verif(theform,theval){
	var str_val=theval.split(",");
	var t=document[theform];
	var i =0;
	for(i=0;i<str_val.length;i++){
		if(t[str_val[i]].value==""){
			alert("Please fill the "+str_val[i]);
			return false;
		}
	}
	t.submit();
}
function ordertabels(who){
	t=document.form2;
	t.ord.value=who;
	if(t.dir.value=="Asc"){
		t.dir.value="Desc";
	} else {
		t.dir.value="Asc";
	}
	t.submit();
}
function limit(who){
	t=document.form2;
	t.limit.value=who;
	t.submit();
}

function pages(thepage){
	t=document.form2;
	t.page.value=thepage;
	t.submit();
}



function add_staff_user(field){
	if(field!=""){
		var nrFields=$('.nr_fields').size();
		var fieldsAdded=$('.fieldsAdded').val();	
		var i=0;
		var valarunc=1;
		var fieldsIDs= new Array();
		var fieldssplited=field.split("-");
		if(fieldsAdded!=""){
		
			var fieldsAddeds=fieldsAdded.split(",");
			for(i=0;i<nrFields;i++){
				if(fieldsAddeds[i]==fieldssplited[0]){
					valarunc="";
					break;
				}
			}
			if(valarunc==""){
				alert("Staff User already added!");
				$('.fieldsAdded').attr("value",fieldsAdded);
			}else{
				var content='<div id="field_'+fieldssplited[0]+'" style="font-size:10px;height:25px;background-color:#ECF6FC" onmouseover="this.style.backgroundColor=\'#BCD4EC\'" onmouseout="this.style.backgroundColor=\'#ECF6FC\'" class="nr_fields"><input type="hidden" name="fieldAlese[]" value="'+fieldssplited[0]+'" /><div style="width:150px;float:left">'+fieldssplited[1]+'</div> <span class="sterge_tema" style="margin-left:10px;cursor:pointer;color:red" onclick="delete_staff_user(\''+fieldssplited[0]+'\');return false;">delete</span><div style="clear:both;"></div></div>';
				$('.fields_area').append(content);
				$('.fieldsAdded').attr("value",fieldsAdded+","+fieldssplited[0]);
			}
		}else{
			var content='<div id="field_'+fieldssplited[0]+'" style="font-size:10px;height:25px;background-color:#ECF6FC" onmouseover="this.style.backgroundColor=\'#BCD4EC\'" onmouseout="this.style.backgroundColor=\'#ECF6FC\'" class="nr_fields"><input type="hidden" name="fieldAlese[]" value="'+fieldssplited[0]+'" /><div style="width:150px;float:left">'+fieldssplited[1]+'</div> <span class="sterge_tema" style="margin-left:10px;cursor:pointer;color:red" onclick="delete_staff_user(\''+fieldssplited[0]+'\');return false;">delete</span><div style="clear:both;"></div></div>';
			$('.fields_area').append(content);
			$('.fieldsAdded').attr("value",fieldsAdded+fieldssplited[0]);
		}
	}
}
function delete_staff_user(id){
	var fieldsAdded=$('.fieldsAdded').val();
	var fieldsAddeds=fieldsAdded.split(",");
	var i=0;
	var fieldsRamase= new Array();
	for(i=0;i<fieldsAddeds.length;i++){
		if(fieldsAddeds[i]!=id){
			fieldsRamase.push(fieldsAddeds[i]);
		}
	}
	var fields=document.getElementById('fields_choosen');
	fields.removeChild(document.getElementById("field_"+id));
	if(fieldsRamase.length>0){
		var restoffields=implode(",",fieldsRamase);
	}else{
		var restoffields="";
	}
	$('.fieldsAdded').attr("value",restoffields);
	return false;
}
function change_featured_profile(profileId,changedvalue){
	$.post("http://www.flirtigo.com/admin/ajax/change_featured_profile.php",{profileId:profileId,changedvalue:changedvalue});
}

function changeUserChecked(userId,uservalue){
	var usercheckfield=$("#usersChecked").val();
	var numberChecked = $(".feturedUsersChecked:checked").length;
	var usercheckfieldarray = new Array();
	var usercheckfieldarrayLeft = new Array();
	//alert(numberChecked);
	var i=0;
	var ii=0;
	var iii=0;
	if(usercheckfield!=0){
		var usercheckfieldarray=usercheckfield.split(",");
		if(uservalue==1){
			$('#usersChecked').val(usercheckfield+','+userId);
		}
		if(uservalue==0){
			if(numberChecked==0){
				$('#usersChecked').val('0');
			}
			if(numberChecked==1){
				for(i=0;i<2;i++){
					if(usercheckfieldarray[i]!=userId){
						usercheckfieldarrayLeft=usercheckfieldarray[i];
					}
				}
				$('#usersChecked').val(usercheckfieldarrayLeft);
			}
			if(numberChecked>1){
				for(ii=0;ii<numberChecked+1;ii++){
					if(usercheckfieldarray[ii]!=userId){
						usercheckfieldarrayLeft[iii]=usercheckfieldarray[ii];
						iii++;
					}	
				}
				var usercheckfieldLeft=implode(',',usercheckfieldarrayLeft);
				$('#usersChecked').val(usercheckfieldLeft);
			}
		}
	}else{
		$('#usersChecked').val(userId);
	}
}


function deleteFeaturedUsers(){
	var usercheckfield=$("#usersChecked").val();
	$.post("http://www.flirtigo.com/admin/ajax/delete_featured_users.php",{usercheckfield:usercheckfield},function(data) {
		location.reload();
	});
}