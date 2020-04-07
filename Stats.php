<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"]);

require_once(ROOT . "/autoload.php");
require_once(ROOT . "/config.php");
require_once(ROOT . "/constants.php");
require_once(ROOT . "/js_rank_rewrite.php");

use \Plancke\HypixelPHP\color\ColorParser;
use \ParagonIE\EasyDB\EasyStatement;
use \ParagonIE\EasyDB\Factory;

$db = Factory::fromArray([
    "mysql:host=localhost;dbname=galex_db",
    "root",
    "password"
]);

function __api_get_guild($id, $key) {
    $data = [
        "key" => $key,
        "id" => $id
    ];

    $url = "https://api.hypixel.net/guild";
    $query = http_build_query($data);

    return json_decode(@file_get_contents($url . "?" . $query), true)["guild"];
}

function __api_get_player($uuid, $key) {
    $data = [
        "key" => $key,
        "uuid" => $uuid
    ];

    $url = "https://api.hypixel.net/player";
    $query = http_build_query($data);

    return json_decode(@file_get_contents($url . "?" . $query), true)["player"];
}

function __api_get_members($guild) {
    return $guild["members"];
}

/* Expects player data */
function format_player($player, $guild) {
    $ranks = [
        "Astronaut" => 1,
        "Cosmonaut" => 2,
        "Staff" => 3,
        "Guild Master" => PHP_INT_SIZE,
    ];

    if ($guild["rank"] === "Lander") {
        $guild["rank"] = "Astronaut";
    } else if ($guild["rank"] === "Neverlander") {
        $guild["rank"] = "Cosmonaut";
    }

    return [
        "uuid" => $player["uuid"],
        "username" => $player["displayname"],
        "joined_at" => intval($guild["joined"]),
        "guild_rank" => $guild["rank"],
        "rank_priority" => $ranks[$guild["rank"]],
        "package_rank" => $player["packageRank"] ?? null,
        "new_package_rank" => $player["newPackageRank"] ?? null,
        "monthly_package_rank" => $player["monthlyPackageRank"] ?? null,
        "rank_plus_color" => $player["rankPlusColor"] ?? null,
        "monthly_rank_color" => $player["monthlyRankColor"] ?? null,
        "rank" => $player["rank"] ?? null,
        "prefix" => $player["prefix"] ?? null
    ];
}

/* Fix cache */
function invalidate_cache($cached, $online, $db, $key) {
    /* Initialize counters */
    $i = count($cached) - 1; $j = count($online) - 1;

    do {
        if ($cached[$i]["uuid"] > $online[$j]["uuid"]) {
            $db->delete('members', [
                'uuid' => $cached[$i]['uuid']
            ]);

            array_splice($cached, $i--, 1);
        } else if ($cached[$i]["uuid"] < $online[$j]["uuid"]) {
            $player = __api_get_player($online[$j]["uuid"], $key);

            $formatted = format_player($player, $online[$j--]);

            $db->insert('members', $formatted);

            array_push($cached, $formatted);
        } else {
            --$i; --$j;
        }

        if ($i < 0 && $j < 0) break;

        if ($i < 0) $i = 0;
        if ($j < 0) $j = 0;

    } while ($i >= 0 && $j >= 0);

    return $cached;
}

$cached = $db->run("SELECT * FROM members ORDER BY joined_at");
$cache_times = $db->row('SELECT * FROM cache_times');

$time = time();

/* Invalidate after 60 minutes */
if ($time - $cache_times["guild"] > 60 * 60) {
    /* Update last time cached */
    $db->update('cache_times', [
        'guild' => $time
    ], [
        'guild' => $cache_times["guild"]
    ]);

    $guild = __api_get_guild("59b2e87d0cf2eb322db9437f", $apiKey);
    $online = __api_get_members($guild);

    $cached = invalidate_cache($cached, $online, $db, $apiKey);
}

/* Sort by rank importance and then by join date */
usort($cached, function($a, $b) {
    if ($a["rank_priority"] === $b["rank_priority"]) {
        return $a["joined_at"] - $b["joined_at"];
    }

    return $b["rank_priority"] - $a["rank_priority"];
});
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
    <style media="screen">
        @font-face {
            font-family: minecraftia;
            src: url("/Minecraftia.ttf");
        }

        .name-wrapper {
            font-family: 'Minecraftia', serif;
            font-size: 0;
        }
    </style>
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
                                        <h2 class="text-white mb-0">
                                            <?php echo count($cached); ?>
                                        </h2>
                                        <p class="text-white">Guild Members</p>
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
                                        <p class="text-white">Online Discord Members</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            function getOnlinePlayers($ip, $key, $port = 25565) {
                                $url = "https://api.hypixel.net/playerCount?key={$key}";
                                $json = json_decode(file_get_contents($url), true);

                                $mconlineplayers = $json["playerCount"];

                                return $mconlineplayers;
                            }
                            ?>
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-orange">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0"><?php echo getOnlinePlayers('play.hypixel.net', $apiKey); ?></h2>
                                        <p class="text-white">Hypixel Members</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // $frequencies = [
                            //         "Lander" => 0,
                            //     "Cosmonaut"=>0,
                            //     "Staff"=>0,
                            //     "Guild Master" => 0,
                            //     "Neverlander" =>0,
                            //     "Astronaut"=>0,
                            // ];
                            //
                            // foreach($guild->getMemberList()->getList() as $ranks) {
                            //     foreach ($ranks as $member) {
                            //         $frequencies[$member->get("rank")]++;
                            //     }
                            // }
                            ?>
                            <div class="col-xs-6 col-xxl-3 m-b-30">
                                <div class="card card-statistics h-100 m-b-0 bg-info">
                                    <div class="card-body">
                                        <h2 class="text-white mb-0">
                                            <?php
                                            $staff = array_filter($cached, function($member) {
                                                return $member["rank_priority"] >= 3;
                                            });

                                            echo count($staff);
                                            ?>
                                        </h2>
                                        <p class="text-white">Guild Staff Members</p>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < count($cached); $i++): ?>
                                                        <?php
                                                        $player = $cached[$i];
                                                        $tag_colors = calcTag($player, $ranks, $colors);
                                                        ?>
                                                        <tr>
                                                        <td><img class="member-list" src="https://crafatar.com/avatars/<?php echo $player["uuid"]; ?>?size=32&overlay=1" /></td>
                                                        <td class="name-wrapper">
                                                            <?php for ($j = 0; $j < count($tag_colors); $j++): ?>
                                                                <span style='font-size: 1rem; color: <?php echo $color_map[$tag_colors[$j][0]]; ?>'><?php echo $tag_colors[$j][1]; ?></span>

                                                                <?php if ($j === count($tag_colors) - 1): ?>
                                                                    <span style='font-size: 1rem; padding-left: 5px; color: <?php echo $color_map[$tag_colors[$j][0]]; ?>'>
                                                                        <?php echo $player["username"]; ?>
                                                                    </span>
                                                                <?php endif; ?>
                                                            <?php endfor; ?>
                                                        </td>
                                                        <td><?php echo ucfirst($player["guild_rank"]); ?></td>
                                                        <td><?php echo date('Y/m/d H:i:s', $player["joined_at"] / 1000); ?></td>
                                                        </tr>
                                                    <?php endfor; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Username</th>
                                                        <th>Guild Rank</th>
                                                        <th>Join Date</th>
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
                        <p>&copy; Copyright 2020. All rights reserved.</p>
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
