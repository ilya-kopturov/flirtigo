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

function search_fakeuser(user,type){
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
	str_val=theval.split(",");
	t=document[theform];
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

