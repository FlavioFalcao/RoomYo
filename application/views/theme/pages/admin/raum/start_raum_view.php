<?=$this->session->flashdata("confirm")?>
<?=$this->session->flashdata("error")?>

<?php if(isset($raum) && is_array($raum) && count($raum) > 0): ?>
<table cellpadding="0" border="0" cellspacing="0" class="listing">
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Sitzplätze</th>
        <th>Beschreibung</th>
        <th>Gebäude</th>
        <th>Etage</th>
        <th>Ersteller</th>
        <th>Aktiv</th>
        <th>Änderungsdatum</th>
        <th>Erstellungsdatum</th>
        <th colspan="3">Bearbeiten</th>
    </tr>
    </thead>
<?php  foreach ($raum as $raum):?>
    
<tr>
    <td><?= $raum->uid ?></td>
    <td><?= $raum->name ?></td>
    <td><?= $raum->sitzplaetze ?></td>
    <td><?= $raum->beschreibung ?></td>
    <td><?= $raum->gebaeudename.', '.$raum->ortsname ?></td>
    <td><?= $raum->etage ?></td>
    <td><?= $raum->username ?></td>
    <td><?= $raum->istaktiv ?></td>
    <td><?= unix_to_human($raum->lastchanged, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($raum->crdate, FALSE, 'eu') ?></td>
    <td class="no-border"><?= anchor('admin/raum/create/'.$raum->uid,'kopieren',array('class' => 'copy')) ?></td>
    <td class="no-border"><?= anchor('admin/raum/edit/'.$raum->uid,'edit', array('class' => 'edit')) ?></td>
    <td><?= anchor('admin/raum/delete/'.$raum->uid,'delete',array('class' => 'delete', 'onclick' => 'return confirm(\'Wollen Sie diesen Datensatz wirklich löschen?\');')) ?></td>
</tr>

<?php  endforeach;?>
</table>

<?php else:?>
<div>Derzeit keine Einträge in der Datenbank vorhanden</div>

<?php endif;?>
<?= $paginator ?>


<p><?= anchor('admin/raum/create/','Neuen Raum erstellen') ?></p>

<!--</body>
</html>-->