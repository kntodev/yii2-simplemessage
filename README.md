Yii2 Simplemessage
==================
Simple Message Module for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kntodev/yii2-simplemessage "*"
```

or add

```
"kntodev/yii2-simplemessage": "*"
```

to the require section of your `composer.json` file.

then add

```
        'messages' => [
            'class' => 'kntodev\simplemessage\Module',
            'channels' => [
                'screen' => [
                    'class' => 'kntodev\simplemessage\channels\ScreenChannel',
                ],
            ],
        ],

to the modules section of your config/main.php
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \kntodev\simplemessage\widgets\Messages::widget(); ?>
```

There are two ways to insert Data

First :

Put following code in your Application

```
use kntodev\simplemessage\Message ;

Message::create([
    'receiver' => [1,2,3,5,6], # where 1,2,3,5,6 are User ID´s
    'subject' => 'test',
    'content' => 'test',
])->send() ;

```

Second :

Controller Actions

```php

messages/default/create			# Creates a Message

messages/default/index 			# Lists all Messages

messages/default/view?id=5		# Display a message with the ID 5 (if you are the receiver)

```

Planned for future Version

Add EMail Channel to send Messages via EMail