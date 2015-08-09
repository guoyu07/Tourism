<?php
/**
* @version		$Id:default.php 1 2015-08-08 11:00:56Z  $
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><h2><?php echo $this->params->get('page_title');  ?></h2></div>
<h3><?php echo $this->item->title; ?></h3>
<div class="contentpane">
	<div><h4>Some interesting informations</h4></div>
		<div>
		Id: <?php echo $this->item->id; ?>
	</div>
		
		<div>
		Title: <?php echo $this->item->title; ?>
	</div>
		
		<div>
		Alias: <?php echo $this->item->alias; ?>
	</div>
		
		<div>
		Catid: <?php echo $this->item->catid; ?>
	</div>
		
		<div>
		Published: <?php echo $this->item->published; ?>
	</div>
		
		<div>
		Language: <?php echo $this->item->language; ?>
	</div>
		
		<div>
		Created: <?php echo $this->item->created; ?>
	</div>
		
		<div>
		Created_by: <?php echo $this->item->created_by; ?>
	</div>
		
		<div>
		Created_by_alias: <?php echo $this->item->created_by_alias; ?>
	</div>
		
		<div>
		Modified: <?php echo $this->item->modified; ?>
	</div>
		
		<div>
		Modified_by: <?php echo $this->item->modified_by; ?>
	</div>
		
		<div>
		Checked_out_time: <?php echo $this->item->checked_out_time; ?>
	</div>
		
		<div>
		Checked_out: <?php echo $this->item->checked_out; ?>
	</div>
		
		<div>
		Access: <?php echo $this->item->access; ?>
	</div>
		
		<div>
		Publish_up: <?php echo $this->item->publish_up; ?>
	</div>
		
		<div>
		Publish_down: <?php echo $this->item->publish_down; ?>
	</div>
		
		<div>
		Params: <?php echo $this->item->params; ?>
	</div>
		
		<div>
		Ordering: <?php echo $this->item->ordering; ?>
	</div>
		
		<div>
		Introtext: <?php echo $this->item->introtext; ?>
	</div>
		
		<div>
		Fulltext: <?php echo $this->item->fulltext; ?>
	</div>
		
		<div>
		Video: <?php echo $this->item->video; ?>
	</div>
		
		<div>
		Gallery: <?php echo $this->item->gallery; ?>
	</div>
		
		<div>
		Extra_fields: <?php echo $this->item->extra_fields; ?>
	</div>
		
		<div>
		Extra_fields_search: <?php echo $this->item->extra_fields_search; ?>
	</div>
		
		<div>
		Trash: <?php echo $this->item->trash; ?>
	</div>
		
		<div>
		Featured: <?php echo $this->item->featured; ?>
	</div>
		
		<div>
		Featured_ordering: <?php echo $this->item->featured_ordering; ?>
	</div>
		
		<div>
		Image_caption: <?php echo $this->item->image_caption; ?>
	</div>
		
		<div>
		Image_credits: <?php echo $this->item->image_credits; ?>
	</div>
		
		<div>
		Video_caption: <?php echo $this->item->video_caption; ?>
	</div>
		
		<div>
		Video_credits: <?php echo $this->item->video_credits; ?>
	</div>
		
		<div>
		Hits: <?php echo $this->item->hits; ?>
	</div>
		
		<div>
		Metadesc: <?php echo $this->item->metadesc; ?>
	</div>
		
		<div>
		Metadata: <?php echo $this->item->metadata; ?>
	</div>
		
		<div>
		Metakey: <?php echo $this->item->metakey; ?>
	</div>
		
		<div>
		Plugins: <?php echo $this->item->plugins; ?>
	</div>
		
		<div>
		Id: <?php echo $this->item->id; ?>
	</div>
		
	</div>
 