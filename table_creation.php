<?php
require 'mysqlconnect.php';

$tbl_members = "CREATE TABLE IF NOT EXISTS users(
				id BIGINT(20) NOT NULL AUTO_INCREMENT,
				pen_name VARCHAR(255) NULL,
				fb_id VARCHAR(255) NULL,
				gl_id VARCHAR(255) NULL,
                password VARCHAR(255) NULL,
                profile TEXT NULL,
                name TEXT NOT NULL,
                type ENUM('0', '1','2','3','4','5') NOT NULL DEFAULT '0',
                bio TEXT NULL,
                token CHAR(255) NULL,
                hash CHAR(255) NULL,
                joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                last_seen TIMESTAMP,
                region VARCHAR(255) NULL,
                PRIMARY KEY(id),
                address TEXT NULL,
                UNIQUE KEY username (pen_name)
				)";

$queryM = $conn->query($tbl_members);

if($queryM === TRUE){
	echo "done<br>";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$tbl_connection = "CREATE TABLE  IF NOT EXISTS posts(
		id BIGINT(20) NOT NULL AUTO_INCREMENT,
		rank DECIMAL(20,9) NULL,
		url VARCHAR(255) NOT NULL,
		ref BIGINT(20) NULL,
		title TEXT NULL,
		content TEXT NULL,
		image VARCHAR(255) NULL,
		visible ENUM('0','1','2','3','4') NOT NULL DEFAULT '0',
		likes BIGINT(20) NOT NULL DEFAULT '0',
		creator VARCHAR(255) NOT NULL,
		region VARCHAR(255) NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY(id),
		UNIQUE (url)
		)";

$queryC = $conn->query($tbl_connection);

if($queryC === TRUE){
	echo "done<br>";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}

// id receiver type like(y,n) comment(null) sender postid

$table_notification = "CREATE TABLE  IF NOT EXISTS notifications(
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		receiver VARCHAR(255) NOT NULL,
		post_id BIGINT(20) UNSIGNED NULL,
		sender VARCHAR(255) NOT NULL,
		type ENUM('like', 'write_back', 'report' ,'follow','reading','tag') NOT NULL,
		liked ENUM('true', 'false', 'other') NULL DEFAULT 'false',
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY(id)
		)";

$queryd = $conn->query($table_notification);

if($queryd === TRUE){
	echo "done<br>";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}



$table_series = "CREATE TABLE  IF NOT EXISTS series(
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		category_id BIGINT(20) UNSIGNED NULL,
		post_id BIGINT(20) NULL,
		type ENUM('tag', 'image', 'content' ) NOT NULL DEFAULT 'tag',
		link TEXT  NULL,
		image TEXT  NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY(id)
		)";

$quersre = $conn->query($table_series);

if($quersre === TRUE){
	echo "done<br> Seires";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}





$table_response = "CREATE TABLE  IF NOT EXISTS response(
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		receiver VARCHAR(255) NOT NULL,
		post_id BIGINT(20) UNSIGNED NULL,
		sender VARCHAR(255) NOT NULL,
		type ENUM('reply', 'comment', 'mention' ,'letter','reading') NOT NULL,
		liked ENUM('true', 'false', 'other') NULL DEFAULT 'false',
		comment TEXT  NULL,
		seen ENUM('y','n') NOT NULL DEFAULT 'n',
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY(id)
		)";

$queryres = $conn->query($table_response);

if($queryres === TRUE){
	echo "done res<br>";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$table_trending = "CREATE TABLE  IF NOT EXISTS trending(
		id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		term TEXT  NULL,
		count BIGINT(20) NOT NULL DEFAULT '0',
		rank DECIMAL(20,9) NULL,
		created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY(id)
		)";

$quertr = $conn->query($table_trending);

if($quertr === TRUE){
	echo "done trending<br>";
}else{
	echo "Error: " . $sql . "<br>" . $conn->error;
}

?>