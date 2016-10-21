<?php

namespace jarrus90\UserPurse\migrations;

use Yii;

class m160809_103818_user_purse extends \yii\db\Migration {

    /**
     * Create table.
     */
    public function safeUp() {
        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->addColumn('{{%user_profile}}', 'purse_amount', $this->money(32, 4)->defaultValue(0));

        $this->createTable('{{%user_purse_refill}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'amount' => $this->money(32, 4),
            'created_at' => $this->integer(),
            'source' => $this->string(),
            'description' => $this->text(),
                ], $tableOptions);
        $this->addForeignKey('fk-user_purse_refill-user', '{{%user_purse_refill}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

        $this->createTable('{{%user_purse_spendings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'amount' => $this->money(32, 4),
            'created_at' => $this->integer(),
            'description' => $this->text(),
                ], $tableOptions);
        $this->addForeignKey('fk-user_purse_spendings-user', '{{%user_purse_spendings}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * Create table.
     */
    public function safeDown() {
        $this->dropTable('{{%user_purse_refill}}');
        $this->dropTable('{{%user_purse_spendings}}');
        $this->dropColumn('{{%user_profile}}', 'purse_amount');
    }

}
