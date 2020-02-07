<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();


$cakeDescription = 'Long Service Awards';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">

    <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('home.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="container text-center">
            <a href="/" target="_blank">
                <img alt="Long Service Awards" src="img/lsa_logo.png" width="150" />
            </a>
            <h1>
                Welcome to Long Service Awards
            </h1>
        </div>
    </header>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <div class="content">
                <div class="row">
                    <div class="column">
                        <h4>Long Service Awards Contact</h4>
                        <ul>
                            <li class="bullet"><?php echo Configure::read('LSA.lsa_contact_name') ?></li>
                            <li class="bullet"><?php echo Configure::read('LSA.lsa_contact_email') ?></li>
                            <li class="bullet"><?php echo Configure::read('LSA.lsa_contact_phone') ?></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="column">
                        <button type="button" class="btn btn-primary" onclick="register()">Register</button>
                    </div>
                    <div class="column">
                        <?php
                            $session = $this->getRequest()->getSession();
                            if ($session->read('user.role') <> 0) {
                                echo '<button type="button" class="btn btn-primary" onclick="admin()">Admin</button>';
                            }
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </main>
</body>

<script>
    function register() {
        location.href = "/registrations/register";
    }

    function admin() {
        location.href = "/registrations";
    }
</script>

</html>
