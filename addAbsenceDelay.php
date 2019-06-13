<html>
<head>
	<title>Add an absence or delay</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="./css/index.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</head>
<body>
  <?php include('./includes/navbarProf.html'); ?>
	<section class="hero is-dark">
	  <div class="hero-body">
	    <div class="container">
	      <h1 class="title">
	        Add an absence or delay
	      </h1>
	    </div>
	  </div>
	</section>
	<section class="section formulaire">

	    <form class="formAdd" name="contact" method="POST"  action="" accept-charset="UTF-8">
	    	<div class="columns">
				<div class="field column" >
				  <label class="label">Date : </label>
				  <div class="control has-icons-left has-icons-right">
				    <input name="date" id="datepickerDemoDefault" class="input" type="date" value="14/06/2019" autocomplete="off" id="datepicker">
				    <span class="icon is-small is-right">
      					<i class="far fa-calendar-alt"></i>
				    </span>
				  </div>
				</div>
				<div class="field column" >
				  <label class="label">Beginning : </label>
				  <div class="control has-icons-left has-icons-right">
	    			<input name="beggingHour" type="text" autocomplete="off" id="timepicker" class="input" type="time">
				    <span class="icon is-small is-right">
		              <i class="far fa-clock"></i>
				    </span>
				  </div>
				</div>
				<div class="field column" >
				  <label class="label">End : </label>
				  <div class="control has-icons-left has-icons-right">
	    			<input name="endHour" type="text" autocomplete="off" id="timepickerend" class="input" type="time">
				    <span class="icon is-small is-right">
		              <i class="far fa-clock"></i>
				    </span>
				  </div>
				</div>		
			</div>	
			<div class="columns">
				<div class="field column">
				  <label class="label">Module : </label>
				  <div class="control">
				    <div class="select module">
				      <select name="module">
				        <option>Select dropdown</option>
				        <option>With options</option>
				      </select>
				    </div>
				  </div>
				</div>
				<div class="field column">
				  <label class="label">UE : </label>
				  <div class="control">
				    <div class="select ue">
				      <select name="ue">
				        <option>Select dropdown</option>
				        <option>With options</option>
				      </select>
				    </div>
				  </div>
				</div>		
				<div class="field column">
				  <label class="label">Type of class : </label>
				  <div class="control">
				    <div class="select type">
				      <select name="classType">
				        <option>Select dropdown</option>
				        <option>With options</option>
				      </select>
				    </div>
				  </div>
				</div>	
			</div>
			
			<div class="columns ">
				<div class="column">
					<div id="Entries" class="field">
						<label class="label">Student : </label>
						<div class="control has-icons-left has-icons-right" id="Entry" style="margin-top:10px;">
							<input class="input studentName" type="text" placeholder="Student name"><!-- the name is student0 and increments for each student added (student1, student2, etc.)-->
							<span class="icon is-small is-right">
							<i class="fas fa-search"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="column" style="display: flex; flex-direction: column-reverse; max-width: fit-content;">
					<button id="button" class="button is-dark">
						<i class="fas fa-plus"></i>
					</button>
				</div>
			</div>

			<div class="field">
			  <label class="label">Comment</label>
			  <div class="control">
			    <textarea class="textarea comment" placeholder="Comment..." name="comment"></textarea>
			  </div>
			</div>

			<label class="checkbox">
			  <input type="checkbox" name="delay">
			  Mark as a delay
			</label>
		</br>
			<label class="checkbox">
			  <input type="checkbox" name="justify">
			  Absence or delay justified
			</label>
			<div class="columns buttons-form">
	            <div class="column "> 
	                <div class="field">
	                    <div class="control is-expanded">
	                        <button class="button is-dark is-rounded is-fullwidth is-outlined submit" type="submit">Submit</button>
	                    </div>
	                </div>
	            </div>
	            <div class="column"> 
	                <div class="field">
	                    <div class="control is-expanded">
							<a href="./interface.php"><!-- Send back to the homepage juste change the name of the file you are currently using -->
								<button class="button is-danger is-rounded is-fullwidth is-outlined cancel" type="submit">Cancel</button>
							</a>
	                    </div>
	                </div>
	            </div>
		        </div>    
		    </div> 
	    </form>
	</section>

<script>
  $("#datepicker").datepicker({
    dateFormat: 'dd-mm-yy',
    currentText: "Now"
  });
  $.datepicker.setDefaults($.datepicker.regional["fr"]);
  $('#timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: '30',
    minTime: '8:00',
    maxTime: '18:00',
    defaultTime: '8:00',
    startTime: '8:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
</script>
<script>
  $("#datepickerend").datepicker({
    dateFormat: 'dd-mm-yy',
    currentText: "Now"
  });
  $.datepicker.setDefaults($.datepicker.regional["fr"]);
  $('#timepickerend').timepicker({
    timeFormat: 'HH:mm',
    interval: '30',
    minTime: '8:00',
    maxTime: '18:00',
    defaultTime: '8:00',
    startTime: '8:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
</script>
<script> 
var count=1;
document.getElementById('button').onclick = function(){
	div = document.getElementById('Entries'); 
	var input = document.getElementById('Entry').cloneNode(true);
	div.appendChild(input);
	var name = "student";
	list = document.getElementsByClassName('input studentName');
	for(var i=0;i<list.length;i++){
		name+=i;
		list[i].name=name;
		name="student";
	}
	count++;
	return false;
}
</script> 
</body>
</html>