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

switch ($params->get('usage'))
{
	case 'archive' :
		$months = ModK2ToolsHelper::getArchive($params);
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'archive');
		break;

	case 'authors' :
		$authors = ModK2ToolsHelper::getAuthors($params);
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'authors');
		break;

	case 'calendar' :
		$calendar = ModK2ToolsHelper::getCalendar($params);
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'calendar');
		break;

	case 'breadcrumbs' :
		$breadcrumbs = ModK2ToolsHelper::getBreadcrumbs($params);
		// Legacy
		$path = array();
		foreach ($breadcrumbs->path as $entry)
		{
			$path[] = '<a href="'.$entry->link.'">'.$entry->title.'</a>';
		}
		$title = $breadcrumbs->title;
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'breadcrumbs');
		break;

	case 'categories' :
	
		$categories = ModK2ToolsHelper::getCategories($params, 'default');
		
		// Legacy
		ob_start();
		require JPATH_SITE.'/modules/mod_k2_tools/tmpl/categories.php';
		$output = ob_get_contents();
		ob_end_clean();
		
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'categories');
		break;

	case 'categoriesList' :
		$categories = ModK2ToolsHelper::getCategories($params, 'selectbox');
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'categories_select');
		break;

	case 'search' :
		$search = ModK2ToolsHelper::getSearch($params);
		// Legacy
		$action = $search->action;
		$categoryFilter = $search->filter;
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'search');
		break;

	case 'tags' :
		$tags = ModK2ToolsHelper::getTagCloud($params);
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'tags');
		break;

	case 'custom' :
		$customcode = ModK2ToolsHelper::getCustomCode($params);
		require JModuleHelper::getLayoutPath('mod_k2_tools', 'customcode');
		break;
}
