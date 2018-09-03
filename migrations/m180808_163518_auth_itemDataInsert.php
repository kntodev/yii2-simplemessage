<?php

use yii\db\Schema;
use yii\db\Migration;

class m180808_163518_auth_itemDataInsert extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $this->batchInsert('{{%auth_item}}',
                           ["name", "type", "description", "rule_name", "data", "created_at", "updated_at"],
                            [
    [
        'name' => 'admin',
        'type' => '1',
        'description' => 'Administrator',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533588240',
        'updated_at' => '1533627217',
    ],
    [
        'name' => 'createMessages',
        'type' => '2',
        'description' => 'create Messages',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533626940',
        'updated_at' => '1533626940',
    ],
    [
        'name' => 'manageMessages',
        'type' => '2',
        'description' => 'Manage Messages',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533587947',
        'updated_at' => '1533626771',
    ],
    [
        'name' => 'manageUsers',
        'type' => '2',
        'description' => 'Manage users',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533587991',
        'updated_at' => '1533587991',
    ],
    [
        'name' => 'messageAdmin',
        'type' => '2',
        'description' => 'Message Admin',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533627152',
        'updated_at' => '1533627152',
    ],
    [
        'name' => 'messageUser',
        'type' => '2',
        'description' => 'Message User',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533627080',
        'updated_at' => '1533627080',
    ],
    [
        'name' => 'moderator',
        'type' => '1',
        'description' => 'Moderator',
        'rule_name' => null,
        'data' => null,
        'created_at' => '1533588119',
        'updated_at' => '1533588119',
    ],
]
        );
    }

    public function safeDown()
    {
        //$this->truncateTable('{{%auth_item}} CASCADE');
    }
}
