<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Veranstaltung extends Base_Controller
{

    // Objektattribute für vereinheitlichen Zugriff 
    public $sitetitle = 'Veranstaltungen';
    public $viewpath;
    public $modeltable = 'Veranstaltung';
    public $modelname = 'veranstaltung';

    function __construct()
    {
        parent::__construct();
        $this->load->model('gebaeude_model', 'gebaeude');
        $this->load->model('raum_model', 'raum');
        $this->load->model('veranstaltung_model', 'veranstaltung');
        $this->load->helper('date_format_helper');
    }

    public function index()
    {
        //Raumid aus der URL auslesen
        $raumid = $this->uri->segment(2);
        // Wenn keine Raumid vorhanden ist kann auf keinen bestimmten Raum gebucht werden und
        // daher wird zu der Raumübersichtsseite umgeleitet
        if (isset($raumid) && $raumid != '') {
            redirect('veranstaltung/buchen/' . $raumid);
        } else {
            redirect('veranstaltung/anfrage');
        }
    }

    // Wenn in der URI keine Raumnummer mit übergeben wird oder der User regulär auf Buchen klickt
    // wird zunächst immer die Übersicht über alle Räume gezeigt.
    public function anfrage()
    {

        $raeume = $this->raum->get(NULL, 0, LIMIT, 'gebaeudename ASC, a.name ASC')->result('Raum_model');
        $content_data['raeume'] = $raeume;

        $this->_load_view("Raum&uuml;bersicht", $content_data, 'veranstaltung/anfrage_view');
    }

    public function buchen()
    {
        $raumid = $this->uri->segment(3);

        $veranstaltungen = $this->veranstaltung->get(array('raum_id' => $raumid))->result_array();
        $json_arr = array();
        $is_read_only = false;
        foreach ($veranstaltungen as $v) {
            // Wenn Ersteller und aktueller Benutzer unterschiedlich
            // ist ein Event nur lesbar. Es sei denn ein Admin ist eingeloggt.
            $is_read_only = ($v['cruser'] != $this->session->userdata('uid') && $this->session->userdata('role') != 1);

            $json_arr[] = array(
                "id" => $v['uid'],
                "start" => date('c', $v['startdatum']),
                "end" => date('c', $v['enddatum']),
                "title" => $v['name'],
                "teilnehmer" => $v['teilnehmer'],
                "readOnly" => $is_read_only
            );
        }
        $this->layout_data['event_data'] = json_encode($json_arr);

        // Wenn keine ID angegeben wird oder Wert nicht von Typ "int" ist, dann  umleiten zur Index Action
        if (!intval($raumid) || $raumid == '') {
            redirect('veranstaltung');
        }

        // Prüfen ob es die ID auch wirklich in der DB gibt
        if (!$raum = $this->raum->get(array('a.uid' => $raumid))->row(0, 'Raum_model'))
            show_error("Der angefragte Raum existiert nicht", 400);

        // Data Array für View befüllen
        $content_data['raum'] = $raum;

        $result = FALSE;
        // Wenn das Formular abgeschickt wurde...
        if ($this->input->post()) {
            // Regeln für die Validierung setzen
            $this->form_validation->set_rules($this->config->item('anfrage_valid'));

            if ($this->form_validation->run() === TRUE) {
                // Wenn alles validiert ist und Daten verfügbar und valide sind dann darf gebucht werden
                $result = $this->veranstaltung->create($this->input->post(), $this->user_id);
            }
        }

        if ($this->input->is_ajax_request()) {
            $this->output->enable_profiler(FALSE);
            if ($result === FALSE)
                return $this->load->view('theme/pages/veranstaltung/buchen_ajax_view', $content_data);
            else
                echo "TRUE";
        }
        else {
            $this->_load_view("", $content_data, 'veranstaltung/buchen_view');
        }
    }

    // Verschieben, Verlängern bzw. generelles Ändern von Daten eines Termines
    public function edit()
    {
        $content_data = array();

        $result = FALSE;
        // Wenn das Formular abgeschickt wurde...
        if ($this->input->post()) {
            // Regeln für die Validierung setzen
            $this->form_validation->set_rules($this->config->item('anfrage_valid'));

            if ($this->form_validation->run() === TRUE) {
                // Wenn alles validiert ist und Daten verfügbar und valide sind dann darf gebucht werden
                $result = $this->veranstaltung->update($this->input->post());
            }
        }

        if ($this->input->is_ajax_request()) {
            $this->output->enable_profiler(FALSE);
            if ($result === FALSE)
                return $this->load->view('theme/pages/veranstaltung/buchen_ajax_view', $content_data);
            else
                echo "TRUE";
        }
        else {
            show_error('Direkter Zugriff nicht erlaubt.');
        }
    }

    // Löscht einen Termin aus der Datenbank wenn der User die jeweilige Berechtigung hat
    public function delete()
    {
        $uid = $this->input->post('uid', TRUE);

        // Bestimmung ob der zu löschende Termin auch von dem User erstellt wurde, der diesen gerade löschen möchte
        $result = $this->veranstaltung->get(array('v.uid' => $uid, 'v.cruser' => $this->session->userdata('uid')))->num_rows();

        // Wenn $result größer null ist die eingeloggte Person der Ersteller und darf diesen Termin löschen.
        // Ein Admin darf den Termin trotzdem löschen
        if ($result > 0 || $this->session->userdata('role') == 1)
            return $this->veranstaltung->delete($uid);
    }

    // Validator-Callback um auf Terminüberschneidung des Stardatums zu überprüfen
    public function _check_ueberschneidung($datum)
    {
        return (self::_check_zeitraum($datum, '', FALSE)) ? TRUE : FALSE;
    }

    // Validator-Callback um auf zu Überprüfen ob der komplette Zeitraum eines anderen Termins umspannt wird
    public function _check_zeitraum($startdatum, $useless_param, $use_enddatum = TRUE, $raumid = '')
    {
        $enddatum = '';
        $form_raumid = set_value('raumid');
        $form_enddatum = $this->input->post('enddatum', TRUE);

        if ($raumid == '') {
            if (empty($form_raumid))
                return FALSE;
            $raumid = $form_raumid;
        }
        if ($use_enddatum == TRUE) {
            if (empty($form_enddatum))
                return FALSE;
            $enddatum = $form_enddatum;
        }
        return $this->veranstaltung->check_verfuegbarkeit($raumid, $startdatum, $enddatum, $this->input->post('uid', TRUE));
    }

    // Validator-Callback um zu Überprüfen ob der Raum mehr oder gleichviele Sitzplätze enthält als angefragt
    public function _check_sitzplaetze($sitzplaetze, $raumid = '')
    {
        $form_raumid = set_value('raumid');
        if ($raumid == '') {
            if (empty($form_raumid))
                return FALSE;
            $raumid = $form_raumid;
        }
        return $this->raum->check_anzahl_plaetze($raumid, $sitzplaetze);
    }

}

/* End of file veranstaltung.php */
/* Location: ./application/controllers/veranstaltung.php */
