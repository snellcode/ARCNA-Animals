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

jimport('joomla.application.component.controller');

class ARCNAAnimalsController extends JController
{
	function __construct()
	{
		$option = JRequest::getCmd('option');
		JHTML::_('behavior.mootools');
		JFactory::getDocument()->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');
				
		// add some common stuff from admin, can just be copied into the frontend if needed
		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models' );
		JFactory::getLanguage()->load( $option, JPATH_ADMINISTRATOR );
		
		parent::__construct();
		// Register task to a method (first arg is a task)
		$this->registerTask( 'add',  'edit' );
	}

	function display()
	{

		if( !JRequest::getCmd('view') ) {
			JRequest::setVar('view','animals');
		}
		parent::display();
	}
	
	function edit()
	{
		$doc = &JFactory::getDocument();
		$model = &$this->getModel('animals');
		
		
		$view = &$this->getView('animal', $doc->getType() );
		$view->setModel( $model, true );
		$view->display();
	}

	function save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		

		
		$post	= JRequest::get('post');
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		$post['id'] = $cid[0];
		
		$view = JRequest::getCmd( 'view' );
		$option = JRequest::getCmd('option');
		$msg = '';
		$type = '';
		
		$model = &$this->getModel('animals');

		if ($id = $model->save($post)) {
			$msg = JText::_( 'Saved' );
		} else {
			$msg = $model->getError();
			$type = 'error';
		}

		if( $this->getTask() == 'apply' ) {

			parent::setRedirect( "index.php?option={$option}&task=edit&cid[]={$id}", $msg, $type );
			return;
		}

		$this->setRedirectDefault($msg, $type);
	}

	function setRedirectDefault( $msg = null, $type = '', $args = null )
	{
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd( 'view' );	
		parent::setRedirect( "index.php?option={$option}&view={$view}{$args}", $msg, $type );
	}

}
