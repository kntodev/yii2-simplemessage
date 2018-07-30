<?php

use Yii;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Customer */

$this->title = Yii::t('modules/messages', 'New Message');
?>
<div class="messages-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
