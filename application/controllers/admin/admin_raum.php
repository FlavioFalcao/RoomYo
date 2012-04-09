<?php

/**
 * Description of admin_raum
 *
 * @author alex
 * @author andreas
 */
class Admin_raum extends Base_Controller
{

    public $sitetitle = 'Raum Übersicht';
    public $viewpath;
    public $modeltable = 'Raum';
    public $modelname = 'raum';

    function __construct()
    {
        parent::__construct();
        $this->load->model('raum_model', $this->modelname);
    }

    function index()
    {
        // Viewpfad für Startseite setzen
        $this->viewpath = 'admin/raum/start_raum_view';
        // Helperfunktion um generisch die Übersichtstabelle zu erzeugen   
        create_startpage(3);
    }

    function edit($id)
    {
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$raum = $this->raum->get(array('a.uid' => $id))->row())
            show_error("Der angefragte Datensatz existiert nicht", 400);

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('raum_valid'));

        if ($this->form_validation->run() == FALSE) {
            self::form_config('bearbeiten', '/admin/raum/edit/' . $id, $raum);
        } else {
            $this->raum->update($this->input->post(), $id);
            $this->session->set_flashdata('confirm', 'Eintrag wurde erfolgreich geändert!');
            redirect('admin/raum');
        }
    }

    function create($id=NULL)
    {

        $id = intval($id);
        // Prüfen ob es die ID auch wirklich in der DB gibt und Objekt erzeugen ansonsten leer setzen
        if (!$raum = $this->raum->get(array('a.uid' => $id))->row())
            $raum = array();

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('raum_valid'));

        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            self::form_config('erstellen', '/admin/raum/create', $raum);
        } else {
            // Validierung Ok
            if (!$this->raum->create($this->input->post()))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag hinzugefügt!');
            redirect('admin/raum');
        }
    }

    function form_config($prozess, $formaction, $raum=NULL)
    {
        // Models laden um View zu füllen
        $this->load->model('gebaeude_model', 'gebaeude');
        $gebaeude = $this->gebaeude->get()->result_array();
        $gebaeude_array = array();
        foreach ($gebaeude as $gebaeude) {
            $gebaeude_array[$gebaeude['uid']] = $gebaeude['name'] . ', ' . $gebaeude['ortsname'];
        }

        $this->sitetitle = 'Neuen Eintrag erstellen';
        $content_data = array();
        $content_data['gebaeude'] = $gebaeude_array;
        $content_data['raum'] = $raum;
        $content_data['prozess'] = $prozess;
        $content_data['formaction'] = $formaction;
        $this->layout_data['title'] = $this->sitetitle;
        // Wenn Validierung fehlschlägt
        $this->layout_data['content_view'] = 'admin/raum/raum_form_view';
        $this->layout_data['content_data'] = $content_data;
        $this->load->view($this->layout, $this->layout_data);
    }

    function delete($id)
    {
        // Helper Aufruf zum Löschen eines Eintrages
        delete_entry($id);
    }

}

/* End of file admin_ausstattung.php */
/* Location: ./application/controllers/admin/admin_ausstattung.php */