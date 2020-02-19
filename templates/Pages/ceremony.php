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
                <div id="header-container" class="row">
                  <img src="/img/ceremony.jpg">
                </div>
                <div class="row info-text">
                    <h2>Ceremony</h2>
                    <p>
                        You will be welcomed to Government House for an evening of celebration, delicious food, live music and dancing,
                        individual award presentations, and an opportunity to connect iwth fellow BC Public Servicde eomployees and executive.
                    </p>
                    <p>
                        You do not need to bring your invitation with you.
                    </p>
                </div>

                <div id="ceremony-schedule">
                    <div>
                        <h3>Schedule</h3>
                        <p>5:45 - 6:15 p.m. | Registration, reception and welcome</p>
                        <p>6:15 - 7:30 p.m. | Dinner buffet</p>
                        <p>7:20 - 7:40 p.m. | Speeches</p>
                        <p>7:40 - 8:30 p.m. | Awards presentation</p>
                        <p>8:00 p.m. | Desset buffet</p>
                        <p>9:00 - 10:00 p.m. | Dancing</p>
                        <p>10:00 p.m. | Evening concludes</p>
                    </div>
                    <div>
                        <img src="/img/band.jpg">
                    </div>
                </div>

                <div class="row">
                    <h3>Award Presentation</h3>
                    <div>
                      <p>
                          You will be escorted into the Drawing Room for a relaxed award presentation with the minister and
                          your executive. Your guest is welcome to join you and take photographs during your presentation.
                        </p>
                        <p>
                          A professional photographer will also take photos of your award presentation and a copy will be sent
                          to you electronically after the ceremonies.
                        </p>
                      </div>
                </div>

                <div id="ceremony-dinner">
                  <div>
                      <img src="/img/dinner.jpg">
                  </div>
                    <div>
                        <h3>Dinner</h3>
                        <p>
                          Long Service Award dinners are buffet-style and include a variety of choices for many dietary needs.
                          If you or your quest have severe food allergies, please be sure to let us know when you RSVP.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <h3>Accessibility</h3>
                    <div>
                      <p>
                        The Long Service Award ceremonies are inclusive and accessible events with free parking available onsite.
                        </p>
                        <p>
                          To ensure you and your guest enjoy the festivities, please share your accessibility requirements when
                          you RSVP (e.g. request for American Sign Language interpreter, guide dog accommodations, accessible parking
                          and/or seating, etc.). A rampe is avialable for accessible entrance into Government House, as well as
                          accessible and gener-neutral washrooms.
                        </p>
                        <p>
                          In consideration of people who have scent allergies or sensitivities, please refrain from wearing heavily scented products.
                        </p>
                      </div>
                </div>

                <div>
                  <div>
                    <h3>Questions</h3>
                  </div>
                  <div>
                    <p>
                      If you have questions, please meail the <a href="mailto:LongServiceAwards@gov.bc.ca">Long Service Award team</a> prior to your ceremony date.
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



</html>
