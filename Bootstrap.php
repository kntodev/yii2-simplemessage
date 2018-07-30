<?php

namespace kntodev\simplemessage;

/**
 * notifications module bootstrap class.
 */
class Bootstrap implements \yii\base\BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // add module I18N category
        if (!isset($app->i18n->translations['modules/messages/*'])) {
            $app->i18n->translations['modules/messages*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@kntodev/simplemessage/messages',
            ];
        }
    }
}