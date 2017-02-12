<?php
class Contact_m extends CI_Model{
    function __construct() {
        parent::__construct();
       
    }

  
    public $_rules_add = array(
        
        'name'=> array(
            'field' =>'name', 
            'label'=> 'name', 
            'rules'=>'trim|required'
           )
        
        
       
    );
    
    public $_rules_edit = array(
     'name'=> array(
            'field' =>'name', 
            'label'=> 'name', 
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
    
        $this -> db -> from('contact');
        //print_r($this -> db);
        return $this -> db -> get() -> result();
    }
   

    function save($User_arr) {
        
        return $this -> db -> insert('contact', $User_arr);

    }
    function count(){
        $this -> db -> from('contact');
        $items = $this -> db -> get() -> result();
        return count($items);
    }
    
    function update($data, $condition) {
        
        
        
        return $this -> db -> update('contact', $data, $condition);
    
    }
    function delete($id) {
        $arr = array('id'=>$id);
        
        $this -> db -> where($arr) -> delete('contact');
    }
    
    function searchByName($name)
    {
        // $query = "SELECT * FROM contact c LEFT JOIN email e ON c.id = e.contact_id LEFT JOIN phone p ON c.id = p.contact_id WHERE c.name LIKE '%" + addslashes($name) + "%'";
        $query = "SELECT c.id, c.name, c.email AS main_email, c.phone AS main_phone, c.date_created, c.date_modified FROM contact c WHERE c.name LIKE '%". addslashes($name) ."%'";
        $result = $this->db->query($query);
        return $result->result();
    }

    function addNewContact($name, $email, $phone)
      {
        $query = "INSERT INTO contact (name, email, phone, date_created) VALUES ('". $name ."','" . $email . "','" . $phone . "', NOW());";
        $result = $this->db->query($query);
        return $this->db->insert_id();
      }  
}