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

/**
 * Contacts helper.
 */
class ContactsHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_CONTACTS_TITLE_CONTACTS'),
			'index.php?option=com_contacts&view=contacts',
			$vName == 'contacts'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_contacts';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
