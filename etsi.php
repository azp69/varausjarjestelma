<?php 
if (isset($_POST['SubmitButton'])) {
    $toimipisteet = $tk->haeLike($_POST["hae"], 1);
    $mokit = $tk->haeLike($_POST["hae"], 2);
    $palvelut = $tk->haeLike($_POST["hae"], 3);
}
?>

<div class ="container">

    <?php

        

        ?>

    <div class="hae-header">
        <h1>Hae</h1>
    </div>
    <form action="" method="post">
    <div class="hakukentta"><input type="text" name="hae" class="textinput" id="textinput-hae" placeholder="Hae toimipisteitä, mökkejä ja palveluita..." <?php if (isset($_POST['SubmitButton'])) {echo "value='" . $_POST["hae"] . "'";} ?>></div>
    <input type="submit" name="SubmitButton" value="Hae">
    </form>

        <?php 
        if (isset($_POST['SubmitButton'])) {
            if ($toimipisteet == null) {
                echo "<p>Haku ei tuottanut yhtään tulosta</p>";
            } else { 
                ?>
                <div id="hakutulos-toimipisteet" class="hakutulos">
                    <h2>Toimipisteet</h2>
                    <?php
                    foreach ($toimipisteet as &$toimipiste){
                    ?>
                    <a href=<?php echo '"index.php?sivu=tiedot&id=' . $toimipiste->getToimipisteId() . '"';?>><?php echo $toimipiste->getNimi();?></a>
                <?php }
                ?> </div> 
                <div id="hakutulos-mokit" class="hakutulos">
                <h2>Mökit</h2>
                <?php
                    foreach ($mokit as &$mokki){
                    ?>
                    <a href=<?php echo '"index.php?sivu=palveluntiedot&id=' . $mokki->getPalveluId() . '"';?>><?php echo $mokki->getNimi();?></a>
                <?php }
                ?> </div>
                <div id="hakutulos-muutpalvelut" class="hakutulos">
                <h2>Muut palvelut</h2>
                <?php
                    foreach ($palvelut as &$palvelu){
                    ?>
                    <a href=<?php echo '"index.php?sivu=palveluntiedot&id=' . $palvelu->getPalveluId() . '"';?>><?php echo $palvelu->getNimi();?></a>
                <?php }
                ?> </div>
                <?php
            } 
        }   ?>
</div>