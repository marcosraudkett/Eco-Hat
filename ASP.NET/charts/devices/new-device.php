 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');

?>
<html>
  <head>
    <title>New Device - Organized Chaos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    <script type="text/javascript" src="https://marcosraudkett.com/calendar/assets/plugins/datepicker/custom.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    
    
  <body>
    <?php 
    $this_page = 'new-device';
    include("../includes/menu.php"); 
    ?>

    </center>
    <br><br>
<div class="container body-content">
    <h3><svg class="feather feather-cloud-lightning sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 16.9A5 5 0 0 0 18 7h-1.26a8 8 0 1 0-11.62 9"></path><polyline points="13 11 9 17 15 17 11 23"></polyline></svg> New Device</h3>
    <p>New Device Configuration</p>
    <?php
    if(isset($_GET["error"]))
    {
      echo '<div class="alert alert-danger">'.$_GET["error"].'</div>';
    }
    ?>
    <form method="POST" action="initiate-create.php">
      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="name" type="text" class="form-control" placeholder="Device Name (eg. Room A, Device 1)" required="required">
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <input name="description" type="text" class="form-control" placeholder="Description">
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <select name="type" class="form-control" required="required">
            <option value="1">Raspberry Pi 3 Model B</option>
            <option value="2">Raspberry Pi 3 Model A</option>
            <option value="3">Raspberry Pi 2</option>
            <option value="4">Raspberry Pi 1</option>
            <option value="5">Raspberry Pi Zero</option>
          </select>
        </div>
      </div>

      <div style="margin-bottom:15px;margin-left: -15px;" class="col-sm-4">
        <div class="input-group">
          <button type="submit" name="create" class="btn btn-secondary">Add Device</button>
        </div>
      </div>

    </form>
    <br>
    <br>
    <br>
   <hr>
  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>
   </div>
</html>
