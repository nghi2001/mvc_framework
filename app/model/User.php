<?php
    class User {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

       public function getUser(){
           $this->db->query("SELECT * FROM `user_profile`");

           $result = $this->db->resultSet();
           return $result;
       }

       public function getUserById($id){
           $this->db->query("select * from `user_profile` where `id`=?");

           $this->db->bind(1,$id);
           $result = $this->db->resultSet();
           return json_encode($result);
       }

       public function findUserByEmail($email){
           $this->db->query('select * from `user_account` where `email` = ?');
           $this->db->bind(1,$email);
           $result = $this->db->resultSet();

           if($this->db->rowCount() > 0){
               return true;
           }
           else
            return false;
       }
       public function login($email, $pass){
           $this->db->query('select * from `user_account` where `email`= :email');
            //binding value
            $this->db->bind(':email', $email);
            $row = $this->db->single();
            if($row){
                $hashpass = $row->pass;
                if (password_verify($pass, $hashpass)){
                    return $row;
                }
                else {
                    return false;
                }
            }else{
                return false;
            }
       }

       public function register($data) {
           $sql = "
                    insert into `user_profile` (`name`) value (:name);
                    INSERT INTO `user_account`(`id_user_profile`, `email`, `pass`,`ngay_tao`) VALUES (LAST_INSERT_ID(),:email,:pass, :date)
                    ";
           $this->db->query($sql);
           //bind value
           $this->db->bind(':name', $data['username']);
           $this->db->bind(':email', $data['email']);
           $this->db->bind(':pass', $data['pass']);
           $this->db->bind(':date', date('Y-m-d'));

           if($this->db->execute()){
               return true;
           }
           return false;
        
        }

        public function findGoogleUser($id){
            $sql = 'select * from `google_account` where `google_id` = :id';
            $this->db->query($sql);
            $this->db->bind(':id' , $id);

            return $this->db->resultSet();
        }

        public function registerSocialAccount($data = [], $type = ''){
            $sql = "
                INSERT INTO `user_profile` (`name`) value (:name);
                INSERT INTO `$type` (`user_profile_id`, `google_id`) VALUES (LAST_INSERT_ID(), :id); 
            ";

            $this->db->query($sql);

            $this->db->bind(':name', $data['name']);
            $this->db->bind(':id', $data['sub']);

            if($this->db->execute())
                return true;
            
            return false;
        }

        public function updateAVT($data){
            $sql ="
                UPDATE `user_profile`
                SET `anh` = :anh
                where `id` = :id
            ";

            $this->db->query($sql);
            $this->db->bind(':anh', $data['anh']);
            $this->db->bind(':id', $data['id']);
            $this->db->execute();
        }

        public function updateProfileUser($data){
            $sql = "
            UPDATE `user_profile` 
            SET `name`= :name,
            `ngay_sinh`= :date,`dia_chi`= :diachi,`sdt`=:sdt 
            WHERE `id` = :id
            ";
            $this->db->query($sql);

            $this->db->bind(':name', $data['name']);
            $this->db->bind(':date', $data['date']);
            $this->db->bind(':diachi', $data['diachi']);
            $this->db->bind(':sdt', $data['sdt']);
            $this->db->bind(':id', $data['id']);

            if($this->db->execute()){
                return 'success';
            }else{
                return 'failed';
            }
        }

        public function changepass($email, $pass){
            $sql = 'update `user_account` set `pass` = :pass where `email` = :email';
            $this->db->query($sql);

            //hash password
            $pass = password_hash($pass, PASSWORD_DEFAULT);

            $this->db->bind(':pass', $pass);
            $this->db->bind(':email' , $email);
            $this->db->execute();
        }

        public function checkRole($id){
            $sql = 'select * from `user_profile` where `id` = :id';
            $this->db->query($sql);
            $this->db->bind(':id', $id);
            $user = $this->db->resultSet();

            if($user['role'] ==1){
                return  true;
            }else{
                return false;
            }
        }
    }