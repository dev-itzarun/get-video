<?php

error_reporting(E_ALL);

include "connect.php";

$user_id = "5288966788";

$token = "5879963018:AAHUAi2cio99Nsgt4Ej78mKeGqZ9VUaLldo";

$sql2 = "INSERT INTO telegramfilesbot (userid) VALUES ($user_id)";

if ($conn->query($sql2) === TRUE) {

    $message_encode = "Welcome";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
}
