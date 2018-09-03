<?php

use yii\db\Schema;
use yii\db\Migration;

class m180805_115552_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_messages_receiver',
            '{{%messages}}','receiver',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
        $this->addForeignKey('fk_messages_sender',
            '{{%messages}}','sender',
            '{{%user}}','id',
            'CASCADE','CASCADE'
         );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_messages_receiver', '{{%messages}}');
        $this->dropForeignKey('fk_messages_sender', '{{%messages}}');
    }
}
