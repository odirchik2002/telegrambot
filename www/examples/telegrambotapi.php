<?php
/** Пример обработки сообщений телеграм бота */

// Подключим автозагрузчик composer, defines
use modules\telegram\services\sTelegram;
use Telegram\Bot\Api;

require_once __DIR__ .'/../system/defines.php';
require_once __DIR__ .'/../system/vendor/autoload.php';

// Получим токен бота из файла
$bot_token = '5053084982:AAEtdPM00KhIbG_oIrwcsjCSndc3jzoixI0';


// Подключаемся к апи
$telegram = new Api($bot_token);
$dataMessage = $telegram->getWebhookUpdates();

if(empty($dataMessage['message']['message_id'])){
    echo json_encode(['error'=> 1, 'data' => 'message_id empty']);
    exit;
}
if(empty($dataMessage['message']['chat']['id'])){
    echo json_encode(['error'=> 1, 'data' => 'chat_id empty']);
    exit;
}
if(empty($dataMessage['message']['text'])){
    echo json_encode(['error'=> 1, 'data' => 'text empty']);
    exit;
}

// Получим данные от пользователя
$message_id = $dataMessage['message']['message_id']; // Id сообщения
$message_chat_id = $dataMessage['message']['chat']['id']; // Id чата
$message_text = $dataMessage['message']['text']; // Текст сообщения

// К нижнему регистру
$messageTextLower = mb_strtolower($message_text);

// Если первое сообщение
if($messageTextLower=='/start'){
    sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'salom, men Botman');
    exit;
}

// Если пользователь напишет Тест, то выведем ответ
if($messageTextLower=='qalesz'){
    sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'Daxshatman');
    exit;
}

// Если пользователь напишет привет
if($messageTextLower=='salom'){
    sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'salom');
    exit;
}

// пример ответа
if($messageTextLower=='nma gap'){
    sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'Tinchko', '', $message_id);
    exit;
}

// пример кнопки
if($messageTextLower=='пример кнопки'){
    $inline_keyboard=[];
    $inline_keyboard[][] = ["text"=>'telegram кнопка', "url"=>'https://telegram.org/'];
    $keyboard=["inline_keyboard"=>$inline_keyboard];
    $reply_markup = json_encode($keyboard);
    sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'Сообщение с кнопкой', $reply_markup);
    exit;
}

// Если не предусмотрен ответ
sTelegram::instance()->sendMessage($bot_token, $message_chat_id, 'bunday soz menga kiritilmagan');
exit;

