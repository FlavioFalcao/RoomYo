<div class="block center">
    
    <p>
        Untenstehend sehen Sie die verschiedenen zu Testzwecken bisher eingerichteten User. 
        In einer Live-Umgebung werden hier selbstverständlich keine Usernamen und Passwörter
        angezeigt!
    <table border="1">
        <tr>
            <td>admin</td>
            <td>RoomYo1!</td>
        </tr>
        <tr>
            <td>alexander</td>
            <td>RoomYo1!</td>
        </tr>
        <tr>
            <td>andreas</td>
            <td>RoomYo1!</td>
        </tr>
    </table>
    </p>
    <p>&nbsp;</p>
<?php echo validation_errors(); ?>
<div class="error"><?php echo $this->session->flashdata("error");?></div>
    
<?php echo form_open();?>
<div class="field user_email">
    <div class="label">
        <?php echo form_label("Benutzer");?>
    </div>
    <div class="FORM-text">
        <div class="field">
            <?php echo form_input(array('name'        => 'username',
                                        'id'          => 'username',
                                        'value'       => '',
                                        'maxlength'   => '50',
                                        'size'        => '50'));?>
        </div>
    </div>
</div>

 <div class="field password">
    <div class="label">   
        <?php echo form_label("Passwort");?>
    </div>
     <div class="FORM-text">
         <div class="field">
            <?php echo form_password(array('name'        => 'password',
                                    'id'          => 'password',
                                    'value'       => '',
                                    'maxlength'   => '50',
                                    'size'        => '50'));?>
         </div>
     </div>
</div>

<p class="buttons">
    <?php echo form_submit('submit', 'Login','class="button login"');?>
</p>
<?php echo form_close();?>
</div>