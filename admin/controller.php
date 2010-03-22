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
		parent::__construct();
		// Register task to a method (first arg is a task)
		$this->registerTask( 'add',  'edit' );
		$this->registerTask( 'apply',  'save' );
		$this->registerTask( 'orderdown',  'orderup' );
		$this->registerTask( 'unpublish',  'publish' );
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

	function orderup()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		
		$model = $this->getModel('animals');
		$model->setId( $cid[0] );

		$msg = '';
		$direction = ( $this->getTask() == 'orderup' ) ? -1 : 1;
		if(!$model->move( $direction )){
			$msg = $model->getError();
		}
		$this->setRedirectDefault($msg);
	}

	function saveorder()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$view = JRequest::getCmd( 'view' );
		$msg = '';
		$cid 	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order 	= JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model = $this->getModel( $view );
		if( !$model->saveorder($cid, $order) ) { 
			$msg = $model->getError();
		}
		$this->setRedirectDefault($msg);
	}

	function publish()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$view = JRequest::getCmd( 'view' );
		$msg = '';
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}
		$publish = ( $this->getTask() == 'publish' ) ? 1 : 0;
		$model = $this->getModel( $view );
		if(!$model->publish($cid, $publish )) {
			$msg = $model->getError();
		}
		$this->setRedirectDefault($msg);
	}

	function cancel()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		JRequest::setVar( 'id', null );
		$this->setRedirectDefault();
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

	function remove()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$view = JRequest::getCmd( 'view' );
		$msg = '';
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);
		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}
		$model = $this->getModel( $view );
		if(!$model->delete($cid)) {
			$msg = $model->getError();
		}

		$this->setRedirectDefault($msg);
	}
	
	function maintenance()
	{
		JRequest::setVar('view','_maintenance');
		$this->setRedirectDefault();
	}

	
	function setRedirectDefault( $msg = null, $type = '', $args = null )
	{
		$option = JRequest::getCmd('option');
		$view = JRequest::getCmd( 'view' );
		parent::setRedirect( "index.php?option={$option}&view={$view}{$args}", $msg, $type );
	}

}
