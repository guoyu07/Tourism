<?php
/**
* @version		$Id:edit.php 1 2015-08-08 11:00:56Z  $
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Set toolbar items for the page
$edit		= JFactory::getApplication()->input->get('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Item' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply('item.apply');
JToolBarHelper::save('item.save');
if (!$edit) {
	JToolBarHelper::cancel('item.cancel');
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'item.cancel', 'Close' );
}
?>

<script language="javascript" type="text/javascript">


Joomla.submitbutton = function(task)
{
	if (task == 'item.cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
		Joomla.submitform(task, document.getElementById('adminForm'));
	}
}

</script>

	 	<form method="post" action="<?php echo JRoute::_('index.php?option=com_frontpage&layout=edit&id='.(int) $this->item->id);  ?>" id="adminForm" name="adminForm">
	 	<div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-60  <?php endif; ?>span8 form-horizontal fltlft">
		  <fieldset class="adminform">
			<legend><?php echo JText::_( 'Details' ); ?></legend>
		
				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('title'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('title');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('alias'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('alias');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('catid'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('catid');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('introtext'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('introtext');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('fulltext'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('fulltext');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('video'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('video');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('gallery'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('gallery');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('extra_fields'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('extra_fields');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('extra_fields_search'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('extra_fields_search');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('trash'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('trash');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('featured'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('featured');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('featured_ordering'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('featured_ordering');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('image_caption'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('image_caption');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('image_credits'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('image_credits');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('video_caption'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('video_caption');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('video_credits'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('video_credits');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('hits'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('hits');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('metadesc'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('metadesc');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('metadata'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('metadata');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('metakey'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('metakey');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('plugins'); ?>
					</div>
				<?php if(version_compare(JVERSION,'3.0','lt')): ?>
				<div class="clr"></div>
				<?php  endif; ?>						
					
					<div class="controls">	
						<?php echo $this->form->getInput('plugins');  ?>
					</div>
				</div>		
					
					
		
				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('published'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('published');  ?>
					</div>
				</div>		
			
						
          </fieldset>                      
        </div>
        <div class="col <?php if(version_compare(JVERSION,'3.0','lt')):  ?>width-30  <?php endif; ?>span2 fltrgt">
		        
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Parameters' ); ?></legend>
		
				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('access'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('access');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('publish_up'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('publish_up');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('publish_down'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('publish_down');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('modified'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('modified');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('created_by_alias'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('created_by_alias');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('language'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('language');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('created_by'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('created_by');  ?>
					</div>
				</div>		

				<div class="control-group">
					<div class="control-label">					
						<?php echo $this->form->getLabel('created'); ?>
					</div>
					
					<div class="controls">	
						<?php echo $this->form->getInput('created');  ?>
					</div>
				</div>		
								
			</fieldset>
			        
     		
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Advanced Parameters' ); ?></legend>
				<table>				
				<?php 
					$fieldSets = $this->form->getFieldsets('params');
					foreach($fieldSets  as $name =>$fieldset):  ?>				
				<?php foreach ($this->form->getFieldset($name) as $field) : ?>
					<?php if ($field->hidden):  ?>
						<?php echo $field->input;  ?>
					<?php else:  ?>
					<tr>
						<td class="paramlist_key" width="40%">
							<?php echo $field->label;  ?>
						</td>
						<td class="paramlist_value">
							<?php echo $field->input;  ?>
						</td>
					</tr>
				<?php endif;  ?>
				<?php endforeach;  ?>
			<?php endforeach;  ?>
			</table>			
			</fieldset>									


        </div>                   
		<input type="hidden" name="option" value="com_frontpage" />
	    <input type="hidden" name="cid[]" value="<?php echo $this->item->id ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="view" value="item" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>