<?php
/**
* @version		$Id:default.php 1 2015-08-08 11:00:56Z  $
* @package		Frontpage
* @subpackage 	Controllers
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controlleradmin');
jimport('joomla.application.component.controllerform');

/**
 * FrontpageItem Controller
 *
 * @package    Frontpage
 * @subpackage Controllers
 */
class FrontpageControllerItem extends JControllerForm
{
	public function __construct($config = array())
	{
	
		$this->view_item = 'item';
		$this->view_list = 'items';
		parent::__construct($config);
	}	
	
	/**
	 * Proxy for getModel.
	 *
	 * @param   string	$name	The name of the model.
	 * @param   string	$prefix	The prefix for the PHP class name.
	 *
	 * @return  JModel
	 * @since   1.6
	 */
	public function getModel($name = 'Item', $prefix = 'FrontpageModel', $config = array('ignore_request' => false))
	{
		$model = parent::getModel($name, $prefix, $config);
	
		return $model;
	}	
}// class
?>