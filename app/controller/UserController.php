<?php

class UserController extends Controller{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function profile($id){
        $user = $this->userModel->getUserById($id);
        $user = json_decode($user);
        $data = $user;
        return $this->view('users/profile',$data);
    }


    public function update(){
        $user_id = $_POST['id'];
        $user_name = $_POST['name'];
        $user_birth = $_POST['date'];
        $user_address = $_POST['dia_chi'];
        $user_phone = $_POST['sdt'];
        
        $data = [
            'id' => $user_id,
            'name' => $user_name,
            'date' => $user_birth,
            'diachi' => $user_address,
            'sdt' => $user_phone
        ];

        $this->userModel->updateProfileUser($data);
        
        header("Location: ".URLROOT.'/user/profile/'.$user_id);
    }

    public function update_avt(){
        $target_dir =__DIR__.'/../../public/img/avt/';
        $filename =explode('.',$_FILES['file']['name']);
        $filename[0] = $_SESSION['user_id'];
        $file = $filename[0].'.'.$filename[1];
        $target_file = $target_dir.basename($file);
        unlink($target_file);

        if(move_uploaded_file($_FILES['file']['tmp_name'], $target_file)){
            $data = [
                'anh' => URLROOT.'/public/img/avt/'.$file,
                'id' => $_SESSION['user_id']
            ];
            $this->userModel->updateAVT($data);

            header("Location: ".URLROOT.'/user/profile/'.$_SESSION['user_id']);
        }
    }
}