<?php include str_replace('/tpl','',__DIR__) . '/functions.php'; ?>
<!doctype html>
    <html lang="en">
        <head>
            <title>Explore OU Libraries</title>

            <!-- Styles-->
            <link rel="stylesheet" href="https://use.typekit.net/ovg3oac.css">
            <link rel="stylesheet" href="css/style.css" />

            <!-- Scripts -->
            <script defer src="https://use.fontawesome.com/releases/v5.7.1/js/all.js" integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script type="text/javascript" src="js/debounce.js"></script>
            <script type="text/javascript" src="js/mousewheel.js"></script>
            <script type="text/javascript" src="js/viewport.js"></script>
            <script type="text/javascript" src="js/main.js"></script>
        </head>
        <body>

            <!-- Navigation -->
            <nav role="navigation">
                <a href="#" class="back"><span style="display:none;">Back Button</span><i class="fa fa-arrow-left"></i></a>
                <a href="" class="logo"><img src="img/ou-logo-color.png" alt="OU Logo"/></a>
                <div>
                    <a href="#" id="contribution">Contribute</a>
                    <a href="#" data-action="openMenu"><span style="display:none;">Menu</span><i class="fa fa-bars"></i></a>
                </div>
            </nav>

            <div class="menu">
                <ul>
                    <li><a href="">Explore</a></li>
                    <!-- <li><a href="#issues">Issues</a></li> -->
                    <li><a href="#" id="contribution">Contribute</a></li>
                    <li><a href="#" id="contacted">Contact</a></li>
<!--                    <li><a href="#publications">Publications</a></li>-->
                </ul>
                <a href="#" class="close"><span style="display:none;">Close</span><i class="fa fa-times"></i></a>
            </div>

            <!-- Main -->
            <div role="main">
                <?php include 'tpl/tpl-intro.php'; ?>
            </div>

        </body>
    </html>