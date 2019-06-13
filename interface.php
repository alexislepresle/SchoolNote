<?php
require_once("./php/restrict_acces.php");
//print_r($_SESSION);

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
		<?php if ($_SESSION['code'] == 1) {
			include('./includes/navbarStudent.html');
		}elseif ($_SESSION['code'] == 2) {
			include('./includes/navbarProf.html');
		}else{
			include("./includes/navbarProf.html");
		}
		?>
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
			
			<?php if ($_SESSION['code'] == 1) {
				include('./includes/journalStudent.php');
			}elseif ($_SESSION['code'] == 2) {
				include('./includes/journalProf.php');
			}else{
				include("./includes/journalHeadProf.php");
			}
			?>

		</div>
		<?php include('./includes/footer.html'); ?>
	</body>
</html>