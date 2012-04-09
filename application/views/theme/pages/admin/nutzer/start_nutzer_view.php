<?=$this->session->flashdata("confirm")?>
<?=$this->session->flashdata("error")?>

<?php if(isset($nutzer) && is_array($nutzer) && count($nutzer) > 0): ?>

<table cellpadding="0" border="0" cellspacing="0" class="listing">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nachname</th>
            <th>Vorname</th>
            <th>Rolle</th>
            <th>Vorgesetzter</th>
            <th>Aktiv</th>
            <th>Ersteller</th>
            <th>Letzter Login</th>
            <th>Änderungsdatum</th>
            <th>Erstellungsdatum</th>
            <th colspan="3">Bearbeiten</th>
        </tr>
    </thead>
<?php  foreach ($nutzer as $nutzer):
    
    switch($nutzer->rolle)
    {
        case 1:
            $rolle = 'admin';
           break;
       
       case 2:
           $rolle = 'approver';
           break;
       
       case 3:
           $rolle = 'user';
           break;
    }  
    if($nutzer->vorgesetzter_id === NULL) {
        $vorgesetzter_id = 'Bitte nachtragen!';
    } else {
         $vorgesetzter_id = $nutzer->vorgesetzter_id;
    }
?>
    
<tr>
    <td><?= $nutzer->uid ?></td>
    <td><?= $nutzer->username ?></td>
    <td><?= $nutzer->nachname ?></td>
    <td><?= $nutzer->vorname ?></td>
    <td><?= $rolle ?></td>
    <td><?= $vorgesetzter_id ?></td>
    <td><?= $nutzer->istaktiv ?></td>
    <td><?= $nutzer->cruser ?></td>
    <td><?= unix_to_human($nutzer->letzterlogin, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($nutzer->lastchanged, FALSE, 'eu') ?></td>
    <td><?= unix_to_human($nutzer->crdate, FALSE, 'eu') ?></td>
    <td class="no-border"><?= anchor('admin/nutzer/create/'.$nutzer->uid,'kopieren',array('class' => 'copy')) ?></td>
    <td class="no-border"><?= anchor('admin/nutzer/edit/'.$nutzer->uid,'bearbeiten', array('class' => 'edit')) ?></td>
    <td><?= anchor('admin/nutzer/delete/'.$nutzer->uid,'l&ouml;schen', array('class' => 'delete', 'onclick' => 'return confirm(\'Wollen Sie diesen Datensatz wirklich löschen?\');')) ?></td>
</tr>

<?php  endforeach;?>
</table>

<?php else:?>
<div>Derzeit keine Einträge in der Datenbank vorhanden</div>

<?php endif;?>
<?= $paginator ?>


<p><?= anchor('admin/nutzer/create/','Neuen Nutzer erstellen') ?></p>

<!--</body>
</html>-->