<?php
    class Page extends Controller{
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }
        public function index(){
            $user = $this->userModel->getUserById(1);

            $data = [
                "user" => $user
            ];
            return $this->view('index',$data);
        }

        public function About(){
            $data = [
                "name" => "Nguyen Duy Nghi",
                "age" => "20"
            ];
            return $this->view("page/about",$data);
        }
    }