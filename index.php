<?php
require_once 'func.php'?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8">  
		<title>Гостевая книга</title>
		<link rel="stylesheet" href="css/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<div id="wrapper">
			<h1>Гостевая книга</h1>
			<?php echo(pagination(5));?>
            <?=showData();?>
            <?=addMessage();?>
            <?=deleteMessage();?>
			<div id="form">
				<form action="" method="POST">
					<p><input class="form-control" placeholder="Ваше имя" name="name"></p>
					<p><textarea class="form-control" placeholder="Ваш отзыв" name="message"></textarea></p>
					<p><input type="submit" class="btn btn-info btn-block" value="Сохранить" name="submit"></p>
				</form>
			</div>
		</div>
	</body>
</html>

<?php


//if (isset($_REQUEST["submit"])) {
//    $db = connect();
//    $name = $_REQUEST['name'];
//    $message = $_REQUEST['message'];
//    $date = date('Y-M-D : H:i:s');
//
//    $query = "INSERT INTO guestbook (user, message, date) VALUES ('$name', '$message', '$date')";
//    $res = $db->query($query);
//    if ($res) {
//        echo "<div class='info alert alert-info'>Запись успешно сохранена!</div>";
//    }
//}