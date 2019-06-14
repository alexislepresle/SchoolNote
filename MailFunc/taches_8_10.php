<?php

// Prend en paramètre l'adresse mail du prof concerné, l'adresse mail de l'eleve concerne et l'enseignement concerne
function mailJustifie($mailProf, $mailEleve, $enseignements,$datedebut){ 
	mail($mailProf, "Absence justifiée dans le module : " . $enseignements, "L'absence de " . $mailEleve . " datant du " . $datedebut . "est justifié");
	mail($mailEleve, "Absence justifié", "Votre absence du module " . $enseignements . " datant du " . $datedebut . "est justifié");
	}
//mailJustifie("21803033@unicaen.fr","21803033@unicaen.fr","math");

?>