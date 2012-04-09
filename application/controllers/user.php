<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('start/dashboard');
    }

    public function login()
    {
        $content_data = array();
        
        // Wenn das Formular mit den Nutzerdaten abgeschickt wurde
        if ($this->input->post('submit')) {
            // Regeln für Validation setzen
            $this->form_validation->set_rules($this->config->item('user_login'));
            // Wenn die Daten richtig eingegeben wurden kann mit der überprüfung des Benutzernamens und Passwortes begonnen werden.
            if ($this->form_validation->run() === TRUE) {
                $ah = new AuthenticationHandler();
                $login_gueltig = $ah->LoginBenutzer($this->input->post('username'), $this->input->post('password'));

                if ($login_gueltig === TRUE) {
                    // create new session
                    $ah->ErstelleNeueSession();
                    $this->session->set_userdata('username', $this->input->post('username'));
                    // wenn alles korrekt ist kann auf das Dashboard umgeleitet werden
                    redirect('start/dashboard');
                }
                else
                    // bei fehlerhafter Eingabe wird wieder auf das Login Formular umgeleitet
                    $this->session->set_flashdata('error', 'Benutzer oder Passwort falsch.');
                    redirect('user/login');
            }
            else {
                $this->session->set_flashdata('Benutzer oder Passwort falsch.');
            }
        }
        
        $this->_load_view("Login", $content_data, 'user/login');
    }

    public function logout()
    {
        $ah = new AuthenticationHandler();
        $ah->LogoutBenutzer();
        redirect('user/login');
    }

}