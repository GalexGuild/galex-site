<?php
$playerObj = null;

if (isset($_GET['ign'])) {
    $ign = $_GET['ign'];
    $playerObj = $HypixelPHP->getPlayer(['name' => $ign]);
    $playerUuid = $playerObj->getUUID();
}
?>
<?php if ($playerObj !== null): ?>
    <div class="information">
        <h1>
            <?php
            echo $ColorParser->parse($playerObj->getRawFormattedName());
            ?>
        </h1>
    </div>
<?php endif ?>
