 <?php
/**
* @version		$Id$ $Revision$ $Date$ $Author$ $
* @package		Frontpage
* @subpackage 	Models
* @copyright	Copyright (C) 2015, .
* @license #
*/

// 

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');
/**
 * Methods supporting a list of contact records.
 *
 * @package     Joomla.Site
 * @subpackage  Frontpage
 */
class FrontpageModelitems extends JModelList
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
	          	          'id', 'a.id',
	          	          'title', 'a.title',
	          	          'alias', 'a.alias',
	          	          'catid', 'a.catid',
	          	          'published', 'a.published',
	          	          'language', 'a.language',
	          	          'created', 'a.created',
	          	          'created_by', 'a.created_by',
	          	          'created_by_alias', 'a.created_by_alias',
	          	          'modified', 'a.modified',
	          	          'modified_by', 'a.modified_by',
	          	          'checked_out_time', 'a.checked_out_time',
	          	          'checked_out', 'a.checked_out',
	          	          'access', 'a.access',
	          	          'publish_up', 'a.publish_up',
	          	          'publish_down', 'a.publish_down',
	          	          'params', 'a.params',
	          	          'ordering', 'a.ordering',
	          	          'introtext', 'a.introtext',
	          	          'fulltext', 'a.fulltext',
	          	          'video', 'a.video',
	          	          'gallery', 'a.gallery',
	          	          'extra_fields', 'a.extra_fields',
	          	          'extra_fields_search', 'a.extra_fields_search',
	          	          'trash', 'a.trash',
	          	          'featured', 'a.featured',
	          	          'featured_ordering', 'a.featured_ordering',
	          	          'image_caption', 'a.image_caption',
	          	          'image_credits', 'a.image_credits',
	          	          'video_caption', 'a.video_caption',
	          	          'video_credits', 'a.video_credits',
	          	          'hits', 'a.hits',
	          	          'metadesc', 'a.metadesc',
	          	          'metadata', 'a.metadata',
	          	          'metakey', 'a.metakey',
	          	          'plugins', 'a.plugins',
	          	          'id', 'a.id',
	          			);

			$app = JFactory::getApplication();

		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
	
		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState('a.title', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id    A prefix for the store id.
	 *
	 * @return  string  A store id.
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		
		$id .= ':' . $this->getState('filter.published');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$user = JFactory::getUser();
		$app = JFactory::getApplication();

		$select_fields = $this->getState('list.select', 'a.*'); 
		
		// Select the required fields from the table.
		$query->select( $select_fields);
		
		$query->from('#__k2_items AS a');

	
		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}
	
   
		// Filter by search in name.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$query->where('LOWER(a.name) LIKE ' . $this->_db->Quote('%' . $search . '%'));		
		}


		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.title');
		$orderDirn = $this->state->get('list.direction', 'asc');
		
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}
}
 