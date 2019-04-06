nest: open source elegant social media



Live at: lluda.herokuapp.com

Step 1: Add Api keys and DB config in a new file "apiKeys.php" in the following format

<?php<br />
<br />
$main_domain = ""<br />
$servername = "";<br />
$username = "";<br />
$password = "";<br />
$dbname = "";<br />
$sendgrid_api = "";<br />
$AmazonApi = array("bucketName"=>"", "IAM_KEY"=>"", "IAM_SECRET"=>"");<br />
$FacebookApi = array("app_id"=>"", "app_secret"=>"");<br />
$GoogleApi = array("ClientId"=>"", "ClientSecret"=>"");<br />
<br />
?><br />

recommended directory: localhost/nest (so that local runtime can be detected)

That's all