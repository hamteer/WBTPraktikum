<?php
namespace Model;
use jsonSerializable;

class User implements JsonSerializable {
    private $username;
    private $firstName;
    private $lastName;
    private $coffeeOrTea;
    private $description;
    private $layout;

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

    public function setAccepted() {
        $this->status = "accepted";
    }

    public function setDismissed() {
        $this->status = "dismissed";
    }

    public static function fromJson($data) {
        $user = new User;
        foreach ($data as $key => $value) {
                $user->{$key} = $value;
        }
        return $user;
    }

    // setters and getters for settings variables
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function getFirstName() { return $this->firstName; }

    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function getLastName() { return $this->lastName; }

    public function setCoffeeOrTea($coffeeOrTea) { $this->coffeeOrTea = $coffeeOrTea; }
    public function getCoffeeOrTea() { return $this->coffeeOrTea; }

    public function setDescription($description) { $this->description = $description; }
    public function getDescription() { return $this->description; }

    public function setLayout($layout) { $this->layout = $layout; }
    public function getLayout() { return $this->layout; }
}
?>