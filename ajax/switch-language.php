<?php

require_once '__ajax.php';

use App\Lang;
use App\HttpRequest;

Lang::setLang(HttpRequest::post('lang'));