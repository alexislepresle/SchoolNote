<?php

class Teacher{

    function __construct($num, $Lname, $Fname, $mail, $pwd, $HoS){

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

    public function getNum(){
        return $this->num;
    }

    public function isHoS(){
        if ($this->HoS == 1){
            return TRUE;
        }else{
            return FALSE;
        }
    }

}

?>