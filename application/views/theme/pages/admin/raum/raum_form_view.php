<div class="block center">


<?php

$val_name           = (isset($raum->name))              ?   $raum->name             : '';
$val_beschreibung   = (isset($raum->beschreibung))      ?   $raum->beschreibung     : '';
$val_sitzplaetze    = (isset($raum->sitzplaetze))       ?   $raum->sitzplaetze      : '';
$val_gebaeude_id    = (isset($raum->gebaeude_id))       ?   $raum->gebaeude_id      : '';
$val_etage          = (isset($raum->etage))             ?   $raum->etage            : '';
$val_istaktiv       = (isset($raum->istaktiv))          ?   $raum->istaktiv         : '';

?>

<?php echo validation_errors();?>
  <?php  echo form_open($formaction);?>

    <div class="field">
        <div class="label">
            <?php echo form_label('Name des Raumes', 'name'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_input('name', set_value('name', $val_name )); ?>
            </div>
        </div>
    </div> 

    <div class="field">
        <div class="label">
            <?php echo form_label('Beschreibung', 'beschreibung'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_input('beschreibung', set_value('beschreibung', $val_beschreibung)); ?>
            </div>
        </div>
    </div> 

    <div class="field">
        <div class="label">
            <?php echo form_label('Sitzplätze', 'sitzplaetze'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_input('sitzplaetze', set_value('sitzplaetze', $val_sitzplaetze)); ?>
            </div>
        </div>
    </div>     
 
    <div class="field">
        <div class="label">
            <?php echo form_label('Gebäude', 'gebaeude_id'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_dropdown('gebaeude_id',$gebaeude, $val_gebaeude_id); ?>
            </div>
        </div>
    </div> 

    <div class="field">
        <div class="label">
            <?php echo form_label('Etage', 'etage'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_input('etage', set_value('etage', $val_etage)); ?>
            </div>
        </div>
    </div> 

    <div class="field">
        <div class="label">
            <?php echo form_label('Aktiv?', 'istaktiv'); ?>
        </div>
        <div class="FORM-text">
            <div class="field checkbox">
                    <?php echo form_checkbox('istaktiv', '1', set_checkbox('istaktiv','1',(bool) intval($val_istaktiv))); ?>
            </div>
        </div>
    </div>

    <p class="buttons">
        <?php echo form_submit('formsubmit','Speichern', 'class="button"'); ?>
    </p>
    <?php echo form_close(); ?>

<?= anchor('admin/raum','Zurück zur Übersicht','class="back"')?>

</div>