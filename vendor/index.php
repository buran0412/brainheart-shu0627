<?php
require('vendor/autoload.php');

use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;

$channel_access_token = 'vxlL9OW74yVqup97A6GTYlaXmKOD4LMC6JOmWWKkKuUvTVG8nEFAH / WpWVkZFRtB5lOVY3S6lcmTZN3R3FYQWGANtadCWYtLvTbSBDqMOnpWE69tWzzT9lKJgt';
$channel_secret = '7504ec17bc370edec440cb7e4ea0126c';

$http_client = new CurlHTTPClient($channel_access_token);
$bot = new LINEBot($http_client, ['channelSecret' => $channel_secret]);
$signature = $_SERVER['HTTP_' . HTTPHeader::LINE_SIGNATURE];
$http_request_body = file_get_contents('php://input');
$events = $bot->parseEventRequest($http_request_body, $signature);
$event = $events[0];
$reply_token = $event->getReplyToken();

$date_time = new DatetimePickerTemplateActionBuilder('日付を選択', 'storeId=12345', 'datetime');
$no_button = new PostbackTemplateActionBuilder('キャンセル', 'button=0');
$actions = [$date_time, $no_button];
$button = new ButtonTemplateBuilder('タイトル', 'テキスト', '', $actions);
$button_message = new TemplateMessageBuilder('タイトル', $button);
$bot->replyMessage($reply_token, $button_message);
$postback_data = $event->getPostbackData();
parse_str($postback_data, $data);
