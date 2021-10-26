<?php
class HomeController extends Controller{
    
    public function index(){
        return $this->view('/') ;
       
    }

    public function error(){
        return $this->view('/page/error');
    }
}