<?php

class Student{

    function __construct($Fname, $Lname, $pwd, $class, $group, $email){
        $this->Fname = $Fname;
        $this->Lname = $Lname;
        $this->pwd = $pwd;
        $this->class = $class;
        $this->group = $group;
        $this->email = $email;
    }

}

?>