<?php
session_start();
if (!isset($_SESSION["luokka"]))
{
    die("Kirjaudu sisään.");
}
?>

<?php 

$message = $tk->poistaToimipiste($_GET['id']);

?>

<div class="listaus">
    <p><?php echo $message;?></p>
    <p><a href='index.php'>Palaa</a>
</div>