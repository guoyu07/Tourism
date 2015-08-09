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

<?php if($field->get('src')): ?>
<img src="<?php echo JURI::root(true).htmlspecialchars($field->get('src'), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($field->get('alt'), ENT_QUOTES, 'UTF-8'); ?>" />
<?php endif; ?>