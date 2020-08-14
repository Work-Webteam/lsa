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
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link lsa-nav-link" href="/registrations">Registrations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/ceremonies">Ceremonies</a>
        </li>
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Reports
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/registrations/reportawards">Awards</a>
                <a class="dropdown-item" href="/registrations/reportawardtotalsceremony">Award Totals - by Ceremony</a>
                <a class="dropdown-item" href="/registrations/reportawardtotalsmilestone">Award Totals - by Milestone</a>
                <a class="dropdown-item" href="/registrations/reportcertificatesmilestone">Certificates - Milestone</a>
                <a class="dropdown-item" href="/registrations/reportcertificatespecsf">Certificates - PECSF Donation</a>
                <a class="dropdown-item" href="/registrations/reportwatches">Watch Report</a>
                <a class="dropdown-item" href="/registrations/reportlsaprogram">LSA Program Data</a>
                <a class="dropdown-item" href="/registrations/awardsummary">Award Summary</a>
                <a class="dropdown-item" href="/registrations/ministrysummary">Ministry Summary</a>
                <a class="dropdown-item" href="/registrations/milestonesummary">Milestone Summary</a>
                <a class="dropdown-item" href="/registrations/exportrecipients">Export Recipients</a>
                <a class="dropdown-item" href="/registrations/exportspecialrequirements">Special Requirements</a>
                <a class="dropdown-item" href="/registrations/reportministryrsvp">RSVP Summary</a>
                <a class="dropdown-item" href="/registrations/reportministryrecipients">Ministry Recipients</a>
                <a class="dropdown-item" href="/registrations/reportpivot/0">Pivot - All Recipients</a>
                <a class="dropdown-item" href="/registrations/reportpivot/1">Pivot - Attending Only</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/registrations/archive">Archive</a>
        </li>
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Maintenance
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="/registrationperiods">Registration Periods</a>
                <a class="dropdown-item" href="/awards">Awards</a>
                <a class="dropdown-item" href="/milestones">Milestones</a>
                <a class="dropdown-item" href="/ministries">Ministries</a>
                <a class="dropdown-item" href="/diet">Diet</a>
                <a class="dropdown-item" href="/accessibility">Accessibility</a>
                <a class="dropdown-item" href="/cities">Cities</a>
                <a class="dropdown-item" href="/pecsfregions">Regions</a>
                <a class="dropdown-item" href="/pecsfcharities">Charities</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/userroles">Admin Access</a>
                <a class="dropdown-item" href="/log">Log</a>
            </div>
        </li>


    </ul>
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
