<?php if($this->session->userdata('uid') != null):
    if(!empty($veranstaltungen_data)):
 ?>
<h2>Termine innerhalb der nächsten 7 Tage</h2>
<ul class="list">
    <?php 
    $datesnextweek = false;
    foreach($veranstaltungen_data as $v):
        if ($v->startdatum >= (now()+604800) && $datesnextweek === false) {
            echo "</ul>";
            echo "<h2>Termine ab der nächsten Woche</h2>";
            echo "<ul class='list'>";   
            $datesnextweek = true;
        }
        ?>
    <li class="entry">
        <div class="left"><?php echo $v->raumname; ?></div>
        <div class="right">
            <p class="name"><a href="/veranstaltung/buchen/<?php echo $v->raum_id;?>"><?php echo $v->name; ?></a></p>
            <p class="details">Am 
            <?php 
                   $tag[0] = "Sonntag";
                   $tag[1] = "Montag";
                   $tag[2] = "Dienstag";
                   $tag[3] = "Mittwoch";
                   $tag[4] = "Donnerstag";
                   $tag[5] = "Freitag";
                   $tag[6] = "Samstag";
                   
                   echo $tag[date("w",$v->startdatum)]; 
                   echo ", den ";
                   echo date("d.m.Y", $v->startdatum);
                   echo " von ";
                   echo date ("H:i", $v->startdatum);
                   echo " bis ";
                   echo date ("H:i", $v->enddatum);
            ?> 
            </p>
        </div>
    </li>
    <?php endforeach;
    else: ?>
    <h2>Keine aktuellen Termine in der Datenbank!</h2>
    <?php endif;?> 
</ul>
<?php else: ?>
<h2>Bitte loggen Sie sich ein um Zugriff auf das Raumbuchungssystem zu erhalten!</h2>
<?php endif; ?>
