<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_gebaeude extends Base_Controller
{

    public $sitetitle = 'Gebäude Übersicht';
    public $viewpath;
    public $modeltable = 'Gebaeude';
    public $modelname = 'gebaeude';

    function __construct()
    {
        parent::__construct();
        $this->load->model('gebaeude_model', 'gebaeude');
        $this->load->model('ort_model', 'ort');
    }

    function index()
    {
        // Viewpfad für Startseite setzen
        $this->viewpath = 'admin/gebaeude/start_gebaeude_view';
        // Helperfunktion um generisch die Übersichtstabelle zu erzeugen   
        create_startpage(3);
    }

    function create($id=NULL)
    {
        $id = intval($id);
        // Gebäudedaten aus DB laden:
        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$gebaeude_data = $this->gebaeude->get(array('g.uid' => $id))->row())
            $gebaeude_data = array();

        $this->sitetitle = 'Neues Gebäude anlegen';
        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('gebaeude_valid'));
        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            self::form_config('erstellen', '/admin/gebaeude/create', $gebaeude_data);
        } else {
            // Validierung Ok
            if (!$this->gebaeude->create($this->input->post()))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag hinzugefügt!');
            redirect('admin/gebaeude');
        }
    }

    function edit($id)
    {
        $id = intval($id);
        // Gebäudedaten aus DB laden:
        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$gebaeude_data = $this->gebaeude->get(array('g.uid' => $id))->row())
            show_error("Das Geb&auml;ude existiert nicht", 400);

        $this->sitetitle = 'Neues Gebäude anlegen';
        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('gebaeude_valid'));
        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            self::form_config('bearbeiten', '/admin/gebaeude/edit/' . $id, $gebaeude_data);
        } else {
            // Validierung Ok
            if (!$this->gebaeude->update($this->input->post(), $id))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag erfolgreich gespeichert!');
            redirect('admin/gebaeude');
        }
    }

    function delete($id)
    {
        // Helper Aufruf zum Löschen eines Eintrages
        delete_entry($id);
    }

    // Formconfig für den Edit und Create Prozess
    function form_config($prozess, $formaction, $gebaeude_data=NULL)
    {
        $data = array();
        if (!isset($gebaeude_data) && !is_array($gebaeude_data))
            $gebaeude_data = array();

        $data['page_title'] = "Gebäude editieren";
        $data['gebaeude_data'] = $gebaeude_data;

        $orte_result = $this->ort->get()->result_array();
        // $dd_data['0'] = 'Bitte auswählen';
        foreach ($orte_result as $row) {
            $dd_data[$row['uid']] = $row['name'];
        }
        $data['orte_dd_options'] = $dd_data;
        $this->layout_data['title'] = $this->sitetitle;
        $data['prozess'] = $prozess;
        $data['formaction'] = $formaction;
        // Wenn Validierung fehlschlägt
        $this->layout_data['content_view'] = 'admin/gebaeude/gebaeude_form_view';
        $this->layout_data['content_data'] = $data;
        $this->load->view($this->layout, $this->layout_data);
    }

}

/* End of file admin_gebaeude.php */
/* Location: ./application/controllers/admin_gebaeude.php */