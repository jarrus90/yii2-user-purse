<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;

class Purse extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%user_purse}}';
    }

}
