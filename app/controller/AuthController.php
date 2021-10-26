<?php
 class AuthController extends Controller{

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function index(){
        $data = $this->userModel->getUserById(1);
        $data = json_decode($data);
        
    }

    public function createClientObject(){
        require_once APPROOT.'/lib/google/vendor/autoload.php';

        // create client request to google
        $client = new Google_Client();
        $client->setClientId(GG_CLIENT_ID);
        $client->setClientSecret(GG_CLIENT_SECRET);
        $client->setRedirectUri(URLROOT.'/auth/verifyTokenGG');
        $client->setAccessType('offline');
        $client->addScope('profile');
        $client->addScope('email');
        
        return $client;
    }

    public function verifyTokenGG(){
        $client = $this->createClientObject();
        if(isset($_GET['code'])){
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token['access_token']);

            try{
                $google_account_info = $client->verifyIdToken($token['id_token']);
                // check user already exists
                $rowCount = $this->userModel->findGoogleUser($google_account_info['sub']);
                
                if($rowCount >= 1){
                    $_SESSION['user_id'] = $rowCount['user_profile_id'];
                    $user_info = $this->userModel->getUserById($rowCount['user_profile_id']);
                    $user_info = json_decode($user_info);

                    $_SESSION['user_info'] = [
                        'user_id' => $user_info->id,
                        'user_name' => $user_info->name,
                        'user_avt' => $user_info->anh
                    ];
                    header("Location: ".URLROOT);
                }
                else{
                    // if user not exist then create an account and redirect user to home page
                    $this->userModel->registerSocialAccount($google_account_info, 'google_account');

                    $rowCount = $this->userModel->findGoogleUser($google_account_info['sub']);
                    
                    $_SESSION['user_id'] = $rowCount['user_profile_id'];
                    header('Location: '.URLROOT);                    
        
                }
            }catch(Exception $e){
                echo $e->getMessage();
            }
        }
    }
    public function login(){
        $client = $this->createClientObject();
        $data = [
            'username' =>'',
            'pass' => '',
            'usernameError' => '',
            'passError' => '',
            'authURL' => $client->createAuthUrl()
        ];
        // check for post method
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //sanitiza data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'pass' => trim($_POST['password']),
                'usernameError' => '',
                'passError' => ''
            ];
            if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username';
            }
            if(empty($data['pass'])){
                $data['passError'] = 'Please enter password';
            }

            if(empty($data['usernameError']) && empty($data['passError'])){
                $login = $this->userModel->login($data['username'], $data['pass']);
                if($login == false){
                   
                    $data['passError'] = 'password or username is icorrect';
                    return $this->view('users/login', $data);
                }
                else{
                    $_SESSION['user_id'] = $login->id_user_profile;
                    $user_info = $this->userModel->getUserById($login->id_user_profile);
                    $user_info = json_decode($user_info);
                    
                    $_SESSION['user_info'] = [
                        'user_id' => $user_info->id,
                        'user_name' => $user_info->name,
                        'user_avt' => $user_info->anh
                    ];
                    header("Location: ".URLROOT."/");
                }
            }
        }
        return $this->view('users/login',$data);
    }
    
    public function register(){
        $data = [
            'username' => '',
            'email' => '',
            'pass' => '',
            'confirmpass' => '',
            'usernameError' => '',
            'emailError' => '',
            'passError' => '',
            'confirmpassError' => ''
            
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'pass' => trim($_POST['password']),
                'confirmpass' => trim($_POST['confirmPassword']),
                'date' => date('Y-m-d'),
                'emailError' => '',
                'passError' => '',
                'confirmpassError' => '',
                'usernameError' => ''
            ];
            $nameValidation = '/^[a-zA-Z0-9]*$/';
          //  $passValidation = '/^(.{0,7}|[^a-z]*|[^\d]*)$/';

            //validate username
            if(empty($data['username'])){
                $data['usernameError'] = 'Please enter username';
            }
            
            //validate email
            if(empty($data['email'])){
                $data['emailError'] = 'Please enter email';
            }
            elseif(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
                $data['emailError'] = 'email incorrect';
            }
            else{
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['emailError'] = 'email is already taken';
                }
            }
            // validate password on length and numberic value
            if(empty($data['pass'])){
                $data['passError'] = 'Please enter password';
            }
            elseif(strlen($data['pass']) < 6){
                $data['passError'] = 'Password must be at least 6 character';
            }

            if(empty($data['confirmpass'])){
                $data['confirmpassError'] = 'Please comfirm password';
            }
            else{
                if($data['confirmpass'] != $data['pass']){
                    $data['confirmpassError'] = 'Password do not match. Please try again';
                }
            }

            //Make sure that errors are empty
            if(empty($data['nameError']) && empty($data['emailError']) 
               && empty($data['passError']) && empty($data['confirmpassError'])){
                   // hash password
                   $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
                   
                   if($this->userModel->register($data)){
                       return header('Location: '.URLROOT.'/auth/login');
                   }else{
                       die('Somthing went wrong');
                   }
               }
        }
        return $this->view('users/register',$data);
    }


    public function changepass(){

        $data = [
            'username' => '',
            'pass' => '',
            'newpass' => '',
            'usernameError' => '',
            'passError' => '',
            'newpassError' => '',
            'success' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
            $data = [
                'username' => $_POST['email'],
                'pass' => $_POST['pass'],
                'newpass' => $_POST['newpass'],
                'usernameError' => '',
                'passError' => '',
                'newpassError' => '',
                'success' => ''
            ];

            if( empty($data['username']) || empty($data['pass']) || empty($data['newpass'])){
                $data['newpassError'] = 'email or old pass new pass is empty';
            }else{
                $user = $this->userModel->login($data['username'], $data['pass']);
                
                if( $user !=false){
                     $this->userModel->changepass($data['username'], $data['newpass']);

                     $data['success'] = 'Bạn đã thay đổi thành công';
                    
                    return $this->view('users/changepass', $data);
                }
                $data['newpassError'] = 'sai thông tin tài khoản';
            }
        }
        return $this->view('users/changepass',$data);
    }

    public function logout(){
        $_SESSION['user_info'] = '';
        $_SESSION['user_id'] = '';
        header("Location: ".URLROOT);
    }
}