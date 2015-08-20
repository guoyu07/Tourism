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
<div class="item-header">
	<?php if ($this->item->params->get('catItemDateCreated')): ?>
		<span class="item-date">
			<?php echo JHTML::_('date', $this->item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>
		</span>
	<?php endif; ?>
	<?php if ($this->item->params->get('catItemTitle')): ?>
		<h3 class="item-title">
			<?php if (isset($this->item->editLink)): ?>
				<span class="catItemEditLink">
					<a class="modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>">
						<?php echo JText::_('K2_EDIT_ITEM'); ?>
					</a>
				</span>
			<?php endif; ?>
			<?php if ($this->item->params->get('catItemTitleLinked')): ?>
				<a href="<?php echo $this->item->link; ?>">
					<?php echo $this->item->title; ?>
				</a>
			<?php else: ?>
				<?php echo $this->item->title; ?>
			<?php endif; ?>
		</h3>
	<?php endif; ?>
	<?php if ($this->item->params->get('catItemAuthor')): ?>
		<span class="item-author">
			<?php echo K2HelperUtilities::writtenBy($this->item->author->profile->gender); ?> 
			<?php if (isset($this->item->author->link) && $this->item->author->link): ?>
				<a rel="author" href="<?php echo $this->item->author->link; ?>"><?php echo $this->item->author->name; ?></a>
			<?php else: ?>
				<?php echo $this->item->author->name; ?>
			<?php endif; ?>
		</span>
	<?php endif; ?>
</div>
<?php echo $this->item->event->AfterDisplayTitle; ?>
<?php echo $this->item->event->K2AfterDisplayTitle; ?>
<div class="item-body">
	<?php echo $this->item->event->BeforeDisplayContent; ?>
	<?php echo $this->item->event->K2BeforeDisplayContent; ?>
	<?php if ($this->item->params->get('catItemImage') && !empty($this->item->image)): ?>
		<div class="item-image">
			<span class="image">
				<a href="<?php echo $this->item->link; ?>" title="<?php
				if (!empty($this->item->image_caption))
					echo K2HelperUtilities::cleanHtml($this->item->image_caption);
				else
					echo K2HelperUtilities::cleanHtml($this->item->title);
				?>">
					<img src="<?php echo $this->item->image; ?>" alt="<?php
					if (!empty($this->item->image_caption))
						echo K2HelperUtilities::cleanHtml($this->item->image_caption);
					else
						echo K2HelperUtilities::cleanHtml($this->item->title);
					?>" />
				</a>
			</span>
		</div>
	<?php endif; ?>
	<?php if ($this->item->params->get('catItemIntroText')): ?>
		<div class="item-text">
			<?php echo $this->item->introtext; ?>
		</div>
	<?php endif; ?>
	<?php if ($this->item->params->get('catItemExtraFields') && count($this->item->extra_fields)): ?>
		<div class="catItemExtraFields">
			<h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
			<ul>
				<?php foreach ($this->item->extra_fields as $key => $extraField): ?>
					<?php if ($extraField->value != ''): ?>
						<li class="<?php echo ($key % 2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
							<?php if ($extraField->type == 'header'): ?>
								<h4 class="catItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
							<?php else: ?>
								<span class="catItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
								<span class="catItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	<?php echo $this->item->event->AfterDisplayContent; ?>
	<?php echo $this->item->event->K2AfterDisplayContent; ?>
	<?php if ($this->item->params->get('catItemReadMore')): ?>
		<a class="more" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('K2_READ_MORE'); ?>
		</a>
	<?php endif; ?>
</div>
<?php echo $this->item->event->AfterDisplay; ?>
<?php echo $this->item->event->K2AfterDisplay; ?>