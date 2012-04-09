<?php

/**
 * Description of admin_ausstattung
 *
 * @author alex
 * @author andreas
 */
class Admin_nutzer extends Base_Controller
{

    public $sitetitle = 'Benutzer Übersicht';
    public $viewpath;
    public $modeltable = 'Nutzer';
    public $modelname = 'nutzer';
    public $additionalParams = NULL;

    function __construct()
    {
        parent::__construct();
        $this->load->model('nutzer_model', $this->modelname);
    }

    function index()
    {
        // Viewpfad für Startseite setzen
        $this->viewpath = 'admin/nutzer/start_nutzer_view';
        // Helperfunktion um generisch die Übersichtstabelle zu erzeugen   
        create_startpage(3);
    }

    function edit($id)
    {
        $this->sitetitle = 'Eintrag bearbeiten';
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$nutzer = $this->nutzer->get(array('a.uid' => $id))->row())
            show_error("Der angefragte Datensatz existiert nicht", 400);

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('nutzer_edit'));
        if ($this->form_validation->run() == FALSE) {
            self::form_config('bearbeiten', '/admin/nutzer/edit/' . $id, $nutzer);
        } else {
            $this->nutzer->update($this->input->post(), $id);
            $this->session->set_flashdata('confirm', 'Eintrag wurde erfolgreich geändert!');
            redirect('admin/nutzer');
        }
    }

    function create($id=NULL)
    {
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt, wenn ja soll das Formular vorbefüllt werden zwecks kopieren
        if (!$nutzer = $this->nutzer->get(array('a.uid' => $id))->row())
            $nutzer = NULL;

        $this->sitetitle = 'Neuen Eintrag erstellen';
        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('nutzer_create'));
        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            self::form_config('erstellen', '/admin/nutzer/create', $nutzer);
        } else {
            // Validierung Ok
            if (!$this->nutzer->create($this->input->post()))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag hinzugefügt!');
            redirect('admin/nutzer');
        }
    }

    function delete($id)
    {
        // Helper Aufruf zum Löschen eines Eintrages
        delete_entry($id);
    }

    // Callback um zu prüfen ob in der Datenbank ein Duplikat vorhanden ist
    function _check_for_duplicate($str, $dbfield=NULL)
    {
        if (!isset($dbfield))
            show_error("Vergleichsfeld nicht gesetzt!", 400);

        $data[$dbfield] = strtolower($str);

        // Wenn Das URI Segment (also die uid) gesetzt ist befinden wir uns im edit mode und da darf der Username
        // des selben Users selbstverständlich wieder eingetragen werden ohne das ein Fehler wegen Duplikat erzeugt wird.
        $id = $this->uri->segment(4);
        if (isset($id) && !empty($id))
            $data['uid !='] = $id;

        if ($this->nutzer->get($data)->num_rows() > 0) {
            $this->form_validation->set_message('_check_for_duplicate', 'Der Wert ist in der Datenbank bereits vorhanden. Bitte einen anderen auswählen.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    // Formconfig für den Edit und Create Prozess
    function form_config($prozess, $formaction, $nutzer=NULL)
    {
        if (!isset($nutzer) && !is_array($nutzer))
            $nutzer = array();
        // Models laden um Pulldown der View zu füllen
        $nutzerresult = $this->nutzer->get()->result_array();

        foreach ($nutzerresult as $einnutzer)
            $alle_nutzer[$einnutzer['uid']] = $einnutzer['nachname'] . ', ' . $einnutzer['vorname'];

        $data = array();
        $data['title'] = $this->sitetitle;
        $data['nutzer'] = $nutzer;
        $data['prozess'] = $prozess;
        $data['formaction'] = $formaction;
        $data['alle_nutzer'] = $alle_nutzer;
        // Wenn Validierung fehlschlägt
        //$this->layout_data['content'] = $this->load->view('theme/pages/admin/nutzer/nutzer_form_view', $data,TRUE);
        //$this->load->view($this->layout, $this->layout_data);
        $this->_load_view($this->sitetitle, $data, 'admin/nutzer/nutzer_form_view');
    }

}

/* End of file admin_ausstattung.php */
/* Location: ./application/controllers/admin/admin_ausstattung.php */
