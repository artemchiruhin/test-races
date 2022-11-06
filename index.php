<?php
    include __DIR__ . '/inc/functions.php';
    $sort_attempt = isset($_GET['attempt']) ? $_GET['attempt'] : '';
    $cars = get_cars_and_attempts($sort_attempt);
    $attempts_count = get_max_attempts($cars);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Гонки</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title-main">Участники</h1>
            <div class="sort">
                <span>Сортировать по: </span>
                <form action="" method="GET" class="form">
                    <select name="attempt">
                        <option value="all" selected>Итого</option>
                        <?php for($i = 1; $i <= $attempts_count; $i++): ?>
                        <option value="<?= $i; ?>" <?= $sort_attempt == $i ? 'selected' : ''; ?>>Попытка <?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <button>Применить</button>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Место</th>
                    <th>ФИО</th>
                    <th>Город</th>
                    <th>Машина</th>
                    <?php for($i = 1; $i <= $attempts_count; $i++): ?>
                    <th class="<?= $sort_attempt == $i ? 'green' : '' ?>">Попытка <?= $i; ?></th>
                    <?php endfor; ?>
                    <th class="<?= $sort_attempt == "all" ? 'green' : '' ?>">Итого</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cars as $i => $car): ?>
                    <tr>
                        <td class="<?= $i + 1 === 1 ? 'gold' : ($i + 1 === 2 ? 'silver' : ($i + 1 === 3 ? 'bronze' : '')); ?>"><?= $i + 1; ?></td>
                        <td><?= $car['name']; ?></td>
                        <td><?= $car['city']; ?></td>
                        <td><?= $car['car']; ?></td>
                        <?php for($i = 0; $i < $attempts_count; $i++): ?>
                        <td><?= $car['attempts'][$i]['result'] ?? 0; ?></td>
                        <?php endfor; ?>
                        <td><?= $car['result'] ?? 0; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>