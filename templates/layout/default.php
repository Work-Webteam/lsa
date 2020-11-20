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

<nav class="top-nav navbar navbar-expand-lg navbar-dark">
    <!-- Brand -->
    <a href="/"><span><img src="/img/lsa_logo.png" class="navbar-brand lsa-logo"></span></a>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="main_nav">
    <ul class="navbar-nav navbar-right" >
 <!-- Dropdown -->
 <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Recipients
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/registrations">Recipients Dashboard</a></li>
                <li><a class="dropdown-item" href="/registrations/milestonesummary">Total by Milestone</a></li>
                <li><a class="dropdown-item" href="/registrations/reportministryrecipients">Total by Ministry</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item" href="/registrations/exportrecipients">Export Recipients</a></li>
                <li><a class="dropdown-item" href="/registrations/reportministryrecipients_copy">Export Recipients by Ministry</a></li>
                <li><a class="dropdown-item" href="/registrations/reportpivot/0">Pivot - All Recipients</a></li>
                <li><a class="dropdown-item" href="/registrations/reportpivot/1">Pivot - Attending Only</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Ceremonies
        </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/ceremonies">Ceremony Dashboard</a></li>
                <li><a class="dropdown-item" href="/executives">Executives Dashboard</a></li>
                <li><a class="dropdown-item" href="/registrations/reportministryrsvp">RSVPs by Ceremony</a></li>
                <li><a class="dropdown-item" href="/registrations/reportwaitinglist">Wait List</a></li>
                <div class="dropdown-divider"></div>
                <!--<li><a class="dropdown-item" href="/vip">Executives</a></li> -->
                <li><a class="dropdown-item" href="/registrations/exportspecialrequirements">Accessibility and Dietary</a></li>
            </ul>
        </li>

        <?php
        $params = $this->getRequest()->getAttribute('params');

            if ($params['action'] == 'attendingrecipients') {
            ?>


                <li class="nav-item dropdown">
                    <a class="nav-link  dropdown-toggle" href="#" data-toggle="dropdown">Reports</a>
                    <ul class="dropdown-menu admin-drop-1">
                        <li><a class="dropdown-item" href="/registrations/ceremonyaccessibility/<?= $ceremony_id ?>">Accessibility</a></li>
                        <li><a class="dropdown-item" href="/registrations/ceremonydiet/<?= $ceremony_id ?>">Diet</a></li>
                        <li><a class="dropdown-item" href="/registrations/ceremonyawards/<?= $ceremony_id ?>/1">Awards - Attending</a></li>
                        <li><a class="dropdown-item" href="/registrations/ceremonyawards/<?= $ceremony_id ?>/0">Awards - Not Attending</a></li>
                        <li><a class="dropdown-item" href="/registrations/ceremonysummary/<?= $ceremony_id ?>">Summary</a></li>
                        <li><a class="dropdown-item" href="/registrations/reportrecipientsbyceremony/<?= $ceremony_id ?>">Recipient Names</a></li>
                        <li><a class="dropdown-item" href="/registrations/exportbadges/<?= $ceremony_id ?>">Recipient Name Badges</a></li>
                        <li><a class="dropdown-item" href="/vip/exportbadges/<?= $ceremony_id ?>">VIP Name Badges</a></li>
                        <li><a class="dropdown-item" href="/vip/reportceremony/<?= $ceremony_id ?>">VIP Report</a></li>
                        <li><a class="dropdown-item" href="/vip/exportplacecards/<?= $ceremony_id ?>">VIP Placecards</a></li>
                    </ul>
                </li>

            <?php
        }
        ?>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Awards
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/registrations/reportawards">Awards Dashboard</a></li>
                <li><a class="dropdown-item" href="/registrations/awardsummary">Totals by Award Type</a></li>
                <li><a class="dropdown-item" href="/registrations/reportawardtotalsceremony">Totals by Ceremony</a></li>
                <li><a class="dropdown-item" href="/registrations/reportawardtotalsmilestone">Totals by Milestone</a></li>
                <li><a class="dropdown-item" href="/registrations/reportcertificatesmilestone">25 Year Certificates</a></li>
                <li><a class="dropdown-item" href="/registrations/reportcertificatespecsf">PECSF Donation Certificates</a></li>
                <li><a class="dropdown-item" href="/registrations/reportwatches">Watch Report</a></li>
            </ul>
        </li>


        <!-- Dropdown -->
        <!--<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop-reports" data-toggle="dropdown">
                Exports
            </a>
            <ul class="dropdown-menu" admin-drop-2>
                <li><a class="dropdown-item" href="/registrations/reportlsaprogram">LSA Program Data</a></li>

            </ul>
        </li> -->
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Settings
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/registrationperiods">Registration Periods</a>
                <a class="dropdown-item" href="/awards">Awards</a>
                <a class="dropdown-item" href="/milestones">PECSF Donations</a>
                <a class="dropdown-item" href="/ministries">Ministries</a>
                <a class="dropdown-item" href="/diet">Diet</a>
                <a class="dropdown-item" href="/accessibility">Accessibility</a>
                <a class="dropdown-item" href="/categories">VIP Categories</a>
                <a class="dropdown-item" href="/cities">Cities</a>
                <a class="dropdown-item" href="/pecsfregions">PECSF Regions</a>
                <a class="dropdown-item" href="/pecsfcharities">PECSF Charities</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/userroles">System Permissions</a>
                <a class="dropdown-item" href="/registrations/archive">Archive Database</a>
                <a class="dropdown-item" href="/log">Log</a>
            </div>
        </li>


    </ul>

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

