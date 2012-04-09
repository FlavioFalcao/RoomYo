<div class="block center">


<?php

$val_vorname        = (isset($nutzer->vorname))             ?   $nutzer->vorname            : '';
$val_nachname       = (isset($nutzer->nachname))            ?   $nutzer->nachname           : '';
$val_email          = (isset($nutzer->email))               ?   $nutzer->email              : '';
$val_username       = (isset($nutzer->username))            ?   $nutzer->username           : '';
$val_rolle          = (isset($nutzer->rolle))               ?   $nutzer->rolle              : '';
$val_istaktiv       = (isset($nutzer->istaktiv))            ?   $nutzer->istaktiv           : '';
$val_vorgesetzter   = (isset($nutzer->vorgesetzter_id))     ?   $nutzer->vorgesetzter_id    : '';

?>

<?php echo validation_errors();?>
  <?php  echo form_open($formaction);?>

    <div class="field">
        <div class="label">
            <?php echo form_label('Nachname', 'nachname'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('nachname', set_value('nachname', $val_nachname )); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Vorname', 'vorname'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('vorname', set_value('vorname',$val_vorname)); ?>
            </div>
        </div>
    </div>    

    <div class="field">
        <div class="label">
            <?php echo form_label('Email', 'email'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('email', set_value('email',$val_email)); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Username', 'username'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_input('username', set_value('username',$val_username), 'id="user_id"'); ?> 
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
           <?php echo form_label('Passwort', 'passwort'); ?> 
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_password('passwort', set_value('passwort'), 'class="password_test"'); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Passwort wiederholen', 'passwort_repeat'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_password('passwort_repeat', set_value('passwort_repeat')); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
           <?php echo form_label('Vorgesetzter', 'vorgesetzter_id'); ?> 
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_dropdown('vorgesetzter_id', $alle_nutzer, $val_vorgesetzter); ?>
            </div>
        </div>
    </div>

    <div class="field">
        <div class="label">
            <?php echo form_label('Rolle', 'rolle'); ?>
        </div>
        <div class="FORM-text">
            <div class="field">
                <?php echo form_dropdown('rolle', array('1' => 'admin', '2' => 'approver', '3' => 'user'), $val_rolle); ?>
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

<?= anchor('admin/nutzer','Zurück zur Übersicht','class="back"')?>
</div>