<?php
try {
	 $db = new PDO("mysql:host=localhost;dbname=kazandi6_am5;charset=utf8", "kazandi6_am5", "~f3G$9R7GNwj");
} catch ( PDOException $e ){
     print $e->getMessage();
}
?>