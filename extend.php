<?php

namespace Olleksi\UkSlug;

use Flarum\Extend;
use Flarum\Discussion\Event\Saving;
use Illuminate\Support\Arr;

return [
    (new Extend\Event)
        ->listen(Saving::class, function (Saving $event) {
            $discussion = $event->discussion;
            
            // Перевірка: чи це об'єкт Discussion, а не інша модель
            if (!($discussion instanceof \Flarum\Discussion\Discussion)) {
                return;
            }
            
            $data = $event->data;
            
            // Перевіряємо, чи змінився заголовок обговорення
            if (Arr::has($data, 'attributes.title')) {
                $title = Arr::get($data, 'attributes.title');
                
                if (!empty($title)) {
                    $discussion->slug = Transliterator::transliterate($title);
                }
            }
        }),
    
    (new Extend\Locales(__DIR__ . '/locale')),
];
