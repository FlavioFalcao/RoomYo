<?=$this->session->flashdata("raumbuchung")?>

<!--
<h2>Auswahl einschränken</h2>
<?php
$attributes = array('id' => 'veranstaltung_form');
$klasse = 'class="form_element"';
echo form_open('',$attributes);

if(isset ($raeume->uid))
    echo form_hidden('raumid',$raeume->uid);

echo form_label('Veranstaltung', 'name');
echo form_input('name', set_value('name'),$klasse);
echo form_error('name');
echo br();

echo form_submit('formsubmit','Speichern!');
echo form_close();

?>
<hr />
-->

<div class="raumliste">
    
<?php 
$gebaeude = NULL;
foreach ($raeume as $raum):
    // Prozentuale Auslastung feststellen und dynamisch die Hintergrundfarbe generieren...
    $auslastung = $raum->get_auslastung($raum->uid);
    // Speichert die Inventartypen in einem Array
    $inventartypen = $raum->get_inventartypen($raum->uid);


    if ($auslastung <= 30)
        $trendclass = '_1-4';
    else if ($auslastung > 30 && $auslastung <= 65)
        $trendclass = '_1-2';
    else if ($auslastung > 65 && $auslastung <= 85)
        $trendclass = '_3-4';
    else
        $trendclass = '_4-4';
    
    // Gebäudenamen ausgeben wenn ein neuer Gebäudename im Objekt steht.
    if($gebaeude != $raum->gebaeudename): 
    // Das schließende div wird erst ausgegeben, nachdem das erste mal $gebaeude gesetzt wurde
        if($gebaeude != NULL)
            echo "</div><!-- gebaeude -->";
        $gebaeude = $raum->gebaeudename;
?>
<div class="gebaeude" style="margin-bottom: 10px;">
    <h2><?=$raum->gebaeudename?></h2>
<?php endif;?>
    
    <div class="raum" style="padding: 10px;">
        <h3><?= anchor('veranstaltung/buchen/'.$raum->uid, $raum->name) ?> <span>(<?=$raum->beschreibung?>)</span></h3>
        <div class="body">
        Sitzpl&auml;tze: <?=$raum->sitzplaetze?><br />
        <?php foreach($inventartypen as $inventartyp => $anzahl) {
            echo $anzahl."&nbsp;".$inventartyp ."<br /> ";
        }
        ?> 
        </div>
        <div class="trend <?=$trendclass;?>"> <!-- style="background-color: rgb(<?//$trendcolor?>);"-->
            Auslastung (7 Tage): <?= $auslastung ?>%
        </div><!-- trend -->
    </div><!-- raum -->
    
<?php endforeach;?>  
</div><!-- gebaeude -->
</div>