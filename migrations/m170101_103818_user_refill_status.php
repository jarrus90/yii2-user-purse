<?php

namespace jarrus90\UserPurse\migrations;

use Yii;
use jarrus90\UserPurse\Models\PurseRefill;

class m170101_103818_user_refill_status extends \yii\db\Migration {

    /**
     * Create table.
     */
    public function safeUp() {
        $this->addColumn('{{%user_purse_refill}}', 'status', $this->integer()->defaultValue(PurseRefill::STATUS_NEW));
    }

    /**
     * Create table.
     */
    public function safeDown() {
        $this->dropColumn('{{%user_purse_refill}}', 'status');
    }

}
