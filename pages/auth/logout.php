<?php

unset($_SESSION["id"]);
unset($_SESSION["name"]);
session_unset();
session_destroy();
header("Location:../../index.php");
