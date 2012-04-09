<?php

/**
 * Description of admin_ausstattung
 *
 * @author alex
 * @author andreas
 */
class Admin_ausstattung extends Base_Controller
{

    public $sitetitle = 'Ausstattungs Übersicht';
    public $viewpath;
    public $modeltable = 'Ausstattung';
    public $modelname = 'ausstattung';
    public $additionalParams = NULL;

    function __construct()
    {
        parent::__construct();
        $this->load->model('ausstattung_model', $this->modelname);
    }

    function index()
    {
        $queryparams = NULL;
        $raumfilter = $this->uri->segment(5);
        // Viewpfad für Startseite setzen
        $this->viewpath = 'admin/ausstattung/start_ausstattung_view';
        // Räume laden und Array füllen für Filterfunktion
        $this->load->model('raum_model', 'raum');
        $raeume = $this->raum->get()->result_array();
        $raeume_array = array();
        foreach ($raeume as $raum) {
            $raeume_array[$raum['uid']] = $raum['name'];
        }
        $this->additionalParams = array('raeume' => $raeume_array);
        if (!empty($raumfilter))
            $queryparams = array('raum_id' => $raumfilter);
        // Helperfunktion um generisch die Übersichtstabelle zu erzeugen   
        create_startpage(3, $queryparams);
    }

    function edit($id)
    {
        $this->sitetitle = 'Eintrag bearbeiten';
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$ausstattung = $this->ausstattung->get(array('a.uid' => $id))->row())
            show_error("Der angefragte Datensatz existiert nicht", 400);

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('ausstattung_valid'));
        if ($this->form_validation->run() == FALSE) {
            self::form_config('bearbeiten', '/admin/ausstattung/edit/' . $id, $ausstattung);
        } else {
            $this->ausstattung->update($this->input->post(), $id);
            $this->session->set_flashdata('confirm', 'Eintrag wurde erfolgreich geändert!');
            redirect('admin/ausstattung');
        }
    }

    function create($id=NULL)
    {
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt, wenn ja soll das Formular vorbefüllt werden zwecks kopieren
        if (!$ausstattung = $this->ausstattung->get(array('a.uid' => $id))->row())
            $ausstattung = NULL;

        $this->sitetitle = 'Neuen Eintrag erstellen';
        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('ausstattung_valid'));
        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            self::form_config('erstellen', '/admin/ausstattung/create', $ausstattung);
        } else {
            // Validierung Ok
            if (!$this->ausstattung->create($this->input->post()))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag hinzugefügt!');
            redirect('admin/ausstattung');
        }
    }

    function delete($id)
    {
        // Helper Aufruf zum Löschen eines Eintrages
        delete_entry($id);
    }

    // Formconfig für den Edit und Create Prozess
    function form_config($prozess, $formaction, $ausstattung=NULL)
    {
        if (!isset($ausstattung) && !is_array($ausstattung))
            $ausstattung = array();
        // Models laden um Pulldown der View zu füllen
        $this->load->model('ausstattungstyp_model', 'astyp');
        $this->load->model('raum_model', 'raum');
        $astypen = $this->astyp->get()->result_array();
        $raeume = $this->raum->get()->result_array();
        $as_array = array();
        $raum_array = array();
        foreach ($astypen as $as) {
            $as_array[$as['uid']] = $as['typ'];
        }
        foreach ($raeume as $raum) {
            $raum_array[$raum['uid']] = $raum['name'];
        }

        $data = array();
        $data['astypen'] = $as_array;
        $data['ausstattung'] = $ausstattung;
        $data['raeume'] = $raum_array;
        $this->layout_data['title'] = $this->sitetitle;
        $data['prozess'] = $prozess;
        $data['formaction'] = $formaction;
        // Wenn Validierung fehlschlägt
        $this->layout_data['content_view'] = 'admin/ausstattung/ausstattung_form_view';
        $this->layout_data['content_data'] = $data;
        $this->load->view($this->layout, $this->layout_data);
    }

}

/* End of file admin_ausstattung.php */
/* Location: ./application/controllers/admin/admin_ausstattung.php */