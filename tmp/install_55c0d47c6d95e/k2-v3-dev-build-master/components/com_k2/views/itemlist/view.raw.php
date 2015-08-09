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

require_once JPATH_SITE.'/components/com_k2/views/view.php';

/**
 * K2 itemlist view class
 */

class K2ViewItemlist extends K2View
{
	public function display($tpl = null)
	{
		// Get application
		$application = JFactory::getApplication();

		// Get input
		$task = $application->input->get('task', '', 'cmd');
		$this->offset = $application->input->get('limitstart', 0, 'int');
		$this->limit = $application->input->get('limit', 10, 'int');

		// Trigger the corresponding method
		if (method_exists($this, $task))
		{
			call_user_func(array($this, $task));
		}
		else
		{
			throw new Exception(JText::_('K2_NOT_FOUND'), 404);
		}

		// Generate the view params depedning on the task prefix. This let's us have one common layout file for listing items
		$this->generateItemlistParams($task);

		// Load the comments counters in a single query for all items
		if ($this->params->get('comments'))
		{
			K2Items::countComments($this->items);
		}

		// Plugins
		foreach ($this->items as $item)
		{
			$item->events = $item->getEvents('com_k2.itemlist.'.$task, $this->params, $this->offset);
		}

		// Pagination
		jimport('joomla.html.pagination');
		$this->pagination = new JPagination($this->total, $this->offset, $this->limit);

		// Display
		parent::display($tpl);
	}

	private function category()
	{
		// Get and count items using parent function
		$this->getCategoryItems(true);

		if (isset($this->category))
		{
			// Get children
			if ($this->params->get('subCategories'))
			{
				$this->category->children = $this->category->getChildren();
			}

			// Add the template path
			$this->addTemplatePath(JPATH_SITE.'/components/com_k2/templates/'.$this->category->template);
			$this->addTemplatePath(JPATH_SITE.'/templates/'.JFactory::getApplication()->getTemplate().'/html/com_k2/'.$this->category->template);
		}

		// Set the layout
		$this->setLayout('category');
	}

	private function user()
	{
		// Get and count items using parent function
		$this->getUserItems(true);

		// Set the layout
		$this->setLayout('user');
	}

	private function tag()
	{
		// Get and count items using parent function
		$this->getTagItems(true);

		// Set the layout
		$this->setLayout('tag');

	}

	private function date()
	{
		// Get and count items using parent function
		$this->getDateItems(true);

		// Set the layout
		$this->setLayout('date');

	}

	private function search()
	{
		// Get and count items using parent function
		$this->getSearchItems(true);

		// Set the layout
		$this->setLayout('search');
	}

}
