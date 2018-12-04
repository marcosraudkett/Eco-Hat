# Frontend PHP

## Structure:
* alerts/
 * <b>delete-alert.php</b> <- alert deleting page
 * <b>edit-alert.php</b> <- alert editing page
 * <b>index.php</b> <- dashboard for viewing alerts, initiated alerts and graph for initiated alerts
 * <b>initiate-create.php</b> <- alert creating function
 * <b>initiate-delete.php</b> <- alert deleting function
 * <b>initiate-edit.php</b> <- alert editing function
 * <b>new-alert.php</b> <- alert creating page
* analysis/
 * <b>index.php</b> <- analysis viewing page
* devices/
 * <b>delete-device.php</b> <- device deleting page
 * <b>edit-device.php</b> <- device editing page
 * <b>index.php</b> <- dashboard for viewing devices, initiated devices and graph for initiated devices
 * <b>initiate-create.php</b> <- device creating function
 * <b>initiate-delete.php</b> <- device deleting function
 * <b>initiate-edit.php</b> <- device editing function
 * <b>new-device.php</b> <- device creating page
* email_notifier/
 * <b>email_notifier.php</b> <- for alerts (notify by email)
* includes/
 * <b>menu.php</b> <- menu on the frontend page
* monthly/
 * <b>index.php</b> <- monthly charts page
* realtime/
 * <b>index.php</b> <- real-time gauge page
* src/
 * <b>config.php</b> <- app configuration (database etc..)
 * <b>db.php</b> <- database connection
 * <b>require.php</b> <- require
* <b>index.php</b> <- daily charts
* <b>signin.php</b> <- sign in page (unused)
* <b>web.config</b> <- if you deploy an app to azure cloud (app service) you will need to connect to it via ftp and replace the existing one with this in order to make both of them work at the same time (c# + php)
