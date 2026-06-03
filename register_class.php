<?php
class RegisterUser{
    private $username;
    private $raw_password;
    private $encrypted_password;
    public $error;
    public $success;
    private $storage = "data/data.json";
    private $stored_users;
    private $new_user;


    public function __construct($username, $password, $confirm_password = null){
        // Check passwords match before anything else if a confirmation value exists
        if($confirm_password !== null && $password !== $confirm_password){
            $this->error = "Passwords do not match.";
            return;
        }

        // Normalize email to lowercase
        $this->username = strtolower(trim($username));
        $this->username = htmlspecialchars($this->username, ENT_QUOTES, 'UTF-8');

        $this->raw_password = trim($password);
        $this->raw_password = htmlspecialchars($this->raw_password, ENT_QUOTES, 'UTF-8');
        $this->encrypted_password = password_hash($this->raw_password, PASSWORD_DEFAULT);

        if(file_exists($this->storage)){
            $this->stored_users = json_decode(file_get_contents($this->storage), true);
        }

        if(!is_array($this->stored_users)){
            $this->stored_users = [];
        }

        $this->new_user = [
            "username" => $this->username,
            "password" => $this->encrypted_password
        ];

        if($this->checkFieldValues()){
            $this->insertUser();
        }
    }

    private function checkFieldValues(){
        if(empty($this->username) || empty($this->raw_password)){
            $this->error = "Both fields are required.";
            return false;
        }
        if(strlen($this->raw_password) < 6){
            $this->error = "Password must be at least 6 characters.";
            return false;
        }
        return true;
    }

    private function usernameExists(){
        foreach ($this->stored_users as $user) {
            if(strtolower($this->username) == strtolower($user['username'])){
                $this->error = "That email is already registered, please use a different one.";
                return true;
            }
        }
        return false;
    }

    private function insertUser(){
        if($this->usernameExists() == FALSE){
            array_push($this->stored_users, $this->new_user);
            if(file_put_contents($this->storage, json_encode($this->stored_users, JSON_PRETTY_PRINT))){
                $this->success = "Registration successful.";
            } else {
                $this->error = "Failed to save user data.";
            }
        }
    }
}
?>