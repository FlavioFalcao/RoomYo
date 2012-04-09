<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of veranstaltung_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: Ï
 *  15.11.2011, 17:00
 */
class Veranstaltung_model extends CI_Model
{

    private $table = NULL;

    public function __construct()
    {
        parent::__construct();

        $this->table = "Veranstaltung";
    }
    
    // "Getter" um Daten aus der DB auszulesen
    function get($params=NULL, $start = 0, $limit = LIMIT, $orderby='uid ASC')
    {
        $this->db->select('v.*, r.name as raumname')
                ->from($this->table . ' v')
                ->join('Raum r', 'r.uid = v.raum_id', 'left')
                ->limit($limit, $start)
                ->order_by($orderby);

        if (isset($params) && is_array($params)) {
            $this->db->where($params);
        }
        $query = $this->db->get();
        return $query;
    }
    
    // Validator der checkt ob ein bestimmter Raum zum Zeitpunkt X noch nicht verbucht ist
    function check_verfuegbarkeit($raumid, $startdatum, $enddatum='', $uid = NULL)
    {
        $startdatum = dateTimeToTimestamp($startdatum);
        if ($enddatum != '')
            $enddatum = dateTimeToTimestamp($enddatum);

        $select = "SELECT * FROM Veranstaltung
                   WHERE raum_id = $raumid
                   AND ( (startdatum < $startdatum AND enddatum > $startdatum)";

        if ($enddatum != '')
            $select .= " OR (startdatum < $enddatum AND enddatum > $enddatum) 
                         OR (startdatum > $startdatum AND enddatum < $enddatum)";

        $select .= " ) ";
        // Wenn uid gesetzt ist, befinden wir uns im Bearbeiten-Modus
        // daher wird der Datensatz aus der Prüfung der Verfügbarkeit ausgeklammert
        if (isset($uid) && !empty($uid))
            $select .= " AND uid != $uid";

        return ($this->db->query($select)->num_rows() > 0) ? FALSE : TRUE;
    }

    // Methode erstellt Verantstaltungen in der DB 
    function create($postdata, $user_id)
    {
        $data = array(
            'name' => $postdata['name'],
            'startdatum' => dateTimeToTimestamp($postdata['startdatum']),
            'enddatum' => dateTimeToTimestamp($postdata['enddatum']),
            'crdate' => time(),
            'lastchanged' => time(),
            'cruser' => $this->session->userdata('uid'),
            'teilnehmer' => $postdata['teilnehmer'],
            'raum_id' => $postdata['raumid'],
            'istaktiv' => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->insert('Veranstaltung', $data);
        return $this->db->insert_id();
    }

    // Methode aktualisiert Datensätze in der DB
    function update($postdata)
    {
        $data = array(
            'name' => $postdata['name'],
            'startdatum' => dateTimeToTimestamp($postdata['startdatum']),
            'enddatum' => dateTimeToTimestamp($postdata['enddatum']),
            'lastchanged' => time(),
            'teilnehmer' => $postdata['teilnehmer'],
            'istaktiv' => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->where('uid', $postdata['uid']);
        $this->db->update('Veranstaltung', $data);
        return $this->db->affected_rows();
    }
    
    // Löschmethode für einzelne Datensätze in der DB
    function delete($id)
    {
        $this->db->delete($this->table, array('uid' => $id), 1);
        var_dump($this->db->last_query());
        return $this->db->affected_rows();
    }

}

/* End of file veranstaltung_model.php */
/* Location: ./application/models/veranstaltung_model.php */