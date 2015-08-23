<?php
/**
 * @version     1.0.0
 * @package     com_contacts
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid <faridv@gmail.com> - http://www.faridr.ir
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

// Execute the task.
$controller	= JControllerLegacy::getInstance('Contacts');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
