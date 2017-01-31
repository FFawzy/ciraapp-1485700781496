<?php
class Email_m extends CI_Model{
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
    
        $this -> db -> from('email');
        //print_r($this -> db);
        return $this -> db -> get() -> result();
    }
   

    function save($User_arr) {
        
        return $this -> db -> insert('email', $User_arr);

    }
    function count(){
        $this -> db -> from('email');
        $items = $this -> db -> get() -> result();
        return count($items);
    }
    
    function update($data, $condition) {
        
        
        
        return $this -> db -> update('email', $data, $condition);
    
    }
    function delete($id) {
        $arr = array('id'=>$id);
        
        $this -> db -> where($arr) -> delete('email');
    }
    
  
}