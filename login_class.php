<?php
    class LoginUser{
        private $username;
        private $password;
        public $error;
        public $success;
        private $storage = "data/data.json";
        private $stored_users = [];

        public function __construct($username, $password){
            $this->username = trim(strtolower($username));
            $this->password = $password;

            if(file_exists($this->storage)){
                $this->stored_users = json_decode(file_get_contents($this->storage), true) ?? [];
            }

            $this->login();
        }

        private function login(){
            foreach($this->stored_users as $user){
                if(strtolower($user['username']) == $this->username){
                    if(password_verify($this->password, $user['password'])){
                        session_start();
                        $_SESSION['username'] = $this->username;
                        header("Location: index.php"); exit();
                    }
                }
            }

            $this->error = "Invalid username or password.";
            return $this->error;
        }
    }
    
?>