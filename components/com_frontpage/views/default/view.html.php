<?php 
/**
* @version		$Id: view.html.php 182 2014-02-08 18:34:48Z michel $
* @package		Frontpage
* @subpackage 	Views
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

 
class FrontpageViewDefault  extends JViewLegacy 
{
/**
	 * Display the view
	 */
	public function display($tpl = null)
	{

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));

			return false;
		}
		
		//Get Params 	
		$this->params = JComponentHelper::getParams('com_frontpage');
		
		parent::display($tpl);	
	}
}
?>