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

function ARCNAAnimalsBuildRoute(&$query)
{
	$segments	= array();

	if( isset( $query['task'] ) && ( $query['task'] == 'edit' ) ) {
		$segments[] = str_replace( ":","-", $query['cid'][0] );
		unset( $query['task'] );
		unset( $query['cid'] );
		
	}
	return $segments;
}

function ARCNAAnimalsParseRoute($segments)
{
	$vars	= array();
	if( isset( $segments[0] ) ) {
		$vars['task'] = 'edit';
		$vars['cid'] = array( (int) $segments[0] );
	}
	return $vars;
}
