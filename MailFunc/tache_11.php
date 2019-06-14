<?php

// Prend en paramètre l'adresse mail de l'eleve concerne, l'enseignement concerne et la date du CC manqué
function mailRatrappage($mailEleve, $enseignements, $datedebut){
	mail($mailEleve, "Autorisation de rattrapage", "Vous pouvez rattraper le CC de " . $enseignements . " datant du " . $datedebut);
	}
//mailRatrappage("21803033@unicaen.fr","math","12/06/2019");

?>