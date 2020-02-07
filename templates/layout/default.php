<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */


?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta
        content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/lux/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title>Long Service Awards</title>

    <?= $this->Html->css('milligram.min.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('lsa.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="/"><span><img src="/img/lsa_logo.png" class="lsa-logo"></span></a>
        </div>
        <div class="top-nav-links">
            <?php
                $session = $this->getRequest()->getSession();
                if ($session->read('user.role') <> 0) {
                    echo '<a href="/registrations">Admin</a>';
                }
                if (in_array($session->read('user.role'), array(1,2))) {
                    echo '<a href="/ceremonies">Ceremonies</a>';
                    echo '<a href="/awards">Awards</a>';
                    echo '<a href="/milestones">Milestones</a>';
                    echo '<a href="/cities">Cities</a>';
                    echo '<a href="/ministries">Ministries</a>';
                    echo '<a href="/diet">Diet</a>';
                    echo ' |  <a href="/userroles">Access</a>';
                }
                if ($session->read('user.role') == 1) {
                    echo ' | <a href="/pecsfregions">Regions</a>';
                    echo ' <a href="/pecsfcharities">Charities</a>';
                }
            ?>


        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
