<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
        <?php $this->beginBody() ?>
        <?= $this->render('_header') ?> 

        <div class="container-fluid fixed-m">
            <?= $content ?>
        </div>




        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
