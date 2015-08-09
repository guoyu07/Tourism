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
<div class="jw--block--field">
	<div class="ov-hidden">
		<label><?php echo JText::_('K2_SOURCE'); ?></label>
	</div>
	<div class="ov-hidden">
		<input class="jw--small--input" type="text" name="<?php echo $field->get('prefix'); ?>[src]" value="<?php echo htmlspecialchars($field->get('src'), ENT_QUOTES, 'UTF-8'); ?>" data-widget="browser" data-button="<button class='left text-left jw--btn jw--file-fakebtn'><i class='fa fa-upload'></i> <span><?php echo JText::_('K2_BROWSE_SERVER'); ?></span></button>" />
	</div>
	
	<div class="ov-hidden">
		<label><?php echo JText::_('K2_ALT'); ?></label>
		<input type="text" name="<?php echo $field->get('prefix'); ?>[alt]" value="<?php echo htmlspecialchars($field->get('alt'), ENT_QUOTES, 'UTF-8'); ?>" />
	</div>
</div>
<?php if($this->required): ?>
<script type="text/javascript">
	jQuery(document).bind('K2ExtraFieldsValidate', function(event, K2ExtraFields) {
		var element = jQuery('input[name="<?php echo $field->get('prefix'); ?>[src]"]');
		if(element.val() == '') {
			K2ExtraFields.addValidationError(<?php echo $this->id; ?>);
		}
	});
</script>
<?php endif; ?>
