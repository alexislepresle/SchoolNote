<?php

class Teacher{

    function __construct($num, $Lname, $Fname, $mail, $pwd, $Hos){

        $this->num = $num;
        $this->Lname = $Lname;
        $this->Fname = $Fname;
        $this->email = $mail;
        $this->pwd = $pwd;
        $this->HoS = $HoS;

    }

    public function getPwd(){
        return $this->pwd;
    }

}

?>