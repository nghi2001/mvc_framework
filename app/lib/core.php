<?php
    class Core{
        protected $currentController = 'HomeController';
        protected $currentMethod = 'index';
        protected $pagrams = [];

        public function __construct()
        {
            $url = $this->getUrl();

            if($url !=null){

                if(file_exists('../app/controller/'.ucwords($url[0].'Controller.php'))){
                    // set a new controller
                    $this->currentController = ucwords($url[0].'Controller');
                    unset($url[0]);
            }
            else{
                $this->currentMethod = 'error';
            }
        }
            // require controller
                require_once '../app/controller/'.$this->currentController.'.php';
                $this->currentController = new $this->currentController;
            //check for the second part of url and check the method not exist
            if(isset($url[1])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);   
                }else{
                    $this->currentController = 'HomeController';
                    $this->currentMethod = 'error';
                }
            }
            // get paramaters
            $this->pagrams = $url ? array_values($url): [];
            call_user_func_array([$this->currentController,$this->currentMethod],$this->pagrams);
            
        }

        public function getUrl() {
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'],'/');
                // allow filter variable as string/number
                $url = filter_var($url, FILTER_SANITIZE_URL);
                // breaking into an array
                $url = explode('/',$url);
                return $url;
            }
        }
    }