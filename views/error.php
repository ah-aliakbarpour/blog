<?php
/** @var $this app\core\View */
$this->title = 'Home';

/** @var $exception \Exception */
?>

<center>
    <h1><?php echo $exception->getCode() ?></h1>
    <h2><?php echo $exception->getMessage() ?></h2>
</center>
