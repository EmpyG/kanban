<?php
require 'vendor/autoload.php';

use App\ConfigLoader;
use App\TaskManager;

$cfg = include 'config.php';
$parser = new ConfigLoader($cfg);
$tasks = new TaskManager($parser);

$id = $_POST['id'] ?? null;

if (isset($id)) {
    $tasks->updateTaskStatus($id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Update task's status</title>
</head>

<body>
<form action="" method="post" class="column">
    <div class="">
        <label class="" for="number">Enter the task's number: </label>
        <input class="" type="text" placeholder="Identificator" id="number" name="id" required>
    </div>
    <div class="">

    </div>
    <div class="">
        <input class="" type="submit" value="Update status">
    </div>
</form>
</body>

</html>