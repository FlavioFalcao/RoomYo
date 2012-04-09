<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Ausstattung_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: 
 *  08.11.2011, 17:00
 */
class Ausstattung_model extends CI_Model 
{    
    private $table = null;
    
    function __construct() 
    {
        parent::__construct();
        $this->table = 'Ausstattung';
    }
    
    function get($params=NULL, $start = 0, $limit = LIMIT, $orderby='uid asc')
    {
        $this->db->select('a.*,b.typ,c.username,d.name as raumname');
        $this->db->from($this->table.' AS a');
        $this->db->join('Ausstattungstyp AS b', 'b.uid = a.ausstattungstyp_id','left');
        $this->db->join('Nutzer AS c', 'c.uid = a.cruser','left');
        $this->db->join('Raum AS d', 'd.uid = a.raum_id','left');
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
            'name'                  => $postdata['name'],
            'inventarnummer'        => $postdata['inventarnummer'],
            'raum_id'               => $postdata['raum_id'],
            'ausstattungstyp_id'    => $postdata['ausstattungstyp_id'],
            'cruser'                => $this->session->userdata('uid'),
            'crdate'                => time(),
            'lastchanged'           => time(),
            'istaktiv'              => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($postdata, $id) 
    {
        $data = array(
            'name'                  => $postdata['name'],
            'inventarnummer'        => $postdata['inventarnummer'],
            'raum_id'               => $postdata['raum_id'],
            'ausstattungstyp_id'    => $postdata['ausstattungstyp_id'],
            'lastchanged'           => time(),
            'istaktiv'              => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );

        $this->db->where('uid', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows(); 
    }
}
/* End of file ausstattung_model.php */
/* Location: ./application/models/ausstattung_model.php */