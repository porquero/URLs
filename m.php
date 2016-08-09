<?php

include_once 'lib/Urls.php';

$u = isset($_GET['u']) ? $_GET['u'] : null;

Urls::m($u, true);