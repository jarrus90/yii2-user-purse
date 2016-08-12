<?php

use yii\helpers\Url;
$this->beginContent('@jarrus90/User/views/admin/update.php', ['user' => $user]);
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="<?= (Yii::$app->controller->action->id == 'refills') ? 'active' : ''; ?>">
            <a href="<?= Url::toRoute(['refills', 'id' => $user->id]); ?>" aria-expanded="true">
                <?= Yii::t('user-purse', 'Refills'); ?>
            </a>
        </li>
        <li class="<?= (Yii::$app->controller->action->id == 'spents') ? 'active' : ''; ?>">
            <a href="<?= Url::toRoute(['spents', 'id' => $user->id]); ?>" aria-expanded="true">
                <?= Yii::t('user-purse', 'Spents'); ?>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="refills">
            <?= $content; ?>
        </div>
    </div>
</div>
<?php
$this->endContent();
$this->params['breadcrumbs'][] = Yii::t('user-purse', 'Purse');