<?=$this->session->flashdata("confirm")?>
<?=$this->session->flashdata("error")?>

<?php if(isset($gebaeude) && is_array($gebaeude) && count($gebaeude) > 0): ?>
<table cellpadding="0" border="0" cellspacing="0" class="listing">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Strasse/Hsnr</th>
            <th>Zusatz</th>
            <th>Ort</th>
            <th>Aktiv</th>
            <th>Änderungsdatum</th>
            <th>Erstellungsdatum</th>

            <th colspan="3">Bearbeiten</th>

        </tr>
    </thead>
<?php  foreach ($gebaeude as $row):?>
    
<tr>
    <td><?= $row->uid ?></td>
    <td><?= $row->name ?></td>
    <td><?= $row->strasse . " " . $row->hausnummer ?></td>
    <td><?= $row->zusatz ?></td>
    <td><?= ($row->ortsname == NULL) ? '<span style="color: red">kein Ort</span>' : $row->ortsname ?></td>
    <td><?= $row->istaktiv ?></td>
    <td><?= unix_to_human($row->lastchanged, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($row->crdate, FALSE, 'eu') ?></td>
    <td class="no-border"><?= anchor('admin/gebaeude/create/'.$row->uid,'kopieren', array('class' => 'copy')) ?></td>
    <td class="no-border"><?= anchor('admin/gebaeude/edit/'.$row->uid,'bearbeiten', array('class' => 'edit')) ?></td>
    <td><?= anchor('admin/gebaeude/delete/'.$row->uid,'l&ouml;schen',array('class' => 'delete', 'onclick' => 'return confirm(\'Wollen Sie diesen Datensatz wirklich löschen?\');')) ?></td>
</tr>

<?php  endforeach;?>
</table>

<?php else:?>
<div>Derzeit keine Einträge in der Datenbank vorhanden</div>

<?php endif;?>
<?= $paginator ?>


<p><?= anchor('admin/gebaeude/create/','Neuen Eintrag erstellen') ?></p>