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

class ARCNAAnimalsViewAnimals extends JView {

	/**
	/* displays the list of records 
	*/
	function display( $tpl = null )
	{
		// initialize variables
		$user = &JFactory::getUser();
		$uri = &JFactory::getURI();
		$state = &$this->get('state');
		$items = &$this->get('items');
		$pagination = &$this->get('pagination');
		
		// assign variables to template
		$this->assignRef( 'state', $state );
		$this->assignRef( 'items', $items );
		$this->assignRef( 'pagination', $pagination );
		$this->assignRef( 'user', $user );
		$this->assign( 'action', $uri->toString() );
		
		// display template
		parent::display( $tpl );
	}
	
}
