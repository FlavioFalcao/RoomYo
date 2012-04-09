<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ort_model
 *
 * @author Andy
 * 
 * Letzte Änderungen: 
 *  15.09.2011, 20:00: Erstellen Klasse Building Model
 */
class Gebaeude_model extends CI_Model
{
    
    private $table = null;
    
    function __construct() 
    {
        parent::__construct();
        $this->table = 'Gebaeude';
    }
        
    function get($params='', $start = 0, $limit = LIMIT, $orderby='uid ASC')
    {
        $this->db->select('g.*, o.name as ortsname')
             ->from($this->table.' g')
             ->join('Ort o', 'o.uid = g.ort_id', 'left')
             ->limit($limit, $start)
             ->order_by($orderby);
            
        if (isset($params) && is_array($params)) {
            $this->db->where($params);
            $query = $this->db->get();
        } else {
            $query = $this->db->get();
        }
        return $query;
    }
    
    function getAlleGebaeude($uid) {
        $query = $this->db->get_where($this->table, array('uid' => $uid), 1, 0);
        return $query->row(0, 'Building_model');
    }

    function delete($uid){
        $this->db->delete($this->table, array('uid' => $uid), 1);
        return $this->db->affected_rows();
    }

    function create($postdata) {

        $data = array(
            'name'          => $postdata['name'],
            'strasse'       => $postdata['strasse'],
            'hausnummer'    => $postdata['hausnummer'],
            'zusatz'        => $postdata['zusatz'],
            'ort_id'        => $postdata['ort_id'],
            'cruser'        => $this->session->userdata('uid'), 
            'crdate'        => time(),
            'lastchanged'   => time(),
            'istaktiv'      => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($postdata, $uid) {
        $data = array(
            'name'          => $postdata['name'],
            'strasse'       => $postdata['strasse'],
            'hausnummer'    => $postdata['hausnummer'],
            'zusatz'        => $postdata['zusatz'],
            'ort_id'        => $postdata['ort_id'],
            'istaktiv'      => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0,
            'lastchanged'   => time(),
        );

        $this->db->where('uid', $uid);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows(); 
    }
}