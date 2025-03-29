<?php

class User {
    private $username;
    private $password;
    private $phone;
    private $email;
    private $userInfo;
    private $role;
    private $appointments = [];
    private $bloodDonationHistories = [];

    public function __construct($username, $password, $phone, $email, $userInfo, $role) {
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
        $this->email = $email;
        $this->userInfo = $userInfo;
        $this->role = $role;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getUserInfo() {
        return $this->userInfo;
    }

    public function setUserInfo($userInfo) {
        $this->userInfo = $userInfo;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getAppointments() {
        return $this->appointments;
    }

    public function addAppointment($appointment) {
        $this->appointments[] = $appointment;
    }

    public function getBloodDonationHistories() {
        return $this->bloodDonationHistories;
    }

    public function addBloodDonationHistory($bloodDonationHistory) {
        $this->bloodDonationHistories[] = $bloodDonationHistory;
    }

    public function getAuthorities() {
        return [$this->role];
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isEnabled() {
        return true;
    }
}