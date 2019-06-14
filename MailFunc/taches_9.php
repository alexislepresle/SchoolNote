<?php

// Prend en paramètre l'adresse mail du prof concerné, l'adresse mail de l'eleve concerne,l'enseignement concerne, la date de debut du cours, le nom et le prenom de l'eleve et le type du cours (pour alerter d'un CC)
function mailAbsence($mailProf, $mailEleve, $enseignements, $datedebut , $nomEleve, $prenomEleve, $typeCours){
	mail($mailProf, "Votre absence est bien enregistrée", "L'absence de l'eleve " . $nomEleve . " " . $prenomEleve . " du module de " . $enseignements . " datant du ". $datedebut ." est bien enregistrée" );
	if($typeCours==4){
			mail($mailEleve, "Nouvelle absence", "Vous avez une nouvelle absence au cours de " . $enseignements . " datant du " . $datedebut . " . C'était un CC il faut donc justifier l'absence rapidement sous peine d'obtenir un 0");
	}
	else{
	mail($mailEleve, "Nouvelle absence", "Vous avez une nouvelle absence au cours de " . $enseignements . " datant du " . $datedebut);
	}
	}
//mailAbsence("21803033@unicaen.fr","21803033@unicaen.fr","math","12/06/2019","Goupil","Thomas","2");

?>