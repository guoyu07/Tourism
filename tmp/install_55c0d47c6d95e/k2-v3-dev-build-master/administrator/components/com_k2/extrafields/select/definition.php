<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;
?>
<div class="jw--multiple--fields">
	<div class="ov-hidden repeater--filters">
		<label><?php echo JText::_('K2_SHOW_NULL_OPTION'); ?></label>
		<input value="1" name="<?php echo $field->get('prefix'); ?>[null]" type="checkbox" <?php if($field->get('null')) { echo 'checked="checked"';} ?> />
	</div>
	
	<div class="ov-hidden">
		<label><?php echo JText::_('K2_MULTIPLE'); ?></label>
		<input value="1" name="<?php echo $field->get('prefix'); ?>[multiple]" type="checkbox" <?php if($field->get('multiple')) { echo 'checked="checked"';} ?> />
	</div>
	
	<div class="ov-hidden repeater--action">
		<button class="jw--btn" id="extraFieldSelectAddOption"><?php echo JText::_('K2_ADD_OPTION'); ?></button>
	</div>
	
	<div class="clr"></div>
	
	<div class="ov-hidden">
		<div id="extraFieldSelectOptions">
			<?php foreach($field->get('options', array()) as $option): ?>
			<div class="extraFieldSelectOption">
				<input type="text" name="<?php echo $field->get('prefix'); ?>[options][]" value="<?php echo htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?>"> 			
				<button class="jw--btn jw--btn__item extraFieldSelectRemoveOption">
					<i class="fa fa-ban"></i>
					<span class="visuallyhidden"><?php echo JText::_('K2_REMOVE'); ?></span>
				</button>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery('body').on('click', '.extraFieldSelectRemoveOption', function(event) {
		event.preventDefault();
		jQuery(this).parent().remove();
	});
	jQuery('#extraFieldSelectAddOption').click(function(event) {
		event.preventDefault();
		var container = jQuery('<div>').attr('class', 'repeater--field extraFieldSelectOption');
		var option = jQuery('<input>').attr('type', 'text').attr('name', '<?php echo $field->get('prefix'); ?>[options][]', 'class', 'left');
		var button = jQuery('<button>').html('<i class="fa fa-ban"></i><span class="visuallyhidden"><?php echo JText::_('K2_REMOVE'); ?></span>').attr('class', 'left repeater--remove extraFieldSelectRemoveOption');
		container.append(option);
		container.append(button);
		jQuery('#extraFieldSelectOptions').append(container);
	});
</script>