<?php

// setWebhook https://api.telegram.org/bot5013086164:AAGQsYyf-a-qEwyLb75kwY-ubS91m9kzrv0/setWebhook?url=https://5d06-88-214-10-164.ngrok.io

    $db = 'https://www.themealdb.com/api/json/v1/1/random.php';
    $sendMessageUrl = 'https://api.telegram.org/bot5013086164:AAGQsYyf-a-qEwyLb75kwY-ubS91m9kzrv0/sendMessage';


        $result = json_decode(file_get_contents('php://input'), true);
        $chatId = $result['message']['chat']['id'];
        $text = mb_strtolower($result['message']['text']);

        $eat = json_decode(file_get_contents($db), true);
        $dish = $eat['meals'][0]['strMeal'];
        $video = $eat['meals'][0]['strYoutube'];
        $recipe = $eat['meals'][0]['strInstructions'];
        $photo = $eat['meals'][0]['strMealThumb'];

    function response($chatId, $answer, $keyboard, $sendMessageUrl) {
        $response = [
            'chat_id' => $chatId,
            'text' => $answer,
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => $keyboard,
            ]),
        ];
        return file_get_contents($sendMessageUrl . '?' . http_build_query($response));
    }

    $buttons = [
        [
            ['text' => 'Голодный, как волк!'],
            ['text' => 'Ну, я не знаю'],
        ],
        [
            ['text' => 'Можешь рискнуть и снова крутануть барабан'],
        ],
    ];

        if ($text == 'привет' || $text == '/start') {
        $answer = 'Здарова! У тебя есть два исхода событий. Сделай правильный выбор! Ты голоден? ДА или НЕТ ???';
        $keyboard = [
                [
                    ['text' => 'ДА'],
                    ['text' => 'НЕТ'],
                ],
            ];
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'да' || $text == 'можешь рискнуть и снова крутануть барабан' ||
            $text == 'или может быть ты передумал? тогда милости просим!' || $text == 'обретение суперсилы' ||
            $text == '... или ты уже подумал над своим поведением?') {
        $answer = 'Ты на верном пути! Что будешь брать?';
        $keyboard = [
                        [
                            ['text' => 'Завтрак'],
                            ['text' => 'Обед'],
                        ],
                        [
                            ['text' => 'Ужин'],
                            ['text' => 'Перекусить ))'],
                        ],
                    ];
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'нет') {
        $answer = 'Тогда проваливай и не задерживай очередь!';
        $keyboard = [
                [
                    ['text' => 'Или может быть ты передумал? Тогда милости просим!'],
                ],
            ];
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'завтрак') {
        $answer = 'Это будет завтрак чемпионов. С тебя 5 баксов! Шучу )) Твой окончательный ответ?';
        $keyboard = $buttons;
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'обед') {
        $answer = 'Ты считаешь что заработал свой обед? Ладно, ладно хватит извиняться и кланяться. Жми, если голоден! Не забудь помыть посуду!';
        $keyboard = $buttons;
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'ужин') {
            $answer = 'Ужин - это хорошо! Ну, ты помнишь да, что после шести есть вредно )) Жми ниже и забирай свои калории! Утром на пробежку!';
            $keyboard = $buttons;
            response($chatId, $answer, $keyboard, $sendMessageUrl);
        } elseif ($text == 'перекусить ))') {
            $answer = 'Ты сказал перекусить или закусить? )) Нажми на кнопку и получишь результат!';
            $keyboard = $buttons;
            response($chatId, $answer, $keyboard, $sendMessageUrl);
        } elseif ($text == 'ну, я не знаю') {
        $answer = 'Приходи завтра! Или ...';
        $keyboard = [
                [
                    ['text' => '... или ты уже подумал над своим поведением?'],
                ],
            ];
        response($chatId, $answer, $keyboard, $sendMessageUrl);
    } elseif ($text == 'голодный, как волк!') {
            $response = [
                'chat_id' => $chatId,
                'text' => $dish . "\n" . $recipe . "\n" . 'Bon appetit!' . "\n" . 'И знаешь что, мой совет тебе, учи английский! Он тебе пригодится!',
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            ['text' => 'Фотка', 'url' => $photo],
                            ['text' => 'Видосик', 'url' => $video],
                        ],
                    ],
                ]),
            ];
            file_get_contents($sendMessageUrl . '?' . http_build_query($response));
            $answer = 'У тебя есть еще одна попытка!';
            $keyboard = [
                [
                    ['text' => 'Можешь рискнуть и снова крутануть барабан'],
                ],
            ];
            response($chatId, $answer, $keyboard, $sendMessageUrl);
        } else {
            $answer = 'Для начала подкрепись. Для выбора суперсилы нажми на кнопку!';
            $keyboard = [
                [
                    ['text' => 'Обретение суперсилы'],
                ],
            ];
            response($chatId, $answer, $keyboard, $sendMessageUrl);
        }

