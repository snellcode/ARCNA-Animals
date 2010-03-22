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

class JHTMLArcna
{
	function thumbnail( $filename, $width = 640, $height = 480 ) 
	{
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$source = "/media/com_arcnaanimals/{$filename}";
		if( !JFile::exists( JPATH_ROOT.$source ) ) return false;
		
		$destination = "/media/com_arcnaanimals/thumbs/{$width}_{$height}_{$filename}";
		if( !JFile::exists( JPATH_ROOT.$destination ) ) {
			if( !JFolder::exists( dirname( JPATH_ROOT.$destination ) ) ) {
				JFolder::create( dirname( JPATH_ROOT.$destination ) );
			}
			require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/thumbnail/Thumbnail.class.php');
			$thumb=new Thumbnail(JPATH_ROOT.$source);	        // Contructor and set source image file
			$thumb->size($width,$height);		                // [OPTIONAL] set the biggest width and height for thumbnail
			$thumb->process();   				        // generate image
			// save the file
			ob_start();
			$thumb->show();
			$output = ob_get_contents();
			ob_end_clean();
			JFile::write(JPATH_ROOT.$destination,$output);
		}	
		$url = JURI::root(true).$destination;
		return "<img src='$url' alt='{$filename}'/>";
	}
	
	function filter( $name, $value, $options = array() )
	{
		static $table;
		if( !isset( $table ) ) {
			$table = &JTable::getInstance( 'animals', 'Table' );
		}
		
		$title = JText::_( ucwords( str_replace( '_', ' ' , $name ) ) );
		$selectOptions = $table->getSelectOptions();
		$options = $options ? $options : $selectOptions[$name];
		$attribs = ' onchange="document.adminForm.submit();"';
		return JHTMLArcna::getAdmintablerowDropdown( $title, 'filter_'.$name, $value, null, $options, $attribs );		
	}
	
	function readonlytablerow( $type, $name, $value, $options = array() ) {
		if( !$value ) return false;
		
		$title = JText::_( ucwords( str_replace( '_', ' ' , $name ) ) );
		$html = "<tr id='admintablerow_{$name}'>
		<td width='100' align='right' class='key'>
			<label for='{$name}'>{$title}</label>
		</td>
		<td>";
	
		switch( $type ) {
			case 'image' :
				$html .= JHTMLArcna::thumbnail( $name, $value );
				break;
			default:
				$html .= $value;
		}
	
		$html .="</td></tr>";
		return $html;	
	}
	
	
	function admintablerow( $type, $name, $value, $options = array() )
	{
	
		static $table, $app, $user;
		
		if( !isset( $table ) ) {
			$table = &JTable::getInstance( 'animals', 'Table' );
		}
		
		if( !isset( $app ) ) {
			$app = &JFactory::getApplication();
		}
		
		if( !isset( $user ) ) {
			$user = &JFactory::getUser();
		}
	
		$requiredFields = $table->getRequiredFields();
		$required = in_array( $name, $requiredFields ) ? 'required' : '';
		
		$title = JText::_( ucwords( str_replace( '_', ' ' , $name ) ) );
		$html = "<tr id='admintablerow_{$name}'>
		<td width='100' align='right' class='key'>
			<label for='{$name}'>{$title}</label>
		</td>
		<td>";

		switch( $type ) {
			case 'text' :
				$html .= JHTMLArcna::getAdmintablerowText( $title, $name, $value, $required );
				break;
			case 'image' :
				$html .= JHTMLArcna::getAdmintablerowimage( $title, $name, $value, $required );
				break;
			case 'date' :
				$html .= JHTMLArcna::getAdmintablerowDate( $title, $name, $value, $required );
				break;
			case 'dropdown' :
				$selectOptions = $table->getSelectOptions();
				$options = $options ? $options : $selectOptions[$name];
				$html .= JHTMLArcna::getAdmintablerowDropdown( $title, $name, $value, $required, $options );
				break;
			case 'textarea' :
				$html .= JHTMLArcna::getAdmintablerowTextarea( $title, $name, $value, $required );
				break;
			case 'readonly' :
				$html .= JHTMLArcna::getAdmintablerowReadonly( $title, $name, $value, $required );
				break;
			case 'published' :
				$html .= JHTMLArcna::getAdmintablerowPublished( $title, $name, $value, $required );
				break;
			default :
				$html .= 'JHTMLArcna says "field type not found"';
		}		
			
		$html .="</td></tr>";
		return $html;	
	}
	
	function getAdmintablerowText( $title, $name, $value, $required )
	{	
		$class = "text_area";
		$class .= $required ? " $required" : '';
		return "<input class='{$class}' type='text' name='{$name}' id='{$name}' size='32' maxlength='250' value='{$value}' />";
	}

	function getAdmintablerowReadonly( $title, $name, $value, $required )
	{	
		return $value;
	}
	
	function getAdmintablerowimage( $title, $name, $value, $required )
	{
		$thumbnail = JHTMLArcna::thumbnail( $value );
		return "{$thumbnail}<br />upload new / replace existing<br /><input type='file' id='{$name}' name='{$name}' />";
	}
	
	function getAdmintablerowDate( $title, $name, $value, $required )
	{
		JHTML::_('behavior.calendar');
		$attribs = $required ? array('class'=>$required) : array();
		return JHTML::calendar( $value, $name, $name, '%Y-%m-%d', $attribs );
	}
	
	function getAdmintablerowDropdown( $title, $name, $value, $required, $options, $attribs = '' )
	{
		$array = array();
		$array[] = JHTML::_('select.option', '0', '- Select -' );

		foreach( $options as $option ) {
			$array[] = JHTML::_('select.option', $option, $option );
		}
		$attribs .= $required ? " class='$required'" : '';
		return JHTML::_('select.genericlist', $array, $name, $attribs, 'value', 'text', $value);
	}

	function getAdmintablerowTextarea( $title, $name, $value )
	{	
		return "<textarea class='text_area' rows='10' cols='60' name='{$name}' id='{$name}'>{$value}</textarea>";
	}
	
	function getAdmintablerowPublished( $title, $name, $value )
	{
		return JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $value );
	}
	
	
}
