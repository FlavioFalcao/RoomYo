<?=$this->session->flashdata("confirm")?>
<?=$this->session->flashdata("error")?>

<?php if(isset($ort) && is_array($ort) && count($ort) > 0): ?>
<table cellpadding="0" border="0" cellspacing="0" class="listing">
    <thead>
    <tr>
        <th><?= anchor($skriptpfad.'/uid_'.$richtung,'ID') ?></th>
        <th><?= anchor($skriptpfad.'/name_'.$richtung,'Name') ?></th>
        <th><?= anchor($skriptpfad.'/plz_'.$richtung,'PLZ') ?></th>
        <th><?= anchor($skriptpfad.'/istaktiv_'.$richtung,'Aktiv') ?></th>
        <th><?= anchor($skriptpfad.'/cruser_'.$richtung,'Ersteller') ?></th>
        <th><?= anchor($skriptpfad.'/lastchanged_'.$richtung,'&Auml;nderungsdatum') ?></th>
        <th><?= anchor($skriptpfad.'/crdate_'.$richtung,'Erstellungsdatum') ?></th>
        <th colspan="3">Bearbeiten</th>
    </tr>
    </thead>
<?php  foreach ($ort as $ort):?>
    
<tr>
    <td><?= $ort->uid ?></td>
    <td><?= $ort->name ?></td>
    <td><?= $ort->plz ?></td>
    <td><?= $ort->istaktiv ?></td>
    <td><?= $ort->username ?></td>
    <td><?= unix_to_human($ort->lastchanged, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($ort->crdate, FALSE, 'eu') ?></td>
    <td class="no-border"><?= anchor('admin/ort/create/'.$ort->uid,'kopieren', array('class' => 'copy')) ?></td>
    <td class="no-border"><?= anchor('admin/ort/edit/'.$ort->uid,'edit', array('class' => 'edit')) ?></td>
    <td><?= anchor('admin/ort/delete/'.$ort->uid,'delete',array('class' => 'delete', 'onclick' => 'return confirm(\'Wollen Sie diesen Datensatz wirklich löschen?\');')) ?></td>
</tr>

<?php  endforeach;?>
</table>

<?php else:?>
<div>Derzeit keine Einträge in der Datenbank vorhanden</div>

<?php endif;?>
<?= $paginator ?>


<p><?= anchor('admin/ort/create/','Neuen Ort erstellen') ?></p>

<!--</body>
</html>-->