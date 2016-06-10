<?php

// Load composer autoload.
require_once __DIR__ . '/vendor/autoload.php';

// Disable E_STRICT errors.
// It occurs only on tests.
error_reporting(error_reporting() & ~E_STRICT);
