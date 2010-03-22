<?php
/**
 * @version		0.0.1
 * @package		ARCNAAnimals
 * @author 		Phil Snell
 * @author mail	phil@snellcode.com
 * @link		http://snellcode.com
 * @copyright	Copyright (C) 2010 Phil Snell - All rights reserved.
 * @license		GNU/GPL
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');


/**
* Animals Table class
*
* @package		Joomla
* @subpackage	Weblinks
* @since 1.0
*/
class TableAnimals extends JTable
{

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		$tableName = '#__arcna_animals';
		parent::__construct($tableName, 'id', $db);

		$fields = &$this->getFields();
		$this->initDataObject( $fields, $this );

	}

	function getSelectOptions()
	{
		$array = array(
			'species'=> array( 'Dog','Cat' ),
			'gender'=>array('M','F'),
			'altered'=>array('Y','N','Unknown'),
			'real_time_need'=> array( 'Rescue','Foster','Adoption','Transport'),
			'real_time_status'=>array( 'Urgent', 'OOS' ),
			'adoption_status'=>array('Pending','Saved','PTS'),
			'location_state'=>array('AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA','ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY')
		);
		
		return $array;
		
		
	}
	
	function canEdit( $item, $user = null )
	{
		if(is_null( $user ) ) {
			$user =& JFactory::getUser();
		}
		return ( ( $user->gid >= 19 && ( $item->id === null || $item->created_by == $user->id ) ) || $user->gid >= 24  );
		
	}
	
	
	function getFields()
	{
		$tableName = $this->getTableName();
		$fields = &$this->_db->getTableFields( $tableName, false );
		return $fields[$tableName];
	}
	
	function initDataObject( &$fields, &$object )
	{
		foreach( $fields as $field ) {
			$name = $field->Field;
			$object->$name = null;
		}
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
	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}

	function getRequiredFields()
	{
		$requiredFields = array( 'name', 'species', 'breed', 'age', 'gender', 'color', 'altered', 
		  'location_state', 'location_city', 'shelter_name', 'adoption_status', 'real_time_need', 
		  'real_time_status', 'available_date', 'pull_by_date', 'contact_name', 
		  'contact_email' );	
		return $requiredFields;
	}
	
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		$requiredFields = $this->getRequiredFields();
		$missingFields = array();
		foreach( $requiredFields as $requiredField ) {
			if(empty($this->$requiredField)) {
				$missingFields[] = $requiredField;
			}
		}
		if(!empty($missingFields)) {
			$this->setError(JText::_('The following required fields are missing: ' . implode( ', ' , $missingFields)));
			return false;
		}

		if(empty($this->alias)) {
			$this->alias = $this->name;
		}
		$this->alias = JFilterOutput::stringURLSafe($this->alias);
	
		if(trim(str_replace('-','',$this->alias)) == '') {
			$datenow =& JFactory::getDate();
			$this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
		}

		return true;
	}
}
