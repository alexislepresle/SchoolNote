<?php

class Student{

    public function __construct($num, $Lname, $Fname, $email, $pwd, $tp, $td){
        $this->num = $num;
        $this->Lname = $Lname;
        $this->Fname = $Fname;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->tp = $tp;
        $this->td = $td;
    }

    public function getNum(){
        return $this->num;
    }
    public function getPwd(){
        return $this->pwd;
    }
    public function toString(){
        return "$this->Lname . $this->Fname";
    }
}

?>