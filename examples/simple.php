<?php

/*
	PHP библиотека для разработки навыков Яндекс.Алисы
	Author: Sergey Avdeev <thesoultaker48@gmail.com>
	URL: https://github.com/thesoultaker48/yandex-dialogs-php
*/


use YandexStation\YandexDialog;

$alice = new YandexDialog();

// Все действия выполняем только если получили корректные данные от Алисы
if($alice->get_request()) {

	// Начало диалога
	function _new_session($alice) {
		$alice->add_button('Да');
		$alice->add_button('Нет');
		$alice->add_message('Здравствуйте! Хотите сыграть в игру?');
	}
	$alice->bind_new_action('_new_session');
	
	// Пример завершения сессии
	function _no($token, $alice) {
		$alice->add_message('Очень жаль!');
		$alice->end_session();
	}
	$alice->bind_words_action(array('не', 'нет'), '_no');
	
	// Пример ответа при наличии одного из заданных слов
	function _yes($token, $alice) {
		$alice->add_button('Как называется игра?');
		// Будет выбран только один случайный ответ
		$alice->add_message('Как я поняла, вы ответили "'.$token.'"!');
		$alice->add_message('Ваш ответ был "'.$token.'"!');
	}
	$alice->bind_words_action(array('хочу', 'да'), '_yes');

	// Ответ при одновременном наличии нескольких слов
	function _game($percentage, $alice) {
		// Из нескольких слов в теге [word1|word2...] будет выбрано только одно случайное
		$alice->add_message('Ваша фраза совпала с [ожидаемой|заданной] на '.$percentage.'%!');
	}
	$alice->bind_percentage_action(array('как', array('называется', 'зовется'), array('твоя', 'ваша'), 'игра'), 60, '_game');
	//$alice->bind_suggestion_action('Как называется ваша игра?', 60, '_game'); // Можно и так, но без вариативности отдельных слов

	// Неизвестная команда
	function _default($alice) {
		$alice->add_message('Я вас не понимаю! Лучше скажите, играть будем?');
	}
	$alice->bind_default_action('_default');

	// Отправляем ответ и завершаем работу скрипта
	$alice->finish();
	exit;
}
