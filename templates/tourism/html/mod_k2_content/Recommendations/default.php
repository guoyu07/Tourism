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
<div class="panel content">
	<div class="panel-body">
<!--		<div class="tools">
			<div class="left">
				<ul class="list-unstyled">
					<li><a href="#"><i class="icon-play"></i></a></li>
					<li><a href="#"><i class="icon-podcast"></i></a></li>
				</ul>
			</div>
			<div class="right">
				<ul class="list-unstyled">
					<li class="pull-right"><a href="#" class="menu"><i class="icon-menu"></i></a></li>
					<li><a href="#" class="prev"><i class="icon-up"></i></a></li>
					<li><a href="#" class="next"><i class="icon-down"></i></a></li>
				</ul>
			</div>
		</div>-->
		<?php if (count($items)) { ?>
		<ul class="items list-unstyled">
			<?php foreach ($items as $key => $item) { ?>
			<li class="<?php if ($key == 0) echo 'active'; ?>"<?php if ($key != 0) echo ' style="height: 0;"'; ?>>
				<div class="player">
					<?php echo $item->event->BeforeDisplay; ?>
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
					<div class="img">
						<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
					</div>
					<?php } ?>
				</div>
<!--				<div class="desc sidebar">
					<div class="inner">
						<?php if ($module->showtitle) { ?><h2><?php echo $module->title; ?></h2><?php } ?>
						<?php if ($params->get('itemTitle')) { ?><h3><?php echo $item->title; ?></h3><?php } ?>
						<?php echo $item->event->AfterDisplayTitle; ?>
						<?php echo $item->event->K2AfterDisplayTitle; ?>
						<?php echo $item->event->BeforeDisplayContent; ?>
						<?php echo $item->event->K2BeforeDisplayContent; ?>
						<?php if ($params->get('itemIntroText')) { ?>
							<p><?php echo $item->introtext; ?></p>
						<?php } ?>
						<?php echo $item->event->AfterDisplayContent; ?>
						<?php echo $item->event->K2AfterDisplayContent; ?>
					</div>
				</div>-->
				<div class="sidebar">
					<div class="subcategories">
						<ul class="list-unstyled">
							<li>
								<a href="<?php echo JURI::base() . 'recommendations/travelog'; ?>" data-catid="15">
									<span class="title">سفرنامه</span>
								</a>
							</li>
							<li>
								<a href="<?php echo JURI::base() . 'recommendations/festivals'; ?>" data-catid="16">
									<span class="title">جشنواره‌ها</span>
								</a>
							</li>
							<li>
								<a href="<?php echo JURI::base() . 'recommendations/eco-tourism'; ?>" data-catid="17">
									<span class="title">بوم‌گردی</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<?php echo $item->event->AfterDisplay; ?>
				<?php echo $item->event->K2AfterDisplay; ?>
			</li>
			<?php } // forach [items] ?>
		</ul>
		<?php } // if [count items] ?>
	</div>
	<div class="itemlist">
		<ul class="items list-unstyled">
			<?php foreach ($items as $key => $item) { ?>
			<li class="<?php if ($key == 0) echo 'active'; ?>">
				<a href="#">
					<?php echo $item->event->BeforeDisplay; ?>
					<?php echo $item->event->K2BeforeDisplay; ?>
					<?php if ($params->get('itemImage') && isset($item->image)) { ?>
					<span class="img">
						<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" />
					</span>
					<?php } ?>
					<span class="title">
						<?php if ($params->get('itemTitle')) { ?><?php echo $item->title; ?><?php } ?>
						<?php echo $item->event->AfterDisplayTitle; ?>
						<?php echo $item->event->K2AfterDisplayTitle; ?>
					</span>
					<?php echo $item->event->AfterDisplay; ?>
					<?php echo $item->event->K2AfterDisplay; ?>
					<span class="clearfix"></span>
				</a>
			</li>
			<?php } // forach [items] ?>
		</ul>
	</div>
</div>