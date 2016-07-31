<?php
/**
 * @version		4.6.1
 * @package		AllVideos (plugin)
 * @author    	JoomlaWorks - http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

$tagsource = str_replace('http://ftp4.presstv.ir/tourism/', 'http://77.36.165.143/Tourism/', $tagsource);

$app = JFactory::getApplication();
if ($app->isAdmin())
	echo '<video width="480" controls src="';
echo $tagsource;
if ($app->isAdmin())
	echo '"></video>';