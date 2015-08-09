<?php
/**
 * @version     1.0.0
 * @package     com_newstabs
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Created by com_combuilder - http://www.notwebdesign.com
 */

// no direct access
defined('_JEXEC') or die;
?>
<?php
require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
$rows = $this->items;


?>

<script type="text/javascript">/*
window.addEvent('domready', function(){
	var ntdrop = document.id('ntlarge');
	var ntdropFx = new Fx.Tween(ntdrop);
	ntdropFx.set('duration', 150);
	var ntitems = $$('.ntitem');

	function resetStyle(ntcurrent){
	ntitems.each(function(ntitem)
	{
		if (ntitem == ntcurrent)
		ntitem.className = 'ntitem ntitemhover';
		else
		ntitem.className = 'ntitem';
	});}
	
	ntitems.each(function(ntitem)
	{
		ntitem.addEvent('mouseenter', function(e)
		{
			ntdrop.removeEvents();
			ntdrop.empty();
			var ntclone = ntitem.getFirst().clone();
			ntclone.inject(ntdrop, 'top');
			ntdropFx.cancel();
			ntdropFx.start('opacity', '0', '1');
			resetStyle(ntitem);
		});	}); });	*/
</script>
<div id="newstabs" >
<div id="ntitems"> 
  	<?php
		$firstImage = '';

		foreach ($rows as $key => $news) {
			$regex1 = "/\<img[^\>]*>/";
			$news->introtext = preg_replace( $regex1, '', $news->introtext );
			$regex1 = "/<div class=\"mosimage\".*<\/div>/";
			$news->introtext = preg_replace( $regex1, '', $news->introtext );
			$news->introtext = trim($news->introtext);
			$news->introtext1 = $news->introtext;

			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute(urlencode($news->slug), urlencode($news->catslug))));
			$image = '';
			
			$link   = JRoute::_(K2HelperRoute::getItemRoute($news->slug, $news->catslug));
			
			$news->title = htmlspecialchars($news->title);
			if (JFile::exists(JPATH_SITE.DS.'media'.DS.'k2'.DS.'items'.DS.'cache'.DS.md5("Image".$news->id).'_XL.jpg')){
				$image = '<img src="' . 'media/k2/items/cache/'.md5("Image".$news->id).'_XL.jpg"' . ' alt="' . $news->title . '" ' . 'title="' . $news->title . '" />';
			} else {
				$image = '';
			}
						//if ($key==0) $firstImage = $image;
	?>
			<div class="<?php echo (($key==0)?'ntitem ntitemhover':'ntitem'); ?>">
		       <a href="<?php echo $link; ?>" ><?php echo $image;?></a>
			   <a href="<?php echo $link; ?>" ><?php echo $news->title;?></a>
			</div> 
	<?php
		}
	?>   
  </div>
  <div id="ntlarge"><?php echo $firstImage; ?></div>
  <div class="clr"></div>
  </div>
