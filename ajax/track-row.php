<?php

require_once '__ajax.php';

use App\View;
use App\HttpRequest;
use App\HttpResponse;

HttpResponse::html(View::render('track-row', HttpRequest::post()));