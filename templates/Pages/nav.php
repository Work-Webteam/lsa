<nav class="top-nav  navbar navbar-expand-lg navbar-dark">

    <!-- Brand -->
    <a href="/"><span><img src="/img/lsa_logo.png" class="navbar-brand lsa-logo"></span></a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link lsa-nav-link" href="/eligibility">Eligibility</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/ceremony">Ceremony</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/travel">Travel</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/Volunteer">Volunteer</a>
        </li>
        <?php
            $session = $this->getRequest()->getSession();

            if ($session->read('user.role') <> 0) {
        ?>
            <li class="nav-item">
                <a class="nav-link" href="/registrations">Admin</a>
            </li>

        <?php
            }
        ?>


    </ul>





</nav>
