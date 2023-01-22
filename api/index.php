<?php

include "connect.php";

$input = file_get_contents("php://input");

$input_data = json_decode($input, true);

// file_put_contents('php://stderr', print_r($input_data, TRUE));

$token = "5879963018:AAHUAi2cio99Nsgt4Ej78mKeGqZ9VUaLldo";

$user_message = $input_data["message"]["text"];

$user_id = $input_data["message"]['chat']['id'];

$user_first_name = $input_data["message"]['chat']['first_name'];

$user_last_name = $input_data["message"]['chat']['last_name'];

$sql2 = "SELECT * FROM telegramfilesbot WHERE userid ='$user_id' ";
$result2 = $conn->query($sql2);

$userscount = mysqli_num_rows($result2);

if ($result2->num_rows > 0) {
    $isavailable = "true";
} else {
    $isavailable = "false";
}

if (!empty($input_data["message"]['document']['file_id'])) {
    $get_file_id = $input_data["message"]['document']['file_id'];
    $file_type = "document";
    // file_put_contents('php://stderr', print_r($file_type));
} elseif (!empty($input_data["message"]['video']['file_id'])) {
    $get_file_id = $input_data["message"]['video']['file_id'];
    $file_type = "video";
    // file_put_contents('php://stderr', print_r($file_type));
} else {
    if (!empty($input_data["message"]['text'])) {
        $get_file_id = $input_data["message"]['text'];
        $file_type = "file_id";
        // file_put_contents('php://stderr', print_r($file_type));
    }
}

// file_put_contents('php://stderr', print_r($get_file_id, TRUE));
// file_put_contents('php://stderr', print_r($file_type, TRUE));

if (!empty($file_type) && !empty($get_file_id)) {
    $new_file_id = $get_file_id;
}

if ($user_message == "/start") {
    error_log($isavailable, 0);
    error_log("started", 0);
    if ($isavailable == "false") {
        $sql5 = "INSERT INTO telegramfilesbot (userid) VALUES ($user_id)";

        if ($conn->query($sql5) === TRUE) {

            error_log("insert true", 0);
            $message_encode = "Welcome $user_first_name $user_last_name 😍";
            $message = urlencode($message_encode);
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
        }
    } else {
        error_log("no new insert", 0);
        $message_encode = "Welcome Again $user_first_name $user_last_name 😍";
        $message = urlencode($message_encode);
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
    }
} elseif ($user_message == "/help") {
    $message_encode = "This bot will assist you in obtaining a Telegram video or document by file-ID.😊
    \n\n - This bot will only function only with the file id's obtained from it.
    \n\n - To obtain File Id Send Or Forward a Document or Video to this bot.
    \n\n - Then share that file id with your Friends Or Family and instruct them to enter that id in this same bot @TheVideoDLBot to obtain the file.
    \n\n - This bot's goal is to improve privacy.";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
} elseif ($user_message == "/terms") {
    $message_encode = "The developer of this bot is not responsible for the information shared through it.";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
} elseif ($user_message == "/developer") {
    $message_encode = "Only Contact The Developer If You face any issue : Arun Kumar - @dev_itsarun";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
} elseif ($user_message == "/stats" && !empty($userscount)) {
    $message_encode = $userscount . " Users Using this Bot";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
} elseif ($user_message == "/howtouse") {
    file_get_contents("https://api.telegram.org/bot$token/sendDocument?chat_id=$user_id&document=CgACAgUAAxkBAAO_Y8qi5fCdFn7KaRLNryHJUIfeFhwAAr4KAALMzVBWjYOzo1u9vH0tBA&caption=How to use The Telegram File Bot Tutorial ☝️☝️☝️☝️");
} elseif ($file_type == "file_id" && !empty($new_file_id)) {
    file_get_contents("https://api.telegram.org/bot$token/sendDocument?chat_id=$user_id&document=$new_file_id");
} elseif ($file_type == "document" && !empty($new_file_id)) {
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=Your Document File id is : <code>$new_file_id</code>&parse_mode=HTML");
} elseif ($file_type == "video" && !empty($new_file_id)) {
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=Your Video File id is : <code>$new_file_id</code>&parse_mode=HTML");
} else {
    $message_encode = "Hey Your Message is Invalid 😟 \n\n Try sending Me a Video / Document OR FileID.😊";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML");
}
