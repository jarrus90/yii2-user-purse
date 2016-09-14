<?php

use yii\helpers\Url;
$this->beginContent('@jarrus90/User/views/admin/update.php', ['user' => $user]);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('user-purse', 'Current purse value:'); ?> <?= Yii::$app->formatter->asCurrency($purse->purse_amount, 'RUR'); ?></h3>
    </div>
</div>
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