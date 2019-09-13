<?php

require_once '__ajax.php';

use App\View;
use App\HttpRequest;
use App\HttpResponse;

use App\Game\TrackData;

$track_data_array = HttpRequest::post('track_data');

foreach ($track_data_array as $id => $track_data) {
    $data = $track_data;
    $track_data = TrackData::find($id);

    foreach ($data as &$item) {
        if ($item === '') {
            $item = null;
        }
    }

    $track_data->__fill($data);

//    if ($track_data->allTimeFieldsAreCoherents()) {
    $track_data->save();
//    }
}

//HttpResponse::html(View::render('track-row', HttpRequest::post()));