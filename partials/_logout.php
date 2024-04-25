<?php

session_start();
echo "You are logouting here";

session_destroy(); 
header("Location: /forum")
?>