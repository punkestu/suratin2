<?php
require_once __DIR__ . "/../env.php";
require_once __DIR__ . "/../model/notifikasi_model.php";

function getMyNotification(){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    $res = Notifikasi::isFor($conn, $_COOKIE["token"])["data"];
    return $res;
}

function notificationIsReadBy($notification, $user_id){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    return $notification->isReadBy($conn, $user_id);
}

function readNotification($notifikasi){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    $res = Notifikasi::readBy($conn, $notifikasi, $_COOKIE["token"]);
    return $res;
}

function getNotificationCount(){
    $conn = new mysqli(HOST, USERNAME, PASSWORD, DB);
    $res = count(Notifikasi::isFor($conn, $_COOKIE["token"])["data"]);
    $res = $res - (int)(Notifikasi::notificationReadCount($conn, $_COOKIE["token"])["count(n.id)"]);
    return $res;
}