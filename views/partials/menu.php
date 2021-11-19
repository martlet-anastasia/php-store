<?php
$menu = [
        ['name' => 'Home', 'link' => '/'],
        ['name' => 'Catalog', 'link' => '/catalog'],

];
?>

<!-- NAVIGATION -->
<nav id="navigation">
    <?php
    $url = $_SERVER['REQUEST_URI'];
    ?>
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <?php foreach ($menu as $item): ?>
                <li <?php if($url == $item['link']) {echo 'class="active"';}?>><a href="<?=$item['link']?>"><?=$item['name']?></a></li>
                <?php endforeach; ?>
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
<!-- /NAVIGATION -->
