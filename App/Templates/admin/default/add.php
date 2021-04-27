<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Добавление новости</title>
</head>
<body>
<b><a href="/admin/">Редактор</a></b><br>
<h2>Новая статья</h2>
<form method="post">
    <label>Название:
        <input type="text" name="title" style="width: 600px">
    </label>
    <br>
    <label>Автор:
        <select name="author">
            <option selected disabled>Выберете автора</option>
			<?php if (!empty($authors)) : ?>
				<?php foreach ($authors as $author) : ?>
                    <option value="<?php echo $author->id; ?>"><?php echo $author->name; ?></option>
				<?php endforeach; ?>
			<?php endif ?>
        </select>
    </label>
    <br>
    <label>Содержание:<br>
        <textarea name="lead" style="width: 600px;height: 400px"></textarea>
    </label>
    <br>
    <input type="submit" name="save" value="Добавить">
</form>
</body>
</html>
