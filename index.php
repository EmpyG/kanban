<?php
require 'vendor/autoload.php';

use App\ConfigLoader;
use App\TaskManager;
use App\TaskView;

$cfg = include 'config.php';
$parser = new ConfigLoader($cfg);
$load = new TaskView($parser);
$manage = new TaskManager($parser);

$status = $_POST['status'] ?? null;
$description = $_POST['description'] ?? null;
$deadline = $_POST['deadline'] ?? null;

if (isset($status, $description, $deadline)) {
    $manage->addToBoard($status, $description, $deadline);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Board</title>
</head>

<body>
<div class="num">
    Amount of tasks in the database: <?php echo $load->getAmount() ?>
</div>
<section class="container">
    <div class="task-list">
        <h1><a href="add.php">To-Do</a></h1>
        <div class="list">
            <?php $load->listDisplay(1) ?>
        </div>
    </div>

    <div class="task-list">
        <h1><a href="status.php">Work in Progress</a></h1>
        <div class="list">
            <?php $load->listDisplay(2) ?>
        </div>
    </div>

    <div class="task-list">
        <h1>Finished</h1>
        <div class="list">
            <?php $load->listDisplay(3) ?>
        </div>
    </div>
</section>

<div class="num">
    <form action="" method="post" class="">
        <div class="">
            <label class="" for="desc">Please describe your task: </label>
            <input class="" type="text" placeholder="Make some progress lmao" id="desc" name="description" required>
        </div>
        <div class="">
            <label class="" for="dline">Enter the task's deadline: </label>
            <input class="" type="datetime-local" placeholder="Soon" id="dline" name="deadline" required>
        </div>
        <label for="task-status">Status of the task:</label>
        <select name="status" id="task-status">
            <option value="" disabled>--sup bich--</option>
            <option value="1">To-Do</option>
            <option value="2">Work in Progress</option>
            <option value="3">Finished</option>
        </select>
        <div class="">
            <input class="" type="submit" value="Add Task">
        </div>
    </form>
</div>

</body>

</html>