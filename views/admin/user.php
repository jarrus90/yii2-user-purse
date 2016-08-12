<?php
/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use jarrus90\Currencies\Models\Currency;

/**
 * @var yii\web\View 					$this
 * @var jarrus90\User\models\User 		$user
 * @var jarrus90\User\models\Profile 	$profile
 */
?>

<div id="refill-popup" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <?php
            $form = ActiveForm::begin([
                        'action' => Url::toRoute(['refill']),
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'formConfig' => ['labelSpan' => 3]
            ]);
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                    <?= Yii::t('user-purse', 'Refill'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $form->field($formRefill, 'amount') ?>
                <?=
                $form->field($formRefill, 'currency')->widget(Select2::className(), [
                    'theme' => 'default',
                    'data' => Currency::listMap(),
                    'options' => [
                        'placeholder' => Yii::t('user-purse', 'Select currency'),
                    ],
                ]);
                ?>
                <?= $form->field($formRefill, 'source') ?>
                <?= $form->field($formRefill, 'description') ?>
            </div>
            <div class="modal-footer">
            <?= Html::submitButton(Yii::t('user-purse', 'Save'), ['class' => 'btn btn-success ']); ?>
            </div>
            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
<?php $this->beginContent('@jarrus90/User/views/admin/update.php', ['user' => $user]) ?>
    <?= Yii::t('user-purse', 'Purse') ?>
<?=
Html::a('<i class="glyphicon glyphicon-plus"></i>', NULL, [
    'data-pjax' => 0,
    'data-toggle' => 'modal',
    'data-target' => '#refill-popup',
    'class' => 'btn btn-default',
    'title' => Yii::t('user-purse', 'Add refill')]
);
?>
<?php var_dump($purse->purse_amount); ?>
<?php $this->endContent() ?>
