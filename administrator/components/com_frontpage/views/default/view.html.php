<?php 
/**
* @version		$Id: view.html.php 183 2014-02-17 16:17:50Z michel $
* @package		Frontpage
* @subpackage 	Views
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jjimport('joomla.application.component.view');


class FrontpageViewDefault  extends JViewLegacy {


	/**
     *  Displays the list view
     * @param string $tpl
     */
	public function display($tpl = null)
{


    // Check for errors.
    if (count($errors = $this->get('Errors')))
    {
        JError::raiseError(500, implode("\n", $errors));
        return false;
    }

    parent::display($tpl);
}
}
?>