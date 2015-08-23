<?php

/**
 * @version     1.0.0
 * @package     com_contacts
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid <faridv@gmail.com> - http://www.faridr.ir
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Contacts.
 */
class ContactsViewContacts extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        ContactsHelper::addSubmenu('contacts');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/contacts.php';

        $state = $this->get('State');
        $canDo = ContactsHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_CONTACTS_TITLE_CONTACTS'), 'contacts.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/contactform';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('contactform.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('contactform.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('contacts.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('contacts.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'contacts.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('contacts.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('contacts.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'contacts.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('contacts.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_contacts');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_contacts&view=contacts');

        $this->extra_sidebar = '';
        
			//Filter for the field created
		$this->extra_sidebar .= '<div class="other-filters">';
			$this->extra_sidebar .= '<small><label for="filter_from_created">'. JText::sprintf('COM_CONTACTS_FROM_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.from'), 'filter_from_created', 'filter_from_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange' => 'this.form.submit();'));
			$this->extra_sidebar .= '<small><label for="filter_to_created">'. JText::sprintf('COM_CONTACTS_TO_FILTER', 'Created') .'</label></small>';
			$this->extra_sidebar .= JHtml::_('calendar', $this->state->get('filter.created.to'), 'filter_to_created', 'filter_to_created', '%Y-%m-%d', array('style' => 'width:142px;', 'onchange'=> 'this.form.submit();'));
		$this->extra_sidebar .= '</div>';
			$this->extra_sidebar .= '<hr class="hr-condensed">';

		//Filter for the field published
		$select_label = JText::sprintf('COM_CONTACTS_FILTER_SELECT_LABEL', 'Published');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "0";
		$options[0]->text = "Unpublished";
		$options[1] = new stdClass();
		$options[1]->value = "1";
		$options[1]->text = "Published";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_published',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.published'), true)
		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.name' => JText::_('COM_CONTACTS_CONTACTS_NAME'),
		'a.email' => JText::_('COM_CONTACTS_CONTACTS_EMAIL'),
		'a.message' => JText::_('COM_CONTACTS_CONTACTS_MESSAGE'),
		'a.created' => JText::_('COM_CONTACTS_CONTACTS_CREATED'),
		'a.published' => JText::_('COM_CONTACTS_CONTACTS_PUBLISHED'),
		);
	}

}
