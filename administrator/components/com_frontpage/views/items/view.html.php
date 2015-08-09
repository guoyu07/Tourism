<?php
/**
* @version		$Id:item.php 1 2015-08-08 11:00:56Z  $
* @package		Frontpage
* @subpackage 	Views
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class FrontpageViewitems  extends JViewLegacy {


	protected $items;

	protected $pagination;

	protected $state;
	
	
	/**
	 *  Displays the list view
 	 * @param string $tpl   
     */
	public function display($tpl = null)
	{
		
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		FrontpageHelper::addSubmenu('items');

		$this->addToolbar();
		if(!version_compare(JVERSION,'3','<')){
			$this->sidebar = JHtmlSidebar::render();
		}
		
		if(version_compare(JVERSION,'3','<')){
			$tpl = "25";
		}
		parent::display($tpl);
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 */
	protected function addToolbar()
	{
		
		$canDo = FrontpageHelper::getActions();
		$user = JFactory::getUser();
		JToolBarHelper::title( JText::_( 'Item' ), 'generic.png' );
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('item.add');
		}	
		
		if (($canDo->get('core.edit')))
		{
			JToolBarHelper::editList('item.edit');
		}
		
				
		if ($this->state->get('filter.state') != 2)
		{
			JToolbarHelper::publish('items.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('items.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}
				
		if ($canDo->get('core.edit.state'))
		{
			if ($this->state->get('filter.state') != -1)
			{
				if ($this->state->get('filter.state') != 2)
				{
					JToolbarHelper::archiveList('items.archive');
				}
				elseif ($this->state->get('filter.state') == 2)
				{
					JToolbarHelper::unarchiveList('items.publish');
				}
			}
			
		}
				
				if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::checkin('items.checkin');
		}
				

		if ($this->state->get('filter.state') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'items.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
				elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('items.trash');
		}		
				
		
		JToolBarHelper::preferences('com_frontpage', '550');  
		if(!version_compare(JVERSION,'3','<')){		
			JHtmlSidebar::setAction('index.php?option=com_frontpage&view=items');
		}
				if(!version_compare(JVERSION,'3','<')){
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_state',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true)
			);
		}
				
					
	}	
	

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
		 	          'a.title' => JText::_('Title'),
	     	          'a.alias' => JText::_('Alias'),
	     	          'a.gallery' => JText::_('Gallery'),
	     	          'a.image_credits' => JText::_('Image_credits'),
	     	          'a.video_credits' => JText::_('Video_credits'),
	     	          'a.created' => JText::_('Created'),
	     	          'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
	     	          'a.published' => JText::_('JSTATUS'),
	     	          'a.id' => JText::_('JGRID_HEADING_ID'),
	     		);
	}	
}
?>
