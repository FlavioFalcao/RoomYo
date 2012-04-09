
<div class="block center">

    <?php
    $val_name = (isset($ausstattung->name)) ? $ausstattung->name : '';
    $val_inventarnummer = (isset($ausstattung->inventarnummer)) ? $ausstattung->inventarnummer : '';
    $val_ausstattungstyp_id = (isset($ausstattung->ausstattungstyp_id)) ? $ausstattung->ausstattungstyp_id : '';
    $val_raum_id = (isset($ausstattung->raum_id)) ? $ausstattung->raum_id : '';
    $val_istaktiv = (isset($ausstattung->istaktiv)) ? $ausstattung->istaktiv : '';
    ?>

    <?php echo validation_errors(); ?>
    <?php echo form_open($formaction); ?>

    <div class="field">
        <div class="label">
            <?php echo form_label('Name des Gegenstandes', 'name'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('name', set_value('name', $val_name)); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Seriennummer', 'inventarnummer'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('inventarnummer', set_value('inventarnummer', $val_inventarnummer)); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Typ', 'ausstattungstyp_id'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_dropdown('ausstattungstyp_id', $astypen, $val_ausstattungstyp_id); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Raum', 'raum_id'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_dropdown('raum_id', $raeume, $val_raum_id); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Aktiv?', 'istaktiv'); ?>
        </div>
        <div class="FORM-checkbox">
            <div class="field checkbox">
                <?php echo form_checkbox('istaktiv', '1', set_checkbox('istaktiv', '1', (bool) intval($val_istaktiv))); ?>
            </div>
        </div>
    </div>

    <p class="buttons">
        <?php echo form_submit('formsubmit', 'Speichern', 'class="button"'); ?>
    </p>
    <?php echo form_close(); ?>


    <?= anchor('admin/ausstattung', 'Zurück zur Übersicht', 'class="back"') ?>
</div>