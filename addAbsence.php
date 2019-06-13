<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
  <link rel="stylesheet" href="./css/index.css">
  <title>Document</title>
</head>

<body>
<<<<<<< HEAD
  <?php include('./includes/navbar.html'); ?>
=======
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

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a class="button is-dark">
              <i class="fas fa-bell"></i>
            </a>
            <a class="button is-light">
              Log out
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
>>>>>>> abecd9135124b344962e2c6d2a904ba6887a7f13
  <div class="form-input">


    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Add Student absent
        </p>
      </header>
      <div class="card-content">
        <div class="field is-grouped">
          <p class="control has-icons-left has-icons-right">
            <input type="text" autocomplete="off" id="datepicker" class="input" placeholder="Date">
            <span class="icon is-small is-left">
              <i class="far fa-calendar-alt"></i>
            </span>
          </p>
          <p class="control has-icons-left has-icons-right">
            <input type="text" autocomplete="off" id="timepicker" class="input" placeholder="Date">
            <span class="icon is-small is-left">
              <i class="far fa-clock"></i>
            </span>
          </p>
        </div>
        <div class="field is-grouped">
          <div class="control">
            <div class="select">
              <select>
                <option>Modules</option>
                <option>Temporary options</option>
              </select>
            </div>
          </div>
          <div class="control">
            <div class="select">
              <select>
                <option>UE</option>
                <option>1.1</option>
                <option>1.2</option>
                <option>2.1</option>
                <option>2.2</option>
              </select>
            </div>
          </div>
          <div class="control">
            <div class="select">
              <select>
                <option>Type</option>
                <option>EM</option>
                <option>TD</option>
                <option>CC</option>
                <option>TP</option>
              </select>
            </div>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <input class="input" type="text" placeholder="Name of the Student">
          </div>
        </div>
      </div>
      <footer class="card-footer">
        <a href="#" class="card-footer-item">Send</a>
        <a href="#" class="card-footer-item">Cancel</a>
      </footer>
    </div>
  </div>
</body>

<script>
  $("#datepicker").datepicker({
    dateFormat: 'dd-mm-yy',
    currentText: "Now"
  });
  $.datepicker.setDefaults($.datepicker.regional["fr"]);
  $('#timepicker').timepicker({
    timeFormat: 'HH:mm',
<<<<<<< HEAD
    interval: '30',
=======
    interval: '5',
>>>>>>> abecd9135124b344962e2c6d2a904ba6887a7f13
    minTime: '8:00',
    maxTime: '18:00',
    defaultTime: '8:00',
    startTime: '8:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
  });
</script>

</html>