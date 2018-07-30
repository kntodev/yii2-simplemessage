<?php

use Yii;

$amount = count($dataProvider);

if (!$dataProvider) {
	?>
	<input type="hidden" id="Amount" value="0">
	<div class="mpty-row" style="height: 100px;width: 100%;text-align: center;color: #868e96;padding: .5rem 12px;display: table;">
		<span style="display: table-cell;vertical-align: middle"><?= Yii::t('modules/messages', 'There are no Messages to show') ?></span>
	</div>
	<?php
} else {
	?>
	<input type="hidden" id="Amount" value="<?= $amount ?>">
	<?php
	foreach ($dataProvider as $row) {
		?>
		<div onclick="window.location.href = '<?= $row->route ?>';"class="dropdown-item messages-item" >
			<span class="fa fa-envelope-o"></span>
			<span class="message"><?= $row->subject ?></span>
			<small class="timeago"><?= $row->timeago ?></small>
		</div>
		<?php
	}
}

?>
