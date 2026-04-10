<?php

namespace Olleksi\UkSlug;

use Flarum\Extend;
use Flarum\Discussion\Event\Saving;

return [
    (new Extend\Event)
        ->listen(Saving::class, function (Saving $event) {
            $discussion = $event->discussion;
            
            if (!($discussion instanceof \Flarum\Discussion\Discussion)) {
                return;
            }
            
            if (isset($event->data['attributes']['title'])) {
                $title = $event->data['attributes']['title'];
                
                if (!empty($title)) {
                    $discussion->slug = Transliterator::transliterate($title);
                }
            }
        }),
];
