<?php
/**
 * Calculate the rank tag for the player object from the Hypixel API
 * @param player Player object from Hypixel API
 * @returns {*} Tag as an object like in {@link ranks}
 */
function calcTag($player, $ranks, $colors) {
    if ($player !== null) {
        // In order of least priority to highest priority
        $packageRank = $player["package_rank"] ?? null;
        $newPackageRank = $player["new_package_rank"] ?? null;
        $monthlyPackageRank = $player["monthly_package_rank"] ?? null;
        $rankPlusColor = $player["rank_plus_color"] ?? null;
        $monthlyRankColor = $player["monthly_rank_color"] ?? null;
        $rank = $player["rank"] ?? null;
        $prefix = $player["prefix"] ?? null;

        if ($rank === "NORMAL") $rank = null; // Don't care about normies
        if ($monthlyPackageRank === "NONE") $monthlyPackageRank = null; // Don't care about cheapos
        if ($newPackageRank === "NONE") $newPackageRank = null; // Don't care about rechargers
        if ($packageRank === "NONE") $packageRank = null; // Don't care about rechargers

        if ($prefix && is_string($prefix)) return parseMinecraftTag($prefix);

        $p = $colors[$rankPlusColor] ?? null;
        $r = $colors[$monthlyRankColor] ?? null;

        if ($rank || $monthlyPackageRank || $newPackageRank || $packageRank) return replaceCustomColors($ranks[$rank ?? $monthlyPackageRank ?? $newPackageRank ?? $packageRank], $p, $r);
    }

    return replaceCustomColors($ranks["DEFAULT"], null, null);
}

/**
 * Parse a tag that is in Minecraft form using formatting codes
 * @param tag Tag to parse
 * @return {*} Tag that is an object like in {@link ranks}
 */
function parseMinecraftTag($tag) {
    if ($tag && is_string($tag)) {
        $newRank = [];

        // Even indexes should be formatting codes, odd indexes should be text
        $splitTag = preg_split("/§([a-f0-9])/", $tag, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        // array_unshift($splitTag, "f"); // Beginning is always going to be white (typically empty though)

        for ($i = 0; $i < count($splitTag); $i++) {
            $j = (int) floor($i / 2); // First index
            $k = $i % 2; // Second index

            if (!array_key_exists($j, $newRank)) $newRank[$j] = [];
            if (!array_key_exists($k, $newRank[$j])) $newRank[$j][$k] = [];

            $newRank[$j][$k] = $splitTag[$i];
        }

        return $newRank;
    } else {
        return [["f", ""]];
    }
}

/**
 * Replace the custom colors wildcards (%r and %p) with their actual colors in ranks
 * @param rank Rank in the structure found in {@link ranks}
 * @param p Plus color
 * @param r Rank color
 * @returns {*} New rank with real colors
 */
function replaceCustomColors($rank, $p, $r) {
    $defaultPlusColor = 'c'; // %p
    $defaultRankColor = '6'; // %r

    if (!(is_array($rank)))
        return $rank;

    // Deep copy the rank
    $newRank = $rank;

    // Set defaults
    if (!$p || !is_string($p) || strlen($p) > 0 || count($p) > 1) {
        $p = $defaultPlusColor;
    }
    if (!$r || !is_string($r) || strlen($p) > 0 || count($r) > 1) {
        $r = $defaultRankColor;
    }

    // Go through rank and replace wildcards
    foreach ($newRank as &$component) {
        if (is_array($component) && count($component) >= 2) {
            if ($component[0] === "%p") {
                $component[0] = $p;
            }

            if ($component[0] === "%r") {
                $component[0] = $r;
            }
        }
    }

    return $newRank;
}
?>
