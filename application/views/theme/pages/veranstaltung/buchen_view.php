

<?=$this->session->flashdata("raumbuchung")?>

<h2>Termin reservieren im Raum <?=$raum->name?></h2>
<?php
//$this->table->add_row('Raumname', $raum->name);
$this->table->add_row('Anzahl Sitzplätze', $raum->sitzplaetze);
echo $this->table->generate(); 
?>


<div id="calendar"></div>

<?php echo validation_errors(); ?>
<div id="event_edit_container"> 
    
<div id="validation-errors-wrapper"></div>
<?php
$attributes = array('id' => 'veranstaltung_form');
$klasse = 'class="form_element"';
echo form_open('',$attributes);

if(isset ($raum->uid))
{
    echo form_hidden('raumid',$raum->uid);
}

echo form_label('Veranstaltung', 'title');
echo form_input('title', set_value('title'),$klasse);
echo form_error('title');
echo br();

echo form_label('Anfang', 'start');
echo form_dropdown('start',array('Bitte wählen' => ''));
echo form_error('start');
echo br();

echo form_label('Ende', 'end');
echo form_dropdown('end',array('Bitte wählen' => ''));
echo form_error('end');
echo br();

echo form_label('Anzahl Teilnehmer', 'teilnehmer');
echo form_input('teilnehmer', set_value('teilnehmer'),$klasse);
echo form_error('teilnehmer');
echo br();

//echo form_submit('formsubmit','Speichern!');
echo form_close();


?>
 
<!--
    <form> 
            <input type="hidden" /> 
            <ul> 
                    <li> 
                            <span>Datum: </span><span class="date_holder"></span> 
                    </li> 
                    <li> 
                            <label for="title">Titel: </label><input type="text" name="title" /> 
                    </li> 
                    <li> 
                            <label for="start">Startzeit: </label><select name="start"><option value="">Select Start Time</option></select> 
                    </li> 
                    <li> 
                            <label for="end">Endzeit: </label><select name="end"><option value="">Select End Time</option></select> 
                    </li> 
                    
                    <li> 
                            <label for="body">Beschreibung: </label><textarea name="body"></textarea> 
                    </li> 
                     <li> 
                            <label for="teilnehmer">Anzahl Teilnehmer: </label><input type="text" name="teilnehmer" /> 
                    </li> 
            </ul> 
    </form> -->
</ul>
</div> 