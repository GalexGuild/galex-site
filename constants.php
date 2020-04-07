<?php
$ranks = [
    "ADMIN" => [
        ["c", "[ADMIN]"]
    ],
    "MODERATOR" => [
        ["2", "[MOD]"]
    ],
    "HELPER" => [
        ["9", "[HELPER]"]
    ],
    "JR_HELPER" => [
        ["9", "[JR HELPER]"]
    ],
    "YOUTUBER" => [
        ["c", "["],
        ["f", "YOUTUBE"],
        ["c", "]"]
    ],
    "SUPERSTAR" => [
        ["%r", "[MVP"],
        ["%p", "++"],
        ["%r", "]"]
    ],
    "MVP_PLUS" => [
        ["b","[MVP"],
        ["%p","+"],
        ["b","]"]
    ],
    "MVP" => [
        ["b", "[MVP]"]
    ],
    "VIP_PLUS" => [
        ["a", "[VIP"],
        ["6", "+"],
        ["a", "]"]
    ],
    "VIP" => [
        ["a", "[VIP]"]
    ],
    "DEFAULT" => [
        ["7", ""]
    ]
];

$colors = [ // Convert name-based colors to number-based
    "BLACK" => "0",
    "DARK_BLUE" => "1",
    "DARK_GREEN" => "2",
    "DARK_AQUA" => "3",
    "DARK_RED" => "4",
    "DARK_PURPLE" => "5",
    "GOLD" => "6",
    "GRAY" => "7",
    "DARK_GRAY" => "8",
    "BLUE" => "9",
    "GREEN" => "a",
    "AQUA" => "b",
    "RED" => "c",
    "LIGHT_PURPLE" => "d",
    "YELLOW" => "e",
    "WHITE" => "f"
];

$color_map = [
    "0" => "#000000",
    "1" => "#0000AA",
    "2" => "#008000",
    "3" => "#00AAAA",
    "4" => "#AA0000",
    "5" => "#AA00AA",
    "6" => "#FFAA00",
    "7" => "#AAAAAA",
    "8" => "#555555",
    "9" => "#5555FF",
    "a" => "#3CE63C",
    "b" => "#3CE6E6",
    "c" => "#FF5555",
    "d" => "#FF55FF",
    "e" => "#FFFF55",
    "f" => "#FFFFFF"
];
?>
