<?php

include("autoload.php");

use Plancke\HypixelPHP\HypixelPHP;
use Plancke\HypixelPHP\color\ColorParser;
use Plancke\HypixelPHP\cache\impl\NoCacheHandler;
$HypixelPHP = new HypixelPHP("");
$HypixelPHP->setCacheHandler(new NoCacheHandler($HypixelPHP));

$guild = $HypixelPHP->getGuild(['byName' => 'Galex']);
$memberList = $guild->getMemberList();
$tagColor = (new ColorParser)::DEFAULT_COLOR_HEX_MAP[$guild->getTagColor()];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Jackelele | Panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="assets\vendors.css">
    <link rel="stylesheet" type="text/css" href="assets\style.css">
    <!-- Plugins -->
    <script src="https://kit.fontawesome.com/56d4802990.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="app">
        <div class="app-wrap">
            <header class="app-header top-bar">
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="fas fa-align-right"></i></a>
                        <a class="navbar-brand" href="index.html">
                            J
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="navigation d-flex">
                            <ul class="navbar-nav nav-left">
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link sidebar-toggle">
                                        <i class="fas fa-align-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
<!-- Modal for Security Nav -->
            <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Security Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            The Security pages are currently unavailable. This website is protected by SSL via MyEncrypt. For more information about this please contact myself.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success">This does nothing..</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--- -->
            <div class="app-container">
                <aside class="app-navbar">
                    <div class="sidebar-nav scrollbar scroll_light">
                        <ul class="metismenu " id="sidebarNav">
                            <li class="nav-static-title">Personal</li>
                            <li><a href="index.html" aria-expanded="false"><i class="nav-icon fas fa-rocket"></i><span class="nav-title">Home</span></a> </li>
                            <li><a href="https://github.com/Jackelele" target="_blank" aria-expanded="false"><i class="nav-icon fab fa-github"></i><span class="nav-title">Github</span></a></li>
                            <li><a href="https://webmail.jackelele.co.uk" aria-expanded="false"><i class="nav-icon fas fa-inbox"></i><span class="nav-title">Mail</span></a> </li>
                            <li><a href="#" data-toggle="modal" data-target="#defaultModal" aria-expanded="false"><i class="nav-icon fas fa-key"></i><span class="nav-title">Security</span></a></li>

                            <li class="nav-static-title">Hypixel</li>
                            <li class="active"> 
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="true"><i class="nav-icon fas fa-chart-bar"></i> <span class="nav-title">Statistics</span> <span class="nav-label label label-success">New</span> </a>
                                <ul aria-expanded="true">
                                    <li class="active"> <a href="widget-chart.html">Galex Statistics</a> </li>
                                    <li> <a href="widget-list.html">Player Statistics</a></li>
                                    <li> <a href="widget-social.html">Server Statistics</a> </li>
                                </ul>
                            </li>
                            <li><a href="#" aria-expanded="false"><i class="nav-icon fas fa-info"></i></i><span class="nav-title">Galex Info</span></a> </li>
                            <li><a href="#" aria-expanded="false"><i class="nav-icon fas fa-info"></i></i><span class="nav-title">Hypixel Website</span></a> </li>
                            <li><a href="#" aria-expanded="false"><i class="nav-icon fas fa-info"></i></i><span class="nav-title">Mods & Clients</span></a> </li>
                            <li class="nav-static-title">More</li>
                            <li>
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="nav-icon far fa-file"></i></i><span class="nav-title">Info</span><span class="nav-label label label-primary">6</span></a>
                                <ul aria-expanded="false">
                                    <li> <a href="page-employees.html">Team Members</a></li>
                                    <li> <a href="page-faq.html">FAQ</a></li>
                                    <li> <a href="page-gallery.html">Photography</a></li>
                                    <li> <a href="page-pricing.html">Services</a> </li>
                                    <li> <a href="page-task-list.html">Project Progress</a></li>
                                </ul>
                            </li>
                            <li><a href="#" aria-expanded="false"><i class="nav-icon fas fa-id-card"></i></i><span class="nav-title">Contact Me</span></a></li>
                            <li class="nav-static-title">Copyright</li>
                            <li><a href="#" aria-expanded="false"><i class="nav-icon fas fa-id-badge"></i></i></i><span class="nav-title">Licenses</span></a></li>
                            <li class="sidebar-banner p-4 bg-gradient text-center m-3 d-block rounded">
                                <h5 class="text-white mb-1">&copy; Jackelele</h5>
                                <p class="font-13 text-white line-20">2017 - <script>document.write(new Date().getFullYear())</script></p>
                            </li>
                        </ul>
                    </div>
                </aside>
                <div class="app-main" id="main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <div class="d-block d-sm-flex flex-nowrap align-items-center">
                                    <div class="page-title mb-2 mb-sm-0">
                                        <h1>Galex Statistics</h1>
                                    </div>
                                    <div class="ml-auto d-flex align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="Stats.html"><i class="fas fa-chart-bar"></i>Statistics</a>
                                                </li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-pink">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0"><?php echo $guild->getMemberCount(); ?></h2>
                                        <p class="text-white">Total Guild Members</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $jsonIn = file_get_contents('https://canary.discordapp.com/api/guilds/498549589008187392/embed.json');
                            $JSON = json_decode($jsonIn, true);
                            $discmembersCount = count($JSON['members']);
                            ?>
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-primary">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0"><?php echo $discmembersCount ?></h2>
                                        <p class="text-white">Discord Members</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            function getOnlinePlayers($ip, $port = 25565) {
                                $ch = curl_init('https://mcapi.us/server/status?ip=mc.hypixel.net');
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $results = curl_exec($ch);
                                curl_close($ch);
                                $json = json_decode($results, true);
                                $mconlineplayers = $json['players']['now'];
                                return $mconlineplayers;
                            }
                            ?>
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-orange">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0"><?php echo getOnlinePlayers('play.hypixel.net'); ?></h2>
                                        <p class="text-white">Hypixel Members</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $frequencies = [
                                    "Lander" => 0,
                                "Cosmonaut"=>0,
                                "Staff"=>0,
                                "Guild Master" => 0,
                                "Neverlander" =>0,
                                "Astronaut"=>0,
                            ];

                            foreach($guild->getMemberList()->getList() as $ranks) {
                                foreach ($ranks as $member) {
                                    $frequencies[$member->get("rank")]++;
                                }
                            }
                            ?>
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-info">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0"><?php echo $frequencies["Staff"] + $frequencies["Guild Master"]; ?></h2>
                                        <p class="text-white">Current Guild Staff</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-statistics">
                                    <div class="card-body">
                                        <div class="datatable-wrapper table-responsive">
                                            <table id="datatable" class="display compact table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Guild Rank</th>
                                                        <th>Join Date</th>
                                                        <th>Last Login</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                foreach($memberList->getList() as $rank => $members) {
                                                    foreach ($members as $member) {
                                                        $player = $member->getPlayer();

                                                        if($player === null) continue;

                                                        echo '<tr>';
                                                        echo '<td><img class="member-list" src="https://cravatar.eu/helmavatar/' . $player->getName() . '/32" /></td>';
                                                        echo '<td><b>' . $player->getName() . '</b></td>';
                                                        echo '<td>' . ucfirst($rank) . '</td>';
                                                        echo '<td>' . date('Y/m/d H:i:s', $member->getJoinTimeStamp() / 1000) . '</td>';
                                                        echo '<td>' . date('Y/m/d H:i:s', $player->get('lastLogin') / 1000) . '</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Guild Rank</th>
                                                        <th>Join Date</th>
                                                        <th>Last Login</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="row">
                    <div class="col-12 col-sm-6 text-center text-sm-left">
                        <p>&copy; Copyright 2019. All rights reserved.</p>
                    </div>
                    <div class="col  col-sm-6 ml-sm-auto text-center text-sm-right">
                        <p>Made with <i class="fa fa-heart text-danger mx-1"></i> by Jackelele</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="assets\js\vendors.js"></script>

    <!-- custom app -->
    <script src="assets\js\app.js"></script>
</body>

</html>