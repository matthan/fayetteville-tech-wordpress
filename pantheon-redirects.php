<?php

// HTTPS, WWW Canonical URL (https://www.faytechcc.edu)
if (isset($_SERVER['PANTHEON_ENVIRONMENT']) && $_SERVER['PANTHEON_ENVIRONMENT'] === 'live') {
    if ($_SERVER['HTTP_HOST'] == 'athletics.faytechcc.edu') {
        header('HTTP/1.0 301 Moved Permanently');
        header('Location: https://www.faytechcc.edu/athletics'. $_SERVER['REQUEST_URI']);
        exit();
    } elseif (($_SERVER['HTTP_HOST'] != 'www.faytechcc.edu') ||
        (!isset($_SERVER['HTTP_X_SSL']) ||
        (isset($_SERVER['HTTP_X_SSL']) && $_SERVER['HTTP_X_SSL'] != 'ON'))) {
        header('HTTP/1.0 301 Moved Permanently');
        header('Location: https://www.faytechcc.edu'. $_SERVER['REQUEST_URI']);
        exit();
	}
}