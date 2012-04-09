<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of raum_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: 
 *  08.11.2011
 */
class Raum_model extends CI_Model
{

    private $table = null;

    function __construct()
    {
        parent::__construct();
        $this->table = 'Raum';
    }

    function get($params=NULL, $start = 0, $limit = LIMIT, $order='a.uid ASC')
    {
        $this->db->select('a.*,n.username,g.name AS gebaeudename, o.name AS ortsname');
        $this->db->from($this->table . ' AS a');
        $this->db->join('Gebaeude AS g', 'g.uid = a.gebaeude_id', 'left');
        $this->db->join('Ort o', 'o.uid = g.ort_id', 'left');
        $this->db->join('Nutzer AS n', 'n.uid = a.cruser', 'left');
        $this->db->order_by($order);
        $this->db->limit($limit, $start);
        if (isset($params) && is_array($params))
            $this->db->where($params);

        return $this->db->get();
    }

    //Errechnet die prozentuale Auslastung eines Raumes in einem vordefinierten Zeitraum
    function get_auslastung($id, $zeitraum = 7)
    {
        $this->load->model('veranstaltung_model', 'veranstaltung');
        $gebuchte_termine = $this->veranstaltung->get(array('raum_id' => $id, 'startdatum >=' => time(), 'enddatum <=' => (time() + $zeitraum * SEKUNDENEINESTAGES)))->result_array();
        $gebuchte_stunden = 0;
        foreach ($gebuchte_termine as $termin) {
            // gebuchte Stunden des gewählten Zeitraumes aufaddieren
            $gebuchte_stunden += ceil(($termin['enddatum'] - $termin['startdatum']) / 3600);
        }
        // gebuchte Stunden durch Stunden einer Woche teilen und mal hundert nehmen
        $prozentuale_auslastung = ($gebuchte_stunden / (WOCHENSTUNDEN * ($zeitraum / 7))) * 100;

        return $prozentuale_auslastung;
    }

    // Gibt die Typen und Anzahl des im Raum vorhandenen Inventares zurück
    function get_inventartypen($id)
    {
        $this->load->model('ausstattung_model', 'ausstattung');
        $raumausstattung = $this->ausstattung->get(array('a.raum_id' => $id))->result_array();
        $inventartypen = array();
        foreach ($raumausstattung as $element) {
            $typ = $element['typ'];
            // Array wird mit den Inventartypen als Key und der Anzahl der Elemente als Value befüllt.
            $inventartypen[$typ] = (array_key_exists($typ, $inventartypen)) ? $inventartypen[$typ] + 1 : 1;
        }
        return $inventartypen;
    }

    // Löscht einen Raum
    function delete($id)
    {
        $this->db->delete($this->table, array('uid' => $id), 1);
        return $this->db->affected_rows();
    }

    // Überprüft ob mehr oder gleich viele Sitzplätze vorhanden sind, als an den Methodenaufruf übergeben werden
    function check_anzahl_plaetze($raumid, $plaetze)
    {
        // Wenn der Raum weniger Sitzplätze bietet als angefragt FALSE zurückgeben
        $result = self::get(array('a.uid' => $raumid, 'sitzplaetze >=' => $plaetze))->num_rows();
        return ($result != 0) ? TRUE : FALSE;
    }

    function create($postdata)
    {
        $data = array(
            'name' => $postdata['name'],
            'sitzplaetze' => $postdata['sitzplaetze'],
            'beschreibung' => $postdata['beschreibung'],
            'gebaeude_id' => $postdata['gebaeude_id'],
            'etage' => $postdata['etage'],
            'cruser' => $this->session->userdata('uid'),
            'crdate' => time(),
            'lastchanged' => time(),
            'istaktiv' => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($postdata, $id)
    {
        $data = array(
            'name' => $postdata['name'],
            'sitzplaetze' => $postdata['sitzplaetze'],
            'beschreibung' => $postdata['beschreibung'],
            'gebaeude_id' => $postdata['gebaeude_id'],
            'etage' => $postdata['etage'],
            'lastchanged' => time(),
            'istaktiv' => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->where('uid', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

}

/* End of file raum_model.php */
/* Location: ./application/models/raum_model.php */