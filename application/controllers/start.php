<?php

class Start extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
    }

    public function index()
    {
        // Ausgangspunkt ist unser Dashboard, daher
        // machen wir einen redirect auf die dashboard-Action
        redirect('start/dashboard');
    }

    public function dashboard()
    {
        $this->load->model('veranstaltung_model', 'veranstaltung');

        // Contentdata Array für die Darstellung im Frontend befüllen
        $content_data['veranstaltungen_data'] = $this->veranstaltung->get(array('v.cruser' => $this->session->userdata('uid'), 'startdatum >=' => time()),0,LIMIT,'startdatum ASC')->result();
        $this->_load_view("Dashboard", $content_data, 'dashboard_view');
    }

}