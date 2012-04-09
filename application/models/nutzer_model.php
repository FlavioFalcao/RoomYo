<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of Ausstattung_model
 *
 * @author alex
 * @author Andreas
 * 
 * Letzte Änderungen: 
 *  11.11.2011, 17:00
 */
class Nutzer_model extends CI_Model 
{    
    private $table = null;
    
    function __construct() 
    {
        parent::__construct();
        $this->table = 'Nutzer';
    }
    
    function get($params=NULL, $start = 0, $limit = LIMIT, $orderby='uid asc')
    {
       /* $this->db->select('a.*, b.username as vorgesetzter, c.username as ersteller');
        $this->db->from($this->table.' as a');
        $this->db->join($this->table.' as b','a.uid = b.vorgesetzter_id','left');
        $this->db->join($this->table.' as c','a.uid = c.cruser','left');
        */
        
        $this->db->select('a.*');
        $this->db->from($this->table.' as a');
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
            'vorname'               => $postdata['vorname'],
            'nachname'              => $postdata['nachname'],
            'username'              => $postdata['username'],
            'email'                 => $postdata['email'],
            'vorgesetzter_id'       => $postdata['vorgesetzter_id'],
            'passwort'              => sha1($this->config->item('encryption_key') . $postdata['username'] . $postdata['passwort']),
            'rolle'                 => $postdata['rolle'],
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
            'vorname'               => $postdata['vorname'],
            'nachname'              => $postdata['nachname'],
            'username'              => $postdata['username'],
            'email'                 => $postdata['email'],
            'vorgesetzter_id'       => $postdata['vorgesetzter_id'],
            'rolle'                 => $postdata['rolle'],
            'lastchanged'           => time(),
            'istaktiv'              => isset($postdata['istaktiv']) ? $postdata['istaktiv'] : 0
        );
        if(isset($postdata['passwort']) && !empty($postdata['passwort']))
            $data['passwort'] = sha1($this->config->item('encryption_key') . $postdata['username'] . $postdata['passwort']);

        $this->db->where('uid', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows(); 
    }
}
/* End of file nutzer_model.php */
/* Location: ./application/models/nutzer_model.php */