<?php 

class Debug extends Controller{
    public function __construct($e){
        parent::__construct();
        $this->view->errors = $e;
        $this->view->render("error");
    }
}

?>