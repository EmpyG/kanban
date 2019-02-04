<?php
require 'vendor/autoload.php';

use App\ConfigLoader;
use App\TaskManager;
use App\TaskView;

$cfg = include 'config.php';
$configLoader = new ConfigLoader($cfg);
$taskView = new TaskView($configLoader);
$taskManager = new TaskManager($configLoader);

$status = $_POST['status'] ?? null;
$description = $_POST['description'] ?? null;
$deadline = $_POST['deadline'] ?? null;

if (isset($status, $description, $deadline)) {
    $taskManager->addToBoard($status, $description, $deadline);
}

$id = $_POST['id'] ?? null;
$statusUpdate = $_POST['statusUpdate'] ?? null;

if (isset($id, $statusUpdate)) {
    $taskManager->updateTaskStatus($id, $statusUpdate);
}

$idDelete = $_POST['idDelete'] ?? null;

if (isset($idDelete)) {
    $taskManager->deleteTask($idDelete);
}

$datas = $taskManager->getAll();
$list = $taskView->generateSelect($datas);

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
    Amount of tasks in the database: <?php echo $taskView->getAmount() ?>
</div>
<section class="container">
    <div class="task-list">
        <h1><a href="add.php">To-Do</a></h1>
        <div class="list">
            <?php $taskView->listDisplay(1) ?>
        </div>
    </div>

    <div class="task-list">
        <h1><a href="status.php">Work in Progress</a></h1>
        <div class="list">
            <?php $taskView->listDisplay(2) ?>
        </div>
    </div>

    <div class="task-list">
        <h1>Finished</h1>
        <div class="list">
            <?php $taskView->listDisplay(3) ?>
        </div>
    </div>
</section>

<div class="num">
    <form action="" method="post" class="">
        <div class="">
            <label class="" for="desc">Please describe your task: </label>
            <input class="" type="text" placeholder="Make some progress" id="desc" name="description" required>
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

<div class="num">
    <form action="" method="post" class="column">
        <div>
            <label class="" for="task-id">Select the task: </label>
            <select name="id" id="task-id">
                <?php echo $list; ?>
            </select>
        </div>
        <div>
            <label for="task-status">Status of the task:</label>
            <select name="statusUpdate" id="task-status">
                <option value="" disabled>--sup bich--</option>
                <option value="<?php echo TaskManager::STATUS_TODO ?>">To-Do</option>
                <option value="<?php echo TaskManager::STATUS_WORK ?>">Work in Progress</option>
                <option value="<?php echo TaskManager::STATUS_FINISHED ?>">Finished</option>
            </select>
        </div>
        <div>
            <input class="" type="submit" value="Update status">
        </div>
    </form>
</div>

<div class="num">
    <form action="" method="post" class="column">
        <div>
            <label class="" for="task-idDelete">Select the task: </label>
            <select name="idDelete" id="task-idDelete">
                <?php echo $list; ?>
            </select>
        </div>
        <div>
            <input class="" type="submit" value="Delete task">
        </div>
    </form>
</div>

</body>

</html>