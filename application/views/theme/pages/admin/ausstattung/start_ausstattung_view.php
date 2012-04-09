<?=$this->session->flashdata("confirm")?>
<?=$this->session->flashdata("error")?>

<?php if(isset($ausstattung) && is_array($ausstattung) && count($ausstattung) > 0): ?>
<?php
   /*
    * TODO: Übergabe des Filterparameters noch angehen...
    echo form_open();
    
    echo form_label('Nur Gegenstände aus folgendem Raum anzeigen', 'raum_id');
    echo form_dropdown('raum_id',$raeume, $this->uri->segment(5), 'onchange="document.forms[0].submit();"');
    echo form_error('raum_id');
    echo br();
   
    echo form_close();
    */
?>
<table cellpadding="0" border="0" cellspacing="0" class="listing">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Seriennummer</th>
            <th>Typ</th>
            <th>Aktuell in Raum</th>
            <th>Aktiv</th>
            <th>Ersteller</th>
            <th>Änderungsdatum</th>
            <th>Erstellungsdatum</th>
            <th colspan="3">Bearbeiten</th>
        </tr>
    </thead>
<?php  foreach ($ausstattung as $ausstattung):?>
    
<tr>
    <td><?= $ausstattung->uid ?></td>
    <td><?= $ausstattung->name ?></td>
    <td><?= $ausstattung->inventarnummer ?></td>
    <td><?= $ausstattung->typ ?></td>
    <td><?= $ausstattung->raumname ?></td>
    <td><?= $ausstattung->istaktiv ?></td>
    <td><?= $ausstattung->username ?></td>
    <td><?= unix_to_human($ausstattung->lastchanged, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($ausstattung->crdate, FALSE, 'eu') ?></td>
    <td class="no-border"><?= anchor('admin/ausstattung/create/'.$ausstattung->uid,'kopieren',array('class' => 'copy')) ?></td>
    <td class="no-border"><?= anchor('admin/ausstattung/edit/'.$ausstattung->uid,'bearbeiten', array('class' => 'edit')) ?></td>
    <td><?= anchor('admin/ausstattung/delete/'.$ausstattung->uid,'l&ouml;schen', array('class' => 'delete', 'onclick' => 'return confirm(\'Wollen Sie diesen Datensatz wirklich löschen?\');')) ?></td>
</tr>

<?php  endforeach;?>
</table>

<?php else:?>
<div>Derzeit keine Einträge in der Datenbank vorhanden</div>

<?php endif;?>
<?= $paginator ?>


<p><?= anchor('admin/ausstattung/create/','Neuen Ausstattungsgegenstand erstellen') ?></p>

<!--</body>
</html>-->