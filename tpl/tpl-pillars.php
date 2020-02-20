<?php
    include str_replace('/tpl','',__DIR__) . '/functions.php';
?>
<div class="wrapper">
    <div class="bg"></div>
        <h1 style="display: none">A Page of Pillars</h1>
    <div class="pillars">
        <?php getPillars( 'image' ); ?>
    </div>

    <div class="pillarTitles">
        <div>
            <?php getPillars( 'list' ); ?>
        </div>
    </div>
    
    <div class="markers">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    
</div>

<div class="leftBorder"></div>
<div class="rightBorder"></div>
<div class="bottomBorder"></div>
<div class="topBorder"></div>


<article>
    <h1 style="display: none">An individual Pillar with stories</h1>
    <section id="opening">
        <div class="container"></div>
        <div id="disclaimer">* The metrics below are for the 2018 - 2019 school year.</div>
    </section>
    <section id="stats"></section>
    <section id="highlights">
    </section>
    <footer>
        <img src="img/ouicon.svg" alt="OU Libraries Logo"/>
    </footer>
</article>

<div id="sidebar">
    <a href="#" class="close"><span style="display:none;">Close</span><i class="fa fa-times"></i></a>
<!--    <img src="https://images.unsplash.com/photo-1563861826100-9cb868fdbe1c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" />-->
    <div class="content">
<!--        <h3>Lorem Ipsum Dolor Sit Amet</h3>-->
<!--        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
<!--        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
    </div>
</div>

<div class="overlay"></div>