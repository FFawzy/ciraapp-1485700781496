<?php
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class SaveContact extends REST_Controller
{
    public function __construct() {
      parent::__construct();      
      $this->load->model('Contact_m');
      $this->load->model('Phone_m');
      $this->load->model('Email_m');
    }
  
  

  public function index_post()
  {
    $name = $this->post('name');
    $main_email = $this->post('main_email');
    $main_phone = $this->post('main_phone');
    $phones = $this->post('phones');
    $emails = $this->post('emails');
    $id = 0;
    if(isset($phones) && sizeof($phones) > 0) {
      foreach ($phones as $phone) {
        $old_phone = $this->Phone_m->getPhoneByNumber($phone);
        if(isset($old_phone)) {
          $id = $old_phone[0]->id;
          break;
        }
      }
    }
    if($id == 0 && isset($emails) && sizeof($emails)) {
      foreach ($emails as $email) {
        $old_email = $this->Email_m->getEmailByEmail($email);
        if(isset($old_email)) {
          $id = $old_email[0]->id;
          break;
        }
      }  
    }
    
    if($id!=0){
      //update old contact
      //$this->updateOldContact($id, $name, $main_email, $main_phone, $phones, $emails);
      //$data = array('id'=>$id,'name'=>$name,'main_email'=$main_email,'main_phone'=>$main_phone,'phones'=>$phones,'emails'=>$emails);
      $this->response('suggest', 200);
    }
    else {
     $this->response('ignore', 200);
    }
    
  }
  public function index_put()
  {
    $name = $this->put('name');
    $main_email = $this->put('main_email');
    $main_phone = $this->put('main_phone');
    $phones = $this->put('phones');
    $emails = $this->put('emails');
    $id = $this->put('id');
   
    
    if($id!=0){
      //update old contact
      $this->updateOldContact($id, $name, $main_email, $main_phone, $phones, $emails);
      //$data = array('id'=>$id,'name'=>$name,'main_email'=$main_email,'main_phone'=>$main_phone,'phones'=>$phones,'emails'=>$emails);
     
    }else{
      $this->response('error', 404);
    }
    // $this->response($phonesArray, 200);
  }

  private function addNewContact($name, $main_email, $main_phone, $phones, $emails)
  {
    if(!isset($main_phone) && $phones && sizeof($phones) > 0) {
      $main_phone = $phones[0];
    }

    if(!isset($main_email) && $emails && sizeof($emails) > 0) {
      $main_email = $emails[0];
    }

    $id = $this->Contact_m->addNewContact($name, $main_email, $main_phone);
    if($phones && sizeof($phones) > 0) {
      foreach ($phones as $phone) {
        $Data;
        $Data['contact_id'] = $id;
        $Data['phone']= $phone;
         date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                   
        $Data['date_created'] = $strdate;
        $this->Phone_m->save($Data);
      }
    }

    if($emails && sizeof($emails) > 0) {
      foreach ($emails as $email) {
        $Data2;
        $Data2['contact_id'] = $id;
        $Data2['email']= $email;
        date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                   
        $Data2['date_created'] = $strdate;
        $this->Email_m->save($Data2);
      }
    }
    $this->response('Contact Saved', 200);
  }

  private function updateOldContact($id, $name, $main_email, $main_phone, $phones, $emails)
  {
    


   $phon=0;
      foreach ($phones as $phone) {
        $check=$this->Phone_m->get(null,array('phone'=>$phone,'contact_id'=>$id));

        if($check[0]->phone!=$phone){
          $Data;
        $Data['contact_id'] = $id;
        $Data['phone']= $phone;
         date_default_timezone_set("America/Chicago");
                    $tempdate = getdate();
                    $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                   
        $Data['date_created'] = $strdate;
        $this->Phone_m->save($Data);
        $phon++;
        }
      }
    

    $mails=0;
      foreach ($emails as $email) {
          $check2=$this->Email_m->get(null,array('email'=>$email,'contact_id'=>$id));
          if($check2[0]->email!=$email){
           $Data2;
          $Data2['contact_id'] = $id;
          $Data2['email']= $email;
          date_default_timezone_set("America/Chicago");
                      $tempdate = getdate();
                      $strdate = $tempdate['year']."-".$tempdate['mon']."-".$tempdate['mday']." ".$tempdate['hours'].":".$tempdate['minutes'].":".$tempdate['seconds'];
                     
          $Data2['date_created'] = $strdate;
          $this->Email_m->save($Data2);
          $mails++;
          }

      }

    
    $this->response('Contact updated with '.$mails.' mails and '.$phon.' phones', 200);
  }

}