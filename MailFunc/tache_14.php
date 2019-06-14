<?php

// Prend en paramètre l'adresse mail du prof concerné, le titre et le message que le directeur des études a saisi.
function mailManuel($mailDest,$message,$titre){ 
	mail($mailProf,$titre ,$message);
	}
//mailManuel("21803033@unicaen.fr","Ceci est un message de test","je suis un titre);

?>