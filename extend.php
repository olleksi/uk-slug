<?php

namespace Olleksi\UkSlug;

use Flarum\Extend;
use Flarum\Discussion\Event;
use Flarum\Discussion\Discussion;

return [
    (new Extend\Event)
        // Flarum 1.x: Використовуємо Saving
        // Flarum 2.x: Цей клас теж існує, але без $event->data, тому потрібен інший підхід
        ->listen(Event\Saving::class, function (Event\Saving $event) {
            $discussion = $event->discussion;
            
            // Перевіряємо, чи це нова дискусія, або чи змінився заголовок
            if ($discussion->exists) {
                // Якщо заголовок не змінився (isDirty працює в обох версіях), виходимо
                if (!$discussion->isDirty('title')) {
                    return;
                }
            }
            
            $title = $discussion->title;
            
            if (!empty($title)) {
                // Тут має бути виклик вашого класу Transliterator
                $discussion->slug = \Olleksi\UkSlug\Transliterator::transliterate($title);
            }
        }),
];
