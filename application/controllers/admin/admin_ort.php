<?php

/**
 * Description of admin_ort
 *
 * @author alex
 * @author Andreas
 */
class Admin_ort extends Base_Controller
{

    public $sitetitle = 'Orte Übersicht';
    public $viewpath;
    public $modeltable = 'Ort';
    public $modelname = 'ort';

    function __construct()
    {
        parent::__construct();
        $this->load->model('ort_model', 'ort');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index()
    {
        // Viewpfad für Startseite setzen
        $this->viewpath = 'admin/ort/start_ort_view';
        // Helperfunktion um generisch die Übersichtstabelle zu erzeugen   
        create_startpage(3);
    }

    function edit($id)
    {
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$ort = $this->ort->get(array('a.uid' => $id))->row(0))
            show_error("Der angefragte Ort existiert nicht", 400);

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('ort_valid'));

        $data = array();
        $data['ort'] = $ort;
        $data['prozess'] = 'bearbeiten';
        $data['formaction'] = '/admin/ort/edit' . $id;
        $data['title'] = 'Ort bearbeiten';
        
        // Wenn Validierung fehlschlägt, dann wird die Seite erneut mit den Fehlermeldungen geladen
        if ($this->form_validation->run() == FALSE) {
            $this->_load_view($this->sitetitle, $data, 'admin/ort/ort_form_view');
        } else {
            $this->ort->update($this->input->post(), $id);
            $this->session->set_flashdata('confirm', 'Eintrag wurde erfolgreich geändert!');
            redirect('admin/ort');
        }
    }
    
    // Erstellen eines neuen Ortes
    function create($id=NULL)
    {
        $id = intval($id);

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$ort = $this->ort->get(array('a.uid' => $id))->row(0))
            $ort = array();

        $data = array();
        $data['ort'] = $ort;
        $data['prozess'] = 'erstellen';
        $data['formaction'] = '/admin/ort/create';
        $this->layout_data['title'] = 'Ort erstellen';

        // Regeln für die Validierung setzen
        $this->form_validation->set_rules($this->config->item('ort_valid'));

        // Validierung starten
        if ($this->form_validation->run() == FALSE) {
            // Wenn Validierung fehlschlägt
            $this->layout_data['content_view'] = 'admin/ort/ort_form_view';
            $this->layout_data['content_data'] = $data;
            $this->load->view($this->layout, $this->layout_data);
        } else {
            // Validierung Ok
            if (!$this->ort->create($this->input->post()))
                show_error("Beim Einfügen in die Datenbank ist ein Fehler aufgetreten", 400);
            $this->session->set_flashdata('confirm', 'Eintrag hinzugefügt!');
            redirect('admin/ort');
        }
    }

    function delete($ortid)
    {
        // Helperaufruf zum Löschen
        delete_entry($ortid);
    }

}

/* End of file admin_ort.php */
/* Location: ./application/controllers/admin/admin_ort.php */