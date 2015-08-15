<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */
// no direct access
defined('_JEXEC') or die;
?>
<div class="slideshow">
	<div class="caption-container">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<div class="inner">
					<div class="controls">
						<span class="prev"><i class="icon-left"></i></span>
						<span class="next"><i class="icon-right"></i></span>
					</div>
					<ul class="sharings list-unstyled list-inline text-center">
						<li><a href="<?php echo JURI::base(); ?>"><i class="icon-instagram"></i></a></li>
						<li><a href="#"><i class="icon-facebook"></i></a></li>
						<li><a href="#"><i class="icon-youtube"></i></a></li>
						<li><a href="#"><i class="icon-twitter"></i></a></li>
						<li><a href="#"><i class="icon-vimeo"></i></a></li>
					</ul>
					<div class="pages"></div>
				</div>
			</div>
		</div>
	</div>
	<?php if (count($items)) { ?>
		<ul class="items list-unstyled">
			<?php foreach ($items as $key => $item) { ?>
				<li data-created="<?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>">
					<?php echo $item->event->BeforeDisplay; ?>
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
						<div class="img">
							<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
						</div>
					<?php } ?>
					<div class="desc">
						<div class="row">
							<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
								<div class="inner">
									<?php if ($params->get('itemTitle')) { ?><h2><span><?php echo $item->title; ?></span></h2><?php } ?>
									<?php echo $item->event->AfterDisplayTitle; ?>
									<?php echo $item->event->K2AfterDisplayTitle; ?>
									<?php echo $item->event->BeforeDisplayContent; ?>
									<?php echo $item->event->K2BeforeDisplayContent; ?>
									<?php if ($params->get('itemIntroText')) { ?>
										<?php echo $item->introtext; ?>
									<?php } ?>
									<?php echo $item->event->AfterDisplayContent; ?>
									<?php echo $item->event->K2AfterDisplayContent; ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo $item->event->AfterDisplay; ?>
					<?php echo $item->event->K2AfterDisplay; ?>
				</li>
			<?php } // forach [items] ?>
		</ul>
	<?php } // if [count items] ?>
</div>