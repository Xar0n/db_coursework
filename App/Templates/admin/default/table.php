<table border="1">
    <tr>
        <th>Номер</th>
        <th>Название</th>
        <th>Автор</th>
        <th colspan="2">Действия</th>
    </tr>
	<?php foreach ($rows as $row) : ?>
        <tr>
			<?php foreach ($columns as $column): ?>
                <td><?php echo htmlspecialchars($column($row)); ?></a></td>
			<?php endforeach ?>
            <td><a href="/admin/default/edit/?id=<?php echo $row->id; ?>">Редактировать</a></td>
            <td><a href="/admin/default/delete/?id=<?php echo $row->id; ?>">Удалить</a></td>
        </tr>
	<?php endforeach; ?>
</table>
