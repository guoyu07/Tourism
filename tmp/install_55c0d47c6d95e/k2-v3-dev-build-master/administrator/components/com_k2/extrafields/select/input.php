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
$name = $field->get('prefix').'[value]';
$attributes = '';
if($field->get('multiple'))
{
	$name .= '[]';
	$attributes = 'multiple="multiple"';
}
?>
<div class="jw--block--field">
	<select class="jw--select" id="k2ExtraFieldSelectId<?php echo $this->id; ?>" name="<?php echo $name; ?>" <?php echo $attributes; ?>>
	<?php if($field->get('null')): ?>
		<option value=""><?php echo JText::_('K2_SELECT_AN_OPTION'); ?></option>
	<?php endif; ?>
	<?php foreach($field->get('options', array()) as $option): ?>
		<option value="<?php echo htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?>"><?php echo $option; ?></option>
	<?php endforeach; ?>
	</select>
</div>

<script type="text/javascript">
	jQuery(document).on('K2ExtraFieldsRender', function() {
		jQuery('#k2ExtraFieldSelectId<?php echo $this->id; ?>').val(<?php echo json_encode($field->get('value')); ?>);
	});
	
	<?php if($this->required): ?>
	jQuery(document).bind('K2ExtraFieldsValidate', function(event, K2ExtraFields) {
		var element = jQuery('#k2ExtraFieldSelectId<?php echo $this->id; ?>');
		if(!element.val()) {
			K2ExtraFields.addValidationError(<?php echo $this->id; ?>);
		}
	});
	<?php endif; ?>
</script>