<table class="memberstable normaltext" style="width: 760px;" cellpadding="0" cellspacing="0">
  <tr>
			<td>
				{literal}
					<script language="javascript">
						/*** Feeds settings ****/
						var MC_style = 6;                                                 //feeds style type, can be found at http://stats.memberchannels.com/
						var MC_sex = 1;                                                   //1: straight, 2: gay
						var MC_niche = 0;                                                 //niche ID, 0: all, 1: Amateur, 2... can be found in http://stats.memberchannels.com/
						var MC_exclude_niche = '';                                        //exclude niche ID, format: 1,3,5,7, example '1,4,7'
						var MC_upgrade_url = '{/literal}{$cfg.path.url_site}{literal}upgrade/index.php';     //only apply if you use trial and redirect to your upgrade page
						var MC_trial_num = 0;                                             //member type, 1: full member, 2: trial member, default 1
						var MC_scene = 0;                                                 //show scenes or movies, 0: movie, 1: scene, only used for scene layout
						var MC_player = 1;                                                //player type, 1: embed, 2: popup
						var MC_play_type = 2;                                             //media type, 1: flash High BW, 2: flash low BW, 3: wmv
						var MC_paging = 1;                                                //pagination, 0: hide, 1: show
						var MC_show_col = 3;                                              //DVD number per col
						var MC_show_row = 2;                                              //DVD number per row
						var MC_dropdown = 1;                                              //DVD number per row
						var MC_show_number = MC_show_row*MC_show_col;                     //DVD number per page
						var MC_niches_list = 1;                                           //category list, 1: show, 0: hidden, default 1
						var MC_star_list = 1;                                             //star list, 1: show, 0: hidden, default 1
						var MC_show_title = 1;                                            //DVD title, 1: show, 0: hidden, default 1
						var MC_show_desc = 1;                                             //DVD description, 1: show, 0: hidden, default 1
						var MC_show_production_year = 0;                                  //DVD production year, 1: show, 0: hidden, default 1
						var MC_show_length = 1;                                           //DVD length, 1: show, 0: hidden, default 1
						var MC_show_stars = 0;                                            //DVD Performaces, 1: show, 0: hidden, default 1
						var MC_show_director = 0;                                         //DVD directors, 1: show, 0: hidden, default 1
						var MC_show_studio = 0;                                           //DVD studio, 1: show, 0: hidden, default 1
						var MC_show_add_time= 0;                                          //show added time, 1: show, 0: hidden, default 1
						var MC_choose_type = 1;                                           //DVD studio, 1: show, 0: hidden, default 1
						var MC_order_type = 1;                                            //movie order, 1: by added date, 2: by title, 3: by production year, 4: by random
						var MC_sort_type = 1;                                             //movie sort, 1: desc, 2: asc, default 1
						var MC_player_w = 560;                                            //flash player width, default: 560
						var MC_player_h = 420;                                            //flash player height, default 420
						var MC_player_sidebar = 1;                                        //player side thumb, default 1
						var MC_player_button = 1;                                         //player bottom 3 buttons, default 1
					</script>
					<script language="javascript" src="http://feeds.memberchannels.com/ajax_v2.js"></script>		
				{/literal}
			</td>
		</tr>                
</table>