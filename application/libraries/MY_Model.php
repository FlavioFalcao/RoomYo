<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

    // The main table name
    public $table;
    private $modelName;

    public function __construct() {
        parent::__construct();
        $this->table = '';
        $this->modelName = __CLASS__;
        log_message('INFO', "TABLE: ".$this->table);
    }

    // Log as Error each time nonexisting method called.
    public function __call($name, $arguments) {
        $args = implode(',',$arguments);
        $this->log('error', $name.'('.$args.') Not exists');
        return FALSE;
    }

    /**
     * Logs an error
     * @param String $level
     * @param String $msg
     */
    protected function log($level, $msg) {
        log_message($level, __CLASS__.'->'.__METHOD__.' :: <strong>'.$msg.'</strong> | In: '.__FILE__.' Line: '.__LINE__);
    }

    /**
     * This method inserts some array of data into the db
     * DEPRECATED, see save()

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    */

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    public function save($data) {
        if(is_array($data)) {
            $this->db->insert($this->table, $data);
            return $this->db->insert_id();
        } else {
            $this->log('error', 'got non-array param.');
            return FALSE;
        }
    }

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    function find_id($id = NULL)
    {
        if ($id == NULL)
        {
            return NULL;
        }

        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        $result = $query->result_array();
        return (count($result) > 0 ? $result[0] : NULL);
    }

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    function find($type = 'all', $options = array())
    {
        if ($type == 'first')
        {
            $this->db->limit(1);
        }
        if(array_key_exists('fields', $options))
        {
            //echo implode(",", $options['fields']);
            $this->db->select(implode(",", $options['fields']));
        }
        if(array_key_exists('where', $options))
        {
            foreach ($options['where'] as $key=>$value)
            {
                //echo $key."=".$value;
                $this->db->where($key, $value);
            }
        }
        if(array_key_exists('order', $options))
        {
            foreach ($option['where'] as $key=>$value)
            {
                $this->db->order_by($key, $value);
            }
        }
        if(array_key_exists('limit', $options))
        {
            $limit = $options['limit'];
            if(array_key_exists('limit', $limit) && !array_key_exists('offset', $limit))
            {
                $this->db->limit($limit['limit']);
            }
            if(array_key_exists('limit', $limit) && array_key_exists('offset', $limit))
            {
                $this->db->limit($limit['limit'], $limit['offset']);
            }
        }
        //$query = $this->db->get($this->table);
        //$result = $query->result_array();
        //return (count($result) > 0 ? $result[0] : NULL);
    }

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    function find_all($sort = 'id', $order = 'asc')
    {
        $this->db->order_by($sort, $order);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    function update($id = NULL, $data = NULL)
    {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    /**
     * This method inserts some array of data into the db
     * @param Array $data
     */
    function delete($id = NULL)
    {
        if ($id != NULL)
        {
            $this->db->where('id', $id);
            $this->db->delete($this->table);
            return TRUE;
        }
        else
        {
            $this->log('error', 'got non-numeric or non ID: '.$id);
            return FALSE;
        }
    }
}

/* End of file MY_Model.php */
/* Location: ./application/libraries/MY_Model.php */