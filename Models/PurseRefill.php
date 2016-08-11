<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;

class PurseRefill extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%user_purse_refill}}';
    }

}
