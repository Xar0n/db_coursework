<?php
use App\Models\Article;

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новостная админ панель</title>
</head>
<body>
<b><a href="/admin/default/add">Добавить новость</a></b>
<?php
if (!empty($articles)) {
	$table = new App\Views\AdminDataTable(
		$articles,
		include __DIR__ . '/../../../Views/functions.php'
	);
	$table->render(__DIR__ . '/table.php');
}
?>
</body>
</html>
