<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ; ?>

<?php if($value = $field->get('date')): ?>
<span><?php echo JHtml::_('date', $value, JText::_('DATE_FORMAT_LC1')); ?></span>
<?php endif; ?>
