<?php 
defined('_JEXEC') or die;

require_once (JPATH_SITE . DS . 'components' . DS . 'com_k2' . DS . 'helpers' . DS . 'route.php');
$rows = $this->items;

/* Checking user's platform for iphone version of website */
$device = null;
if (!class_exists('Browser')) {
	require_once (JPATH_BASE . '/templates/worldservice/libs/browser.php');
}
$browser = new Browser;
$platform = strtolower($browser->getPlatform());
$browser = strtolower($browser->getBrowser());
$uiRequest = strtolower(JRequest::getVar('ui', null, 'GET'));
$uiCookie = &JRequest::getVar('ui', null, 'cookie');
$devices = array('ipod', 'ipad', 'iphone', 'android', 'blackberry');
if (in_array($platform, $devices) || in_array($browser, $devices) || in_array($uiRequest, $devices) || in_array($uiCookie, $devices)){
	$device = 'iphone';
}
/* End of checking user's platform */

if($device != 'iphone') {
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
<?php } ?>
<div id="news-carousel">
	<?php if ($device == 'iphone') { ?>
	<div id="carousel-controls">
		<a class="next-news right carousel-control">›</a>
		<a class="prev-news left carousel-control">‹</a>
	</div>
	<?php } ?>
	<div class="newstabs">
		<?php
		$titles = '<ul id="news-titles" class="titles">';
		foreach ($rows as $key => $news) {
			$link = urldecode(JRoute::_(K2HelperRoute::getItemRoute(urlencode($news->slug), urlencode($news->catslug))));
			$link   = JRoute::_(K2HelperRoute::getItemRoute($news->slug, $news->catslug));
			$news->title = htmlspecialchars($news->title);
			$image = '<div class="slideimage"><img class="slide" src="' . 'media/k2/items/cache/'.md5("Image".$news->id).'_XL.jpg"' . ' alt="' . $news->title . '" ' . 'title="' . $news->title . '" /></div>';
			if ($device != 'iphone') {
				$titles .= '<li>' . $image . '<a href="' . $link . '" title="' . $news->title . '" >' . $news->title . '</a></li>';
			} else {
				$titles .= '<li class="item">' . $image . '<a href="' . $link . '" title="' . $news->title . '" ><span class="item-title">' . $news->title . '</span></a></li>';
			}
		}
		$titles .= "</ul>";
		echo $titles;
		?>
		<div class="clear"></div>
	</div>
	<?php if ($device == 'iphone') { ?>
	<div id="pager" class="pagination pagination-centered">
		<ul>
			<?php for ($i = 0; $i < count($rows); $i++) echo '<li class="page"><span>' . ($i + 1) . '</span></li>'; ?>
		</ul>
	</div>
	<?php } ?>
</div>

<?php if ($device == 'iphone') { ?>
<script type="text/javascript">
$('#news-carousel .newstabs').iosSlider({
	scrollbar: true,
	snapToChildren: true,
	desktopClickDrag: true,
	//scrollbarLocation: 'bottom',
	//scrollbarMargin: '10px 10px 0 10px',
	//scrollbarBorderRadius: '3px',
	//responsiveSlideWidth: true,
	navSlideSelector: $('#pager .page'),
	infiniteSlider: true,
	startAtSlide: '1',
	//onSlideStart: slideContentStart,
	navNextSelector: $('.next-news'),
	navPrevSelector: $('.prev-news'),
	onSlideChange: slideContentChange,
	onSlideComplete: slideContentComplete,
	onSliderLoaded: slideContentLoaded
});
function slideContentChange(args) {
	/* indicator */
	$('#pager .page').removeClass('selected');
	$('#pager .page:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
}
function slideContentComplete(args) {
	/* animation */
	//$(args.currentSlideObject).children('.item-title').animate({ opacity : '1' }, 400);
}
function slideContentLoaded(args) {
	/* animation */
	//$(args.currentSlideObject).children('.item-title').animate({ opacity : '1' }, 400);
	/* indicator */
	$('#pager .page').removeClass('selected');
	$('#pager .page:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
}
</script>
<?php  } ?>