<div class="block center">
<?php

$val_name       = (isset($gebaeude_data->name))         ? $gebaeude_data->name          : '';
$val_strasse    = (isset($gebaeude_data->strasse))      ? $gebaeude_data->strasse       : '';
$val_hausnummer = (isset($gebaeude_data->hausnummer))   ? $gebaeude_data->hausnummer    : '';
$val_zusatz     = (isset($gebaeude_data->zusatz))       ? $gebaeude_data->zusatz        : '';
$val_ort_id     = (isset($gebaeude_data->ort_id))       ? $gebaeude_data->ort_id        : '';
$val_istaktiv   = (isset($gebaeude_data->istaktiv))     ? $gebaeude_data->istaktiv      : '';

?>

<?php echo validation_errors();?>
  <?php  echo form_open($formaction);?>

    <div class="field">
        <div class="label">
           <?php echo form_label('Gebäudename', 'name'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('name', (set_value('name',$val_name))); ?>    
            </div>
        </div>
    </div>


    
    
    
    <div class="field">
        <div class="label">
           <?php echo form_label('Strasse', 'strasse'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('strasse', (set_value('strasse',$val_strasse))); ?>    
            </div>
        </div>
    </div>    
    
    
    
    
    <div class="field">
        <div class="label">
           <?php echo form_label('Hausnummer', 'hausnummer'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                    <?php echo form_input('hausnummer', (set_value('hausnummer',$val_hausnummer))); ?> 
            </div>
        </div>
    </div>    
    
    <div class="field">
        <div class="label">
           <?php echo form_label('Ort', 'ort_id'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                 <?php echo form_dropdown('ort_id', $orte_dd_options,$val_ort_id); ?>   
            </div>
        </div>
    </div>    
    
    <div class="field">
        <div class="label">
           <?php echo form_label('Zusatztext', 'zusatz'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                 <?php echo form_input('zusatz', (set_value('zusatz',$val_zusatz))); ?>   
            </div>
        </div>
    </div>    
    
    
    <div class="field">
        <div class="label">
            <?php echo form_label('Aktiv?', 'istaktiv'); ?>
        </div>
        <div class="FORM-checkbox">
            <div class="field checkbox">
                <?php echo form_checkbox('istaktiv', '1', set_checkbox('istaktiv','1',(bool) intval($val_istaktiv))); ?>
            </div>
        </div>
    </div>  
    
    <p class="buttons">
        <?php echo form_submit('formsubmit','Speichern','class="button"'); ?>
    </p>
    
    <?php echo form_close(); ?>

<?= anchor('admin/gebaeude','Zurück zur Übersicht','class="back"')?>
</div>
