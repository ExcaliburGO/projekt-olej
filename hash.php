<?php
echo password_hash("mroilpass", PASSWORD_DEFAULT)."<br>";
echo hash('sha256', 'mroilemailtokensecret'.'1');
?>