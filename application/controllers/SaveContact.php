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
    $id=0;

    if(isset($phones) && sizeof($phones) > 0) {
      foreach ($phones as $phone) {
        $old_phone = $this->Phone_m->getPhoneByNumber($phone);
        if(isset($old_phone)) {
          $id = $old_phone[0]->id;
          break;
        }
      }
    }
    if($id==0 && isset($emails) && sizeof($emails)>0) {
      foreach ($emails as $email) {
        $old_email = $this->Email_m->getEmailByEmail($email);
        if(isset($old_email)) {
          $id = $old_email[0]->id;
          break;
        }
      }  
    }
    if($id==0) {
      //add new contact

      $this->addNewContact($name, $main_email, $main_phone, $phones, $emails);
    }
    else {
      //update old contact
      $this->updateOldContact($id, $name, $main_email, $main_phone, $phones, $emails);
    }
    // $this->response($phonesArray, 200);
  }

  public function addNewContact($name, $main_email, $main_phone, $phones, $emails)
  {
    // if(!$main_phone && $phones && sizeof($phones) > 0) {

    //   $main_phone = $phones[0];
    // }

    // if(!$main_email && $emails && sizeof($emails) > 0) {
    //   $main_email = $emails[0];
    // }

    $id = $this->Contact_m->addNewContact($name, $main_email, $main_phone);
    // if($phones && sizeof($phones) > 0) {
    //   foreach ($phones as $phone) {
    //     $Data;
    //     $Data['contact_id'] = $id;
    //     $Data['phone']= $phone;
    //     $this->Phone_m->save($Data);
    //   }
    // }

    // if($emails && sizeof($emails) > 0) {
    //   foreach ($emails as $email) {
    //     $Data;
    //     $Data['contact_id'] = $id;
    //     $Data['email']= $email;
    //     $this->Email_m->save($Data);
    //   }
    // }
    $this->response($id, 200);
  }

  private function updateOldContact($id, $name, $main_email, $main_phone, $phones, $emails)
  {
    
    if($phones && sizeof($phones) > 0) {
      foreach ($phones as $phone) {
        if(!$this->Phone_m->getPhoneByNumber($phone)) {
          $Data;
        $Data['contact_id'] = $id;
        $Data['phone']= $phone;
        $this->Phone_m->save($Data);
        }
      }
    }

    if($emails && sizeof($emails) > 0) {
      foreach ($emails as $email) {
        if(!$this->Email_m->getEmailByEmail($email)) {
          $Data;
        $Data['contact_id'] = $id;
        $Data['email']= $email;
        $this->Email_m->save($Data);
        }
      }
    }
    $this->response('Contact updated', 200);
  }

}