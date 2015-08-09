 <?php
/**
* @version		$Id: default_modelfrontend.php 136 2013-09-24 14:49:14Z michel $
* @package		Frontpage
* @subpackage 	Models
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license 		
*/
 defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.modelitem');
jimport('joomla.application.component.helper');

JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_frontpage/tables');
/**
 * FrontpageModelItem
 * @author $Author$
 */
 
 
class FrontpageModelItem  extends JModelItem { 

	
	
	protected $context = 'com_frontpage.item';   
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	public function populateState()
	{
		$app = JFactory::getApplication();

		$params	= $app->getParams();

		// Load the object state.
		$id	= JFactory::getApplication()->input->getInt('id', null);
		$this->setState('item.id', $id);

		// Load the parameters.
		
		$this->setState('params', $params);
	}

	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('item.id');

		return parent::getStoreId($id);
	}
	
	/**
	 * Method to get an ojbect.
	 *
	 * @param	integer	The id of the object to get.
	 *
	 * @return	mixed	Object on success, false on failure.
	 */
	public function &getItem($id = null)
	{
		if ($this->_item === null) {
			
			$this->_item = false;

			if (empty($id)) {
				$id = $this->getState('item.id');
			}

			// Get a level row instance.
			$table = JTable::getInstance('Item', 'Table');


			// Attempt to load the row.
			if ($table->load($id)) {
				
				// Check published state.
				if ($published = $this->getState('filter.published')) {
					
					if ($table->state != $published) {
						return $this->_item;
					}
				}

				// Convert the JTable to a clean JObject.
				$this->_item = JArrayHelper::toObject($table->getProperties(1), 'JObject');
				
			} else if ($error = $table->getError()) {
				
				$this->setError($error);
			}
		}		
		// Convert parameter fields to objects.
		$registry = new JRegistry;
		$registry->loadString($this->_item->params);
		$this->_item->params = clone $this->getState('params');
		$this->_item->params->merge($registry);


		return $this->_item;
	}
		
}
?>