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

$option = JRequest::getCmd('option');
$view = JRequest::getCmd('view' );
$Itemid = JRequest::getInt('Itemid');

JToolBarHelper::title("ARCNA Animals");
JToolBarHelper::publishList();
JToolBarHelper::unpublishList();
JToolBarHelper::deleteList('Permanently delete record(s)?');
JToolBarHelper::editListX();
JToolBarHelper::addNewX();
JToolBarHelper::preferences( $option, '380');

?>

<form action="<?php echo $this->action;?>" method="post" name="adminForm">
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
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>

			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'id', 'id', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th width="1%" nowrap="nowrap">
				<?php echo JText::_('image' ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'name', 'name', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'species', 'species', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>			
										
			<th>
				<?php echo JHTML::_('grid.sort',  'Breed', 'breed', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Age', 'age', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Gender', 'gender', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Color', 'color', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Altered', 'altered', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
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

			<th>
				<?php echo JHTML::_('grid.sort',  'Real Time Need', 'real_time_need', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Adoption Status', 'adoption_status', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
					
			<th>
				<?php echo JHTML::_('grid.sort',  'Real Time Status', 'real_time_status', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			
			<th>
				<?php echo JHTML::_('grid.sort',  'Available Date', 'available_date', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>

			<th>
				<?php echo JHTML::_('grid.sort',  'Pull By Date', 'pull_by_date', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			
			
			<th width="8%">
				<?php echo JHTML::_('grid.sort',  'created', 'created', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'Published', 'published', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
			</th>
			<th width="8%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',  'Order', 'ordering', $this->state->filter_order_Dir, $this->state->filter_order ); ?>
				<?php if ($this->state->filter_order) echo JHTML::_('grid.order',  $this->items ); ?>
			</th>

		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="50">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++) {
		$item = &$this->items[$i];
		$url = JRoute::_("index.php?option={$option}&amp;task=edit&amp;cid[]={$item->id}");
		$checked 	= JHTML::_('grid.checkedout',   $item, $i );
		$published 	= JHTML::_('grid.published', $item, $i );
		$isCheckedOut = JTable::isCheckedOut($this->user->get ('id'), $item->checked_out );
		
		$thumbnail = JHTML::_('arcna.thumbnail', $item->image, 120, 120 );
		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>

			<td align="center">
				<?php
				if ( $isCheckedOut ) {
					echo $this->escape($item->id);
				} else {
				?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Item' );?>::<?php echo $this->escape($item->name); ?>">
					<a href="<?php echo $url; ?>">
						<?php echo $this->escape($item->id); ?></a></span>
				<?php
				}
				?>
			</td>

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
			</td>
					
			<td>
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
				<?php echo $item->species; ?>
			</td>
			
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
				<?php echo $item->color; ?>
			</td>

			<td align="center">
				<?php echo $item->altered; ?>
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
			
			<td align="center">
				<?php echo $item->real_time_need; ?>
			</td>

			<td align="center">
				<?php echo $item->adoption_status; ?>
			</td>
					
			<td align="center">
				<?php echo $item->real_time_status; ?>
			</td>
			
			<td align="center">
				<?php echo $item->available_date; ?>
			</td>
			
			<td align="center">
				<?php echo $item->pull_by_date; ?>
			</td>
						
			
			<td align="center">
				<?php echo $item->created; ?>
			</td>
			<td align="center">
				<?php echo $published;?>
			</td>
			<td class="order">
				<span><?php echo $this->pagination->orderUpIcon( $i, true,'orderup', 'Move Up', ( $this->state->filter_order == 'ordering' ) ) ; ?></span>
				<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', ( $this->state->filter_order == 'ordering' ) ); ?></span>
				<?php $disabled = $this->state->filter_order?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
			</td>


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
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->state->filter_order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->state->filter_order_Dir; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
