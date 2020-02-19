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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <title><?php echo Configure::read('LSA.lsa_site_name') ?></title>

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

        echo '<a href="/pages/eligibility">Eligibility</a>';
        echo '<a href="/registrations/register">Register</a>';
        echo '<a href="/pages/ceremony">Ceremony</a>';
        echo '<a href="/pages/travel">Travel</a>';
        echo '<a href="/pages/Volunteer">Volunteer</a>';
        if ($session->read('user.role') <> 0) {
            echo '<a href="/registrations">Admin</a>';
        }
        ?>


    </div>
  </nav>

    <main id="ceremony-info" class="main">
            <div class="container">
                <div class="info-text">
                    <h2>Eligibility</h2>
                    <p>
                        Eligibility info goes here.
                    </p>
                </div>


          </div>
    </main>
</body>


</html>
