<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;

require_once dirname(__FILE__).'/helper.php';
include dirname(__FILE__).'/legacy.php';

switch($params->get('usage'))
{
	case 'comments' :
		$comments = modK2CommentsHelper::getLatestComments($params);
		require JModuleHelper::getLayoutPath('mod_k2_comments', 'comments');
		break;

	case 'commenters' :
		$commenters = modK2CommentsHelper::getTopCommenters($params);
		require JModuleHelper::getLayoutPath('mod_k2_comments', 'commenters');
		break;
}
