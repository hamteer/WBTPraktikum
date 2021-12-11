<?php
namespace Model;
use jsonSerializable;

class Friend implements JsonSerializable {
    private $username;
    private $status;

    public function __construct($username = null) {
        if($username == null) {
            $this->username = null;
        }
        $this->username = $username;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getUsername() {
        return $this->username;
    }

    public function getStatus() {
        return $this->status;
    }

    public static function fromJson($data) {
        $friend = new Friend;
        foreach ($data as $key => $value) {
                $friend->{$key} = $value;
        }
        return $friend;
    }
}
?>