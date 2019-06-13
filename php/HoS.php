<?php

class HoS{


    function __construct($num, $Fname, $Lname, $pwd, $email, $HoS){
        $this->num = $num;
        $this->Lname = $Lname;
        $this->Fname = $Fname;
        $this->pwd = $pwd;
        $this->email = $email;
        $this->Hos = $HoS;
    }

    public function getPwd(){
        return $this->pwd;
    }

    public function getNum(){
        return $this->num;
    }

}

?>