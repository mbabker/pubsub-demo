<?php

namespace App\Chat;

use Gos\Bundle\PubSubRouterBundle\Request\PubSubRequest;

class MessageHandler
{
    public function notifyUser(PubSubRequest $request)
    {
        if ($request->getAttributes()->get('application') === 'pubsub-demo') {
            dump('This is the pubsub-demo application');
        } else {
            dump('Who are you? Where are we?');
        }
    }
}
