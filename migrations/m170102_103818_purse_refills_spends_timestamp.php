<?php

namespace jarrus90\UserPurse\migrations;

use Yii;

class m170102_103818_purse_refills_spends_timestamp extends \yii\db\Migration {

    /**
     * Create table.
     */
    public function safeUp() {
        $this->addColumn('{{%user_purse_refill}}', 'updated_at', $this->integer());
        $this->addColumn('{{%user_purse_spendings}}', 'updated_at', $this->integer());
    }

    /**
     * Create table.
     */
    public function safeDown() {
        $this->dropColumn('{{%user_purse_refill}}', 'updated_at');
        $this->dropColumn('{{%user_purse_spendings}}', 'updated_at');
    }

}
