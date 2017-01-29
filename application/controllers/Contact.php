<?php
use Restserver\Libraries\REST_Controller;

class Contact extends REST_Controller
{
  public function index_get()
  {
     $this->load->model('Contact_m');
     $contacts=$this->Contact_m->get();
     $this->response($contacts, 200);
  }

  public function index_post()
  {
     $this->load->model('Contact_m');
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
     $this->load->model('Contact_m');
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
  public function index_delete($id)
  {
     $this->load->model('Contact_m');
    
      				
     $contacts=$this->Contact_m->delete($id);
     $this->response('Contact Deleted', 200);
  }
}