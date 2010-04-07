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
JHTML::_('behavior.keepalive');
$option = JRequest::getCmd('option');
$doc =& JFactory::getDocument();
// Set toolbar items for the page
JToolBarHelper::title(   JText::_( 'Animal' ) );
JToolBarHelper::apply();
JToolBarHelper::save();
JToolBarHelper::cancel();

$doc->addStyleDeclaration("
#system-message .required,
#animalProfile .required {
	border:2px solid #fc0 !important; 
}
#system-message .error,
#animalProfile .error {
	border:2px solid #f00 !important; 
}
#system-message .valid,
#animalProfile .valid {
	border:2px solid #0f0 !important; 
}

");

JFactory::getApplication()->enqueueMessage('Please note: There are <span class="required">required</span> fields. Take note of any <span class="error">errors</span>, to make sure the form is <span class="valid">valid</span> ','notice');
$requiredFieldsJson = json_encode( $this->requiredFields );
$doc->addScriptDeclaration("

	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		var requiredFieldsJson = {$requiredFieldsJson};
		var missingFields = [];

		requiredFieldsJson.each(function(i){
			
			$(i).removeClass('error');
			$(i).removeClass('valid');
			
			if( false === Boolean( $(i).value ) || $(i).value === '0000-00-00 00:00:00' ) {
				$(i).addClass('error');
				missingFields.push( i );
			} else if( 'SELECT' === $(i).tagName ) {
				if( 0 === $(i).selectedIndex ) {
					$(i).addClass('error');
					missingFields.push( i );
				} else {
					$(i).removeClass('error');
					$(i).addClass('valid');
				}
			} else {
				$(i).removeClass('error');
				$(i).addClass('valid');
			}
		});

		if( 0 !== missingFields.length ) {
			alert('You missed some required fields');
			return false;
		} else {
			submitform( pressbutton );
		}

	}
");

?>
<div id='animalProfile'>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype='multipart/form-data'>
	<div class="col width-50">
	<table class="admintable">
	<tr><td>ID</td><td><?php echo $this->item->id; ?></td></tr>
	<?php
	echo JHTML::_('arcna.admintablerow', 'published', 'published', $this->item->published );
	echo JHTML::_('arcna.admintablerow', 'text', 'name', $this->item->name );
	echo JHTML::_('arcna.admintablerow', 'image', 'image', $this->item->image );
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'species', $this->item->species );
	echo JHTML::_('arcna.admintablerow', 'text', 'breed', $this->item->breed );
	echo JHTML::_('arcna.admintablerow', 'text', 'age', $this->item->age );
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'gender', $this->item->gender );
	echo JHTML::_('arcna.admintablerow', 'text', 'color', $this->item->color );
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'altered', $this->item->altered);
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'location_state', $this->item->location_state );
	echo JHTML::_('arcna.admintablerow', 'text', 'location_city', $this->item->location_city );
	echo JHTML::_('arcna.admintablerow', 'text', 'shelter_name', $this->item->shelter_name );
	echo JHTML::_('arcna.admintablerow', 'text', 'shelter_id', $this->item->shelter_id );
	echo JHTML::_('arcna.admintablerow', 'text', 'shelter_phone', $this->item->shelter_phone );
	echo JHTML::_('arcna.admintablerow', 'text', 'shelter_address', $this->item->shelter_address );	
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'adoption_status', $this->item->adoption_status );
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'real_time_need', $this->item->real_time_need );
	echo JHTML::_('arcna.admintablerow', 'dropdown', 'real_time_status', $this->item->real_time_status );
	echo JHTML::_('arcna.admintablerow', 'date', 'date_in', $this->item->date_in );
	echo JHTML::_('arcna.admintablerow', 'date', 'available_date', $this->item->available_date );
	echo JHTML::_('arcna.admintablerow', 'date', 'pull_by_date', $this->item->pull_by_date );	
	echo JHTML::_('arcna.admintablerow', 'text', 'contact_name', $this->item->contact_name );
	echo JHTML::_('arcna.admintablerow', 'text', 'contact_email', $this->item->contact_email );
	echo JHTML::_('arcna.admintablerow', 'text', 'contact_phone', $this->item->contact_phone );
	?>
	
	</table>
	</div>
	<div class="col width-50">
	<table class="admintable">
	
	<tr>
	<td colspan="2">
		<?php echo $this->params->render(); ?>
	</td>
	</tr>
	
	<?php
	
	echo JHTML::_('arcna.admintablerow', 'textarea', 'comments', $this->item->comments );
	echo JHTML::_('arcna.admintablerow', 'textarea', 'special_needs', $this->item->special_needs );
	echo JHTML::_('arcna.admintablerow', 'textarea', 'behavior_evaluation', $this->item->behavior_evaluation );
	echo JHTML::_('arcna.admintablerow', 'textarea', 'concerns', $this->item->concerns );
	echo JHTML::_('arcna.admintablerow', 'textarea', 'general_comments', $this->item->general_comments );
	?>
	
	</table>
	</div>
	
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
