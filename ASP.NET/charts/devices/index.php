 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');

?>
<html>
  <head>
    <title>My Devices - Organized Chaos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  
    
    <script type="text/javascript" src="https://marcosraudkett.com/calendar/assets/plugins/datepicker/custom.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
    
    
  <body>
    <?php 
    $this_page = 'devices';
    include("../includes/menu.php"); 
    ?>


    </center>
    <br><br>
<div class="container body-content">
    <h3><svg class="feather feather-cloud-lightning sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 16.9A5 5 0 0 0 18 7h-1.26a8 8 0 1 0-11.62 9"></path><polyline points="13 11 9 17 15 17 11 23"></polyline></svg> Your Devices</h3>
    <p>On this page you can add new devices or modify old ones.</p>
    <button style="float: right;margin-bottom: 21px;margin-top: -65px;" onclick="window.location.replace('/app/devices/new-device.php');" class="btn btn-secondary btn-xs">New Device</button>
    <table id="devices" class="table">
    <thead>
        <tr>
            <th>
                Device Name
            </th>
            <th>
                Description
            </th>
            <th>
                Device Type
            </th>
            <th>
                Device Secret
            </th>
            <th>
                Device Added
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
          <?php
          /* SENT ITEMS */
           $tsql = "SELECT * FROM Devices";
           $params = array();
           $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
           $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
           $get_rows = sqlsrv_num_rows($getResults);
           while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
              switch($row["Device_type"])
              {
                  case "1": $device_type = 'Raspberry Pi 3 Model B'; break;
                  case "2": $device_type = 'Raspberry Pi 3 Model A'; break;
                  case "3": $device_type = 'Raspberry Pi 2'; break;
                  case "4": $device_type = 'Raspberry Pi 1B'; break;
                  case "5": $device_type = 'Raspberry Pi Zero'; break;
              }
          ?>
        <tr>
          <td><?php echo $row["Device_name"]; ?></td>
          <td><?php if($row["Device_description"] == '') { echo '<h6 style="font-size:12px;">No description set</h6>'; } else { echo $row["Device_description"]; } ?></td>
          <td><p class="badge badge-dark"><?php echo $device_type; ?></p></td>
          <td><i><?php echo $row["Device_secret"]; ?></i></td>
          <td><?php echo $row["Device_added"]->format('d.m.Y H:i:s'); ?></td>
          <td>
            <button onclick="window.location.replace('/app/devices/edit-device.php?id=<?php echo $row["Device_id"]; ?>');" class="btn btn-secondary btn-sm">Edit</button>
            <button onclick="window.location.replace('/app/devices/delete-device.php?id=<?php echo $row["Device_id"]; ?>');" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
   <br>
    <br>
    <br>
    <hr>

    <script>
    $(document).ready( function () {
        $('#devices').DataTable({
            "order": [[ 0, "asc" ]]
        });
    } );
    </script>


  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>

  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
   </div>
</html>
