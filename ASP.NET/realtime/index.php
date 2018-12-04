 <?php 

  require_once("../src/require.php"); //database

  //setlocale(LC_TIME, array('fi_FI.UTF-8','fi_FI@euro','fi_FI','finnish')); 
  date_default_timezone_set('Europe/Tallinn');


/* Function joka toimii loputtomasti(?) voi rajata vaikka koko vuoden */
function tilastot($dates, $amount, $conn) {
  $new = str_replace(' ',',', $dates);
  $box_array = explode(',', $new);

  $i = 0; /* lasku on 0 */
  if($i != $amount) {
    if (is_array($box_array) || is_object($box_array))  {
      foreach ($box_array as $this_date) {

       if($amount >= 60) { 
        /* tähän voi muokata tilastonnäkymää(?) että esim jos käyttäjä on rajannut enemmän kuin 60 pv niin sitten tulostuu kk eikä päivät */
         $date_day = ucwords(strftime('%A', strtotime($this_date, '-'.$amount.' day')));
         $date_date = ucwords(strftime('%d.%m', strtotime($this_date, '-'.$amount.' day')));
         $date_fulldate = ucwords(strftime('%d.%m.%Y', strtotime($this_date, '-'.$amount.' day')));
       } else {
         $date_day = ucwords(strftime('%A', strtotime($this_date, '-'.$amount.' day')));
         $date_date = ucwords(strftime('%d.%m', strtotime($this_date, '-'.$amount.' day')));
         $date_fulldate = ucwords(strftime('%d.%m.%Y', strtotime($this_date, '-'.$amount.' day')));
       }

       /* */
       $date_mysql = ucwords(strftime('%Y-%m-%d 00:00:00', strtotime($this_date, '-'.$amount.' day')));
       $date_mysql_2 = ucwords(strftime('%Y-%m-%d 23:59:59', strtotime($this_date, '-'.$amount.' day')));
       
       /* SENT ITEMS */
       $tsql = "SELECT * FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$date_mysql' AND '$date_mysql_2' ORDER BY Sense_hat_entry_id DESC";
       $params = array();
       $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
       $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
       $get_rows = sqlsrv_num_rows($getResults);


       if($date_fulldate != '01.01.1970') { /* jos pvm on väärä niin ei tulosteta */
         echo "['".$date_day." (".$date_date.")', ".$get_rows."],";
       }
       $i++; /* lisätään jokaisen pvm kohdalla +1 laskuriin */
     }
    }
  }
}

$currentday = ucwords(strftime( '%A' )); date_default_timezone_set('Europe/Helsinki');
$current_date = strftime( '%d.%m' ); date_default_timezone_set('Europe/Helsinki');
$current_fulldate = strftime( '%d.%m.%Y' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate_1 = strftime( '%Y-%m-%d 00:00:00' ); date_default_timezone_set('Europe/Helsinki');
$currentday_mysqlfulldate = strftime( '%Y-%m-%d 23:59:59' ); date_default_timezone_set('Europe/Helsinki');


?><?php 

$tsql = "SELECT * FROM SenseHat WHERE Sense_hat_datetime BETWEEN '$currentday_mysqlfulldate_1' AND '$currentday_mysqlfulldate' ORDER BY Sense_hat_entry_id DESC";
$params = array();
$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
$get_rows = sqlsrv_num_rows($getResults);
//echo ("Reading data from table " . PHP_EOL);


?>
<html>
  <head>
    <title>Real-time - Organized Chaos</title>
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
    $this_page = 'realtime';
    include("../includes/menu.php"); 
    ?>

    <img style="height: 56px;float:left;margin-top: -21px;" src="https://marcosraudkett.com/mvrclabs/code/scripts/admin/images/organizedchaos_withouttext.png">
    <center style="border-bottom: 1px solid #c7c7c7;">
    <form action="" style="display: inline-flex;margin-top: -5px;margin-bottom: 9px;" method="GET">
      <select class="form-control" style="margin-right: 20px;" name="selected_device">
        <option>Select Device</option>
        <optgroup label="Devices">
        <?php
          /* SENT ITEMS */
         $tsql = "SELECT * FROM Devices";
         $params = array();
         $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
         $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
         $get_rows = sqlsrv_num_rows($getResults);
         while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            
            echo '<option value="'.$row["Device_secret"].'" ';
            if($_GET["selected_device"] == $row["Device_secret"]) { echo 'selected="selected"'; }
            echo '>'.$row["Device_name"];
            if($row["Device_description"] != '')
            {
              echo ' ('.$row["Device_description"].')';
            }
            echo '</option>';

        }
        ?>
        </optgroup>
      </select>
      <button type="submit" class="btn btn-secondary btn-sm">Apply</button>
    </form>

    </center>
    <br><br>
<div class="container body-content">
    <h3>Real-Time</h3>
    <p>On this page you can view "Real-Time" (~3 second interval) data that is being sent from your selected device.</p>
    <?php
    if(isset($_GET["selected_device"])) {

        $device_secret = $_GET["selected_device"];
        $tsql = "SELECT * FROM Devices WHERE Device_secret = '$device_secret'";
        $params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $getResults = sqlsrv_query($conn, $tsql, $params, $options) or die( print_r( sqlsrv_errors(), true));
        $get_rows = sqlsrv_num_rows($getResults);
        
        if($get_rows == '')
        {
          echo '<center><svg class="feather feather-alert-triangle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" style="height: 45px;width: 45px;"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>
          <br><h6>The Device you selected could not be found!</h6></center>';
        } else {

        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            

        }
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Temp', 0],
          ['Air Press', 0],
          ['Humidity', 0]
        ]);

        var options = {
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var temp_options = {
          width: 400, height: 120,
          redFrom: 60, redTo: 80,
          yellowFrom:40, yellowTo: 60,
          minorTicks: 5
        };

        var air_press_options = {
          width: 400, height: 1080,
          redFrom: 1050, redTo: 1080,
          yellowFrom:1020, yellowTo: 1050,
          greenFrom:1000,greenTo:1020,
          min:250,max:1100,
          minorTicks: 5
        };


        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);
        setInterval(function() {

          $.ajax({
              'async': false,
              'global': false,
              'url': "fetch_values.php?device_secret=<?php echo $_GET["selected_device"]; ?>",
              'dataType': "json",
              success: function (json_data) {

                  json = data;

                if(json_data["data"][0]["Sense_hat_offline"] == '1')
                {
                  $(".extra_info").html('<center><svg class="feather feather-alert-triangle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" style="height: 45px;width: 45px;"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg><br><h6>There has not been any new data in at least ~5 minutes!</h6></center>');
                  $("#chart_div").hide();
                } else {
                  $("#chart_div").show();
                  data.setValue(0, 1, json_data["data"][0]["Sense_hat_temperature"]);
                  chart.draw(data, temp_options);

                  data.setValue(1, 1, json_data["data"][0]["Sense_hat_air_pressure"]);
                  chart.draw(data, air_press_options);

                  data.setValue(2, 1, json_data["data"][0]["Sense_hat_humidity"]);
                  chart.draw(data, options);

                  var userDate = json_data["data"][0]["Sense_hat_datetime"]["date"];
                  str = userDate.slice(0, -7); // "12345.0"
                  //var date_string = moment(str, "YYYY-MM-DD HH:MM:SS").format("DD.MM.YYYY HH:MM:SS");
                  var date_string = moment(str).format("DD.MM.YYYY HH:mm:ss");

                  $(".extra_info").html("<h6>Timestamp: " + date_string + "</h6>");

                }
                  /*for (i = 0; i < data.places.length; i++) {  
                  }*/
              }
            });

         }, 5000);
      }
    </script>
  
  <div id="chart_div" style="width: 400px; height: 120px;"></div>
  

  <br>
  <br>
  <div class="extra_info"></div>
  <br>
  <?php
} 
} else {
  echo '<center><img style="height:64px;margin-top: 30px;margin-bottom: 15px;" src="raspberry-pi.png"><br><h6>Please select a device from the top in order to view "Real-Time" data.</h6></center>';
}
  ?>
<br>
  <style>
  .ui-dialog {
    border-radius: 0px !important;
  } 
  .ui-dialog-titlebar {
    background: #a7d86d  !important;
    border-radius: 0px !important;
  }
  .ui-state-hover {
    background: white !important;
  }
  .ui-state-highlight {
    border: 1px solid #a7d86d  !important;
    background: rgba(87, 193, 134, 0.08) !important;
  }
  .ui-state-default {
    background: #efefef !important;
  }
  .ui-state-default:hover {
    background: #d8d8d8 !important;
  }
  .ui-datepicker {
    border-radius: 0px !important;
    font-family: 'Open Sans', 'Segoe UI', 'Droid Sans', Tahoma, Arial, sans-serif !important;
  }
  .ui-datepicker-header {
    background: #a7d86d  !important;
    color: #FFFFFF !important;
    border-radius: 0px !important;
  }
  .ui-datepicker-calendar tr {
    background: white !important;
  }
</style>
  
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="../charts/js/moment.js"></script>
  <hr>
  <footer>
      <p>© 2018 - Organized Chaos</p>
  </footer>
</div>
</body>
  <script>
  $(function(){
$("#datepicker").datepicker();
  $("#datepicker").datepicker({
    language:"fi",
    showWeek:1,
    firstDay:1,
    showButtonPanel:!0,
    dateFormat:"dd.mm.yy"
  }).val()
})
  $(function(){
$("#datepicker1").datepicker();
  $("#datepicker1").datepicker({
    language:"fi",
    showWeek:1,
    firstDay:1,
    showButtonPanel:!0,
    dateFormat:"dd.mm.yy"
  }).val()
})
  </script>
</html>
