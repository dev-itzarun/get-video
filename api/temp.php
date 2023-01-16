<?php

$input = file_get_contents("php://input");

$input_data = json_decode($input, true);

// file_put_contents('php://stderr', print_r($input_data, TRUE));

$user_message = $input_data["message"]["text"];

$user_id = $input_data["message"]['chat']['id'];

$user_first_name = $input_data["message"]['chat']['first_name'];

$user_last_name = $input_data["message"]['chat']['last_name'];

$file_id = $input_data["message"]['document']['file_id'];

$token = "5879963018:AAHUAi2cio99Nsgt4Ej78mKeGqZ9VUaLldo";

if (!empty($file_id)) {
    file_get_contents("https://api.telegram.org/$token/sendVideo?chat_id=$user_id&video=$file_id");
} else if ($user_message == "/start") {
    $message_encode = "Welcome $user_first_name $user_last_name 😍 
    \n\n This Bot Help You to get a Telegram Video / Document By File-ID.😊
    \n\n Send a Video / Document File ID Now 
    \n\n Ex File-id : BQACAgUAAxkBAAIKqWPFgQ3pPLeKAz0ad3rJTy-1M2pyAAJ-CgACFpopVm2LMdgNKEQQLQQ";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML&disable_web_page_preview=TRUE");
} else {
    $message_encode = "Hey Your Message is Invalid 😟 \n\n Try sending Me a Video / Document OR FileID.😊";
    $message = urlencode($message_encode);
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$user_id&text=$message&parse_mode=HTML");
}
