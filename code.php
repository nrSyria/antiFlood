<?php
session_start();
require_once 'functions.php';
$timeNow = time();

$genrateTime = 10;
$timeLimit = 60 * 60 * 12 *0;
# time of the last genration
$act_time = isset($_SESSION['code']['act_time']) ? $_SESSION['code']['act_time'] : 0;
# seconds since last genration
$elapsedTime = $timeNow - $act_time;

$op = isset($_GET['op']) ? $_GET['op'] : 'start';

switch ($op) {

    case 'start':
        if (isset($_SESSION['code']['value'])) {
            if ($elapsedTime > $timeLimit) {
                unset($_SESSION['code']['value']);
                $_SESSION['code']['act_time'] = $timeNow;
                startGenerating();
            } else {
                 viewCode();
                 $nextAfter = seconds2human($timeLimit-$elapsedTime);
                print '<p> you have already code , can use it for one time <br> '
                 . 'or should waiting '.$nextAfter.' for next code</p>';
            }
        } else {
            $_SESSION['code']['act_time'] = $timeNow;            
            startGenerating();
        }
        die();
        break;

    case 'genrate':

        if ($elapsedTime >= $genrateTime) {
            $_SESSION['code']['value'] = WMHash();
            viewCode();
        } else {
            startGenerating();
        }
        break;
    case 'view':
        break;

    case 'image':
        if(isset($_SESSION['code']['value']))
         captchaImage($_SESSION['code']['value']);
        else
         header("Location: error.png");   
        break;
    default:
        die();
}

?>