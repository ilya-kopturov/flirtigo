 <tr>
	 <td align="center" valign="top">
		 <table width="780" border="0" cellpadding="0" cellspacing="0">
			 <tr>
				 <td valign="top" align="center" width="205">
					 {include file="site/dirtyflirting/login/menu.tpl"}
					 <table><tr><td height="2"></td></tr></table>
				 </td>
				 <td width="2"></td>
				 <td valign="top" align="center" width="573">
					 {include file="site/dirtyflirting/login/details.tpl"}
					 <table><tr><td height="2"></td></tr></table>
					 <table width="568" border="0" cellpadding="0" cellspacing="0">
						 <tr>
							 <td height="3" width="568"></td>
						 </tr>
						 <tr>
							 <td width="568"	align="center">
								 <table width="560" border="0" cellpadding="0" cellspacing="0">
									 <tr>
										 <td width="35" height="45" align="center">
										 </td>
										 <td width="10" align="center">
										 </td>
										 <td width="540" align="left" class="details_text">
											 <b>View Photos of {$user.screenname}</b>
										 </td>
									 </tr>
									 <tr style="padding: 10px 10px 5px 10px;">
										 <td align="center" colspan="3">
											 <img border="1" src="{$cfg.path.url_site}showphoto.php?id={$user.id}&t=b&p={$pic_id}" style="border-color: #FFFFFF;">
										 </td>
									 </tr>
									 <tr style="padding: 10px 10px 10px 10px;">
										 <td align="center" colspan="3" valign="top">
											 <table width="400" border="0" cellpadding="0" cellspacing="0">
												 <tr>
													 <td>
													 <table border="0" cellpadding="0" cellspacing="0">
														 <tr align="left" valign="top">
															 <td width="150" class="myprofile_text">
																 <a href="{$cfg.path.url_site}mem_profile.php?id={$user.id}" class="myprofile_text">{$user.screenname}</a> <br>
																	Picture No: {$pic_id} <br>
																	Added: {assign var=pid value=$pic_id-1 }{$photos[$pid].upload_date} <br>
																	Views: {$photos[$pid].photo_viewed}
															 </td>
															 <td width="250" class="myprofile_text">
																 <input type="text" name="link" value="{$cfg.path.url_site}profileid.php?profile={$user.id}" class="search_input" style="width: 200px;"> <br><br>
																 {rateme rating=$user.rating id=$user.id} &nbsp; <B>{$user.votes}</B> Votes (<B>{$user.rating|string_format:"%.2f"}</B>)
															 </td>
														 </tr>
													 </table>
													 </td>
												 </tr>
												 <tr style="padding-top: 13px;">
													 <td align="left">
													 <table width="400" border="0" cellpadding="0" cellspacing="0">
														 <tr align="left" valign="top">
															 <td class="myprofile_text">
															 </td>
														 </tr>
														 <tr style="padding-top: 10px">
															 <td align="center" class="myprofile_text">
																 {section name=more loop=$photos}
																	 {if $smarty.section.more.iteration != $pic_id}
																		 <label><a href="{$cfg.path.url_site}mem_viewphotos.php?id={$user.id}&pic_id={$smarty.section.more.iteration}"><img border="1" src="{$cfg.path.url_site}showphoto.php?id={$user.id}&t=s&p={$smarty.section.more.iteration}" style="border-color: #FFFFFF;"></a>&nbsp;&nbsp;<label>
																	 {/if}
																 {/section}
																 
																 {if $nr_photos <= 1}
																	 <label>No more photos from {$user.screenname}.</label>
																 {/if}
															 </td>
														 </tr>
													 </table>
													 </td>
												 </tr>
												 {*<tr style="padding-top: 20px;">
													 <td align="center">
														 <a href="{$cfg.path.url_site}mem_profile.php?id={$user.id}" class="myprofile_text">View {$user.screenname} full profile</a>
													 </td>
												 </tr>*}
											 </table>
										 </td>
									 </tr>
								 </table>
							 </td>
						 </tr>
						 <tr>
							 <td height="3" width="568"></td>
						 </tr>
					 </table>
				 </td>
			 </tr>
		 </table>
	 </td>
 </tr>