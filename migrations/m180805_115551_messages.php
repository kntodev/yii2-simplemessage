<?php

use yii\db\Schema;
use yii\db\Migration;

class m180805_115551_messages extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%messages}}',
            [
                'id'=> $this->primaryKey(11),
                'readed'=> $this->integer(11)->notNull(),
                'sender'=> $this->integer(11)->notNull(),
                'receiver'=> $this->integer(11)->notNull(),
                'subject'=> $this->string(25)->notNull(),
                'content'=> $this->text()->notNull(),
                'route'=> $this->string(255)->notNull(),
                'created_at'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('created_at','{{%messages}}',['created_at'],false);
        $this->createIndex('fb_sender','{{%messages}}',['sender'],false);
        $this->createIndex('fb_receiver','{{%messages}}',['receiver'],false);

    }

    public function safeDown()
    {
        $this->dropIndex('created_at', '{{%messages}}');
        $this->dropIndex('fb_sender', '{{%messages}}');
        $this->dropIndex('fb_receiver', '{{%messages}}');
        $this->dropTable('{{%messages}}');
    }
}
