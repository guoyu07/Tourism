<?php
/**
 * @version		$Id: default.php 1251 2011-10-19 17:50:13Z joomlaworks $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
$(function(){
	$('.newstabs ul.titles img.slide').hide();	
	$('.newstabs ul.titles img.slide:first').fadeIn(100);
	$('.newstabs ul.titles li:first').addClass('act');	
	$('.newstabs ul.titles li a').mouseenter(function(){
		$('.newstabs ul.titles li img.slide').hide();
		$('.newstabs ul.titles li').removeClass('act');
		$(this).parent().addClass('act');
		$(this).parent().find('img.slide').fadeIn(300);		
	});
});
</script>
<div class="newstabs">
	<?php if(count($items)) { ?>
		<ul class="titles">
			<?php foreach ($items as $key=>$item) { ?>
				<li>
					<a href="<?php echo $item->link; ?>"><?php echo K2HelperUtilities::cleanHtml($item->title); ?></a>
					<div class="slideimage">
						<img class="slide" src="<?php echo JURI::base(true).'/media/k2/items/cache/'.md5("Image".$item->id).'_XL.jpg'; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
					</div>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
</div>