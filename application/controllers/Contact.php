<?php
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Contact extends REST_Controller
{
    public function __construct() {
        parent::__construct();      
          $this->load->model('Contact_m');
     $this->load->model('Phone_m');
     $this->load->model('Email_m');
    }
  public function index_get()
  {
    
     $contacts=$this->Contact_m->get();
     $this->response($contacts, 200);
  }
  

  public function index_post()
  {
     
     $Data;
     if($this->post('name')!=null){
      $Data['name']=$this->post('name');
     } if($this->post('email')!=null){
      $Data['email']=$this->post('email');
     } if($this->post('phone')!=null){
      $Data['phone']=$this->post('phone');
     }
              date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                    $Data['date_created'] = $strdate;
     $contacts=$this->Contact_m->save($Data);
     $this->response('Contact Saved', 200);
  }
  public function index_put($id)
  {
     
     $Data;
     if($this->put('name')!=null){
      $Data['name']=$this->put('name');
     } if($this->post('email')!=null){
      $Data['email']=$this->put('email');
     } if($this->post('phone')!=null){
      $Data['phone']=$this->put('phone');
     }
              
     $contacts=$this->Contact_m->update($Data,array('id'=>$id));
     $this->response('Contact Updated', 200);
  }
  public function match($contact){
    
     $contacts=$this->Contact_m->get(null,array('name'=>$contact->name));
     if(count($contacts)>0){
        if($contacts[0]->phone!=$contact->phone){
           
            $Data['contact_id']=$contacts[0]->id;
            $Data['phone']=$contact->phone;
           date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                    $Data['date_created'] = $strdate;
                   $this->Phone_m->save($Data);

        }
        if($contacts[0]->email!=$contact->email){
           
            $Data['contact_id']=$contacts[0]->id;
            $Data['phone']=$contact->email;
           date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                    $Data['date_created'] = $strdate;
                   $this->Email_m->save($Data);

        }
     }

  }
  public function index_delete($id)
  {
    
    
              
     $contacts=$this->Contact_m->delete($id);
     $this->response('Contact Deleted', 200);
  }
}