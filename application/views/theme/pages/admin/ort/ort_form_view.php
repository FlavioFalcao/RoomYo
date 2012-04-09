<div class="block center">

<?php


$val_name       = (isset($ort->name))       ?   $ort->name      : '';
$val_plz        = (isset($ort->plz))        ?   $ort->plz       : '';
$val_istaktiv   = (isset($ort->istaktiv))   ?   $ort->istaktiv  : '';

?>
<?php echo validation_errors();?>
  <?php  echo form_open($formaction);?>

    <div class="field">
        <div class="label">
            <?php echo form_label('Name des Ortes', 'name'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('name', (set_value('name',$val_name))); ?>
            </div>
        </div>
    </div>
    
    <div class="field">
        <div class="label">
            <?php echo form_label('PLZ', 'plz'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">            
                <?php echo form_input('plz', (set_value('plz',$val_plz))); ?>
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
        <?php echo form_submit('formsubmit','Speichern','class="button"'); ?>
    </p>
    <?php echo form_close(); ?>

<?= anchor('admin/ort','Zurück zur Übersicht','class="back"')?>

</div>