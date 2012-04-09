<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of ort_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: 
 *  17.09.2011, 17:00
 */
class Ort_model extends CI_Model 
{    
    private $table = null;
    
    function __construct() 
    {
        parent::__construct();
        $this->table = 'Ort';
    }
    
    function get($params=NULL, $start = 0, $limit = LIMIT, $orderby='uid ASC')
    {
        $this->db->select('a.*,c.username');
        $this->db->from($this->table.' AS a');
        $this->db->join('Nutzer AS c', 'c.uid = a.cruser','left');
        $this->db->order_by($orderby);
        $this->db->limit($limit, $start);
        if (isset($params) && is_array($params)) 
            $this->db->where($params);
        
        return $this->db->get();
    }

    function delete($id)
    {
        $this->db->delete($this->table, array('uid' => $id), 1);
        return $this->db->affected_rows(); 
    }

    function create($postdata)
    {
        $data = array(
            'name'          => $postdata['name'],
            'plz'           => $postdata['plz'],
            'cruser'        => $this->session->userdata('uid'),
            'crdate'        => time(),
            'lastchanged'   => time(),
            'istaktiv'      => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($postdata, $ortid) 
    {
        $data = array(
            'name'          => $postdata['name'],
            'plz'           => $postdata['plz'],
            'istaktiv'      => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0,
            'lastchanged'   => time(),
        );

        $this->db->where('uid', $ortid);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows(); 
    }
}
/* End of file ort_model.php */
/* Location: ./application/models/ort_model.php */