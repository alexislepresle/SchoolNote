<?php

class Absence{

    function __construct($codeModule, $lastNameTeacher, $nStudent, $codeType, $dateBegin, $dateEnd, $comment){
        $this->codeModule = $codeModule;
        $this->lastNameTeacher = $lastNameTeacher;
        $this->nStudent = $nStudent;
        $this->codeType = $codeType;
		$this->StatusAbsence = false;
		$this->dateBegin = $dateBegin;
		$this->dateEnd = $dateEnd;
		$this->comment = $comment;
    }
	
}

?>