<?php

// Load composer autoload.
require_once 'vendor/autoload.php';

// Disable E_STRICT errors.
// It occurs only on tests.
error_reporting(error_reporting() & ~E_STRICT);
