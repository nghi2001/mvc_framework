<?php

    class Controller{
        public function model($model){
            // require  model file
            require_once '../app/model/'.$model.'.php';
            return new $model();
        }
        // load view
        public function view($view, $data = []){
            if($view == "/"){
                require_once '../app/view/index.php';
            }
            elseif(file_exists('../app/view/'.$view.'.php')){
                require_once '../app/view/'.$view.'.php';
            }else{
                die("view dosen't exist");
            }
        }
    }