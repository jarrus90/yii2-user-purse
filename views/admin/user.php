<?php
/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View 					$this
 * @var jarrus90\User\models\User 		$user
 * @var jarrus90\User\models\Profile 	$profile
 */
?>

<?php $this->beginContent('@jarrus90/User/views/admin/update.php', ['user' => $user]) ?>
<?php var_dump($purse->purse_amount); ?>
<?php $this->endContent() ?>
