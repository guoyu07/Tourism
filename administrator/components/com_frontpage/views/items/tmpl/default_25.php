<?php
/**
* @version		$Id:default_25.php 1 2015-08-08 11:00:56Z  $
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
  JFactory::getDocument()->addStyleSheet(JURI::base().'/components/com_frontpage/assets/lists-j25.css');
  $user		= JFactory::getUser();
  $userId		= $user->get('id');
  $listOrder	= $this->escape($this->state->get('list.ordering'));
  $listDirn	= $this->escape($this->state->get('list.direction'));    
?>

<form action="index.php?option=com_frontpage&amp;view=item" method="post" name="adminForm" id="adminForm">
	<table>
		<tr>
			<td align="left" width="100%">
				<div id="filter-bar" class="btn-toolbar">
					<div class="filter-search btn-group pull-left">
						<label class="element-invisible" for="filter_search"><?php echo JText::_( 'Filter' ); ?>:</label>
						<input type="text" name="search" id="search" value="<?php  echo $this->escape($this->state->get('filter.search'));?>" class="text_area" onchange="document.adminForm.submit();" />
					</div>
					<div class="btn-group pull-left">
						<button class="btn" onclick="this.form.submit();"><?php if(version_compare(JVERSION,'3.0','lt')): echo JText::_( 'Go' ); else: ?><i class="icon-search"></i><?php endif; ?></button>
						<button type="button" class="btn" onclick="document.getElementById('search').value='';this.form.submit();"><?php if(version_compare(JVERSION,'3.0','lt')): echo JText::_( 'Reset' ); else: ?><i class="icon-remove"></i><?php endif; ?></button>
					</div>
				</div>					
			</td>
			<td nowrap="nowrap">
				<?php
 				  	echo JHTML::_('grid.state', $this->state->get('filter.state'), 'Published', 'Unpublished', 'Archived', 'Trashed');
  				?>
		
			</td>
		</tr>		
	</table>
<div id="editcell">
	<table class="adminlist table table-striped">
		<thead>
			<tr>
				<th width="5">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="20">				
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Title', 'a.title', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Alias', 'a.alias', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Gallery', 'a.gallery', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Image_credits', 'a.image_credits', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Video_credits', 'a.video_credits', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Created', 'a.created', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Ordering', 'a.ordering', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Published', 'a.published', $listDirn, $listOrder ); ?>
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort', 'Id', 'a.id', $listDirn, $listOrder ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
<?php
  $k = 0;
  if (count( $this->items ) > 0 ):
  
  for ($i=0, $n=count( $this->items ); $i < $n; $i++):
  
  	$row = $this->items[$i];
 	$onclick = "";

    if (JFactory::getApplication()->input->get('function', null)) {
    	$onclick= "onclick=\"window.parent.jSelectItem_id('".$row->id."', '".$this->escape($row->title)."', '','id')\" ";
    }  	
    
 	$link = JRoute::_( 'index.php?option=com_frontpage&view=item&task=item.edit&id='. $row->id );
 	$row->id = $row->id;
 	$checked = JHTML::_('grid.checkedout', $row, $i );
	
 	
  	$published = JHTML::_('jgrid.published', $row->published, $i, 'items.');
  	
 	
  ?>
	<tr class="<?php echo "row$k"; ?>">
		
		<td align="center"><?php echo $this->pagination->getRowOffset($i); ?>.</td>
        
        <td><?php echo $checked  ?></td>
		
	<td>
      
        		<?php
				if ( JTable::isCheckedOut($user->get ('id'), $row->checked_out ) ):
							echo $row->title;
						else:
							?>
						
							<a <?php echo $onclick; ?>href="<?php echo $link; ?>"><?php echo $row->title; ?></a>
							
							<?php	
				endif;			
				?>
								
		</td>	
	
			<td><?php echo $row->alias; ?></td>		
	
			<td><?php echo $row->gallery; ?></td>		
	
			<td><?php echo $row->image_credits; ?></td>		
	
			<td><?php echo $row->video_credits; ?></td>		
	
			<td><?php echo $row->created; ?></td>		
	
		        <td>
        	<span><?php echo $this->pagination->orderUpIcon( $i, true, 'items.orderup', 'Move Up', ($listOrder == 'a.ordering' and $listDirn == 'asc'));?></span>
			<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'items.orderdown', 'Move Down', ($listOrder == 'a.ordering' and  $listDirn == 'asc') );?></span>
        </td>
	
		<td><?php echo $published; ?></td>
	
			<td><?php echo $row->id; ?></td>		
	
	</tr>		
<?php
  $k = 1 - $k;
  endfor;
  else:
  ?>
	<tr>
		<td colspan="12">
			<?php echo JText::_( 'NO_ITEMS_PRESENT' ); ?>
		</td>
	</tr>
	<?php
  endif;
  ?>
</tbody>
</table>
</div>
<input type="hidden" name="option" value="com_frontpage" />
<input type="hidden" name="task" value="item" />
<input type="hidden" name="view" value="items" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>  	