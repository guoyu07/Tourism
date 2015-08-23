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

jimport('joomla.application.component.controllerform');

/**
 * Contactform controller class.
 */
class ContactsControllerContactform extends JControllerForm
{

    function __construct() {
        $this->view_list = 'contacts';
        parent::__construct();
    }

}