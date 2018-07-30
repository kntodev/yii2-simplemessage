<?php

namespace kntodev\simplemessage;

use yii\web\AssetBundle;

/**
 * Class NotificationsAsset
 *
 * @package common\modules\simplemessage
 */
class MessagesAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@common/modules/simplemessage/assets';

//    public $linkAssets = TRUE ;
    /**
     * @inheritdoc
     */
    public $js = [
//        'js/message.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/messages.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];

}
