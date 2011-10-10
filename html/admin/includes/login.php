<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%">
<tr>
	<td style="background:url(pics/header/shadow_header_white.jpg)" height="3" width="100%"></td>
</tr>
<tr>
<td width="100%">
<div align="center">
<table cellpadding="0" cellspacing="0" border="0" height="262">
<tr>

	<td valign="bottom" width="12" height="262"><img alt="Margin Login" src="pics/login/margin_left_login.jpg" width="12" height="232"></td>
	<td height="262">
		<table cellpadding="0" cellspacing="0" border="0" height="262" width="400">
		<tr>
			<td height="37" width="400">
				<table cellpadding="0" cellspacing="0" border="0" height="37" width="400">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" border="0" height="37">

						<tr>
							<td width="12" height="37"><img src="pics/login/margin_left_login_mini.jpg" width="12" height="37" /></td>
							<td valign="middle" style="background:url(pics/login/backgr_login_mini.jpg)" height="37"><font class="login">&nbsp;&nbsp;Login&nbsp;&nbsp;</font></td>
							<td width="12" height="37"><img src="pics/login/margin_right_login_mini.jpg" width="12" height="37" /></td>
						</tr>
						<tr>
							<td bgcolor="#FFFFFF" width="12" height="2"></td>
							<td bgcolor="#FFFFFF" height="2"></td>

							<td bgcolor="#FFFFFF" width="12" height="2"></td>
						</tr>
						</table>
					</td>
					<td valign="bottom" height="37" width="100%">
						<table cellpadding="0" cellspacing="0" border="0" height="7" width="100%">
						<tr>
							<td width="100%" height="7" style="background:url(pics/login/margin_top_login.jpg)"></td>
						</tr>

						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="background:url(pics/login/backgr_login.jpg)" valign="middle" height="218" width="400" align="center">
			<!-- Inceput form de login -->

			<form name="loginfrm" method="post" action="includes/login_action.php?action=login">
			<table cellpadding="0" cellspacing="0" border="0" height="200" width="380">
			<tr>
				<td width="210" align="left" valign="top">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td><font class="logintextbig"><font style="font-size:14px; color:#FF6600"><?=str_replace('"','',str_replace("'","",htmlspecialchars($_GET["msg"]))) ?></font><br />User:<br /></font></td>
					</tr>

					<tr>
						<td>
						
						<table cellpadding="0" cellspacing="0" border="0" height="28">
						<tr>
							<td width="7" headers="28"><img src="pics/login/margin_left_input.jpg" width="7" height="28" /></td>
							<td height="28" style="background:url(pics/login/backgr_input.jpg)">
							<input style="border:none; background-color:transparent" size="28" class="logininput" type="text" name="username" />
							</td>
							<td width="7" headers="28"><img src="pics/login/margin_right_input.jpg" width="7" height="28" /></td>

						</tr>
						</table>
						
						</td>
					</tr>
					<tr>
						<td><br /><font class="logintextbig">Password:<br /></font></td>
					</tr>
					<tr>

						<td>
						
						<table cellpadding="0" cellspacing="0" border="0" height="28">
						<tr>
							<td width="7" headers="28"><img src="pics/login/margin_left_input.jpg" width="7" height="28" /></td>
							<td height="28" style="background:url(pics/login/backgr_input.jpg)">
							<input style="border:none; background-color:transparent" size="28" class="logininput" name="pass" type="password" />
							</td>
							<td width="7" headers="28"><img src="pics/login/margin_right_input.jpg" width="7" height="28" /></td>
						</tr>

						</table>
						
						</td>
					</tr>
					<tr>
						<td height="20"></td>
					</tr>
					<tr>
						<td width="100%" align="right">
						<!-- BTN LOGIN -->

						<input class="login" type="submit" style="background:url(pics/login/backgr_btn_login_out.jpg); border:2px; border-color:#000000; border-style:solid; font-size:16px" onmouseover="this.style.backgroundImage='url(pics/login/backgr_btn_login_on.jpg)'; this.style.color='#000000'; this.style.cursor='pointer'" onmouseout="this.style.backgroundImage='url(pics/login/backgr_btn_login_out.jpg)'; this.style.color='#FFFFFF'" name="action" value="Login" />
						
						<!-- BTN LOGIN -->
						</td>
					</tr>
					</table>
				</td>
				<td width="10"></td>
				<td width="1" bgcolor="#000000"></td>
				<td width="1" bgcolor="#666666"></td>

				<td width="10"></td>
				<td width="140"><font class="logintextsmall">Welcome to MCS Dating <br />Site Administrator<br /><br />Use a valid username and password to gain access to the administration console.</font></td>
			</tr>
			</table>
			</form>
			<!-- Sfarsit form de login -->
			</td>

		</tr>
		<tr>
			<td valign="bottom" style="background:url(pics/login/margin_bottom_login.jpg)" width="400" height="7"></td>
		</tr>
		</table>
	</td>
	<td valign="bottom" width="12" height="262"><img alt="Margin Login" src="pics/login/margin_right_login.jpg" width="12" height="232"></td>
</tr>
</table>
</div>

</td>
</tr>
<tr>
	<td style="background:url(pics/footer/shadow_footer_white.jpg)" height="4" width="100%"></td>
</tr>
</table>	