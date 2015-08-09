 <?php
/**
* @version		$Id:default.php 1 2015-08-08 11:00:56Z  $
* @package		Frontpage
* @subpackage 	Models
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_frontpage/tables');

class FrontpageModelitems extends JModelList
{
	public function __construct($config = array())
	{
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                            'title', 'a.title',
                            'alias', 'a.alias',
                            'gallery', 'a.gallery',
                            'image_credits', 'a.image_credits',
                            'video_credits', 'a.video_credits',
                            'created', 'a.created',
                            'ordering', 'a.ordering',
                            'published', 'a.published',
                            'id', 'a.id',
                        );
        }

		parent::__construct($config);		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
			parent::populateState();
			$app = JFactory::getApplication();
            $config = JFactory::getConfig();
			$id = $app->input->getInt('id', null);
			$this->setState('itemlist.id', $id);			
			
			// Load the filter state.
			$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
			$this->setState('filter.search', $search);

			$app = JFactory::getApplication();
			$value = $app->getUserStateFromRequest('global.list.limit', 'limit', $config->get('list_limit'));
			$limit = $value;
			$this->setState('list.limit', $limit);
			
			$value = $app->getUserStateFromRequest($this->context.'.limitstart', 'limitstart', 0);
			$limitstart = ($limit != 0 ? (floor($value / $limit) * $limit) : 0);
			$this->setState('list.start', $limitstart);
			
			$value = $app->getUserStateFromRequest($this->context.'.ordercol', 'filter_order', $ordering);
			$this->setState('list.ordering', $value);			
						$value = $app->getUserStateFromRequest($this->context.'.orderdirn', 'filter_order_Dir', $direction);
			$this->setState('list.direction', $value);

					$state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
			$this->setState('filter.state', $state);
					
	}
    		
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('itemlist.id');
						$id .= ':' . $this->getState('filter.state');
				return parent::getStoreId($id);
	}	
	
	/**
	 * Method to get a JDatabaseQuery object for retrieving the data set from a database.
	 *
	 * @return	object	A JDatabaseQuery object to retrieve the data set.
	 */
	protected function getListQuery()
	{
		
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.*, '
		. ' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END as slug');

		$query->from('#__k2_items as a');
	
		 				// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search, true) . '%');
				$query->where('(a.title LIKE ' . $search . '  OR a.alias LIKE ' . $search . '  OR a.created_by_alias LIKE ' . $search . '  OR a.gallery LIKE ' . $search . '  OR a.image_credits LIKE ' . $search . '  OR a.video_credits LIKE ' . $search . ' )');
			}
		}
				
		$published = $this->getState('filter.state');
		
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published IN (0, 1))');
		}
		
		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'ordering');
		$orderDirn = $this->state->get('list.direction', 'ASC');
		if(empty($orderCol)) $orderCol = 'ordering';
		if(empty($orderDirn)) $orderDirn = 'DESC'; 		
		$query->order($db->escape($orderCol . ' ' . $orderDirn));
							
		return $query;
	}	
}