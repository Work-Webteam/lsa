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

    <main id="home-page" class="main">
            <div class="container">
                <div id="flash-container">
                    <?= $this->Flash->render() ?>
                </div>
                <div id="home-header-container" class="row">
                  <img src="/img/government-house.jpg">
                    <div class="centered">
                      <h1><?php echo Configure::read('LSA.lsa_site_name') ?></h1>
                    </div>
                </div>
                <div class="row info-text">
                  <h2>Celebrating Your Loyal Service</h2>
                  <p>
                    Every year, we celebrate the dedication and commitment of employees with 25+ years in the BC Public Service
                  </p>
                  <p>
                    Long Service Award ceremonies are prestigious and memorable events held at Government House. Government House
                        is the official residence of B.C.'s Lieutenant Governor and the ceremonial home of all British Columbians.
                    </p>
                    <p>
                        Upon your arrival, volunteers will usher you into the grand ballroom for a night of celebration. Enjoy
                        a gourmet meal while you take in remarks from notable attendees including the Lieutenant Governor, if in attendance.
                        Receive your chosen award druing an intimate presentation and cap the night of with live music and
                        decadent desserts!
                    </p>
                </div>

                <div class="row">
                    <h2>Check Your Eligibility</h2>
                    <p>
                        Register to celebrate your Long Service milestone if you have 25, 30, 35, 40, 45, 50+ years working for
                        an eligible BC Public Service organization.
                    </p>
                    <p>
                        Long service time is cumulative. If you've had a break in service, that time still counts twoard your years of service.
                        Breaks in service may include times when you took paid leave or worked part-time or seasonally.
                    </p>
                    <button type="button" class="btn btn-primary" onclick="checkEligibility()">Check Eligibility</button>
                </div>

                <div class="row">
                    <h2>Register</h2>
                    <p>
                        If you're eligible for a long service milestone, you'll need to register between March and June. Once you've
                        registered, your supervisor will be notified and you'll receive an official invitation in September with your
                        ceremony date.
                    </p>
                    <p>
                        You invitation will include a link to RSVP. This is where you can let us know about your dietary restrictions,
                        accessibility requirements and if you will be bringing a guest.
                    </p>
                    <button type="button" class="btn btn-primary" onclick="register()">Register</button>
                </div>


                <div class="row">
                    <h2>Travel</h2>
                    <div>
                    <p>
                        Your travel arrangements need to be approved by your supervisor or organization's LSA contact.
                    </p>
                    <p>
                        It's recommended that you book your travel as soon as you've confirmed your attendance to the ceremony.
                        For information on travel politices, check out the Policy section.
                    </p>
                    <p>
                        Reimbursement processes vary for each organization, so confirm this with your LSA contact prior to traveling.
                    </p>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="travel()">Travel</button>
                </div>


                <div class="row">
                    <div class="column">
                        <h2>Volunteer</h2>
                        <p>Volunteer info text goes here.</p>
                    </div>
                    <div class="column">
                        <h2>Accessibility</h2>
                        <p>Accessibility info text goes here.</p>
                    </div>
                    <div class="column">
                        <h2>Defer Attendance</h2>
                        <p>
                            If you're unable to attend the ceremony in the year you register, you can defer to the following year.
                            Your award will be sent to your ministry and presented to you by your supervisor, in the year you registered.
                            Unfortunately, we cannot accommodate switching ceremony nights as each employee is scheduled to attend wit their ministry
                            and executive members. If your ministry has another ceremony date schedule, email the Long Service Award team with your request.
                        </p>
                    </div>
                </div>

            </div>


            <div id="page-footer" class="container">
            <div >
                <h4>Questions?</h4>
                <div>
                  <p>
                      Email YOURMINISTRY@gov.bc.ca or LongServiceAwards@gov.bc.ca
                    </p>
                  </div>
            </div>

            <div class="row">
                <h4>Territorial Acknowledgement</h4>
                <p>
                    The Long Service Award ceremonies take place in the territory of the Lekwungen Peoples, also known as Songhees and Esquimalt Nations.
                    We acknowledge with respect that the public servants these ceremonies honor live and work throughout B.C. on the traditional lands of
                    Indigenous peoples. The BC Public Service is deeply committed to <u>true and lasting reconciliation</u>.
                </p>

            </div>
          </div>
    </main>
</body>

<script>
    function checkEligibility() {
        location.href = "/eligibility";
    }

    function register() {
        location.href = "/register";
    }

    function travel() {
        location.href = "/travel";
    }
</script>

</html>
