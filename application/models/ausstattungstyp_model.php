<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Ausstattungstyp_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: 
 *  06.11.2011, 22:00
 */
class Ausstattungstyp_model extends CI_Model 
{    
    
    private $table = null;
    
    function __construct() 
    {
        parent::__construct();
        $this->table = 'Ausstattungstyp';
    }    
    
    function get($params=NULL, $start = 0, $limit = LIMIT,$order='typ ASC')
    {   
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by($order);
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
            'typ'   => $postdata['typ'],
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($postdata, $id) 
    {
        $data = array(
            'typ'   => $postdata['typ'],
        );

        $this->db->where('uid', $id);
        $this->db->update( $this->table, $data);
        return $this->db->affected_rows(); 
    }
}
/* End of file ausstattungstyp_model.php */
/* Location: ./application/models/ausstattungstyp_model.php */