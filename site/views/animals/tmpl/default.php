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
 
$filter_species = JRequest::getWord('filter_species');

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.keepalive');
$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view' );
$Itemid = JRequest::getInt('Itemid');
	
	
// for the filters available, make the reset button javascript

$availableFilters = array('species','location_state','real_time_need','real_time_status');
$filterResetJavascript = '';
foreach( $availableFilters as $availableFilter ) {
	$filterResetJavascript .= "document.adminForm.getElementById('filter_{$availableFilter}').value='0';";
}
$filterResetJavascript .= "document.adminForm.submit();";

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration("

#whitebox #editcell div {
	text-align:center !important;
}

.list-footer {
	padding:10px;
	
}

#editcell {
	font-size:10px;
}

.adminlist {
		width:100%;
	border-collapse:collapse;
}

.adminlist select {
	font-size:10px;
}

.adminlist th {
	padding:2px;
	text-align:center;
	vertical-align:top;
	
}

.adminlist .row0,
.adminlist .adminlistSort th {
	background:#eee;

	
}


.adminlist th,
.adminlist tbody td {
	border:1px solid #ccc;
}

.arcnaButton {
	border:1px solid #09c;
	background:#ccc;
	padding:5px;
	display:block;
	text-align:center;
}

");
	



?>
	



<form action="<?php echo $this->action;?>" method="post" name="adminForm">
<?php /*
<table>
<tr>
	<td align="left" width="100%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->filter_search;?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('filter_search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
</tr>
</table>
*/
?>
<div id="editcell">
	
	<table class="adminlist">
	<thead>
		<?php if( $this->user->gid >= 19  ) : ?>
			<tr><th colspan='23'><a class='arcnaButton' href='<?php echo JRoute::_("index.php?option={$option}&task=add"); ?>'>Submit a new record</a></th></tr>
		<?php endif; ?>

		<tr class="adminlistSort">

			<th style="width:100px">Sort by :</th>

			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'id', 'id', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			
			<?php if( $this->params->get('show_species', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'species', 'species', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
			<th><?php echo JHTML::_('grid.sort',  'Breed', 'breed', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>

			<th><?php echo JHTML::_('grid.sort',  'Age', 'age', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Gender', 'gender', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'State', 'location_state', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
				
			<th>
				<?php echo JHTML::_('grid.sort',  'City', 'location_city', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Shelter Name', 'shelter_name', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			
			<?php if( $this->params->get('show_real_time_need', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'Real Time Need', 'real_time_need', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_real_time_status', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'Real Time Status', 'real_time_status', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_available_date', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'Available Date', 'available_date', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_pull_by_date', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'Pull By Date', 'pull_by_date', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_created', 1 ) ) : ?>
			<th><?php echo JHTML::_('grid.sort',  'created', 'created', $this->state->filter_order_Dir, $this->state->filter_order ); ?></th>
			<?php endif; ?>
			
		</tr>
		<tr class="adminlistFilter">
			<th>
				Filters : <a href="#" onclick="<?php echo $filterResetJavascript;?>">reset all</a>
			</th>

			<th>
				
			</th>
			
			<?php if( $this->params->get('show_species', 1 ) ) : ?>
			<th><?php echo JHTML::_('arcna.filter',  'species', $this->state->filter_species); ?></th>
			<?php endif; ?>
			
			<th>
				
			</th>

			<th>
				
			</th>

			<th>
				
			</th>

			<th>
				<?php echo JHTML::_('arcna.filter',  'location_state', $this->state->filter_location_state); ?>
			</th>
				
			<th>
				
			</th>

			<th>
				
			</th>
			
			<?php if( $this->params->get('show_real_time_need', 1 ) ) : ?>
			<th><?php echo JHTML::_('arcna.filter',  'real_time_need', $this->state->filter_real_time_need); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_real_time_status', 1 ) ) : ?>
			<th><?php echo JHTML::_('arcna.filter',  'real_time_status', $this->state->filter_real_time_status ); ?></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_available_date', 1 ) ) : ?>
			<th></th>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_pull_by_date', 1 ) ) : ?>
			<th></th>
			<?php endif; ?>
				
			<?php if( $this->params->get('show_created', 1 ) ) : ?>
			<th></th>
			<?php endif; ?>
			
	</tr>

	</thead>
	<tfoot>
		<tr>
			<td colspan="23">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
		$item = &$this->items[$i];
		$slug = JFilterOutput::stringUrlSafe( $item->location_state .'-'.$item->location_city . '-' . $item->name );
		$url = JRoute::_("index.php?option={$option}&amp;task=edit&amp;cid[]={$item->id}:{$slug}");
		$checked 	= JHTML::_('grid.checkedout',   $item, $i );
		$published 	= JHTML::_('grid.published', $item, $i );
		$isCheckedOut = JTable::isCheckedOut($this->user->get ('id'), $item->checked_out );
		
		$thumbnail = JHTML::_('arcna.thumbnail', $item->image, 100, 100 );
		
		?>
		<tr class="<?php echo "row$k"; ?>">


			
			<td align="center">
				<?php
				if ( $isCheckedOut ) { 
					echo $thumbnail;
				} else {
				?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Item' );?>::<?php echo $this->escape($item->name); ?>">
					<a href="<?php echo $url; ?>">
						<?php echo $thumbnail; ?>
					</a>
				</span>
				<?php
				}
				?>

				<?php
				if ( $isCheckedOut ) {
					echo $this->escape($item->name);
				} else {
				?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Item' );?>::<?php echo $this->escape($item->name); ?>">
					<a href="<?php echo $url; ?>">
						<?php echo $this->escape($item->name); ?></a></span>
				<?php
				}
				?>

			</td>
			
			<td align="center">
				<?php echo $item->id; ?>
			</td>

			<?php if( $this->params->get('show_species', 1 ) ) : ?>
			<td align="center"><?php echo $item->species; ?></td>
			<?php endif; ?>
			
			<td align="center">
				<?php echo $item->breed; ?>
			</td>
			
			<td align="center">
				<?php echo $item->age; ?>
			</td>
			
			<td align="center">
				<?php echo $item->gender; ?>
			</td>
						
			<td align="center">
				<?php echo $item->location_state; ?>
			</td>
			
			<td align="center">
				<?php echo $item->location_city; ?>
			</td>
			
			<td align="center">
				<?php echo $item->shelter_name; ?>
			</td>

			<?php if( $this->params->get('show_real_time_need', 1 ) ) : ?>
			<td align="center"><?php echo $item->real_time_need; ?></td>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_real_time_status', 1 ) ) : ?>
			<td align="center"><?php echo $item->real_time_status; ?></td>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_available_date', 1 ) ) : ?>
			<td align="center"><?php echo JFactory::getDate( $item->available_date )->toFormat('%m/%d/%Y'); ?></td>
			<?php endif; ?>
			
			<?php if( $this->params->get('show_pull_by_date', 1 ) ) : ?>
			<td align="center"><?php echo JFactory::getDate(  $item->pull_by_date )->toFormat('%m/%d/%Y'); ?></td>
			<?php endif; ?>
				
			<?php if( $this->params->get('show_created', 1 ) ) : ?>
			<td align="center"><?php echo JFactory::getDate( $item->created )->toFormat('%m/%d/%Y'); ?></td>
			<?php endif; ?>

		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
	</table>
</div>

	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="view" value="<?php echo $view;?>" />
	<input type="hidden" name="Itemid" value="<?php echo $Itemid;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="viewcache" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->state->filter_order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->filter_order_Dir; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
