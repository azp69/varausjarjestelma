<?php
session_start();

    if ($_SESSION["luokka"] > 0)
    {

    }
    else
    {
        ?>
        
<div id="loginscreen" class="loginscreen">
    <h2>Tervetuloa!</h2>
    Kirjaudu sisään, ole hyvä.
    <hr class="erotin" />
    <br />
    <br />
    <form action="login.php" method="post">
        Käyttäjätunnus<br />
        <input type="text" name="tunnus" class="textinput" /><br />
        Salasana<br />
        <input type="password" name="salasana" class="textinput" /><br />
        <br />
        <input type="submit" name="submit" value="Kirjaudu" class="button_default" />
    </form>                
</div>

<?php
    }
?>