<?php

namespace kntodev\simplemessage\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\db\Query;
use kntodev\simplemessage\MessagesAsset;


class Messages extends \yii\base\Widget
{

    public $options = ['class' => 'dropdown nav-messages'];

    /**
     * @var string the HTML options for the item count tag. Key 'tag' might be used here for the tag name specification.
     * For example:
     *
     * ```php
     * [
     *     'tag' => 'span',
     *     'class' => 'badge badge-warning',
     * ]
     * ```
     */
    public $countOptions = [];

    /**
     * @var array additional options to be passed to the notification library.
     * Please refer to the plugin project page for available options.
     */
    public $clientOptions = [];
    /**
     * @var integer the XHR timeout in milliseconds
     */
    public $xhrTimeout = 2000;
    /**
     * @var integer The delay between pulls in milliseconds
     */
    public $pollInterval = 60000;

    public function init()
    {
        parent::init();

        if(!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
//        echo $this->renderNavbarItem();

//        $this->registerAssets();
        return $this->render('message-widget');
    }

    /**
     * @inheritdoc
     */
    protected function renderNavbarItem()
    {
        $html  = Html::beginTag('li', $this->options);
        $html .= Html::beginTag('a', ['href' => '#', 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']);
        $html .= Html::tag('span', '', ['class' => 'fa fa-envelope-o']);

        $count = self::getCountUnseen();
        $countOptions = array_merge([
            'tag' => 'span',
            'data-count' => $count,
        ], $this->countOptions);
        Html::addCssClass($countOptions, 'label label-warning navbar-badge messages-count');
        if(!$count){
            $countOptions['style'] = 'display: none;';
        }
        $countTag = ArrayHelper::remove($countOptions, 'tag', 'span');
        $html .= Html::tag($countTag, $count, $countOptions);

        $html .= Html::endTag('a');
        $html .= Html::begintag('div', ['class' => 'dropdown-menu','style' => 'width: 600px;']);
        $header = Html::a(Yii::t('modules/messages', 'New Message'), '/messages/default/create', ['class' => 'read-all pull-right']);
        $header .= Yii::t('modules/messages', 'Messages');
        $html .= Html::tag('div', $header, ['class' => 'header']);

        $html .= Html::begintag('div', ['class' => 'messages-list', 'id' => 'msgContainer']);
        //$html .= Html::tag('div', '<span class="ajax-loader"></span>', ['class' => 'loading-row']);
//        $html .= Html::tag('div', Html::tag('span', Yii::t('modules/messages', 'There are no messages to show'), ['style' => 'display: none;']), ['class' => 'empty-row']);
        $html .= Html::endTag('div');

        $footer = Html::a(Yii::t('modules/messages', 'View all'), ['/messages/default/index']);
        $html .= Html::tag('div', $footer, ['class' => 'footer']);
        $html .= Html::endTag('div');
        $html .= Html::endTag('li');

        return $html;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $this->clientOptions = array_merge([
            'id' => $this->options['id'],
            'url' => Url::to(['/messages/default/list']),
            'countUrl' => Url::to(['/messages/default/count']),
            'readUrl' => Url::to(['/messages/default/read']),
            'readAllUrl' => Url::to(['/messages/default/read-all']),
            'xhrTimeout' => Html::encode($this->xhrTimeout),
            'pollInterval' => Html::encode($this->pollInterval),
        ], $this->clientOptions);

//        $js = 'Messages(' . Json::encode($this->clientOptions) . ');';
        $js = 'Messages();';
        $view = $this->getView();

        MessagesAsset::register($view);

        $view->registerJs($js);
    }

    public static function getCountUnseen(){
        $userId = Yii::$app->getUser()->getId();
        $count = (new Query())
            ->from('messages')
            ->andWhere(['receiver' => $userId])
            ->andWhere(['readed' => 0])
            ->count();
        return $count;
    }

}
