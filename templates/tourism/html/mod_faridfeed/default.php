<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if($feed){ $style = ($rssitems == 1)?'width: 99%; float: left;':'width: 49.5%; float: left;'; ?>
<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>" style="padding: 0px !important; margin: 0px !important">
	<?php if($showradiotitle == 1){ ?>
	<div class="module-title">
		<h2 class="title">
			<a href="<?php echo JURI::base().$radiourl; ?>" target="_blank"><?php echo $radiotitle; ?>:&nbsp;</a>
			<?php echo modFaridFeedHelper::categoryLinks($categories, $radiourl); ?>
		</h2>
    </div>
	<?php } ?>
</div>
<?php if($mediaboxenabled){ ?>
<div class="MediaBox-layout<?php echo $mediaboxlayout; ?>" style="float: <?php echo $mediaboxfloat; ?>; width:<?php echo $mediaboxwidth; ?>%; height: 100%; padding-bottom: 5px;">
    <div class="boxtitle">
        <h4><?php echo $mediaboxtitle; ?></h4>
    </div>
    <?php
        for ($j = 0; $j < $mediaitems; $j++){
            if (!isset($feed2->items[$j])) continue;
			$currItem = $feed2->items[$j];
            $image_url = modFaridFeedHelper::parseImage($currItem->description);
            $image_url = str_replace('_M.jpg', '_S.jpg', $image_url);
            $filter = new JFilterInput();
            $text = $filter->clean($currItem->description);
            $text = str_replace('&apos;', "'", $text);
            if ($mediaitemlength){
                $texts = explode(' ', $text);
                $count = count($texts);
                    if ($count > $words)
                    {
                        $text = '';
                        for ($i = 0; $i < $mediaitemlength; $i ++) {
                        $text .= ' '.$texts[$i];
                        }
                        $text .= '...';
                    }
            }
            if ( !is_null( $currItem->link ) ) {
    ?>
    <div class="MediaItems">
        <div class="MediaImage">
            <?php if($mediaimage){ ?>
                <a href="<?php echo $currItem->link; ?>" target="_blank">
                    <img src="<?php echo $image_url; ?>" title="<?php echo $currItem->title; ?>" alt="<?php echo $currItem->title; ?>" />
                </a>
            <?php } ?>
        </div>
        <span class="jazin-title-2"  style="text-align: <?php echo $align; ?>;">
            <a href="<?php echo $currItem->link; ?>" target="_blank"><?php echo $currItem->title; ?></a>
        </span>
        <?php if ($mediaitemdesc){ ?>
            <div class="MediaDesc">
                <?php echo $text; ?>
            </div>
        <?php } ?>
		<div class="clear"></div>
    </div>
	<div class="clear"></div>
 <?php
        }
    }
?>
</div>
<?php } ?>

<div class="itemsbox" style="float: <?php echo $itemsboxfloat; ?>; width: <?php echo $itemsboxwidth; ?>%;">
    <div class="FeedItems">
        <ul class="ff-newsfeed<?php echo $params->get( 'moduleclass_sfx'); ?>">
        <?php 
        for ($j = 0; $j < $rssitems; $j++){
			if (!isset($feed->items[$j])) continue;
            $currItem = $feed->items[$j];
            $image_url = modFaridFeedHelper::parseImage($currItem->description);
            $image_url = str_replace('_S.jpg', '_M.jpg', $image_url);

            $filter = new JFilterInput();
            $text = $filter->clean($currItem->description);
            
            $text = str_replace('&apos;', "'", $text);
            if ($words){
                $texts = explode(' ', $text);
                $count = count($texts);
                if ($count > $words){
                    $text = '';
                    for ($i = 0; $i < $words; $i ++) {
                        $text .= ' '.$texts[$i];
                    }
                    $text .= '...';
                }
            }
            ?>
            <li>
            <?php
            if ( !is_null( $currItem->link ) ) {
            ?>
            <?php
            }
            ?>
                <div class="newsfeed_item<?php echo $params->get( 'moduleclass_sfx'); ?>"  >
                    <?php if($rssimage){ ?>
					<a href="<?php echo $currItem->link; ?>" target="_blank" class="pagep-first-item-image-link">
						<img src="<?php echo $image_url; ?>" title="<?php echo $currItem->title; ?>" alt="<?php echo $currItem->title; ?>" />
					</a>
                    <?php } ?>

                    <h4 class="pagepreview-title">
						<a href="<?php echo $currItem->link; ?>" target="_blank"><?php echo $currItem->title; ?></a>
                    </h4>
					<div class="clear"></div>
                    <?php if ($rssdesc) { ?>
                        <div class="ItemDesc">
                            <?php echo $text; ?>
                        </div>
                    <?php } ?>
                </div>
                
			</li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="linkitems" style="float: <?php echo $itemsboxfloat; ?>;">
	<ul>
		<?php
			for ($j=$rssitems; $j<$totalcount; $j++){
				if (!isset($feed->items[$j])) continue;
				$currItem = $feed->items[$j];
		?>
			<li><a href="<?php echo $currItem->link; ?>" target="_blank"><?php echo $currItem->title; ?></a></li>
		<?php
			}
		?>
	</ul>
</div>
<?php } ?>
<div class="clear"></div>
