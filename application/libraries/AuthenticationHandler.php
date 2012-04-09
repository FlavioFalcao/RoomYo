<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthenticationHandler 
{
    private $CI         = null;
    private $user_id    = null;
    private $user_role  = null;
    
    function __construct() 
    {
        $this->CI = & get_instance();;
    }
    /**
     * Vom Benutzer eingegeben Login-Daten gegen die Datenbank prüfen
     * Wenn die eingegebenen Daten stimmen, wird eine neue Session erstellt
     * @param username
     * @param password as sha1 Hash
     * @return bool
     */
    public function LoginBenutzer($username = NULL, $password = NULL) 
    {
        $pwHashed = sha1($this->CI->config->item('encryption_key') . $username . $password);
        $qry = "SELECT uid, rolle, vorgesetzter_id FROM Nutzer where MD5(username) = MD5('".$username."') AND passwort = '".$pwHashed."' AND istaktiv = 1";
        
        $query = $this->CI->db->query($qry);
        if ($query->num_rows() == 1)
        {
            $row = $query->row();
            $this->user_id   = $row->uid;
            $this->user_role = $row->rolle;
            $update = "UPDATE Nutzer SET letzterlogin = ".time()." WHERE uid = ".$row->uid."";
            $this->CI->db->query($update);
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Benutzer ausloggen und Session beenden
     */
    public function LogoutBenutzer()
    {
        $this->ZerstoereSession();
    }
    
    public function ErstelleNeueSession()
    {
        $this->CI->session->sess_create();
        $this->CI->session->set_userdata('uid', $this->user_id);
        $this->CI->session->set_userdata('role', $this->user_role);
        $this->CI->session->set_userdata('logged_in', 1);
    }
    
    public function ZerstoereSession()
    {
        $this->CI->session->set_userdata('uid',NULL);
        $this->CI->session->set_userdata('role',NULL);
        $this->CI->session->set_userdata('logged_in',NULL);
        $this->CI->session->set_userdata('username',NULL);
        $this->CI->session->sess_destroy();
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */