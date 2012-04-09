<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @name UserRoles
 * 
 */
class UserRoles {
    const admin = 1;
    const approver = 2;
    const user = 3;
    const guest = 4;
}

class Base_Controller extends CI_Controller 
{   
    protected $logged_in    = null;
    protected $user_id      = null;
    public $layout_data  = array();
    
    function __construct()
    {        
        parent::__construct();

        $this->logged_in = $this->session->userdata('logged_in');
        $user_role = $this->session->userdata('role');
        $user_id = $this->session->userdata('uid');
        
        // Admin-Menü
        $menu_items = array(
            UserRoles::admin => array(
                '/admin/ort'            => 'Orte',
                '/admin/gebaeude'       => 'Gebäude',
                '/admin/nutzer'         => 'Benutzer',
                '/admin/ausstattung'    => 'Ausstattung',
                '/admin/raum'           => 'Raum'
            ),
            UserRoles::user => array(
                '/veranstaltung'        => 'Veranstaltung buchen'  
            )
        );
        
        /**
         * Authorisation prüfen
         */
        $controller = $this->uri->segment(1);
        $action = $this->uri->segment(2);
        $action = ("" == $action) ? 'index' : $action;

        if ("admin" == $controller || "veranstaltung")
            $acl = $this->config->item($controller.'/*');
        else
            $acl = $this->config->item($controller.'/'.$action);
        
        // Aus dem Array die festgelegte (mindestens nötige) Rolle auslesen
        // und ebenfalls auslesen, ob ein Login dafür nötig ist.
        $acl_role_required = $acl['role_required'];
        $acl_auth_required = $acl['auth_required'];

       //var_dump($acl_role_required, $acl_auth_required, $user_role, $this->logged_in);
        
        if (NULL == $user_role)
            $user_role = UserRoles::guest;
        
        // Ist eine Anmeldung erforderlich?
        if ($acl_auth_required)
        {
            if (FALSE == $this->logged_in)
                redirect('user/login');  
            
            // hiermit erreichen wir, dass der Browser keine Daten cached und
            // bei Seiten, die nur via Login sichtbar sein dürfen nicht mehr via 
            // Browser-History angesehen werden können, wenn der Benutzer bereits ausgeloggt ist.
            $this->output->set_header("Expires: Mon, 01 Jan 2000 05:00:00 GMT");                        // Date in the past
            $this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");           // always modified
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP/1.1
            $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
            $this->output->set_header("Pragma: no-cache");                                              // Pragma/Anweisung für Clients, die nur HTTP/1.0 "sprechen"
        }
        
        $constructed_main_menu = array();
        // Check der Rollen.
        // Erfüllt die Rolle des Benutzers die Mindestanforderung?
        if ("user" == $acl_role_required)
        {
            if ($user_role > UserRoles::user)
                redirect('error/accessdenied');
        }   
        else if ("approver" == $acl_role_required)
        {
            if($user_role > UserRoles::approver)
                redirect('error/accessdenied'); 
        }
        else if ("admin" == $acl_role_required)
        {
            if($user_role > UserRoles::admin)
                redirect('error/accessdenied');
        }
        // End of Authorisation    
        
        // Profiler aktivieren?
        // Der Profiler zeigt verschiedene Informationen, wie z.B. 
        // Ladezeiten, Ausführungszeiten, GET/POST Daten und SQL-Statements.
        //if ("development" == ENVIRONMENT)
        //    $this->output->enable_profiler(TRUE);
        
        // Setzen der sog. Error-Delimiters. In diesen werden eventuelle 
        // Fehler der Eingabe-Validierung angezeigt.
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        // Festlegen verschiedener Parameter für das verwendete Seiten-Template
        $this->template_folder = 'theme';
        $this->layout_folder = $this->template_folder.'/layout/';
        $this->pages_folder = 'theme/pages/';

        // Das Basis-Layout, bestehende aus
        // - Header-,
        // - Content-,
        // - Footer-Bereich
        $this->layout = $this->layout_folder.'master';

        // Ausgabe einer Fehlermeldung, wenn ein Benutzer mit einem mobilen Gerät auf
        // die Seite zugreifen möchte
        $this->load->library('user_agent');
        if( $this->agent->is_mobile() )
        {
            show_error('Sorry, until now we do not support mobile devices. We are working on it...');
        }
        
        // Setzen von einigen Werten, die in jeder Seite benötigt werden:
        $this->layout_data['logged_in'] = $this->logged_in;
        if ($user_role == UserRoles::admin)
            $this->layout_data['auth_menu'] = $menu_items[UserRoles::admin];
         if ($user_role == UserRoles::user)
            $this->layout_data['auth_menu'] = $menu_items[UserRoles::user];
        
        $this->load->library('javascript');
        $this->load->library('javascript/jquery');
    }
    
    
    public function _load_view($title = NULL, $content_data = array(), $content_view_file = NULL)
    {
        $this->layout_data['content_data'] = $content_data;
        $this->layout_data['title'] = $title;
        $this->layout_data['content_view'] = $content_view_file;
        $this->load->view($this->layout, $this->layout_data);
    }
}

/* End of file Base_Controller.php */
/* Location: ./application/controllers/Base_Controller.php */