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
<div class="jw--block--field">
	<label><?php echo JText::_('K2_COMMA_SEPARATED_VALUES'); ?></label>
	<div class="ov-hidden">
		<input type="text" name="<?php echo $field->get('prefix'); ?>[value]" value="<?php echo htmlspecialchars($field->get('value'), ENT_QUOTES, 'UTF-8'); ?>" />
	</div>
</div>