<?php
require 'vendor/autoload.php';

use App\ConfigLoader;
use App\TaskManager;

$cfg = include 'config.php';
$parser = new ConfigLoader($cfg);
$tasks = new TaskManager($parser);

$description = $_POST['description'] ?? null;
$deadline = $_POST['deadline'] ?? null;

if (isset($description, $deadline)) {
    $tasks->addToBoard($description, $deadline);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Add new task</title>
</head>

<body>
<form action="" method="post" class="column">
    <div class="">
        <label class="" for="desc">Please describe your task: </label>
        <input class="" type="text" placeholder="Make some progress lmao" id="desc" name="description" required>
    </div>
    <div class="">
        <label class="" for="dline">Enter the task's deadline: </label>
        <input class="" type="text" placeholder="Soon" id="dline" name="deadline" required>
    </div>
    <div class="">
        <input class="" type="submit" value="Add Task">
    </div>
</form>
</body>

</html>
