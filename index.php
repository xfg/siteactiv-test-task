<?php
  require_once "db.php";
  require_once "./src/App.php";

  if (isset($_POST['max'])) {
    $conn = new PDO($db['dsn'], $db['user'], $db['password']);
    $numbers = (new App($conn))->calculatePrimeNumbers(intval($_POST['max']));
  }
?>

<!doctype html>

<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Простые числа</title>
  <meta name="description" content="Тестовое приложение для нахождения простых чисел">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="container h-100">
    <div class="row h-100 p-3">
      <div class="col-6 m-auto">
        <h1 class="display-4 text-center">
          <a href="https://ru.wikipedia.org/wiki/Простое_число" target="_blank">
            Простые числа
          </a>
        </h1>
        <form method="post">
          <div class="form-group">
            <input type="number" name="max" value="<?= $_POST['max'] ?>" class="form-control" placeholder="Введите число">
            <small class="form-text text-muted">
              Число до которого выводить простые числа
            </small>
          </div>

          <div class="form-group text-center">
            <?php if (is_array($numbers)) : ?>
              <?php foreach($numbers as $number) : ?>
                <span class="App-number m-3"><?= $number ?></span>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary btn-block">Продолжить</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>