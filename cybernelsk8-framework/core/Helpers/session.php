<?php

use Core\Session\Session;

function session():Session {
    return app()->session;
}