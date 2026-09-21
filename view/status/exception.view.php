<?php
    $cssArticle = "font-weight: bold; position: absolute; top: 0;left: 0; width: 100%; height: 100%; background-color: #FF88AA; z-index: 100;";
    $cssSection = "max-width: 80ch; margin-inline: auto; position: relative; top: 30%";
    $cssButton = "color: black; display: block; text-decoration: none; ";
    $cssH1 = "font-size: 8rem; font-weight: bolder;";
    $cssStar = "text-align: center; font-size: 1.2em; margin-block: 1rem;";
?>

<?php require_once basePath( 'view/components/header.php' ) ?>
    <article style="<?= $cssArticle ?>">
        <section style="<?= $cssSection ?>">
            <h1 style="<?= $cssStar ?>;<?= $cssH1 ?>"><?= $attr[ 'code' ] ?>!</h1>
            <p style="<?= $cssStar ?>"><?= $attr[ 'exception' ] ?></p>
            <a href="/" style="<?= $cssStar ?>; <?= $cssButton ?>">Home</a>
        </section>
    </article>
    <?php ?>
<?php require_once basePath( 'view/components/footer.php' ) ?>
