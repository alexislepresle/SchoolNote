<?php
include("restrict_acces.php");

print_r($_SESSION);

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SchoolNote</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="./css/index.css">
  </head>
	<body>
		<nav class="navbar" role="navigation" aria-label="main navigation">
			 <div class="navbar-brand">
				<a class="navbar-item" href="https://bulma.io">
				  <h1 class="title"> SchoolNote</h1>
				</a>

				<a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
				  <span aria-hidden="true"></span>
				  <span aria-hidden="true"></span>
				  <span aria-hidden="true"></span>
				</a>
			 </div>
		  
			<div id="navbarBasicExample" class="navbar-menu">
				<div class="navbar-start">
					  <a class="navbar-item">
						Add an absence 
					  </a>
				</div>

				<div class="navbar-end">
				  <div class="navbar-item">
					<div class="buttons">
					  <a class="button is-dark">
						<i class="fas fa-bell"></i>
					  </a>
					  <a class="button is-light" href="php/deconnexion.php">
						Log out
					  </a>
					</div>
				  </div>
				</div>
			</div>
		</nav>
		
		<div class="container journal">

			<section class="hero">
			  <div class="hero-body">
				<div class="container">
				  <h1 class="title">
					Absence journal
				  </h1>
				  <h2 class="subtitle">
					Last Absences
				  </h2>
				</div>
			  </div>
			</section>
			
			<table class="table has-text-centered">
			  <thead>
				<tr>
				  <th><abbr title="Date">Date</abbr></th>
				  <th>Module</th>
				  <th><abbr title="UE">N° UE</abbr></th>
				  <th><abbr title="Won">Student name</abbr></th>
				</tr>
			  </thead>
			  <tfoot>
				<tr>
				  <th><abbr title="Date">Date</abbr></th>
				  <th>Module</th>
				  <th><abbr title="UE">N° UE</abbr></th>
				  <th><abbr title="Won">Student name</abbr></th>
				</tr>
			  </tfoot>
			  <tbody>
				<tr>
				  <th>12/06/2019</th>
				  <td>M2101</td>
				  <td>UE 1</td>
				  <td>Julien Monteil</td>
				</tr>
				<tr>
				  <th>12/06/2019</th>
				  <td>M2101</td>
				  <td>UE 1</td>
				  <td>Julien Monteil</td>
				</tr>
				<tr>
				  <th>12/06/2019</th>
				  <td>M2101</td>
				  <td>UE 1</td>
				  <td>Julien Monteil</td>
				</tr>
				<tr>
				  <th>12/06/2019</th>
				  <td>M2101</td>
				  <td>UE 1</td>
				  <td>Julien Monteil</td>
				</tr>
			  </tbody>
			</table>
		</div>
	</body>
</html>