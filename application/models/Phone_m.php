<?php
class Phone_m extends CI_Model{
    function __construct() {
        parent::__construct();
       
    }

  
    public $_rules_add = array(
        
        'contact_id'=> array(
            'field' =>'contact_id', 
            'label'=> 'contact_id', 
            'rules'=>'trim|required'
           )
        
        
       
    );
    
    public $_rules_edit = array(
     'contact_id'=> array(
            'field' =>'contact_id', 
            'label'=> 'contact_id', 
            'rules'=>'trim|required'
           )
        
    );
    
  
    
    function get($select_str = null, $condition_arr = null, $ordercol = null, $orderoption = null, $limit = null, $start = null) {
    
        if ($select_str != null) {
            $this -> db -> select($select_str);
        }
        if ($condition_arr != null) {
            $this -> db -> where($condition_arr);
        }
        if ($limit != null) {
            $this -> db -> limit($limit, $start);
        }
        //$this -> db -> order_by('membership_type','asc');
    
        $this -> db -> from('phone');
        //print_r($this -> db);
        return $this -> db -> get() -> result();
    }
   

    function save($User_arr) {
       
        return $this -> db -> insert('phone', $User_arr);

    }
    function count(){
        $this -> db -> from('phone');
        $items = $this -> db -> get() -> result();
        return count($items);
    }
    
    function update($data, $condition) {
        
        
        
        return $this -> db -> update('phone', $data, $condition);
    
    }
    function delete($id) {
        $arr = array('id'=>$id);
        
        $this -> db -> where($arr) -> delete('phone');
    }
    
    function getPhonesByID($contact_id)
    {
        $query = "SELECT * FROM phone WHERE contact_id =" . addslashes($contact_id);
        $result = $this->db->query($query);
        return $result->result();
    }

    function getPhoneByNumber($phone)
    {
        $query = "SELECT * FROM phone WHERE phone ='" . addslashes($phone) . "'";
        $result = $this->db->query($query);
        return $result->result();
    }

    function addNewPhone($id, $phone)
    {
        $query = "INSERT INTO phone (contact_id, phone) VALUES (". $id .", '" . $phone . "');";
        $result = $this->db->query($query);
        return $result->result();
    }
}