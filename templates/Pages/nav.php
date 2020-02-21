<nav class="top-nav">

    <div class="top-nav-title">
        <a href="/"><span><img src="/img/lsa_logo.png" class="lsa-logo"></span></a>
    </div>

    <div class="top-nav-links">
        <?php
        $session = $this->getRequest()->getSession();

        echo '<a href="/eligibility">Eligibility</a>';
        echo '<a href="/register">Register</a>';
        echo '<a href="/ceremony">Ceremony</a>';
        echo '<a href="/travel">Travel</a>';
        echo '<a href="/volunteer">Volunteer</a>';
        if ($session->read('user.role') <> 0) {
            echo '<a href="/registrations">Admin</a>';
        }
        ?>

    </div>

</nav>
