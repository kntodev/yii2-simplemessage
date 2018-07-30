<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\modules\simplemessage\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\customer\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('modules/messages', 'Messages');

?>
<div class="messages-index">

    <p>
        <?= Html::a(Yii::t('modules/messages', 'New Message'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'readed',
                'format'=>'raw',
                'value' => function ($model) {
                    return  $model->readed == 1 ? Yii::t('modules/messages', 'yes') : Yii::t('modules/messages', 'no') ;
                }
            ],
            [
                'attribute'=>'sender',
                'value' => function ($model) {
                    return  $model->sender0->username ;
                },
                'filter' => Html::activeDropDownList($searchModel, 'sender', ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),['class'=>'form-control','prompt' => Yii::t('modules/messages', 'Select User')]),

            ],
            [
                'attribute'=>'receiver',
                'value' => function ($model) {
                    return  $model->receiver0->username ;
                },
                'filter' => Html::activeDropDownList($searchModel, 'receiver', ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'),['class'=>'form-control','prompt' => Yii::t('modules/messages', 'Select User')]),

            ],
//          'route',
            [
                'attribute' => 'created_at',
                'format'=>'raw',
                'value' => function ($model) {
                    return  Yii::$app->formatter->asDatetime($model->created_at) ;
                }
            ],
            'subject',
            'content:ntext',

//            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
