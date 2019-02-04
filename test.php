<?php
require_once 'vendor/autoload.php';

use App\ConfigLoader;
use App\TaskManager;

$cfg = include 'config.php';
$parser = new ConfigLoader($cfg);
$add = new TaskManager($parser);
// $add->addToBoard("I think I found it", "Before");
//$add->updateTaskFinish(5);
//$add->setActiveStatus(4, 0);
$deadline = 'now';
$add->taskTime($deadline);