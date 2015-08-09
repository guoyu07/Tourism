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

require_once JPATH_ADMINISTRATOR.'/components/com_k2/views/view.php';

/**
 * Tags JSON view.
 */

class K2ViewTags extends K2View
{

	/**
	 * Builds the response variables needed for rendering a list.
	 * Usually there will be no need to override this function.
	 *
	 * @return void
	 */

	public function show()
	{
		// Set title
		$this->setTitle('K2_TAGS');

		// Set user states
		$this->setUserStates();

		// Set pagination
		$this->setPagination();

		// Set rows
		$this->setRows();

		// Set filters
		$this->setFilters();

		// Set toolbar
		$this->setToolbar();

		// Set menu
		$this->setMenu();

		// Set Actions
		$this->setListActions();

		// Render
		parent::render();
	}

	/**
	 * Builds the response variables needed for rendering a form.
	 * Usually there will be no need to override this function.
	 *
	 * @param integer $id	The id of the resource to load.
	 *
	 * @return void
	 */

	public function edit($id = null)
	{
		// Set title
		$this->setTitle($id ? 'K2_EDIT_TAG' : 'K2_ADD_TAG');

		// Set row
		$this->setRow($id);

		// Set form
		$this->setForm();

		// Set menu
		$this->setMenu('edit');

		// Set Actions
		$this->setFormActions();

		// Render
		parent::render();
	}

	protected function setUserStates()
	{
		$this->setUserState('limit', 10, 'int');
		$this->setUserState('page', 1, 'int');
		$this->setUserState('search', '', 'string');
		$this->setUserState('state', '', 'cmd');
		$this->setUserState('sorting', '', 'string');
	}

	protected function setFilters()
	{

		// Sorting filter
		$sortingOptions = array('K2_NONE' => '', 'K2_ID_ASC' => 'id', 'K2_ID_DESC' => 'id.reverse', 'K2_NAME_ASC' => 'name', 'K2_NAME_DESC' => 'name.reverse', 'K2_STATE_ASC' => 'state', 'K2_STATE_DESC' => 'state.reverse');
		K2Response::addFilter('sorting', JText::_('K2_SORT_BY'), K2HelperHTML::sorting($sortingOptions), false, 'header');

		// Search filter
		K2Response::addFilter('search', JText::_('K2_SEARCH'), K2HelperHTML::search(), false, 'sidebar');

		// State filter
		K2Response::addFilter('state', JText::_('K2_STATE'), K2HelperHTML::state('state', null, 'K2_ANY', false), true, 'sidebar');

	}

	protected function setToolbar()
	{
		K2Response::addToolbarAction('publish', 'K2_PUBLISH', array('data-state' => 'state', 'data-value' => '1', 'data-action' => 'set-state'));
		K2Response::addToolbarAction('unpublish', 'K2_UNPUBLISH', array('data-state' => 'state', 'data-value' => '0', 'data-action' => 'set-state'));

		K2Response::addToolbarAction('remove', 'K2_DELETE', array('data-action' => 'remove'));
	}

	protected function setFormFields(&$form, $row)
	{
		require_once JPATH_ADMINISTRATOR.'/components/com_k2/helpers/html.php';
		$form->state = K2HelperHTML::state('state', $row->state, false, false, 'radio', true);
		require_once JPATH_ADMINISTRATOR.'/components/com_k2/helpers/extrafields.php';
		$form->extraFields = K2HelperExtraFields::getTagExtraFieldsGroups($row->extra_fields);
	}

	/**
	 * Hook for children views to allow them set the menu for the list requests.
	 * Children views usually will not need to override this method.
	 *
	 * @return void
	 */
	protected function setListActions()
	{
		$user = JFactory::getUser();
		if ($user->authorise('k2.tags.manage', 'com_k2'))
		{
			K2Response::addAction('add', 'K2_ADD', array('data-action' => 'add'));
		}
	}

	protected function prepareRows($rows)
	{
		foreach ($rows as $row)
		{
			$row->items = $row->getItems();
		}
	}

	protected function prepareRow($row)
	{
		// State
		if (!$row->id)
		{
			$row->state = 1;
		}
	}

}
