<?php 

$message = $tk->poistaToimipiste($_GET['id']);

?>

<div class="listaus">
    <p><?php echo $message;?></p>
    <p><a href='index.php'>Palaa</a>
</div>