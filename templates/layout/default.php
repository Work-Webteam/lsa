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
    <?php include 'header.php'; ?>
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
                    echo '<a href="/registrationperiods">Reg.Periods</a>';
                    echo ' |  <a href="/userroles">Access</a>';
                }
                if ($session->read('user.role') == 1) {
                    echo ' | <a href="/pecsfregions">Regions</a>';
                    echo ' <a href="/pecsfcharities">Charities</a>';
                    echo ' <a href="/roles">Roles</a>';
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
