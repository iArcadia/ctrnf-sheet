<?php

require_once '__ajax.php';

use App\HttpRequest;
use App\Game\Option;

Option::findBySlug('console')
    ->setValue(HttpRequest::post('console'))
    ->save();

Option::findBySlug('console-rank-goal')
    ->setValue(HttpRequest::post('console-rank-goal'))
    ->save();