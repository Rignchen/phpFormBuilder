<?php
session_start();
require_once 'vendor/autoload.php';

use Rignchen\Forms\FormBuilder;
use Rignchen\Forms\FormTypes;

$users = [
    'admin' => password_hash('admin', PASSWORD_BCRYPT),
    'user' => password_hash('user', PASSWORD_BCRYPT),
];
if (!isset($_SESSION['usernames'])) $_SESSION['usernames'] = [];
$current_user = null;
$form = new FormBuilder('safe_post');
$form->addList([
    new FormTypes\ResetButton('reset'),
    new FormTypes\TextInput('name', '', function ($value) {
        $_SESSION['usernames'][] = $value;
    }, 'pomme'),
    new FormTypes\PasswordInput('password', function ($value) {
        global $users, $current_user;
        if ($value !== null) foreach ($users as $user => $hash) if (password_verify($value, $hash)) $current_user = $user;
    }),
    new FormTypes\TextArea('bio'),
    new FormTypes\ColorInput('skin'),
    new FormTypes\NumberInput('age', '', null, 0, 100, 10, 55),
    new FormTypes\CheckboxInput('agree'),
    new FormTypes\Select('gender', ["Prefer not to say","Men","Women","Other"], 3),
    new FormTypes\SubmitButton('submit')
]);
$form_renderer = $form->render();
?>

<?php if (isset($current_user)): ?>
    <h1>Welcome, <?= $current_user ?></h1>
<?php endif ?>

<?= $form_renderer->open() ?>
<?= $form_renderer->get('name') ?>
<?= $form_renderer->get('password') ?>
<?= $form_renderer->get('bio') ?>
<?= $form_renderer->get('skin') ?>
<?= $form_renderer->get('age') ?>
<?= $form_renderer->get('gender') ?>
<?= $form_renderer->get('agree') ?> <?= $form_renderer->label('agree', 'I agree to the terms and conditions') ?>
<?= $form_renderer->get('submit') ?>
<?= $form_renderer->get('reset') ?>
<?= $form_renderer->close() ?>

<?php dump($_SESSION) ?>

<ul>
    <?php foreach ($_SESSION['usernames'] as $username): ?>
        <li><?= $username ?></li>
    <?php endforeach ?>
</ul>
