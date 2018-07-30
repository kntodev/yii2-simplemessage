<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;
use common\modules\simplemessage\models\User;

?>

<div class="messages-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'users')->widget(Select2::classname(), [
	    'data' => User::getCreatedUsersList(),
	    'maintainOrder' => true,
	    'toggleAllSettings' => [
	        'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> Tag All',
	        'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> Untag All',
	        'selectOptions' => ['class' => 'text-success'],
	        'unselectOptions' => ['class' => 'text-danger'],
	    ],
	    'options' => ['placeholder' => Yii::t('modules/messages', 'Select User'), 'multiple' => true],
	    'pluginOptions' => [
	        'tags' => true,
	        'maximumInputLength' => 10
	    ],
	]) ?>

	<?= $form->field($model, 'subject')->textInput() ?>

	<?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('modules/messages', 'Save Messages'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>