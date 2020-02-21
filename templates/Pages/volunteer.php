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
    <?php include 'header.php'; ?>
</head>

<body>

    <?php include 'nav.php'; ?>

    <main id="ceremony-info" class="main">
            <div class="container">
                <div class="info-text">
                    <h2>Volunteer</h2>
                    <p>
                        Volunteer info goes here.
                    </p>
                </div>


          </div>
    </main>
</body>


</html>
