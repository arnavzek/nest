<?php 

require_once 'mysqlconnect.php';

$sql = "SELECT * FROM posts";

$check = $conn->query($sql);

if ($check->num_rows != 0) {

	while($row = $check->fetch_assoc()) {


		$post_id = $row['id'];

		$delta_time = time() - strtotime($row['created_at']);

		$ranking_data = round (log($row['likes']+1,10) / ($delta_time / 10800), 7);

		$rank_query = "UPDATE posts SET rank = '$ranking_data' WHERE id = '$post_id' ";

		$update_rank = $conn->query($rank_query);

			if ($update_rank) {

			

					echo "Done ".$ranking_data." ".$row['title']." <br> <br>" ;
			
				
			}else{

				echo "<br> error".$ranking_data." ".$row['title']." ".$row['likes']." ". log($row['likes'],10) ."  ".($delta_time / 10800*4)."<br><br><br><br>";
				echo "Error: " . $sql . "<br>" . $conn->error;
				
			}

	}
}

 ?>