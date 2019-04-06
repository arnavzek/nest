nest: open source elegant social media



Live at: lluda.herokuapp.com

Step 1: Add Api keys and DB config in a new file "apiKeys.php" in the following format

<?php

$main_domain = ""
$servername = "";
$username = "";
$password = "";
$dbname = "";
$sendgrid_api = "";
$AmazonApi = array("bucketName"=>"", "IAM_KEY"=>"", "IAM_SECRET"=>"");
$FacebookApi = array("app_id"=>"", "app_secret"=>"");
$GoogleApi = array("ClientId"=>"", "ClientSecret"=>"");

?>

recommended directory: localhost/nest (so that local runtime can be detected)

That's all