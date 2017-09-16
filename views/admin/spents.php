<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use jarrus90\Currencies\Models\Currency;
$this->beginContent("@jarrus90/UserPurse/views/admin/_layout.php", ['user' => $user, 'purse' => $purse]);
?>
<div id="spent-popup" class="fade modal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <?php
            $form = ActiveForm::begin([
                        'action' => Url::toRoute(['spend', 'id' => $user->id]),
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'formConfig' => ['labelSpan' => 3]
            ]);
            ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                    <?= Yii::t('user-purse', 'Spent'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <?= $form->field($formSpent, 'amount') ?>
                <?=
                $form->field($formSpent, 'currency')->widget(Select2::className(), [
                    'theme' => 'default',
                    'data' => Currency::listMap(),
                    'options' => [
                        'placeholder' => Yii::t('user-purse', 'Select currency'),
                    ],
                ]);
                ?>
                <?= $form->field($formSpent, 'description') ?>
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
<?php
echo GridView::widget([
    'dataProvider' => $dataSpentsProvider,
    'filterModel' => $filterSpentsModel,
    'pjax' => true,
    'hover' => true,
    'export' => false,
    'id' => 'list-spents-table',
    'layout' => "{toolbar}{items}{pager}",
    'pager' => ['options' => ['class' => 'pagination pagination-sm no-margin']],
    'options' => [
        'class' => 'tab-content'
    ],
    'toolbar' => [
        ['content' =>
            Html::a(Yii::t('user-purse', 'Add spent'), NULL, [
                'data-pjax' => 0,
                'data-toggle' => 'modal',
                'data-target' => '#spent-popup',
                'class' => 'btn btn-default',
                'title' => Yii::t('user-purse', 'Refill')]
            ) .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::toRoute(['', 'id' => $user->id]), [
                'class' => 'btn btn-default',
                'title' => Yii::t('user-purse', 'Reset filter')]
            )
        ],
    ],
    'panel' => [
        'type' => \kartik\grid\GridView::TYPE_DEFAULT
    ],
    'columns' => [
        [
            'attribute' => 'amount',
            'width' => '15%',
            'content' => function ($model) {
                return Yii::$app->formatter->asCurrency($model->amount, 'RUR');
            }
        ],
        [
            'attribute' => 'created_at',
            'format' => 'datetime',
            'width' => '20%'
        ],
        [
            'attribute' => 'description',
            'width' => '65%'
        ],
    ],
]);
$this->endContent();