<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Erstelle die Starseitentabelle
 *
 * @access	public
 * @param	integer	Nummer des uri Segementes, dass als offset für die DB anfrage genutzt wird.
 * @return	void
 */
function create_startpage($urisegment,$params=NULL) 
    {
        $CI =& get_instance();
        $modelname = $CI->modelname;
        $start = $CI->uri->segment($urisegment);
        $start = (empty($start)) ? 0 : $start;
        $count_all = $CI->db->count_all($CI->modeltable);
        // Abbrechen wenn User falschen GET Parameter setzt
        if($start > $count_all) show_error('Offset gr&ouml;&szlig;er als Anzahl Datens&auml;tze',400);

        // Defaultwert für $orderby setzen 
        $sortierrichtung = 'asc';
        $orderby = 'uid '.$sortierrichtung;
        // Prüfen ob ein Sorting Parameter gesetzt wurde und splitten in die zwei Bestandteile
        $orderArray = preg_split('/_/', $CI->uri->segment($urisegment+1),-1,PREG_SPLIT_NO_EMPTY);
        if(!empty($orderArray)) 
        {
            // Spaltennamen aus der jeweiligen Tabelle auslesen
            $columns = $CI->db->query('SHOW COLUMNS FROM '.$CI->modeltable)->result_array();
            $erlaubte_felder = array();
            foreach ($columns as $index => $spaltenbezeichner){
                $erlaubte_felder[] = $spaltenbezeichner['Field'];
            }
            
            $pruefstring = $orderArray[0];
            $sortierrichtung = $orderArray[1];
            // Falls ein "id" Parameter mit in dem URL steht müssen die Parameter 
            // aus der nächsten Array Position genommen werden.
            if($orderArray[1] == 'id') {
                $pruefstring .= '_'. $orderArray[1];
                $sortierrichtung = $orderArray[2];
            }
            // Wenn der Parameter aus dem URL im Array der Spaltennamen enthalten ist,
            // dann wird der $orderby Parameter mit den URL Parametern überschrieben.
            if(in_array($pruefstring, $erlaubte_felder))
                $orderby = $pruefstring. ' ' . $sortierrichtung;
        } 
        
        $result = $CI->$modelname->get($params,$start,ELEMENTE_PRO_SEITE,$orderby);
        
        $data = array();
        if(isset($CI->additionalParams) && $CI->additionalParams !== NULL) {
            foreach($CI->additionalParams as $param => $value) {
                $data[$param] = $value;
            }
        }
        $data[$modelname] = $result->result();
        $data['title'] = $CI->sitetitle;
        $data['richtung'] = ($sortierrichtung == 'asc') ? 'desc' : 'asc';
        $data['skriptpfad'] = 'admin/'.$modelname.'/'.$start;
        
        // Paginator laden und mit Parametern spicken
        $CI->load->library('pagination');
        $config['base_url'] = base_url().'admin/'.$modelname.'/';
        $config['total_rows'] = $count_all;
        $config['per_page'] = ELEMENTE_PRO_SEITE;
        $config['full_tag_open'] = '<span class="paginator">';
        $config['full_tag_close'] = '</span>';


        $CI->pagination->initialize($config);
        $data['paginator'] = $CI->pagination->create_links();

        //$CI->layout_data['content'] = $CI->load->view($CI->viewpath, $data, TRUE);
        //$CI->load->view($CI->layout, $CI->layout_data);
        $CI->_load_view($CI->sitetitle, $data, $CI->viewpath);
    }
    
 /**
 * Lösche Eintrag aus beliebiger Tabelle
 *
 * @access	public
 * @param	integer	Nummer des uri Segementes, dass als offset für die DB anfrage genutzt wird.
 * @return	void
 */
function delete_entry($id) 
    {
        $CI =& get_instance();
        $modelname = $CI->modelname;
        
        $id = intval($id);
        if($CI->$modelname->delete($id) > 0) 
        {
            $CI->session->set_flashdata('confirm' , 'Eintrag wurde erfolgreich gelöscht!');
            redirect('admin/'.$modelname);
        } 
        else 
        {
            $CI->session->set_flashdata('error' , 'Es existiert bereits kein Eintrag mit der ID '.$id.' in der Datenbank!');
            redirect('admin/'.$modelname);
        }
    }