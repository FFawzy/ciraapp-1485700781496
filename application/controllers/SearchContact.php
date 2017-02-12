<?php
require_once APPPATH.'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class SearchContact extends REST_Controller
{
  public function __construct() {
    parent::__construct();      
    $this->load->model('Contact_m');
    $this->load->model('Phone_m');
    $this->load->model('Email_m');
  }
  public function index_get()
  {
    $name = $this->get('name');
    if(!$name) {
        $this->response(NULL, 400);
    }
    else {
      $contacts=$this->Contact_m->searchByName($name);
      if($contacts) {
        foreach ($contacts as $contact) {
          $id = $contact->id;
          $contact->emails = $this->Email_m->getEmailsByID($id);
          $contact->phones = $this->Phone_m->getPhonesByID($id);
        }
        $this->response($contacts, 200);  
      }
      else {
        $this->response(NULL, 404);
      }
    }
  }
}