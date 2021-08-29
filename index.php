<?php
header('Content-Type: text/html; charset=utf-8');

$req = json_decode(file_get_contents('php://input'), true);

$session_id=$req['session']['session_id'];
$user_id=$req['session']['user_id'];
$application_id=$req['session']['application']['application_id'];
$user_id=$req['session']['user_id'];
$skill_id=$req['session']['skill_id'];
$message_id=$req['session']['message_id'];
$message_id=$req['session']['message_id'];

$command=$req['request']['command'];

$answer_text=($command=='on_interrupt')?'До свидания, приходите ещё':$command;

$ans['response']['text']=$answer_text;
$ans['response']['tts']=$answer_text;

$ans['response']['end_session']=false;
$ans['session']['session_id']=$session_id;
$ans['session']['user_id']=$user_id;
$ans['session']['skill_id']=$skill_id;
$ans['session']['message_id']=$message_id;
$ans['session']['user']['user_id']=$user_id;
$ans['version']='1.0';
echo json_encode($ans);