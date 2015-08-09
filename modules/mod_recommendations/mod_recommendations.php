<?php
/**
 * @version SVN: $Id: mod_#module#.php 147 2013-10-06 08:58:34Z michel $
 * @package    Contacts
 * @subpackage Base
 * @author     
 * @license    
 */

defined('_JEXEC') or die('Restricted access'); // no direct access

require_once __DIR__ . '/helper.php';
$item = modRecommendationsHelper::getItem($params);
require(JModuleHelper::getLayoutPath('mod_recommendations'));
require_once ('helper.php');

?>