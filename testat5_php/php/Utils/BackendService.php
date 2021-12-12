<?php
namespace Utils;
use Model\Friend;
use Model\User;

class BackendService {
    private $base;
    private $id;
    private $chat_token;

    public function __construct($base, $id) {
            $this->base = $base;
            $this->id = $id;
    }

    
    public function test() {
        try {
        return HttpClient::get($this->base . '/test.json');
        } catch(\Exception $e) {
        error_log($e);
        }
        return false;
    }

    public function login($username, $password) {
        try {
            $data = array('username' => $username, 'password' => $password);
            $ergebniss = HttpClient::post($this->base . '/' . $this->id . '/' . 'login', $data);
            $_SESSION['chat_token'] = $ergebniss->token;
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function register($username, $password) {
        try {
            $data = array('username' => $username, 'password' => $password);
            $ergebniss = HttpClient::post($this->base . '/' . $this->id . '/' . 'register', $data);
            $_SESSION['chat_token'] = $ergebniss->token;
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function loadUser($username) {
        try {
            $ergebniss = HttpClient::get($this->base . '/' . $this->id . '/' . 'user' . '/' . $username, $_SESSION['chat_token']);
            $user = User::fromJson($ergebniss);
            return $user;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function saveUser($user) {
        try {
            $ergebniss = HttpClient::post($this->base . '/' . $this->id . '/' . 'user' . '/' , $user, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function loadFriends() {
        try {
            $ergebniss = HttpClient::get($this->base . '/' . $this->id . '/' . 'friend' , $_SESSION['chat_token']);
            $friends = array();
            foreach ($ergebniss as $key) {
                $friends[] = User::fromJson($key);
            }
            return $friends;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function friendRequest($friend) {
        try {
            HttpClient::post($this->base . '/' . $this->id . '/' . 'friend' , $friend, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function friendAccept($friend) {
        try {
            HttpClient::put($this->base . '/' . $this->id . '/' . 'friend' . '/' . $friend->getUsername() , $friend, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function friendDismiss($friend) {
        try {
            HttpClient::put($this->base . '/' . $this->id . '/' . 'friend' . '/' . $friend->getUsername() , $friend, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function friendRemove($friend) {
        try {
            HttpClient::delete($this->base . '/' . $this->id . '/' . 'friend' . '/' . $friend->getUsername() , $friend, $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function userExists($username) {
        try {
            HttpClient::get($this->base . '/' . $this->id . '/' . 'user' . '/' . $username , $_SESSION['chat_token']);
            return true;
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public function getUnread($friend) {
        try {
            return HttpClient::get($this->base . '/' . $this->id . '/unread' , $friend, $_SESSION['chat_token']);
        } catch(\Exception $e) {
            error_log($e);
        }
        return false;
    }

}

?>