  {include file="site/dirtyflirting/login/menu.tpl"}
  
  <div class="center">
    <div class="clear"><img src="/images/pixel.gif" style="width: 5px;" /></div>
    <div class="index_container">
      <div class="grey" style="float: left; width: 480px; height: 330px; padding: 7px 7px 0px 7px;">
        <div class="container_text" style="float: left; width: 300px; height: 30px; text-align: left;"><span class="container_red_text">my</span> hornybook</div>
        <div style="float: left; width: 150px; height: 30px; margin: 0px; padding: 0px; position: relative;">
          <div id="myhornybook" style="float: right; width: 150px; height: 20px; position: absolute; bottom: 0px; right: 0px;">
            <ul style="margin: 0px; padding: 0px; width: 150px;">
              <li><a href="#Hot_List" title="Hot List"> Hot List </a></li>
              <li><a href="#Viewed_Me{if $smarty.session.sess_accesslevel == 0}_Upgrade{/if}" title="Viewed Me{if $smarty.session.sess_accesslevel == 0}_Upgrade{/if}" onclick="{if $smarty.session.sess_accesslevel == 0}needUpgrade(); return false;{/if}"> Viewed Me </a></li>
            </ul>
          </div>
        </div>
        <div style="clear: both; width: 464px; height: 250px; background-color: white; padding: 0px; margin: 0px;">
          <div id="Viewed_Me_Upgrade" style="display: none; padding: 0px; margin: 0px; border: 0px;"></div>
          <div id="Viewed_Me" style="display: none; padding: 0px; margin: 0px; border: 0px;">
            {section name="view" loop=$viewedme max=8}
              {if $viewedme[view].id}
                <div style="float: left; margin: 8px 8px 0px 8px; width: 94px; height: 109px;">
                  <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
                    <a href="{$cfg.path.url_site}profile/{screenname user_id=$viewedme[view].id}"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" /></a>
                    <img src="{$cfg.path.url_site}showphoto.php?id={$viewedme[view].id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
                  </div>
                  <div class="smalltext" style="text-align: right; margin: 0px; padding: 0px; height: 15px;">{$viewedme[view].screenname}</div>
                </div>
              {else}
                <div style="float: left; margin: 8px 8px 0px 8px;"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif" alt="" style="width: 94px; height: 94px; border: 1px;" /></div>
              {/if}
              {if $smarty.section.view.iteration % 4 == 0 && !$smarty.section.view.last}
                <div class="clear"><img src="/images/pixel.gif" style="width: 1px;" alt="" /></div>
              {/if}
            {/section}
          </div>
          <div id="Hot_List" style="display: none; padding: 0px; margin: 0px; border: 0px;">
            {section name="hot" loop=$hotlist max=8}
              {if $hotlist[hot].id}
                <div style="float: left; margin: 8px 8px 0px 8px; width: 94px; height: 109px;">
                  <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
                    <a id="a_{$hotlist[hot].id}" href="{$cfg.path.url_site}profile/{screenname user_id=$hotlist[hot].id}"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" /></a>
                    <img id="pic_{$hotlist[hot].id}" src="{$cfg.path.url_site}showphoto.php?id={$hotlist[hot].id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
                  </div>
                  <div id="div_{$hotlist[hot].id}" class="smalltext" style="text-align: right; margin: 0px; padding: 0px; height: 15px;">{$hotlist[hot].screenname} [<a href="javascript:;" style="font-weight: bold;" onclick="removeHotBlock({$hotlist[hot].id});">x</a>]</div>
                </div>
              {else}
                <div style="float: left; margin: 8px 8px 0px 8px;"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif" alt="" style="width: 94px; height: 94px; border: 0px;" /></div>
              {/if}
              {if $smarty.section.hot.iteration % 4 == 0 && !$smarty.section.hot.last}
                <div class="clear"><img src="/images/pixel.gif" style="width: 1px;" alt="" /></div>
              {/if}
            {/section}
          </div>
        </div>
        <div class="clear"><img src="/images/pixel.gif" style="width: 5px;" /></div>
        <div style="bottom: 0px; right: 0px; text-align: right; vertical-align: bottom; width: 464px; margin: 0px; padding: 0px;">[<a id="myhornybook_more" href="{$cfg.path.url_site}mem_myprofile.php#Who_Viewed_Me">more</a>]</div>
      </div>
      <div style="float: left; width: 240px; height: 330px; padding: 7px 0px 7px 7px;">
        <div class="container_text" style="height: 30px; text-align: left; padding-left: 10px;"><span class="container_red_text">my</span> profile</div>
        <div style="float: left; margin: 10px 10px 0px 10px; padding: 0px;">
          <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
            <img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="{$smarty.session.sess_screenname}" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" />
            <img src="{$cfg.path.url_site}showphoto.php?id={$smarty.session.sess_id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
          </div>
          <div class="normaltext" style="padding: 2px 0px 0px 5px; text-align: left; font-size: 12px;">Photo Preview</div>
          <div class="normaltext" style="padding: 0px 0px 0px 5px; text-align: left; font-size: 12px;">Discreet:  {$smarty.session.sess_picturediscret}</div>
          <div class="smalltext" style="padding: 0px 0px 0px 5px; text-align: left; color: red;">{if $smarty.session.sess_picturepending == 'Y'}Pending Approval{/if}</div>
        </div>
        <div style="float: left; margin: 10px 5px 0px 10px; padding: 0px;">
          <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
            <img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="{$smarty.session.sess_screenname}" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" />
            <img src="{$cfg.path.url_site}videothumb.php" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
          </div>
          <div class="normaltext" style="padding: 2px 0px 0px 0px; text-align: left; font-size: 12px;">Video Preview</div>
          <div class="normaltext" style="padding: 0px 0px 0px 0px; text-align: left; font-size: 12px;">Discreet: {$smarty.session.sess_videodiscret}</div>
          <div class="smalltext" style="padding: 0px 0px 0px 0px; text-align: left; color: red;">{if $smarty.session.sess_videopending}Pending Approval{/if}</div>
        </div>
        <div class="clear"><img src="/images/pixel.gif" style="height: 2px;" alt="" /></div>
        <div class="normaltext" style="margin: 0px 0px 5px 15px; text-align: left;">Your rating: {rateme rating=$smarty.session.sess_rating id=$smarty.session.sess_id screenname=$smarty.session.sess_screenname}</div>
        <div class="normaltext" style="margin: 0px 0px 0px 15px; text-align: left; color: #900202;">
          {$cfg.option.members[$smarty.session.sess_accesslevel]} {if $smarty.session.sess_accesslevel < 2}[ <a href="{$cfg.path.url_upgrade}" style="color: #900202;">upgrade now</a> ]{/if}
        </div>
        <div class="normaltext" style="margin: 0px 0px 0px 15px; text-align: left;">
          <span style="width: 15px; text-align: left;"><img src="{$cfg.template.url_template}login/images/hornybook_{if !$checkProfile[0]}un{/if}checked.gif" alt="FlirtiGo.com"></span> Basic Profile Complete</div>
        <div class="normaltext" style="margin: 0px 0px 0px 15px; text-align: left;">
          <span style="width: 15px; text-align: left;"><img src="{$cfg.template.url_template}login/images/hornybook_{if !$checkProfile[1]}un{/if}checked.gif" alt="FlirtiGo.com"></span> Extended Profile Complete</div>
        <div class="normaltext" style="margin: 0px 0px 0px 15px; text-align: left;">
          <span style="width: 15px; text-align: left;">{if $smarty.session.sess_withpicture == 'Y'}<img src="{$cfg.template.url_template}login/images/hornybook_checked.gif" alt="FlirtiGo.com">{else}<img src="{$cfg.template.url_template}login/images/hornybook_unchecked.gif" alt="FlirtiGo.com">{/if}</span> Photo Uploaded</div>
        <div class="normaltext" style="margin: 0px 0px 0px 15px; text-align: left;">
          <span style="width: 15px; text-align: left;">{if $smarty.session.sess_withvideo == 'Y'}<img src="{$cfg.template.url_template}login/images/hornybook_checked.gif" alt="FlirtiGo.com">{else}<img src="{$cfg.template.url_template}login/images/hornybook_unchecked.gif" alt="FlirtiGo.com">{/if}</span> Video Uploaded
        </div>
        <div style="margin: 0px 0px 0px 15px; text-align: right;">[<a href="{$cfg.path.url_site}mem_myprofile.php#Edit_Profile">edit</a>]</div>
      </div>
    </div>
    <div class="clear"><img src="/images/pixel.gif" style="height: 10px;" /></div>
    <div class="index_container">
      <div class="grey" style="float: left; width: 233px; height: 320px; padding: 7px 7px 0px 7px;">
        <div class="container_text" style="float: left; height: 30px; text-align: left;"><span class="container_red_text">quick</span> search</div>
        
	    <form method="get" action="{$cfg.path.url_site}mem_searchresults.php">
		<input type="hidden" name="sex" value="1" />
		<input type="hidden" name="looking" value="0" />
        <div style="clear: both; width: 219px; height: 155px; background-color: white; padding: 5px; margin: 0px;">
          <div style="float: left; width: 54px; text-align: left;">Search</div>
          <div style="float: left; width: 155px;">
                <select name="sex_looking" style="width:155px;">
                  <option value="0" selected>Women seeking Men</option>
                  <option value="1">Men seeking Women</option>
                  <option value="2">Men seeking Men</option>
                  <option value="3">Women seeking Women</option>
                  <option value="4">Men seeking Couples</option>
                  <option value="5">Woman seeking Couples</option>
                </select>
          </div>
          <div class="clear"><img src="/images/pixel.gif" style="width: 3px; border: 0px;" alt="" /></div>
          <div style="float: left; width: 54px; text-align: left;">Ages</div>
			<div style="float: left; width: 155px; text-align: left;">
				<select style="width:50px" name="age_from">{html_options values=$cfg.profile.age output=$cfg.profile.age selected=18}</select>
				<span>to</span>
				<select style="width:50px" name="age_to">{html_options values=$cfg.profile.age output=$cfg.profile.age selected=99}</select>
          	</div>
          <div class="clear"><img src="/images/pixel.gif" style="width: 6px; border: 0px;" alt="" /></div>
          <div style="float: left; width: 54px; text-align: left;">State</div>
          	<div style="float: left; width: 155px;">
          		<select name="state" style="vertical-align:middle; width:155px;">
          		<option value="0">Choose...</option>
				{foreach from=$states key=id item=name}
				<option value="{$id}">{$name}</option>
				{/foreach}
				</select>
          	</div>
          <div class="clear"><img src="/images/pixel.gif" style="width: 6px; border: 0px;" alt="" /></div>
          <div style="float: left; width: 54px; text-align: left;">Country</div>
			<div style="float: left; width: 155px;">
				<select name="country" style="vertical-align:middle;width:155px;">
					<option value="1">Choose...</option>
					{foreach from=$countries key=id item=name}
				  	<option value="{$id}" {if $id == $userArea.id}selected{/if}>{$name}</option>
				  	{if $id == 3}
				    	<option value="15" {if 15 == $userArea.id}selected{/if}>Australia</option>
				  	{elseif $id == 39}
				    	<option value="2" {if 2 == $userArea.id}selected{/if}>Canada</option>
				  	{elseif $id == 220}
				    	<option value="3" {if 3 == $userArea.id}selected{/if}>United Kingdom</option>
				    	<option value="2" {if 2 == $userArea.id}selected{/if}>United States</option>
				  	{/if}
					{/foreach}
				</select>
			</div>
          <div class="clear"><img src="/images/pixel.gif" style="height: 6px; border: 0px;" alt="" /></div>
          <div style="width: 204px; text-align: right;"><input type="image" name="login" src="{$cfg.template.url_template}login/images/hornybook_quicksearch.gif" /></div>
        </div>
        </form>
        <div class="container_text" style="float: left; height: 25px; text-align: left;"><span class="container_red_text">tag</span> search</div>
        <div class="grey" style="clear: both; width: 219px; height: 95px; padding: 0px; margin: 0px; overflow: hidden; text-align: left;">
          {foreach name=tags from=$tags item=tag}
		    {assign var="ratio" value=$tag.count/$tag_sum*6}
			{assign var="header" value=$ratio*100/6%6+6}
				<h{$header} style="display:inline; text-align: left;">
					<a title="search for {$tag.tag|lower}" href="{$cfg.path.url_site}tag/{$tag.tag|lower|escape:'urlpathinfo'}" style="font-size:{$ratio+1}em">{$tag.tag|lower|capitalize}</a>
				</h{$header}>
		  {foreachelse}
				Empty tag cloud
		  {/foreach}
        </div>
      </div>
      <div style="float: left; width: 240px; height: 320px; padding: 5px 5px 0px 5px;">
        <div class="container_text" style="height: 30px; text-align: left; padding-left: 10px;"><span class="container_red_text">featured</span> faces</div>
        <div class="clear"></div>
        <div id="Featured_Faces" style="padding: 0px; margin: 0px;">
            {section name="faces" loop=$featured max=4}
              {if $featured[faces].id}
                <div style="float: left; margin: 8px 8px 0px 8px; width: 94px; height: 109px;">
                  <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
                    <a href="{$cfg.path.url_site}profile/{screenname user_id=$featured[faces].id}"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" /></a>
                    <img src="{$cfg.path.url_site}showphoto.php?id={$featured[faces].id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
                  </div>
                  <div class="smalltext" style="text-align: left; margin: 0px; padding: 0px 0px 0px 10px; height: 15px;"><a href="{$cfg.path.url_site}profile/{screenname user_id=$featured[faces].id}" style="text-decoration: underline;">{$featured[faces].screenname}</a></div>
                  {*<div class="smalltext">{location type="short" typeloc=$featured[faces].typeloc city=$featured[faces].city country=$featured[faces].country joined=$featured[faces].joined}</div>*}
                </div>
              {else}
                <div style="float: left; margin: 8px 8px 0px 8px;"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif" alt="" style="width: 94px; height: 94px; border: 1px;" /></div>
              {/if}
              {if $smarty.section.view.iteration % 2 == 0 && !$smarty.section.view.last}
                <div class="clear"><img src="/images/pixel.gif" style="width: 1px;" alt="" /></div>
              {/if}
            {/section}
        </div>
      </div>
      <div class="grey" style="float: left; width: 229px; height: 320px; padding: 7px 7px 0px 7px;">
        <div class="container_text" style="float: left; width: 130px; height: 24px; text-align: left; padding-left: 10px;"><span class="container_red_text">inbox</span> snapshot</div>
        <div style="float: left; width: 45px; height: 24px; text-align: right; padding: 0px; margin: 0px;"><img src="{$cfg.template.url_template}login/images/hornybook_inboxshot.gif" style="border: 0px; margin: 0px;"  alt="" /></div>
        <div style="clear: both; width: 205px; height: 260px; background-color: white; padding: 0px; margin: 0px;">
          <div style="padding: 5px;">
          	<div style="float: left; width: 35px; text-align: center;"><img src="{$cfg.template.url_template}login/images/hornybook_inboxsubject.gif" alt="" /></div>
          	<div style="float: left; width: 15px;">|</div>
          	<div style="float: left; text-align: left;" class="container_text">Subject</div>
          	<div class="clear"><img src="{$cfg.image.pixel}" style="height: 20px;"/></div>
          	{section name=mail loop=$mymessages}
          	  <div style="float: left; width: 35px; text-align: center;">
          	    {if $mymessages[mail] != 'S'}
          	      <img src="{$cfg.template.url_template}login/images/hornybook_withpicture.gif" alt="" />
          	    {else}
          	      <img src="{$cfg.template.url_template}login/images/hornybook_withoutpicture.gif" alt="" />
          	    {/if}
          	  </div>
          	  <div style="float: left; margin-left: 15px;"><a href="{$cfg.path.url_site}mem_mail.php{if $mymessages[mail].type == 'F'}#Flirts{elseif $mymessages[mail].folder == 5}#Site_Announce{/if}">{$mymessages[mail].subject|truncate:20:'...'}</a></div>
          	  <div class="clear"><img src="{$cfg.image.pixel}" style="height: 2px;"/></div>
          	{sectionelse}
          	  <div style="align: center;">Inbox is empty</div>
          	{/section}
          </div>
        </div>
        <div style="bottom: 0px; right: 0px; text-align: right; vertical-align: bottom; width: 205px; height: 22px; margin: 0px; padding: 0px;">[<a href="{$cfg.path.url_site}mem_mail.php">more</a>]</div>
      </div>
    <div>
    <div class="clear"><img src="/images/pixel.gif" style="height: 10px;" /></div>
    <div class="index_container">
      <div class="grey" style="float: left; width: 491px; height: 200px; padding: 7px 7px 0px 7px; vertical-align: bottom;">
        <div class="container_text" style="float: left; width: 240px; height: 30px; text-align: left;"><span class="container_red_text">featured</span> members content</div>
        <div style="float: left; height: 30px; width: 210px; padding: 0px; margin: 0px; position: relative;">
          <div id="viewcontent" style="float: left; text-align: right; width: 210px; height: 20px; padding: 0px; margin: 0px; position: absolute; bottom: 0px; right: 0px;">
            <ul style="padding: 0px 0px 0px 15px; margin: 0px; width: 200px;">
              <li style="padding: 0px; margin: 0px;"><a href="#Picture_Gallery" title="Picture Gallery"> Picture Gallery </a></li>
              <li style="padding: 0px; margin: 0px;"><a href="#Video_Gallery{if $smarty.session.sess_accesslevel == 0}_Upgrade{/if}" title="Video Gallery{if $smarty.session.sess_accesslevel == 0}_Upgrade{/if}" onclick="{if $smarty.session.sess_accesslevel == 0}needUpgrade(); return false;{/if}"> Video Gallery </a></li>
            </ul>
          </div>
        </div>
        
        <div style="clear: both; width: 477px; height: 140px; background-color: white; padding: 0px; margin: 0px;">
          <div id="Video_Gallery_Upgrade" style="display: none; padding: 0px; margin: 0px; border: 0px;"></div>
          <div id="Video_Gallery" style="display: none; padding: 0px; margin: 0px; border: 0px;">
            {section name="video" loop=$videogallery max=4}
              {if $videogallery[video].id}
                <div style="float: left; margin: 8px 10px 0px 12px; width: 94px; height: 109px;">
                  <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
                    <a href="{$cfg.path.url_site}profile/{screenname user_id=$videogallery[video].id}"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" /></a>
                    <img src="{$cfg.path.url_site}showphoto.php?id={$videogallery[video].id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
                  </div>
                  <div class="smalltext" style="text-align: right; margin: 0px; padding: 0px; height: 15px;">{$videogallery[video].screenname}</div>
                </div>
              {else}
                <div style="float: left; margin: 8px 10px 0px 12px;"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif" alt="" style="width: 94px; height: 94px; border: 1px;" /></div>
              {/if}
            {/section}
          </div>
          <div id="Picture_Gallery" style="display: none; padding: 0px; margin: 0px; border: 0px;">
            {section name="picture" loop=$picturegallery max=4}
              {if $picturegallery[picture].id}
                <div style="float: left; margin: 8px 10px 0px 12px; width: 94px; height: 109px;">
                  <div style="margin: 0px; padding: 0px; position: relative; width: 94px; height: 94px;">
                    <a href="{$cfg.path.url_site}profile/{screenname user_id=$picturegallery[picture].id}"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture.gif" alt="" style="width: 94px; height: 94px; position: absolute; top: 0px; left: 0px; z-index: 1; border: 0px;" /></a>
                    <img src="{$cfg.path.url_site}showphoto.php?id={$picturegallery[picture].id}&m=Y&t=r&p=1" alt="" style="width: 90px; height: 90px; border: 2px solid black;" />
                  </div>
                  <div class="smalltext" style="text-align: right; margin: 0px; padding: 0px; height: 15px;">{$picturegallery[picture].screenname}</div>
                </div>
              {else}
                <div style="float: left; margin: 8px 10px 0px 12px;"><img src="{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif" alt="" style="width: 94px; height: 94px; border: 1px;" /></div>
              {/if}
            {/section}
          </div>
        </div>
        <div style="bottom: 0px; right: 0px; text-align: right; vertical-align: bottom; width: 477px; height: 16px; margin: 0px; padding: 0px;">[<a href="{$cfg.path.url_site}mem_videogallery.php">more</a>]</div>    
      </div>
      <div style="float: left; width: 220px; height: 200px; padding: 7px 0px 0px 17px;">
        <div class="container_text" style="height: 30px; text-align: left;"><span class="container_red_text">live</span> cam shows</div>
        <div style="float: left; width: 80px; margin: 0px; padding: 0px 10px 0px 0px;">
          <a href="{$cfg.path.url_site}mem_xtras.php"><img src="{if $smarty.session.cams.live[0]}{$smarty.session.cams.live[0].performer_schedule_pic}{else if $smarty.session.cams.next[0]}{$smarty.session.cams.next[0].performer_schedule_pic}{/if}" alt="FlirtiGo.com Cams" style="border: 1px solid black; width: 80px; height: 60px;" /></a>
        </div>
        <div style="float: left; width: 80px; margin: 0px; padding: 0px;">
          <a href="{$cfg.path.url_site}mem_xtras.php"><img src="{if $smarty.session.cams.live[1]}{$smarty.session.cams.live[1].performer_schedule_pic}{else if $smarty.session.cams.next[1]}{$smarty.session.cams.next[1].performer_schedule_pic}{/if}" alt="FlirtiGo.com Cams" style="border: 1px solid black; width: 80px; height: 60px;" /></a>
        </div>
        <div class="clear"><img src="{$cfg.image.pixel}" style="height: 2px;"/></div>
        <div class="smalltext" style="float: left; width: 82px; margin: 0px; padding: 0px 10px 0px 0px">
          {if $smarty.session.cams.live[0]}{$smarty.session.cams.live[0].start_24|date_format:"%h %P"}{else if $smarty.session.cams.next[0]}{$smarty.session.cams.next[0].start_24|date_format:"%H %P"}{/if} USA EST
        </div>
        <div class="smalltext" style="float: left; width: 80px; padding: 0px; margin: 0px;">
          {if $smarty.session.cams.live[1]}{$smarty.session.cams.live[1].start_24|date_format:"%h %P"}{else if $smarty.session.cams.next[1]}{$smarty.session.cams.next[1].start_24|date_format:"%H %P"}{/if} USA EST
        </div>
        <div class="clear"><img src="{$cfg.image.pixel}" height="1" /></div>
        
        <div style="float: left; width: 80px; margin: 0px; padding: 0px 10px 0px 0px;">
          <a href="{$cfg.path.url_site}mem_xtras.php"><img src="{if $smarty.session.cams.live[2]}{$smarty.session.cams.live[2].performer_schedule_pic}{else if $smarty.session.cams.next[2]}{$smarty.session.cams.next[2].performer_schedule_pic}{/if}" alt="FlirtiGo.com Cams" style="border: 1px solid black; width: 80px; height: 60px;" /></a>
        </div>
        <div style="float: left; width: 80px; margin: 0px; padding: 0px;">
          <a href="{$cfg.path.url_site}mem_xtras.php"><img src="{if $smarty.session.cams.live[3]}{$smarty.session.cams.live[3].performer_schedule_pic}{else if $smarty.session.cams.next[3]}{$smarty.session.cams.next[3].performer_schedule_pic}{/if}" alt="FlirtiGo.com Cams" style="border: 1px solid black; width: 80px; height: 60px;" /></a>
        </div>
        <div class="clear"><img src="{$cfg.image.pixel}" style="height: 2px;"/></div>
        <div class="smalltext" style="float: left; width: 82px; margin: 0px; padding: 0px 10px 0px 0px">
          {if $smarty.session.cams.live[2]}{$smarty.session.cams.live[2].start_24|date_format:"%h %P"}{else if $smarty.session.cams.next[2]}{$smarty.session.cams.next[2].start_24|date_format:"%H %P"}{/if} USA EST
        </div>
        <div class="smalltext" style="float: left; width: 80px; padding: 0px; margin: 0px;">
          {if $smarty.session.cams.live[3]}{$smarty.session.cams.live[3].start_24|date_format:"%h %P"}{else if $smarty.session.cams.next[3]}{$smarty.session.cams.next[3].start_24|date_format:"%H %P"}{/if} USA EST
        </div>
        
    </div>
    <div class="clear"><img src="/images/pixel.gif" style="height: 10px;" /></div>
  </div>
  
  {literal}
  	<script type="text/javascript">
		$('#myhornybook > ul').tabs({
    		select: function() {
        			if($('#myhornybook > ul').data('selected.tabs') == 1){
        				$('#myhornybook_more').attr({href : "{/literal}{$cfg.path.url_site}mem_myprofile.php#Who_Viewed_Me{literal}"});
        			}else{
        				$('#myhornybook_more').attr({href : "{/literal}{$cfg.path.url_site}mem_myprofile.php#Edit_Hot__Block_Lists{literal}"});
        			}
    		},
    		click: function() {
					setTimeout(function() {
						window.location = '{/literal}{$cfg.path.url_upgrade}{literal}';
					}, 0);
    		}
    		
		});
		
		$(document).ready(function() {
			$('select[name="sex_looking"]').change(function() {
				if(this.options[this.selectedIndex].value == '0'){
					$('input[name="sex"]').attr('value', '1');
					$('input[name="looking"]').attr('value', '0');
				}else if(this.options[this.selectedIndex].value == '1'){
					$('input[name="sex"]').attr('value', '0');
					$('input[name="looking"]').attr('value', '1');
				}else if(this.options[this.selectedIndex].value == '2'){
					$('input[name="sex"]').attr('value', '0');
					$('input[name="looking"]').attr('value', '0');
				}else if(this.options[this.selectedIndex].value == '3'){
					$('input[name="sex"]').attr('value', '1');
					$('input[name="looking"]').attr('value', '1');
				}else if(this.options[this.selectedIndex].value == '4'){
					$('input[name="sex"]').attr('value', '0');
					$('input[name="looking"]').attr('value', '2');
				}else if(this.options[this.selectedIndex].value == '5'){
					$('input[name="sex"]').attr('value', '1');
					$('input[name="looking"]').attr('value', '2');
				}
			});
		});
		
		$('#viewcontent > ul').tabs();
		
		function removePic(pic){
			var pic_element = '#pic_' + pic;
			var div_element = '#div_' + pic;
			$(pic_element).attr({src: "{/literal}{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif{literal}"});
			$(div_element).css({text: ""});
		}
		function removeHotBlock(id) {
			var pic_element = '#pic_' + id;
			var div_element = '#div_' + id;
			var a_element = '#a_' + id;
			$(pic_element).attr({src: "{/literal}{$cfg.template.url_template}login/images/hornybook_bgpicture_full.gif{literal}"});
			$(pic_element).attr({style: "width: 94px; height: 94px; border: 0px;"});
			$(div_element).remove();
			$(a_element).remove();
			$.get('{/literal}{$cfg.path.url_site}{literal}ajax_hot-block.php?d&id=' + id);
		}
		
		function needUpgrade() {
			setTimeout(function() {
				window.location = '{/literal}{$cfg.path.url_upgrade}{literal}';
			}, 0);
		}
  	</script>
  {/literal} 