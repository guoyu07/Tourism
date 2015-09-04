<?php
/**
 * @version		$Id: category.php 1618 2012-09-21 11:23:08Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php if (isset($this->secondary) && count($this->secondary)): ?>
	<!-- Secondary items -->
	<ul class="items list-unstyled">
		<?php foreach ($this->secondary as $key => $item): ?>
			<?php
			// Load category_item.php by default
			$this->item = $item;
			echo $this->loadTemplate('item');
			?>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>  \