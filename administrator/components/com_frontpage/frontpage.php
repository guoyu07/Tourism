<?php
/**
 * @version 1.0
 * @package    joomla
 * @subpackage Frontpage
 * @author	   	
 *  @copyright  	Copyright (C) 2015, . All rights reserved.
 *  @license 
 */

//--No direct access
defined('_JEXEC') or die('Resrtricted Access');

require_once(JPATH_COMPONENT.'/helpers/frontpage.php');
$controller = JControllerLegacy::getInstance('frontpage');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();