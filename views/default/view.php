<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Message */

$this->title = Yii::t('modules/messages', 'Message from').' '.$model->sender0->username;
?>
<div class="messages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('modules/messages', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('modules/messages', 'Are you sure you want to delete this message?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
#	 id 	readed 	sender 	receiver 	subject 	content 	route 	created_at
//            'id',
			[
				'attribute' => 'readed',
				'format'=>'raw',
				'value'=> $model->readed == 1 ? Yii::t('modules/messages', 'yes') : Yii::t('modules/messages', 'no'),
			],
			[
				'attribute'=>'sender',
				'value'=>$model->sender0->username
			],
//			'receiver',
//			'route',
			[
				'attribute' => 'created_at',
				'format'=>'raw',
				'value'=> Yii::$app->formatter->asDatetime($model->created_at),
			],
			'subject',
			'content:ntext',
		],
	]) ?>

</div>
