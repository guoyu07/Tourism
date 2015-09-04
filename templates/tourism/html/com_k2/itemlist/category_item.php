<?php
/**
 * @version		$Id: category_item.php 1766 2012-11-22 14:10:24Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;

// Define default image size (do not change)
K2HelperUtilities::setDefaultImage($this->item, 'itemlist', $this->params);
?>
<?php echo $this->item->event->BeforeDisplay; ?>
<?php echo $this->item->event->K2BeforeDisplay; ?>
<li class="">
	<a href="<?php echo $this->item->link; ?>">
		<span class="img">
			<img src="<?php echo $this->item->image; ?>" alt="<?php
			if (!empty($this->item->image_caption))
				echo K2HelperUtilities::cleanHtml($this->item->image_caption);
			else
				echo K2HelperUtilities::cleanHtml($this->item->title);
			?>" />
		</span>
		<span class="title"><?php echo $this->item->title; ?></span>
		<span class="clearfix"></span>
	</a>
</li>
