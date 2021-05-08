<?php

use yii\db\Migration;

/**
 * Class m200713_172505_insert_default_admin_to_user_table
 */
class m200713_172505_insert_default_admin_to_user_table extends Migration
{
    public $tableName = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert($this->tableName, [
            'username' => 'admin',
            'auth_key' => '123',
            'password_hash' => '$2y$13$u/VLohfRG5ZUieodqJZiSutCOl1rZqUqPlAyazDjbckd6kOBAFhMK',
            'email' => 'admin@mail.ru',
            'status' => 10,
            'role' => 'admin',
            'created_at' => '123',
            'updated_at' => '123'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200713_172505_insert_default_admin_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200713_172505_insert_default_admin_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
