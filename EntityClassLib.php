<?php
class student {
    private $studentId;
    private $name;
    private $phoneNum;
    private $password;

    
    public function __construct($studentId, $name, $phoneNum)
    {
        $this->studentId = $studentId;
        $this->name = $name;
        $this->phoneNum = $phoneNum;
        
        $this->messages = array();
    }
    
    public function getStudentId() {
        return $this->studentId;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhoneNum() {
        return $this->phoneNum;
    }
}

