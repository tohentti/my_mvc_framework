<?php

    echo 'url: ' . $_GET['url'] . '<br>';

	require_once __DIR__ . "/libs/Bootstrap.php";
	$app = new libs\Bootstrap(isset($_GET['url'])?$_GET['url']:'common/home');


