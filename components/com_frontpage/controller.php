<?php
/**
* @version		$Id:controller.php  1 2015-08-08 11:00:56Z  $
* @package		Frontpage
* @subpackage 	Controllers
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Frontpage Controller
 *
 * @package    
 * @subpackage Controllers
 */
class FrontpageController extends JControllerLegacy
{

    /**
    * Constructor.
    *
    * @param	array An optional associative array of configuration settings.
    * @see		JController
    */
    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->input = JFactory::getApplication()->input;
    }

	public function display($cachable = false, $urlparams = false)
	{
		$cachable	= true;	
				$vName = $this->input->get('view', 'itemss');
		$this->input->set('view', $vName);
		$safeurlparams = array('id' => 'INT');
		 
		return parent::display($cachable, $safeurlparams);
	}	
	

}// class
?>