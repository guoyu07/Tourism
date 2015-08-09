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

/**
 * K2 route helper class.
 */
class K2HelperRoute
{

	private static $cache = array('item' => array(), 'category' => array(), 'user' => array(), 'tag' => array());

	private static $languages = array();

	private static $defaultItemidLegacy = false;

	public static function getItemRoute($id, $category, $language = 0)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get component menu links
		$component = JComponentHelper::getComponent('com_k2');
		$params = JComponentHelper::getParams('com_k2');
		$menu = $application->getMenu('site');
		$items = $menu->getItems('component_id', $component->id);

		// Initialze route
		$route = 'index.php?option=com_k2&view=item&id='.$id;

		// Append language variable if required
		if ($language && $language != '*' && JLanguageMultilang::isEnabled())
		{
			self::getLanguages();

			if (isset(self::$languages[$language]))
			{
				$route .= '&lang='.self::$languages[$language];
			}
		}

		// Cast variables
		$id = (int)$id;
		$category = (int)$category;

		// Search only if we have not the item in our cache
		if (!isset(self::$cache['item'][$id]))
		{
			// Initialize Itemid
			$defaultItemid = 0;
			if ($params->get('k2SefMode', 'legacy') != 'legacy')
			{
				$defaultItemid = (int)$params->get('k2SefPrefixItem');
			}
			else
			{
				$defaultItemid = (int)self::getDefaultItemidLegacy();
			}
			if ($params->get('k2Sef') && $defaultItemid)
			{
				$Itemid = $defaultItemid;
			}
			else
			{
				$Itemid = '';
			}
			// Search the menu
			foreach ($items as $item)
			{
				if (isset($item->query['view']) && $item->query['view'] == 'item' && isset($item->query['id']) && $item->query['id'] == $id)
				{
					$Itemid = $item->id;
					break;
				}
			}

			// If we do not have menu link to the item search for a menu link to it's category
			if (!$Itemid || $Itemid == $defaultItemid)
			{
				foreach ($items as $item)
				{
					if (isset($item->query['view']) && $item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'category' && isset($item->query['id']) && $item->query['id'] == $category)
					{
						$Itemid = $item->id;
						break;
					}
				}
			}

			// Second pass for menu links to multiple categories
			if (!$Itemid || $Itemid == $defaultItemid)
			{
				foreach ($items as $item)
				{
					if (isset($item->query['view']) && $item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'category' && !isset($item->query['id']))
					{
						// Get menu link categories
						$filter = $item->params->get('categories');
						if (isset($filter->categories) && is_array($filter->categories) && in_array($category, $filter->categories))
						{
							$Itemid = $item->id;
							break;
						}
					}
				}
			}

			// Add what we found to cache
			self::$cache['item'][$id] = $Itemid;
		}

		// Append what we have found
		$route .= '&Itemid='.self::$cache['item'][$id];

		return $route;
	}

	public static function getCategoryRoute($id, $language = 0)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get component menu links
		$component = JComponentHelper::getComponent('com_k2');
		$params = JComponentHelper::getParams('com_k2');
		$menu = $application->getMenu('site');
		$items = $menu->getItems('component_id', $component->id);

		// Initialze route
		$route = 'index.php?option=com_k2&view=itemlist&task=category&id='.$id;

		// Append language variable if required
		if ($language && $language != '*' && JLanguageMultilang::isEnabled())
		{
			self::getLanguages();

			if (isset(self::$languages[$language]))
			{
				$route .= '&lang='.self::$languages[$language];
			}
		}

		// Cast variables
		$id = (int)$id;

		// Search only if we have not the item in our cache
		if (!isset(self::$cache['category'][$id]))
		{
			// Initialize Itemid
			$defaultItemid = 0;
			if ($params->get('k2SefMode', 'legacy') != 'legacy')
			{
				$defaultItemid = (int)$params->get('k2SefPrefixCat');
			}
			else
			{
				$defaultItemid = (int)self::getDefaultItemidLegacy();
			}
			if ($params->get('k2Sef') && $defaultItemid)
			{
				$Itemid = $defaultItemid;
			}
			else
			{
				$Itemid = '';
			}

			// If we do not have menu link to the item search for a menu link to it's category
			foreach ($items as $item)
			{
				if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'category' && isset($item->query['id']) && $item->query['id'] == $id)
				{
					$Itemid = $item->id;
					break;
				}
			}

			// Second pass for menu links to multiple categories
			if (!$Itemid || $Itemid == $defaultItemid)
			{
				foreach ($items as $item)
				{
					if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'category' && !isset($item->query['id']))
					{
						// Get menu link categories
						$filter = $item->params->get('categories');
						if (isset($filter->categories) && is_array($filter->categories) && in_array($id, $filter->categories))
						{
							$Itemid = $item->id;
							break;
						}
					}
				}
			}

			// Add what we found to cache
			self::$cache['category'][$id] = $Itemid;
		}

		// Append what we have found
		$route .= '&Itemid='.self::$cache['category'][$id];

		return $route;

	}

	public static function getUserRoute($id)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get component menu links
		$component = JComponentHelper::getComponent('com_k2');
		$params = JComponentHelper::getParams('com_k2');
		$menu = $application->getMenu('site');
		$items = $menu->getItems('component_id', $component->id);

		// Initialze route
		$route = 'index.php?option=com_k2&view=itemlist&task=user&id='.$id;

		// Cast variables
		$id = (int)$id;

		// Search only if we have not the item in our cache
		if (!isset(self::$cache['user'][$id]))
		{
			// Initialize Itemid
			$defaultItemid = 0;
			if ($params->get('k2SefMode', 'legacy') != 'legacy')
			{
				$defaultItemid = (int)$params->get('k2SefPrefixUser');
			}
			else
			{
				$defaultItemid = (int)self::getDefaultItemidLegacy();
			}
			if ($params->get('k2Sef') && $defaultItemid)
			{
				$Itemid = $defaultItemid;
			}
			else
			{
				$Itemid = '';
			}

			// If we do not have menu link to the item search for a menu link to it's category
			foreach ($items as $item)
			{
				if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'user' && $item->query['id'] == $id)
				{
					$Itemid = $item->id;
					break;
				}
			}

			// Add what we found to cache
			self::$cache['user'][$id] = $Itemid;
		}

		// Append what we have found
		$route .= '&Itemid='.self::$cache['user'][$id];

		return $route;

	}

	public static function getTagRoute($id)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get component menu links
		$component = JComponentHelper::getComponent('com_k2');
		$params = JComponentHelper::getParams('com_k2');
		$menu = $application->getMenu('site');
		$items = $menu->getItems('component_id', $component->id);

		// Initialze route
		$route = 'index.php?option=com_k2&view=itemlist&task=tag&id='.$id;

		// Cast variables
		$id = (int)$id;

		// Search only if we have not the item in our cache
		if (!isset(self::$cache['tag'][$id]))
		{
			// Initialize Itemid
			if ($params->get('k2SefMode', 'legacy') != 'legacy')
			{
				$defaultItemid = (int)$params->get('k2SefPrefixTag');
			}
			else
			{
				$defaultItemid = (int)self::getDefaultItemidLegacy();
			}
			if ($params->get('k2Sef') && $defaultItemid)
			{
				$Itemid = $defaultItemid;
			}
			else
			{
				$Itemid = '';
			}

			// If we do not have menu link to the item search for a menu link to it's category
			foreach ($items as $item)
			{
				if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'tag' && isset($item->query['id']) && $item->query['id'] == $id)
				{
					$Itemid = $item->id;
					break;
				}
			}

			// Add what we found to cache
			self::$cache['tag'][$id] = $Itemid;
		}

		// Append what we have found
		$route .= '&Itemid='.self::$cache['tag'][$id];

		return $route;
	}

	public static function getDateRoute($year, $month, $day = null, $category = null)
	{
		$params = JComponentHelper::getParams('com_k2');
		$route = 'index.php?option=com_k2&view=itemlist&task=date&year='.$year.'&month='.$month;
		if ($day)
		{
			$route .= '&day='.$day;
		}
		if ($category)
		{
			$route .= '&category='.$category;
		}
		$defaultItemid = (int)$params->get('k2SefPrefixDate');
		if ($params->get('k2Sef') && $defaultItemid)
		{
			$Itemid = $defaultItemid;
		}
		else
		{
			$Itemid = '';
		}
		$route .= '&Itemid='.$Itemid;
		return $route;
	}

	public static function getSearchRoute()
	{
		// Get application
		$application = JFactory::getApplication();

		// Get component menu links
		$component = JComponentHelper::getComponent('com_k2');
		$menu = $application->getMenu('site');
		$items = $menu->getItems('component_id', $component->id);

		// Initialze route
		$route = 'index.php?option=com_k2&view=itemlist&task=search';

		// Search only if we have not the item in our cache
		if (!isset(self::$cache['search']))
		{
			// Initialize Itemid
			$Itemid = '';

			// If we do not have menu link to the item search for a menu link to it's category
			foreach ($items as $item)
			{
				if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && $item->query['task'] == 'search')
				{
					$Itemid = $item->id;
					break;
				}
			}

			// Add what we found to cache
			self::$cache['search'] = $Itemid;
		}

		// Append what we have found
		$route .= '&Itemid='.self::$cache['search'];

		return $route;
	}

	private static function getLanguages()
	{
		if (count(self::$languages) == 0)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true)->select('a.sef AS sef')->select('a.lang_code AS lang_code')->from('#__languages AS a');
			$db->setQuery($query);
			$languages = $db->loadObjectList();
			foreach ($languages as $language)
			{
				self::$languages[$language->lang_code] = $language->sef;
			}
		}
	}

	private static function getDefaultItemidLegacy()
	{
		if (self::$defaultItemidLegacy === false)
		{
			self::$defaultItemidLegacy = null;

			// Get application
			$application = JFactory::getApplication();

			// Get component menu links
			$component = JComponentHelper::getComponent('com_k2');
			$params = JComponentHelper::getParams('com_k2');
			$menu = $application->getMenu('site');
			$items = $menu->getItems('component_id', $component->id);

			foreach ($items as $item)
			{
				if ($item->query['view'] == 'itemlist' && isset($item->query['task']) && ($item->query['task'] == 'category' || $item->query['task'] == '') && (!isset($item->query['id']) || $item->query['id'] == ''))
				{
					$menuparams = json_decode($item->params);
					$filter = isset($menuparams->categories) ? $menuparams->categories : new stdClass;
					if (!$filter->enabled || count($filter->categories) == 0)
					{
						self::$defaultItemidLegacy = $item->id;
						break;
					}

				}
			}

		}
		return self::$defaultItemidLegacy;
	}

}
