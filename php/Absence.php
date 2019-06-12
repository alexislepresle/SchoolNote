<?php

class Absence{

    function __construct($codeModule, $lastNameTeacher, $nStudent, $codeType, $lastNameHeadOfStudy, $dateBegin, $dateEnd){
        $this->codeModule = $codeModule;
        $this->lastNameTeacher = $lastNameTeacher;
        $this->nStudent = $nStudent;
        $this->codeType = $codeType;
		$this->lastNameHeadOfStudy = $lastNameHeadOfStudy;
		$this->StatusAbsence = false;
		$this->dateBegin = $dateBegin;
		$this->dateEnd = $dateEnd;
    }
	
}

?>