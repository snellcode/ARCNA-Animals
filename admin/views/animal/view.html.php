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

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.'/helpers/html');
		
class ARCNAAnimalsViewAnimal extends JView {

	/**
	/* displays the list of records 
	*/
	function display( $tpl = null )
	{
		// initialize variables
		$item = & $this->get('Item');
		$fields = & $this->get('Fields');
		$requiredFields = $this->get('requiredFields');
		$editor = &JFactory::getEditor();
		$orderingQuery = $this->get('OrderingQuery');

		// extra fields in params
		$file 	= JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'animal.xml';
		$params = new JParameter( $item->params, $file );
		
		// assign variables to template
		$this->assignRef( 'item', $item );
		$this->assignRef( 'fields', $fields );
		$this->assignRef( 'requiredFields', $requiredFields );
		$this->assignRef( 'editor', $editor );
		$this->assignRef( 'orderingQuery', $orderingQuery );
		$this->assignRef('params',		$params);
		
		// display template
		parent::display( $tpl );
	}
	
}
