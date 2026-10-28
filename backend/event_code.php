<?php
session_start();
include '../connection.php';
include '../classes/event.php';

$eventObj = new Event($pdo);
$username = $_SESSION['username'] ?? 'Guest';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $success = false;

    if ($action === 'add') {
        $success = $eventObj->addEvent($_POST['title'], $_POST['description'], $_POST['event_date'], $_POST['venue'], $_POST['organizer'], $username);
    } elseif ($action === 'update') {
        $success = $eventObj->updateEvent($_POST['id'], $_POST['title'], $_POST['description'], $_POST['event_date'], $_POST['venue'], $_POST['organizer'], $username);
    } elseif ($action === 'delete') {
        $success = $eventObj->deleteEvent($_POST['id'], $username);
    }

    $_SESSION['flash'] = $success
        ? ['type' => 'success', 'msg' => 'Action completed successfully.']
        : ['type' => 'danger',  'msg' => 'Something went wrong. No changes were saved.'];

    header("Location: ../index.php");
    exit();
}
?>