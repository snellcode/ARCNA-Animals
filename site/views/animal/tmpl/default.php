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
$task = JRequest::getCmd('task' );
$view = JRequest::getCmd('view');

// can the user submit a record?  does this record belong to them for editing?
$canEdit = $this->table->canEdit( $this->item );

$backUrl = JRoute::_("index.php?option={$option}"); 
$doc =& JFactory::getDocument();

$doc->addStyleDeclaration("

#animalProfile .arcnaButton {
	border-top:4px solid #eee !important; 
	border-left:4px solid #eee !important; 
	border-bottom:5px solid #ddd !important; 
	border-right:6px solid #ddd !important; 
	background:#ccc !important; 
	padding:5px !important; 
	display:block !important; 
	float:right !important; 
}

#animalProfile  .admintable {
	border-collapse:collapse !important; 
}
#animalProfile .admintable td {
	border:1px solid #ccc !important; 
}

#animalProfile .admintable .profileImage * {
	border:0 !important; 
	text-align:center !important; 
}

");


echo "<div id='animalProfile'>";
if( $canEdit ) {

/*
// Set toolbar items for the page
JToolBarHelper::title(   JText::_( 'Animal' ) );
JToolBarHelper::apply();
JToolBarHelper::save();
JToolBarHelper::cancel();
*/
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


//if( $this->user->gid == 19 ) {
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
		return false;

	}
");


?>


<form action="index.php" method="post" name="adminForm" id="adminForm" enctype='multipart/form-data'>

<?php  } // canSubmit ?>

	<table class="admintable">
	
	<tr>
		
	<td style="border:0" colspan="2">
		<?php if( $canEdit ) : ?>
		<a class="arcnaButton" href="#" onclick="submitbutton('save');return false;"><?php echo JText::_('Submit') ?></a>
		<?php endif; ?>
		<a class="arcnaButton" href='<?php echo $backUrl;?>'>Back to List</a></td>
	</tr>
	
	<tr><td>ID</td><td><?php echo $this->item->id; ?></td></tr>
	<?php
	
	
	$method = 'arcna.readonlytablerow';
	if(  $canEdit ) {
		$method = 'arcna.admintablerow';
	}
	
	if(  $canEdit ) {
		echo JHTML::_($method, 'text', 'name', $this->item->name );
		echo JHTML::_($method, 'image', 'image', $this->item->image );
	} else {
		
		echo '<tr class="profileImage"><td colspan="2">';
		echo '<h1>'.$this->item->name.'</h1>';
		echo JHTML::_('arcna.thumbnail',$this->item->image );
		echo '</td></tr>';
	}
	echo JHTML::_($method, 'dropdown', 'species', $this->item->species );
	echo JHTML::_($method, 'text', 'breed', $this->item->breed );
	echo JHTML::_($method, 'text', 'age', $this->item->age );
	echo JHTML::_($method, 'dropdown', 'gender', $this->item->gender );
	echo JHTML::_($method, 'text', 'color', $this->item->color );
	echo JHTML::_($method, 'dropdown', 'altered', $this->item->altered);
	echo JHTML::_($method, 'dropdown', 'location_state', $this->item->location_state );
	echo JHTML::_($method, 'text', 'location_city', $this->item->location_city );
	echo JHTML::_($method, 'text', 'shelter_name', $this->item->shelter_name );
	echo JHTML::_($method, 'text', 'shelter_id', $this->item->shelter_id );
	echo JHTML::_($method, 'text', 'shelter_phone', $this->item->shelter_phone );
	echo JHTML::_($method, 'text', 'shelter_address', $this->item->shelter_address );
	echo JHTML::_($method, 'dropdown', 'adoption_status', $this->item->adoption_status );	
	echo JHTML::_($method, 'dropdown', 'real_time_need', $this->item->real_time_need );
	echo JHTML::_($method, 'dropdown', 'real_time_status', $this->item->real_time_status );
	echo JHTML::_($method, 'date', 'date_in', $this->item->date_in );
	echo JHTML::_($method, 'date', 'available_date', $this->item->available_date );
	echo JHTML::_($method, 'date', 'pull_by_date', $this->item->pull_by_date );	
	echo JHTML::_($method, 'text', 'contact_name', $this->item->contact_name );
	echo JHTML::_($method, 'text', 'contact_email', $this->item->contact_email );
	echo JHTML::_($method, 'text', 'contact_phone', $this->item->contact_phone );


	?>

	<tr>
	<td colspan="2">
		<?php echo $this->params->render(); ?>
	</td>
	</tr>
	
	<?php
	echo JHTML::_($method, 'textarea', 'comments', $this->item->comments );
	echo JHTML::_($method, 'textarea', 'special_needs', $this->item->special_needs );
	echo JHTML::_($method, 'textarea', 'behavior_evaluation', $this->item->behavior_evaluation );
	echo JHTML::_($method, 'textarea', 'concerns', $this->item->concerns );
	echo JHTML::_($method, 'textarea', 'general_comments', $this->item->general_comments );
	?>
	
	</table>

<?php if( $canEdit ) { ?>
		
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->id; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="<?php echo $view; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

<?php  } // canSubmit 
?>
</div><!-- #animalProfile -->
