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
jimport('joomla.application.component.model');

class ARCNAAnimalsModelAnimals extends JModel {

	var $__state_set = false;  // flag if the sate has been initialized
	var $_items = array(); // the array of data objects
	var $_fields = array(); // the array fields metadata
	var $_requiredFields = array(); // the array fields metadata
	var $_item = null; // a single record
	var $_id = null; // the current record id



	
	/* 
	* init the model, setting the current id
	*/
	function __construct() {
		parent::__construct();
		$array = JRequest::getVar('cid', array(0), '', 'array');
		$this->setId((int)$array[0]);
	}
	
	/* 
	* used to reset the id used by the model
	*/
	function setId($id) {
		$this->_id = $id;
	}
	/*
	* filter / sort states
	*/
	function getState($property = null)
	{
		if (!$this->__state_set) {
			$option = JRequest::getCmd('option');
			$app = &JFactory::getApplication();
			$context = $option.'.'.$this->getName();
			$this->setState('filter_published',$app->getUserStateFromRequest( $context.'.filter_published', 'filter_published', 0, 'int' ));
			$this->setState('filter_catid',$app->getUserStateFromRequest( $context.'.filter_catid', 'filter_catid', 0, 'int' ));
			$this->setState('filter_species',$app->getUserStateFromRequest( $context.'.filter_species', 'filter_species', 0, 'word' ));
			$this->setState('filter_location_state',$app->getUserStateFromRequest( $context.'.filter_location_state', 'filter_location_state', 0, 'word' ));
			$this->setState('filter_adoption_status',$app->getUserStateFromRequest( $context.'.filter_adoption_status', 'filter_adoption_status', 0, 'word' ));
			$this->setState('filter_real_time_need',$app->getUserStateFromRequest( $context.'.filter_real_time_need', 'filter_real_time_need', 0, 'word' ));
			$this->setState('filter_real_time_status',$app->getUserStateFromRequest( $context.'.filter_real_time_status', 'filter_real_time_status', 0, 'word' ));
			$this->setState('filter_search', $app->getUserStateFromRequest($context.'.filter_search', 'filter_search', ''));
			$this->setState('filter_order', $app->getUserStateFromRequest($context.'.filter_order', 'filter_order', 'title', 'cmd'));
			$this->setState('filter_order_Dir', $app->getUserStateFromRequest($context.'.filter_order_Dir', 'filter_order_Dir', 'ASC', 'word'));
		
			$limit		= $app->getUserStateFromRequest($context.'.limit', 'limit', $app->getCfg('list_limit', 5), 'int');
			
			//strange limitstart
			//	$limitstart	= $app->getUserStateFromRequest( $context.'.limitstart', 'limitstart', 0, 'int' );
			$limitstart	= JRequest::getInt('limitstart', 0, '', 'int');
			$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
			
			$this->setState('limit', $limit);
			$this->setState('limitstart', $limitstart);
			
			$this->__state_set = true;
		}
		return parent::getState($property);
	}

	/* 
	* gets a single record, or inits a new empty record
	*/
	function getItem() 
	{
		if(!$this->_item) {
			if (!$this->_id) {
				$this->_initItem();
			} else {
				$this->setState('filter_id', $this->_id );
				$query = $this->_buildQuery();
				$this->_db->setQuery( $query );
				$this->_item = $this->_db->loadObject();
			}
			
		}
		return $this->_item;
	}
	
	/* 
	* gets a list of records, with pagination 
	*/
	function getItems()
	{
		if (empty($this->_items)) {
			$this->_id = null;
			$option = JRequest::getCmd('option');
			$view = JRequest::getCmd('view'); 
			$limitstart = $this->getState('limitstart');
			$limit = $this->getState('limit');
			$query = $this->_buildQuery();
			$this->_items = $this->_getList($query, $limitstart, $limit);
		}

		//echo '<pre>';var_dump( $this->_items );echo '</pre>';exit;
		return $this->_items;
	}

	/* 
	* gets some fields metadata
	*/
	function getFields()
	{
		if( empty( $this->_fields ) ) {
			$this->_fields = $this->getTable()->getFields();
		}
		
		return $this->_fields;	

	}

	/* 
	* gets some fields metadata
	*/
	function getRequiredFields()
	{
		if( empty( $this->_requiredFields ) ) {
			$this->_requiredFields = $this->getTable()->getRequiredFields();
		}
		
		return $this->_requiredFields;	

	}
	
	/* 
	* makes the sql select query based on state filters
	*/
	function _buildQuery()
	{
		$app =& JFactory::getApplication();
		$where = array();
		$contentTableName = $this->_db->nameQuote( '#__arcna_animals' );
		$categoryTableName = $this->_db->nameQuote('#__categories');
		$filter_order = $this->getState('filter_order');
		$filter_order_Dir = $this->getState('filter_order_Dir');
		$filter_search = $this->getState('filter_search');
		$filter_catid = $this->getState('filter_catid');
		$filter_species = $this->getState('filter_species');
		$filter_location_state = $this->getState('filter_location_state');
		$filter_real_time_need = $this->getState('filter_real_time_need');
		$filter_real_time_status = $this->getState('filter_real_time_status');
		$filter_adoption_status = $this->getState('filter_adoption_status');
		$filter_id = $this->getState('filter_id');
		$filter_published = $this->getState('filter_published');
		
		if ($filter_adoption_status ) {
			$where[] = 'animal.adoption_status = '.$this->_db->Quote( $filter_adoption_status );
		}
		
		if ($filter_species ) {
			$where[] = 'animal.species = '.$this->_db->Quote( $filter_species );
		}

		if ($filter_real_time_status ) {
			$where[] = 'animal.real_time_status = '.$this->_db->Quote( $filter_real_time_status );
		}

		if( $filter_id ) {
			$where[] = 'animal.id = '.(int) $filter_id;
		}

		if ($filter_published > 0) {
			$where[] = 'animal.published = '.(int) $filter_published;
		}
		
		if ($filter_catid > 0) {
			$where[] = 'animal.catid = '.(int) $filter_catid;
		}


		if ($filter_location_state ) {
			$where[] = 'animal.location_state = '.$this->_db->Quote( $filter_location_state );
		}

		if ($filter_real_time_need ) {
			$where[] = 'animal.real_time_need = '.$this->_db->Quote( $filter_real_time_need );
		}

		
		if ( $filter_search ) {
			$where[] = 'LOWER(animal.name) LIKE '.$this->_db->Quote( '%'.$this->_db->getEscaped( $filter_search, true ).'%', false );
		}
		
		$where = ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		
		$query = "SELECT animal.*"
		 . " FROM $contentTableName AS animal"
		 //. " LEFT JOIN $categoryTableName AS category ON content.catid = category.id"
		 . $where
		 . " ORDER BY {$filter_order} {$filter_order_Dir}"
		 ;
		
		// echo '<p>'.str_replace( '#__','jos_',$query ).'</p>';
		
		return $query;
	}
	
	/* 
	* get the fields and set them to null for a new record
	*/
	function _initItem()
	{
		$table = &$this->getTable();
		$fields = &$table->getFields($table->getTableName());
		$this->_item = new StdClass;
		$table->initDataObject( $fields, $this->_item );	
	}

	/* 
	* gets the complete record set
	*/
	function getTotal()
	{
		if (empty($this->_total)) {
			$query = $this->_buildQuery();
			@$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	/* 
	* the pagination object, for dealing with page links
	*/
	function getPagination()
	{
		$limitstart = $this->getState('limitstart');
		$limit = $this->getState('limit');
		if (empty($this->_pagination)) {
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $limitstart, $limit );
		}
		return $this->_pagination;
	}
	
	/*
	* for help creating ordering selections
	*/
	function getOrderingQuery()
	{
			// build the html select list for ordering
		$orderingQuery = 'SELECT ordering AS value, title AS text'
			. ' FROM #__arcna_animals'
			//. ' WHERE catid = ' . (int) $item->catid
			. ' ORDER BY ordering';	
		return $orderingQuery;
	}
	
	/*
	* save a single record
	*/
	function save( &$data ) {
		$table =& $this->getTable();



		if (!$table->bind($data)) {
			$this->setError($table->getErrorMsg());
			return false;
		}
		
		// for allow html records...
		// fix up special html fields
		$fields = $table->getFields();

		foreach( $fields as $field ) {
			if( $field->Type == 'text' && $field->Field != 'params' ) {
				$name = $field->Field;
				$table->$name = JRequest::getVar( $name, '', 'post', 'string', JREQUEST_ALLOWHTML );
			}
		}
		
		if (!$table->id) {
			$where = ( @$table->catid ) ? 'catid = ' . (int) $table->catid : null;
			$table->ordering = $table->getNextOrder( $where );
			
			$user = &JFactory::getUser();
			$table->created_by 	= $user->get('id');
		}

	
	// $user = &JFactory::getUser();
	// $table->created_by 	= $table->created_by ? $table->created_by : $user->get('id');

		if ($table->created && strlen(trim( $table->created )) <= 10) {
			$table->created 	.= ' 00:00:00';
		}

		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($table->created, $tzoffset);
		$table->created = $date->toMySQL();
		
		if (!$table->check()) {
			$this->setError($table->getError());
			return false;
		}

		// image upload
		jimport('joomla.filesystem.file');
		$image = JRequest::getVar('image', null, 'files', 'array');
		if ( strtolower(JFile::getExt($image['name']) ) == 'jpg') {
			$imageFilename = JFilterOutput::stringUrlSafe($table->name).'_'.time().'.jpg';
			$src = $image['tmp_name'];
			$dest = JPATH_ROOT . '/media/com_arcnaanimals/'.$imageFilename;
			if ( JFile::upload($src, $dest) ) {
				 
			}
		}
		
		// auto publish
		$table->published = 1;

		$table->image = $imageFilename;
		if (!$table->store()) {
			$this->setError($table->getError());
			return false;
		}

		return $table->id;
	}

	/*
	* deletes one or many records
	*/
	function delete($cid = array())	{
		if (count( $cid )) {
			$table =& $this->getTable();
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM '.$table->getTableName()
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/* 
	* moves on record up or down in ordering
	*/
	function move($direction) {
		$table =& $this->getTable();
		if (!$table->load($this->_id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// $where = (@$table->catid) ? ' catid = '.(int) $table->catid.' AND published >= 0 ' : null;
		$where = null;
		
		if (!$table->move( $direction, $where )) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/* 
	* save changes to ordering on all records
	*/
	function saveorder($cid = array(), $order) {
		$table =& $this->getTable();
		$groupings = array();
		for( $i=0; $i < count($cid); $i++ ) {
			$table->load( (int) $cid[$i] );
			$groupings[] = $table->catid;
			if ($table->ordering != $order[$i]) {
				$table->ordering = $order[$i];
				if (!$table->store()) {
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}
		$groupings = array_unique( $groupings );
		foreach ($groupings as $group){
			$table->reorder('catid = '.(int) $group);
		}
		return true;
	}

	/*
	* publish or unpublish one or many records
	*/
	function publish($cid = array(), $publish = 1) {
		$user 	=& JFactory::getUser();
		$table =& $this->getTable();
		if (count( $cid )) {
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'UPDATE ' .$table->getTableName()
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	/* 
	* check out a single record, locking it from other admins
	*/
	function checkout($uid = null) {
		if ($this->_id) {
			$table = & $this->getTable();
			if (is_null($uid)) {
				$user	=& JFactory::getUser();
				$uid	= $user->get('id');
			}
			if(!$table->checkout($uid, $this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}
	
	/*
	* check in the record after editing is done
	*/
	function checkin() {
		if ($this->_id) {
			$table =& $this->getTable();
			if( !$table->checkin($this->_id)) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}
	
	
}
