<?php
/**
 * This file implements the Chapter form
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2011 by Francois Planque - {@link http://fplanque.com/}
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
 * @package admin
 *
 * @version $Id: _chapter.form.php,v 1.14 2011/09/04 22:13:13 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * @var Chapter
 */
global $edited_GenericCategory;
/**
 * @var Chapter
 */
$edited_Chapter = & $edited_GenericCategory;

/**
 * @var GenericCategoryCache
 */
global $GenericCategoryCache;

global $Settings, $action, $subset_ID;

// Determine if we are creating or updating...
$creating = is_create_action( $action );

$Form = new Form( NULL, 'form' );

$Form->global_icon( T_('Cancel editing!'), 'close', regenerate_url( 'action' ) );

$Form->begin_form( 'fform', $creating ?  T_('New category') : T_('Category') );

$Form->add_crumb( 'element' );
$Form->hidden( 'action', $creating ? 'create' : 'update' );
$Form->hiddens_by_key( get_memorized( 'action' ) );

$Form->begin_fieldset( T_('Properties') );

	// We're essentially double checking here...
	$edited_Blog = & $edited_Chapter->get_Blog();
	$move = '';
	if( $Settings->get('allow_moving_chapters') && ( ! $creating ) )
	{ // If moving cats between blogs is allowed:
		$move = ' '.action_icon( T_('Move to a different blog...'), 'file_move', regenerate_url( 'action,cat_ID', 'cat_ID='.$edited_Chapter->ID.'&amp;action=move' ), T_('Move') );
	}
	$Form->info( T_('Blog'), $edited_Blog->get_maxlen_name().$move );

	$Form->select_input_options( 'cat_parent_ID',
				$GenericCategoryCache->recurse_select( $edited_Chapter->parent_ID, $subset_ID, true, NULL, 0, array($edited_Chapter->ID) ), T_('Parent category') );

	$Form->text_input( 'cat_name', $edited_Chapter->name, 40, T_('Name'), '', array( 'required' => true, 'maxlength' => 255 ) );

	$Form->text_input( 'cat_urlname', $edited_Chapter->urlname, 40, T_('URL "slug"'), T_('Used for clean URLs. Must be unique.'), array( 'maxlength' => 255 ) );

	$Form->text_input( 'cat_description', $edited_Chapter->description, 40, T_('Description'), T_('May be used as a title tag and/or meta description'), array( 'maxlength' => 255 ) );

	if( $Settings->get('chapter_ordering') == 'manual' )
	{
		$Form->text_input( 'cat_order', $edited_Chapter->order, 5, T_('Order'), T_('For manual ordering of the categories'), array( 'maxlength' => 11 ) );
	}

$Form->end_fieldset();

if( $creating )
{
	$Form->end_form( array( array( 'submit', 'submit', T_('Record'), 'SaveButton' ),
													array( 'reset', '', T_('Reset'), 'ResetButton' ) ) );
}
else
{
	$Form->end_form( array( array( 'submit', 'submit', T_('Update'), 'SaveButton' ),
													array( 'reset', '', T_('Reset'), 'ResetButton' ) ) );
}


/*
 * $Log: _chapter.form.php,v $
 * Revision 1.14  2011/09/04 22:13:13  fplanque
 * copyright 2011
 *
 * Revision 1.13  2010/09/16 14:35:23  efy-asimo
 * don't show 'move to another blog' icon on create new category page
 *
 * Revision 1.12  2010/02/08 17:52:07  efy-yury
 * copyright 2009 -> 2010
 *
 * Revision 1.11  2010/01/30 18:55:20  blueyed
 * Fix "Assigning the return value of new by reference is deprecated" (PHP 5.3)
 *
 * Revision 1.10  2010/01/03 13:45:38  fplanque
 * set some crumbs (needs checking)
 *
 * Revision 1.9  2009/06/29 02:14:04  fplanque
 * no message
 *
 * Revision 1.8  2009/03/08 23:57:42  fplanque
 * 2009
 *
 * Revision 1.7  2009/01/28 21:23:22  fplanque
 * Manual ordering of categories
 *
 * Revision 1.6  2009/01/22 00:58:00  blueyed
 * Remove required=true for cat slugs text input, since it gets autogenerated now (too bad, that the default(?) admin skin does not display .field_required differently, eh? ;)
 *
 * Revision 1.5  2008/12/28 23:35:51  fplanque
 * Autogeneration of category/chapter slugs(url names)
 *
 * Revision 1.4  2008/12/28 22:55:55  fplanque
 * increase blog name max length to 255 chars
 *
 * Revision 1.3  2008/01/21 09:35:26  fplanque
 * (c) 2008
 *
 * Revision 1.2  2008/01/05 17:54:43  fplanque
 * UI/help improvements
 *
 * Revision 1.1  2007/06/25 10:59:26  fplanque
 * MODULES (refactored MVC)
 *
 * Revision 1.8  2007/04/26 00:11:05  fplanque
 * (c) 2007
 *
 * Revision 1.7  2006/12/11 00:32:26  fplanque
 * allow_moving_chapters stting moved to UI
 * chapters are now called categories in the UI
 *
 * Revision 1.6  2006/12/09 17:59:34  fplanque
 * started "moving chapters accross blogs" feature
 *
 * Revision 1.5  2006/12/09 02:37:44  fplanque
 * Prevent user from creating loops in the chapter tree
 * (still needs a check before writing to DB though)
 *
 * Revision 1.4  2006/12/09 01:55:36  fplanque
 * feel free to fill in some missing notes
 * hint: "login" does not need a note! :P
 *
 * Revision 1.3  2006/11/24 18:27:25  blueyed
 * Fixed link to b2evo CVS browsing interface in file docblocks
 */
?>