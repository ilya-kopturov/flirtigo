<?php
/**
 * This file implements the Archives plugin.
 *
 * Displays a list of post archives.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @copyright (c)2003-2011 by Francois Planque - {@link http://fplanque.com/}
 * Parts of this file are copyright (c)2004-2006 by Daniel HAHLER - {@link http://thequod.de/contact}.
 *
 * {@internal License choice
 * - If you have received this file as part of a package, please find the license.txt file in
 *   the same folder or the closest folder above for complete license terms.
 * - If you have received this file individually (e-g: from http://evocms.cvs.sourceforge.net/)
 *   then you must choose one of the following licenses before using the file:
 *   - GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *   - Mozilla Public License 1.1 (MPL) - http://www.opensource.org/licenses/mozilla1.1.php
 * }}
 *
 * {@internal Open Source relicensing agreement:
 * Daniel HAHLER grants Francois PLANQUE the right to license
 * Daniel HAHLER's contributions to this file and the b2evolution project
 * under any OSI approved OSS license (http://www.opensource.org/licenses/).
 * }}
 *
 * @package plugins
 *
 * {@internal Below is a list of authors who have contributed to design/coding of this file: }}
 * @author blueyed: Daniel HAHLER.
 * @author fplanque: Francois PLANQUE - {@link http://fplanque.net/}
 * @author cafelog (group)
 *
 * @version $Id: _archives.plugin.php,v 1.63 2011/09/04 22:13:23 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );


load_class( '_core/ui/results/_results.class.php', 'Results' );



/**
 * Archives Plugin
 *
 * This plugin displays
 */
class archives_plugin extends Plugin
{
	/**
	 * Variables below MUST be overriden by plugin implementations,
	 * either in the subclass declaration or in the subclass constructor.
	 */

	var $name;
	var $code = 'evo_Arch';
	var $priority = 50;
	var $version = '3.2';
	var $author = 'The b2evo Group';
	var $group = 'widget';


	/**
	 * Init
	 */
	function PluginInit( & $params )
	{
		$this->name = T_( 'Archives Widget' );
		$this->short_desc = T_('This skin tag displays a list of post archives.');
		$this->long_desc = T_('Archives can be grouped monthly, daily, weekly or post by post.');

		$this->dbtable = 'T_items__item';
		$this->dbprefix = 'post_';
		$this->dbIDname = 'post_ID';
	}


	/**
	 * Event handler: SkinTag
	 *
	 * @param array Associative array of parameters. Valid keys are:
	 *                - 'block_start' : (Default: '<div class="bSideItem">')
	 *                - 'block_end' : (Default: '</div>')
	 *                - 'title' : (Default: T_('Archives'))
	 *                - 'mode' : 'monthly'|'daily'|'weekly'|'postbypost' (Default: conf.)
	 *                - 'sort_order' : 'date'|'title' (Default: date - used only if the mode is 'postbypost')
	 *                - 'link_type' : 'canonic'|'context' (default: canonic)
	 *                - 'context_isolation' : what params need override when changing date/range (Default: 'm,w,p,title,unit,dstart' )
	 *                - 'form' : true|false (default: false)
	 *                - 'limit' : # of archive entries to display or '' (Default: 12)
	 *                - 'more_link' : more link text (Default: 'More...')
	 *                - 'list_start' : (Default '<ul>')
	 *                - 'list_end' : (Default '</ul>')
	 *                - 'line_start' : (Default '<li>')
	 *                - 'line_end' : (Default '</li>')
	 *                - 'day_date_format' : (Default: conf.)
	 * @return boolean did we display?
	 */
	function SkinTag( $params )
	{
	 	global $month;

		/**
		 * @todo get rid of this global:
		 */
		global $m;

		/**
		 * @var Blog
		 */
		global $Blog;

		if( empty($Blog) )
		{
			return false;
		}

		/**
		 * Default params:
		 */
		// This is what will enclose the block in the skin:
		if(!isset($params['block_start'])) $params['block_start'] = '<div class="bSideItem">';
		if(!isset($params['block_end'])) $params['block_end'] = "</div>\n";

		// Title:
		if(!isset($params['block_title_start'])) $params['block_title_start'] = '<h3>';
		if(!isset($params['block_title_end'])) $params['block_title_end'] = '</h3>';

		// Archive mode:
		if(!isset($params['mode']))
			$params['mode'] = $Blog->get_setting('archive_mode');

		//Sort order (used only in postbypost mode):
		if($params['mode'] !='postbypost')
		{
			$params['sort_order'] = 'date';
		}
		if(!isset($params['sort_order']))
		{
			$params['sort_order'] = $Blog->get_setting('archives_sort_order');
		}

		// Link type:
		if(!isset($params['link_type'])) $params['link_type'] = 'canonic';
		if(!isset($params['context_isolation'])) $params['context_isolation'] = 'm,w,p,title,unit,dstart';

		// Add form fields?:
		if(!isset($params['form']))
			$params['form'] = false;

		// Number of archive entries to display:
		if(!isset($params['limit'])) $params['limit'] = 12;

		// More link text:
		if(!isset($params['more_link'])) $params['more_link'] = T_('More...');

		// This is what will enclose the list:
		if(!isset($params['list_start'])) $params['list_start'] = '<ul>';
		if(!isset($params['list_end'])) $params['list_end'] = "</ul>\n";

		// This is what will separate the archive links:
		if(!isset($params['line_start'])) $params['line_start'] = '<li>';
		if(!isset($params['line_end'])) $params['line_end'] = "</li>\n";

		// Daily archive date format?
		if( (!isset($params['day_date_format'])) || ($params['day_date_format'] == '') )
		{
		 	$dateformat = locale_datefmt();
			$params['day_date_format'] = $dateformat;
		}

		$ArchiveList = new ArchiveList( $params['mode'], $params['limit'], $params['sort_order'], ($params['link_type'] == 'context'),
																			$this->dbtable, $this->dbprefix, $this->dbIDname );

		echo $params['block_start'];

		if( !empty($params['title']) )
		{	// We want to display a title for the widget block:
			echo $params['block_title_start'];
			echo $params['title'];
			echo $params['block_title_end'];
		}

		echo $params['list_start'];
		while( $ArchiveList->get_item( $arc_year, $arc_month, $arc_dayofmonth, $arc_w, $arc_count, $post_ID, $post_title, $permalink) )
		{
			echo $params['line_start'];
			switch( $params['mode'] )
			{
				case 'monthly':
					// --------------------------------- MONTHLY ARCHIVES -------------------------------------
					$arc_m = $arc_year.zeroise($arc_month,2);

					if( $params['form'] )
					{ // We want a radio button:
						echo '<input type="radio" name="m" value="'.$arc_m.'" class="checkbox"';
						if( $m == $arc_m ) echo ' checked="checked"' ;
						echo ' /> ';
					}

					$text = T_($month[zeroise($arc_month,2)]).' '.$arc_year;

					if( $params['link_type'] == 'context' )
					{	// We want to preserve current browsing context:
						echo '<a rel="nofollow" href="'.regenerate_url( $params['context_isolation'], 'm='.$arc_m ).'">'.$text.'</a>';
					}
					else
					{	// We want to link to the absolute canonical URL for this archive:
						echo $Blog->gen_archive_link( $text, T_('View monthly archive'), $arc_year, $arc_month );
					}

					echo ' <span class="dimmed">('.$arc_count.')</span>';
					break;

				case 'daily':
					// --------------------------------- DAILY ARCHIVES ---------------------------------------
					$arc_m = $arc_year.zeroise($arc_month,2).zeroise($arc_dayofmonth,2);

					if( $params['form'] )
					{ // We want a radio button:
						echo '<input type="radio" name="m" value="'. $arc_m. '" class="checkbox"';
						if( $m == $arc_m ) echo ' checked="checked"' ;
						echo ' /> ';
					}

					$text = mysql2date($params['day_date_format'], $arc_year.'-'.zeroise($arc_month,2).'-'.zeroise($arc_dayofmonth,2).' 00:00:00');

					if( $params['link_type'] == 'context' )
					{	// We want to preserve current browsing context:
						echo '<a rel="nofollow" href="'.regenerate_url( $params['context_isolation'], 'm='.$arc_m ).'">'.$text.'</a>';
					}
					else
					{	// We want to link to the absolute canonical URL for this archive:
						echo $Blog->gen_archive_link( $text, T_('View daily archive'), $arc_year, $arc_month, $arc_dayofmonth );
					}

					echo ' <span class="dimmed">('.$arc_count.')</span>';
					break;

				case 'weekly':
					// --------------------------------- WEEKLY ARCHIVES --------------------------------------

					$text = $arc_year.', '.T_('week').' '.$arc_w;

					if( $params['link_type'] == 'context' )
					{	// We want to preserve current browsing context:
						echo '<a rel="nofollow" href="'.regenerate_url( $params['context_isolation'], 'm='.$arc_year.'&amp;w='.$arc_w ).'">'.$text.'</a>';
					}
					else
					{	// We want to link to the absolute canonical URL for this archive:
						echo $Blog->gen_archive_link( $text, T_('View weekly archive'), $arc_year, NULL, NULL, $arc_w );
					}
					echo ' <span class="dimmed">('.$arc_count.')</span>';
					break;

				case 'postbypost':
				default:
					// -------------------------------- POST BY POST ARCHIVES ---------------------------------

					if( $post_title)
					{
						$text = strip_tags($post_title);
					}
					else
					{
						$text = $post_ID;
					}

					if( $params['link_type'] == 'context' )
					{	// We want to preserve current browsing context:
						echo '<a rel="nofollow" href="'.regenerate_url( $params['context_isolation'], 'p='.$post_ID ).'">'.$text.'</a>';
					}
					else
					{
						// fp> THIS IS ALL OBSOLETE. There is a better way to have a post list with a specific widget.
						// TO BE DELETED (waiting for photoblog cleanup)

						// until the cleanup, a fix. I hope.

						echo '<a href="'. $permalink .'">'.$text.'</a>';
					}
			}

			echo $params['line_end'];
		}

		// Display more link:
		if( !empty($params['more_link']) )
		{
			echo $params['line_start'];
			echo '<a href="';
			$Blog->disp( 'arcdirurl', 'raw' );
			echo '">'.format_to_output($params['more_link']).'</a>';
			echo $params['line_end'];
		}

		echo $params['list_end'];

		echo $params['block_end'];

		return true;
	}

	
  /**
   * Get definitions for widget specific editable params
   *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 */
	function get_widget_param_definitions( $params )
	{
		$r = array(
			'title' => array(
					'label' => T_('Block title'),
					'note' => T_('Title to display in your skin.'),
					'size' => 60,
					'defaultvalue' => T_('Archives'),
			),
			'limit' => array(
				'label' => T_( 'Max items' ),
				'note' => T_( 'Maximum number of items to display.' ),
				'size' => 4,
				'defaultvalue' => 12,
			),
		);
		return $r;
	}

}


/**
 * Archive List Class
 *
 * @package evocore
 */
class ArchiveList extends Results
{
	var $archive_mode;
	var $arc_w_last;

	/**
	 * Constructor
	 *
	 * Note: Weekly archives use MySQL's week numbering and MySQL default if applicable.
	 * In MySQL < 4.0.14, WEEK() always uses mode 0: Week starts on Sunday;
	 * Value range is 0 to 53; week 1 is the first week that starts in this year.
	 *
	 * @link http://dev.mysql.com/doc/mysql/en/date-and-time-functions.html
	 *
	 * @todo categories combined with 'ALL' are not supported (will output too many archives,
	 * some of which will resolve to no results). We need subqueries to support this efficiently.
	 *
	 * @param string
	 * @param integer
	 * @param boolean
	 */
	function ArchiveList(
		$archive_mode = 'monthly',
		$limit = 100,
		$sort_order = 'date',
		$preserve_context = false,
		$dbtable = 'T_items__item',
		$dbprefix = 'post_',
		$dbIDname = 'ID' )
	{
		global $DB;
		global $blog, $cat, $catsel;
		global $Blog;
		global $show_statuses;
		global $author, $assgn, $status, $types;
		global $timestamp_min, $timestamp_max;
		global $s, $sentence, $exact;

		$this->dbtable = $dbtable;
		$this->dbprefix = $dbprefix;
		$this->dbIDname = $dbIDname;
		$this->archive_mode = $archive_mode;


		/*
		 * WE ARE GOING TO CONSTRUCT THE WHERE CLOSE...
		 */
		$this->ItemQuery = new ItemQuery( $this->dbtable, $this->dbprefix, $this->dbIDname ); // TEMPORARY OBJ

		// - - Select a specific Item:
		// $this->ItemQuery->where_ID( $p, $title );

		if( $preserve_context )
		{	// We want to preserve the current context:
			// * - - Restrict to selected blog/categories:
			$this->ItemQuery->where_chapter( $blog, $cat, $catsel );

			// * Restrict to the statuses we want to show:
			$this->ItemQuery->where_visibility( $show_statuses );

			// Restrict to selected authors:
			$this->ItemQuery->where_author( $author );

			// Restrict to selected assignees:
			$this->ItemQuery->where_assignees( $assgn );

			// Restrict to selected satuses:
			$this->ItemQuery->where_statuses( $status );

			// - - - + * * timestamp restrictions:
			$this->ItemQuery->where_datestart( '', '', '', '', $timestamp_min, $timestamp_max );

			// Keyword search stuff:
			$this->ItemQuery->where_keywords( $s, $sentence, $exact );

			$this->ItemQuery->where_types( $types );
		}
		else
		{	// We want to preserve only the minimal context:
			// * - - Restrict to selected blog/categories:
			$this->ItemQuery->where_chapter( $blog, '', array() );

			// * Restrict to the statuses we want to show:
			$this->ItemQuery->where_visibility( $show_statuses );

			// - - - + * * timestamp restrictions:
			$this->ItemQuery->where_datestart( '', '', '', '', $timestamp_min, $timestamp_max );

			// Include all types except pages, intros and sidebar links:
			$this->ItemQuery->where_types( '-1000,1500,1520,1530,1570,1600,3000' );
		}


		$this->from = $this->ItemQuery->get_from();
		$this->where = $this->ItemQuery->get_where();
		$this->group_by = $this->ItemQuery->get_group_by();

		switch( $this->archive_mode )
		{
			case 'monthly':
				// ------------------------------ MONTHLY ARCHIVES ------------------------------------
				$sql = 'SELECT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart) AS year, EXTRACT(MONTH FROM '.$this->dbprefix.'datestart) AS month,
																	COUNT(DISTINCT postcat_post_ID) AS count '
													.$this->from
													.$this->where.'
													GROUP BY year, month
													ORDER BY year DESC, month DESC';
				break;

			case 'daily':
				// ------------------------------- DAILY ARCHIVES -------------------------------------
				$sql = 'SELECT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart) AS year, MONTH('.$this->dbprefix.'datestart) AS month,
																	DAYOFMONTH('.$this->dbprefix.'datestart) AS day,
																	COUNT(DISTINCT postcat_post_ID) AS count '
													.$this->from
													.$this->where.'
													GROUP BY year, month, day
													ORDER BY year DESC, month DESC, day DESC';
				break;

			case 'weekly':
				// ------------------------------- WEEKLY ARCHIVES -------------------------------------
				$sql = 'SELECT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart) AS year, '.
															$DB->week( $this->dbprefix.'datestart', locale_startofweek() ).' AS week,
															COUNT(DISTINCT postcat_post_ID) AS count '
													.$this->from
													.$this->where.'
													GROUP BY year, week
													ORDER BY year DESC, week DESC';
				break;

			case 'postbypost':
			default:
				// ----------------------------- POSY BY POST ARCHIVES --------------------------------
				global $timestamp_min, $timestamp_max;
		
		                $this->count_total_rows();
				$archives_list = new ItemListLight( $Blog , $timestamp_min, $timestamp_max, $this->total_rows );
				$archives_list->set_filters( array(
				'visibility_array' => array( 'published' ),  // We only want to advertised published items
				'types' => '-1000,1500,1520,1530,1570,1600,3000',	// Include all types except pages, intros and sidebar links:
	) );

				if($sort_order == 'title')
				{
					$archives_list->set_filters( array(
					'orderby' => 'title',
					'order' => 'ASC') );
				}
			
				$archives_list->query();
				$this->rows = array();
				while ($Item = $archives_list->get_item())
				{
					$this->rows[] = $Item;
				}
				$this->result_num_rows = $archives_list->result_num_rows;
				$this->current_idx = 0;
				$this->arc_w_last = '';
				return;
		}


		// dh> Temp fix for MySQL bug - apparently in/around 4.1.21/5.0.24.
		// See http://forums.b2evolution.net/viewtopic.php?p=42529#42529
		if( in_array($this->archive_mode, array('monthly', 'daily', 'weekly')) )
		{
			$sql_version = $DB->get_var('SELECT VERSION()'); // fp> TODO: $DB->get_mysql_version()
			if( version_compare($sql_version, '4', '>') )
			{
				$sql = 'SELECT SQL_CALC_FOUND_ROWS '.substr( $sql, 7 ); // "SQL_CALC_FOUND_ROWS" available since MySQL 4
			}
		}

		parent::Results( $sql, 'archivelist_', '', $limit );

		$this->restart();
	}


	/**
	 * Count the number of rows of the SQL result
	 *
	 * These queries are complex enough for us not to have to rewrite them:
	 * dh> ???
	 */
	function count_total_rows()
	{
		global $DB;

		switch( $this->archive_mode )
		{
			case 'monthly':
				// ------------------------------ MONTHLY ARCHIVES ------------------------------------
				$sql_count = 'SELECT COUNT( DISTINCT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart), EXTRACT(MONTH FROM '.$this->dbprefix.'datestart) ) '
													.$this->from
													.$this->where;
				break;

			case 'daily':
				// ------------------------------- DAILY ARCHIVES -------------------------------------
				$sql_count = 'SELECT COUNT( DISTINCT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart), EXTRACT(MONTH FROM '.$this->dbprefix.'datestart),
																	EXTRACT(DAY FROM '.$this->dbprefix.'datestart) ) '
													.$this->from
													.$this->where;
				break;

			case 'weekly':
				// ------------------------------- WEEKLY ARCHIVES -------------------------------------
				$sql_count = 'SELECT COUNT( DISTINCT EXTRACT(YEAR FROM '.$this->dbprefix.'datestart), '
													.$DB->week( $this->dbprefix.'datestart', locale_startofweek() ).' ) '
													.$this->from
													.$this->where;
				break;

			case 'postbypost':
			default:
				// ----------------------------- POSY BY POST ARCHIVES --------------------------------
				$sql_count = 'SELECT COUNT( DISTINCT '.$this->dbIDname.' ) '
													.$this->from
													.$this->where
													.$this->group_by;
		}

		// echo $sql_count;

		$this->total_rows = $DB->get_var( $sql_count ); //count total rows

		// echo 'total rows='.$this->total_rows;
	}


	/**
	 * Rewind resultset
	 */
	function restart()
	{
		// Make sure query has executed at least once:
		$this->query();

		$this->current_idx = 0;
		$this->arc_w_last = '';
	}

	/**
	 * Getting next item in archive list
	 *
	 * WARNING: these are *NOT* Item objects!
	 */
	function get_item( & $arc_year, & $arc_month, & $arc_dayofmonth, & $arc_w, & $arc_count, & $post_ID, & $post_title, & $permalink )
	{
		// echo 'getting next item<br />';

		if( $this->current_idx >= $this->result_num_rows )
		{	// No more entry
			return false;
		}

		$arc_row = $this->rows[ $this->current_idx++ ];

		switch( $this->archive_mode )
		{
			case 'monthly':
				$arc_year  = $arc_row->year;
				$arc_month = $arc_row->month;
				$arc_count = $arc_row->count;
				return true;

			case 'daily':
				$arc_year  = $arc_row->year;
				$arc_month = $arc_row->month;
				$arc_dayofmonth = $arc_row->day;
				$arc_count = $arc_row->count;
				return true;

			case 'weekly':
				$arc_year  = $arc_row->year;
				$arc_w = $arc_row->week;
				$arc_count = $arc_row->count;
				return true;

			case 'postbypost':
			default:
				$post_ID = $arc_row->ID;
				$post_title = $arc_row->title;
				$permalink = $arc_row->get_permanent_url();
				return true;
		}
	}
}




/*
 * $Log: _archives.plugin.php,v $
 * Revision 1.63  2011/09/04 22:13:23  fplanque
 * copyright 2011
 *
 * Revision 1.62  2010/02/08 17:55:47  efy-yury
 * copyright 2009 -> 2010
 *
 * Revision 1.61  2010/01/30 18:55:36  blueyed
 * Fix "Assigning the return value of new by reference is deprecated" (PHP 5.3)
 *
 * Revision 1.60  2009/09/14 14:10:46  efy-arrin
 * Included the ClassName in load_class() call with proper UpperCase
 *
 * Revision 1.59  2009/09/14 10:45:39  efy-arrin
 * Included the ClassName in load_class() call with proper UpperCase
 *
 * Revision 1.58  2009/09/01 02:58:02  waltercruz
 * A better fix
 *
 * Revision 1.57  2009/09/01 01:25:43  waltercruz
 * Trying to fix the limit bug, but I think that there's still something stra nge
 *
 * Revision 1.56  2009/08/27 11:54:40  tblue246
 * General blog settings: Added default value for archives_sort_order
 *
 * Revision 1.55  2009/08/10 17:15:25  waltercruz
 * Adding permalinks on postbypost archive mode and adding a button to set the sort order on postbypost mode
 *
 * Revision 1.54  2009/08/03 13:30:15  tblue246
 * Make title of Archives widget editable. Fixes http://forums.b2evolution.net//viewtopic.php?p=94788
 *
 * Revision 1.53  2009/07/05 16:39:10  sam2kb
 * "Limit" to "Max items"
 *
 * Revision 1.52  2009/07/04 22:47:47  tblue246
 * Archives widget: Do not display sidebar links
 *
 * Revision 1.51  2009/06/24 18:47:54  tblue246
 * Make widget plugin names translatable
 *
 * Revision 1.50  2009/05/26 22:18:23  fplanque
 * fix limit (and make it configurable)
 *
 * Revision 1.49  2009/03/08 23:57:47  fplanque
 * 2009
 *
 * Revision 1.48  2009/02/26 22:16:54  blueyed
 * Use load_class for classes (.class.php), and load_funcs for funcs (.funcs.php)
 *
 * Revision 1.47  2009/01/21 22:36:35  fplanque
 * Cleaner handling of pages and intros in calendar and archives plugins
 *
 * Revision 1.46  2008/01/21 09:35:38  fplanque
 * (c) 2008
 *
 * Revision 1.45  2007/11/29 21:52:22  fplanque
 * minor
 *
 * Revision 1.44  2007/11/25 18:20:37  fplanque
 * additional SEO settings
 *
 * Revision 1.43  2007/06/25 11:02:31  fplanque
 * MODULES (refactored MVC)
 *
 * Revision 1.42  2007/05/14 02:43:06  fplanque
 * Started renaming tables. There probably won't be a better time than 2.0.
 *
 * Revision 1.41  2007/05/07 18:03:27  fplanque
 * cleaned up skin code a little
 *
 * Revision 1.40  2007/05/04 01:55:59  waltercruz
 * Changing the MySQL date functions to the standart ones.
 * Adding a sort_order parameter to archives plugins, to be used in postbypost mode, with two options: date (posts sorted by date DESC) and title (posts sorted by title ASC).
 *
 * Revision 1.39  2007/04/26 00:11:04  fplanque
 * (c) 2007
 *
 * Revision 1.38  2007/03/25 10:20:02  fplanque
 * cleaned up archive urls
 *
 * Revision 1.37  2007/01/13 18:36:24  fplanque
 * renamed "Skin Tag" plugins into "Widget" plugins
 * but otherwise they remain basically the same & compatible
 *
 * Revision 1.36  2007/01/13 16:55:00  blueyed
 * Removed $DB member of Results class and use global $DB instead
 *
 * Revision 1.35  2006/12/26 03:19:12  fplanque
 * assigned a few significant plugin groups
 *
 * Revision 1.34  2006/12/04 19:41:11  fplanque
 * Each blog can now have its own "archive mode" settings
 *
 * Revision 1.33  2006/11/24 18:27:27  blueyed
 * Fixed link to b2evo CVS browsing interface in file docblocks
 *
 * Revision 1.32  2006/11/02 19:49:22  fplanque
 * no message
 *
 * Revision 1.31  2006/10/26 19:04:07  blueyed
 * Make the SQL fix work..
 *
 * Revision 1.30  2006/10/25 22:27:44  blueyed
 * Fix for MySQL bug
 *
 * Revision 1.29  2006/09/10 20:59:19  fplanque
 * extended extra path info setting
 *
 * Revision 1.28  2006/08/29 00:26:11  fplanque
 * Massive changes rolling in ItemList2.
 * This is somehow the meat of version 2.0.
 * This branch has gone officially unstable at this point! :>
 *
 * Revision 1.27  2006/07/10 20:19:30  blueyed
 * Fixed PluginInit behaviour. It now gets called on both installed and non-installed Plugins, but with the "is_installed" param appropriately set.
 *
 * Revision 1.26  2006/07/08 12:33:50  blueyed
 * Fixed regression with Results' class adding an additional ORDER column to ItemList2's query
 *
 * Revision 1.25  2006/07/07 21:26:49  blueyed
 * Bumped to 1.9-dev
 *
 * Revision 1.24  2006/06/20 00:53:07  blueyed
 * require results class (through global)!
 *
 * Revision 1.23  2006/06/20 00:38:42  blueyed
 * require results class!
 *
 * Revision 1.22  2006/06/16 21:30:57  fplanque
 * Started clean numbering of plugin versions (feel free do add dots...)
 *
 * Revision 1.21  2006/05/30 19:39:55  fplanque
 * plugin cleanup
 *
 * Revision 1.20  2006/04/19 20:14:03  fplanque
 * do not restrict to :// (does not catch subdomains, not even www.)
 *
 * Revision 1.19  2006/03/12 23:09:27  fplanque
 * doc cleanup
 *
 * Revision 1.18  2006/02/05 19:04:49  blueyed
 * doc fixes
 *
 * Revision 1.17  2006/02/05 14:07:18  blueyed
 * Fixed 'postbypost' archive mode.
 *
 * Revision 1.16  2006/01/04 20:34:51  fplanque
 * allow filtering on extra statuses
 *
 * Revision 1.15  2005/12/22 23:13:40  blueyed
 * Plugins' API changed and handling optimized
 *
 * Revision 1.14  2005/12/12 19:22:04  fplanque
 * big merge; lots of small mods; hope I didn't make to many mistakes :]
 *
 * Revision 1.13  2005/11/01 17:47:37  yabs
 * minor corrections to postbypost
 *
 * Revision 1.12  2005/10/03 18:10:08  fplanque
 * renamed post_ID field
 *
 * Revision 1.11  2005/09/14 19:23:45  fplanque
 * doc
 *
 * Revision 1.10  2005/09/06 19:38:29  fplanque
 * bugfixes
 *
 * Revision 1.9  2005/09/06 17:14:12  fplanque
 * stop processing early if referer spam has been detected
 *
 * Revision 1.8  2005/09/01 17:11:46  fplanque
 * no message
 *
 *
 * Merged in the contents of _archivelist.class.php; history below:
 *
 * Revision 1.11  2005/06/10 18:25:43  fplanque
 * refactoring
 *
 * Revision 1.10  2005/05/24 15:26:52  fplanque
 * cleanup
 *
 * Revision 1.9  2005/03/08 20:32:07  fplanque
 * small fixes; slightly enhanced WEEK() handling
 *
 * Revision 1.8  2005/03/07 17:36:10  fplanque
 * made more generic
 *
 * Revision 1.7  2005/02/28 09:06:32  blueyed
 * removed constants for DB config (allows to override it from _config_TEST.php), introduced EVO_CONFIG_LOADED
 *
 * Revision 1.6  2005/01/03 15:17:52  fplanque
 * no message
 *
 * Revision 1.5  2004/12/27 18:37:58  fplanque
 * changed class inheritence
 *
 * Changed parent to Results!!
 *
 * Revision 1.4  2004/12/13 21:29:58  fplanque
 * refactoring
 *
 * Revision 1.3  2004/11/09 00:25:11  blueyed
 * minor translation changes (+MySQL spelling :/)
 *
 * Revision 1.2  2004/10/14 18:31:24  blueyed
 * granting copyright
 *
 * Revision 1.1  2004/10/13 22:46:32  fplanque
 * renamed [b2]evocore/*
 *
 * Revision 1.19  2004/10/11 19:02:04  fplanque
 * Edited code documentation.
 *
 */
?>
