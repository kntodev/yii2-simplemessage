<?php

use yii\db\Schema;
use yii\db\Migration;

class m180808_163133_auth_item_childDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_item_child}}',
                           ["parent", "child"],
                            [
    [
        'parent' => 'messageAdmin',
        'child' => 'createMessages',
    ],
    [
        'parent' => 'messageUser',
        'child' => 'createMessages',
    ],
    [
        'parent' => 'messageAdmin',
        'child' => 'manageMessages',
    ],
    [
        'parent' => 'moderator',
        'child' => 'manageMessages',
    ],
    [
        'parent' => 'admin',
        'child' => 'manageUsers',
    ],
    [
        'parent' => 'admin',
        'child' => 'messageAdmin',
    ],
    [
        'parent' => 'admin',
        'child' => 'moderator',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_item_child}} CASCADE');
    }
}
