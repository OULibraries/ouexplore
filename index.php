<?php include str_replace('/tpl','',__DIR__) . '/functions.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <title>Explore OU Libraries</title>

  <!-- Styles-->
  <link rel="stylesheet" href="css/ovg3oac.css">
  <link rel="stylesheet" href="css/style.css" />

  <!-- Scripts -->
  <script type="text/javascript" src="js/all.js"></script>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/debounce.js"></script>
  <script type="text/javascript" src="js/mousewheel.js"></script>
  <script type="text/javascript" src="js/viewport.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
  <script type="text/javascript" src="js/wurfl.js"></script>
</head>
<body>

<!-- Navigation -->
<nav role="navigation">
  <a href="#" class="back"><span style="display:none;">Back Button</span><i class="fa fa-arrow-left"></i></a>
  <a href="" class="logo"><img src="img/ou-logo-color.png" alt="OU Logo"/></a>
  <div>
    <a href="#" id="contribution">Contribute</a>
    <a class="open_menu" href="#" data-action="openMenu"><span style="display:none;">Menu</span><i class="fa fa-bars"></i></a>
  </div>
</nav>

<div class="menu">
  <ul>
    <li><a href="#" class="explore_home">Explore</a></li>
    <!-- <li><a href="#issues">Issues</a></li> -->
    <li><a href="#" id="contribution">Contribute</a></li>
    <li><a href="#" id="contacted">Contact</a></li>
    <!--                    <li><a href="#publications">Publications</a></li>-->
  </ul>
  <a class="close"><span style="display:none;">Close</span><i class="fa fa-times"></i></a>
</div>

<!-- Main -->
<div class="main_container" role="main">
  <?php include 'tpl/tpl-intro.php'; ?>
</div>

</body>
</html>