<?php

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kntodev\simplemessage\MessagesAsset;
use richardfan\widget\JSRegister;

MessagesAsset::register($this);
?>
<li id="w0" class="dropdown nav-messages">
	<a class="dropdown-toggle" href="#" data-toggle="dropdown">
		<span class="fa fa-envelope-o"></span>
		<span class="label label-warning navbar-badge messages-count" id="msgCount">
		</span>
	</a>
	<div class="dropdown-menu" style="width: 600px;">
		<div class="header">
			<?= Html::a(Yii::t('modules/messages', 'New Message'), '/messages/default/create', ['class' => 'read-all pull-right']) ?>
			<?= Yii::t('modules/messages', 'Messages') ?>
		</div>
		<div id="msgContainer" class="messages-list"></div>
		<div class="footer">
			<?= Html::a(Yii::t('modules/messages', 'View all'), ['/messages/default/index']) ?>
		</div>
	</div>
</li>
<?php JSRegister::begin(); ?>
<script>
	var options = {
		url : '/messages/default/list',
		pollInterval: 60000,
		xhrTimeout: 2000,
		readLabel: 'read',
		markAsReadLabel: 'mark as read'
	};

	var showList = function worker() {
		$.ajax({
			url: options.url,
			success: function(data) {
				$("#msgContainer").html(data);
				$("#msgCount").html($('#Amount').val());
			},
			complete: function() {
				// Schedule the next request when the current one's complete
				setTimeout(worker, options.pollInterval);
			}
		});
	};

	showList();
</script>
<?php JSRegister::end(); ?>
