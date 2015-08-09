 <?php
/**
* @version		$Id:item.php  1 2015-08-08 11:00:56Z  $
* @package		Frontpage
* @subpackage 	Tables
* @copyright	Copyright (C) 2015, . All rights reserved.
* @license #
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
* Jimtawl TableItem class
*
* @package		Frontpage
* @subpackage	Tables
*/
class TableItem extends JTable
{

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) 
	{
		parent::__construct('#__k2_items', 'id', $db);
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	public function bind($array, $ignore = '')
	{
		if ( isset( $array['params'] ) && is_array( $array['params'] ) )
        {
            $registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
        }		
		return parent::bind($array, $ignore);		
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	public function check()
	{
		if ($this->id === 0) {
			//get next ordering
			$condition = ' catid = '.(int) $this->catid  . ' AND published >= 0 '; 
			$this->ordering = $this->getNextOrder( $condition );

		}		
		if (!$this->created) {
			$date = JFactory::getDate();
			$this->created = $date->format("Y-m-d H:i:s");
		}

		/** check for valid name */
		/**
		if (trim($this->title) == '') {
			$this->setError(JText::_('Your Item must contain a title.')); 
			return false;
		}
		**/
		if(empty($this->alias)) {
			$this->alias = $this->title;
		}
		
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
		
		/** check for existing alias */
		$query = 'SELECT '.$this->getKeyName().' FROM '.$this->_tbl.' WHERE alias = '.$this->_db->Quote($this->alias);
		$this->_db->setQuery($query);
		
		$xid = intval($this->_db->loadResult());

		if ($xid && $xid != intval($this->{$this->getKeyName()})) {		
			$this->setError(JText::_('Can\'t save to Item. Name already exists'));
			return false;
		}
		return true;
	}
}
 