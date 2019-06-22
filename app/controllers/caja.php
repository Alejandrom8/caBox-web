<?php 

class Caja {
    public $owner;
    public $id;
    public $title;
    public $content;
}

class ServiceResult {
    public $success;
    public $errors;
    public $messages;
    public $data;
    public $onSuccessEvent;
    public $onErrorEvent; 

    public function __construct(){
        $this->success = false;
        $this->data = null;
    }
} 

?>