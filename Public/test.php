<?php
session_start();
require_once '../vendor/autoload.php';

use Rignchen\Forms\FormBuilder;
use Rignchen\Forms\FormTypes;

$form = new FormBuilder('get');
$form->add(new FormTypes\ResetButton('reset'));
$form_renderer = $form->render();
?>

<?= $form_renderer->open() ?>
<?= $form_renderer->get('reset') ?>
<?= $form_renderer->close() ?>
