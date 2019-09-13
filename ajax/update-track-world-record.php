<?php

require_once '__ajax.php';

use App\HttpRequest;
use App\Game\Track;
use App\Game\Character;

$corr_tracks = [
    1 => 'crash-cove',
    3 => 'roo-s-tubes',
    5 => 'tiger-temple',
    7 => 'coco-park',
    9 => 'mystery-caves',
    11 => 'blizzard-bluff',
    13 => 'sewer-speedway',
    15 => 'dingo-canyon',
    17 => 'papu-s-pyramid',
    19 => 'dragon-mines',
    21 => 'polar-pass',
    23 => 'cortex-castle',
    25 => 'tiny-arena',
    27 => 'hot-air-skyway',
    29 => 'n-gin-labs',
    31 => 'oxide-station',
    33 => 'slide-coliseum',
    35 => 'turbo-track',
    37 => 'inferno-island',
    39 => 'jungle-boogie',
    41 => 'tiny-temple',
    43 => 'meteor-gorge',
    45 => 'barin-ruins',
    47 => 'deep-sea-driving',
    49 => 'out-of-time',
    51 => 'clockwork-wompa',
    53 => 'thunder-struck',
    55 => 'assembly-lane',
    57 => 'android-alley',
    59 => 'electron-avenue',
    61 => 'hyper-spaceway',
    63 => 'retro-track',
    65 => 'twilight-tour',
    67 => 'prehistoric-playground',
    69 => 'spyro-circuit'
];

$corr_characters = [
    'crash-bandicoot', 'dr-neo-cortex', 'tiny-tiger', 'coco-bandicoot', 'dr-n-gin', 'dingodile', 'polar',
    'pura', 'ripper-roo', 'papu-papu', 'komodo-joe', 'pinstripe', 'fake-crash', 'oxide', 'n-tropy', 'crunch-bandicoot',
    'krunk', 'small-norm', 'big-norm', 'nash', 'n-trance', 'real-velo', 'geary', 'zam', 'zem', 'penta-penguin', 'ami', 'liz', 'tawna', 'megumi',
    'isabella', 'baby-t', 'baby-crash', 'baby-coco', 'hunter', 'gnasty-gnorc', 'spyro'
];

$subpatterns = [
    'open_row_1' => '<tr>',

    'track_id' => 'track_choice=(\d+)',

    'best_time' => '((?:\d:)?\d{2}\.\d{2})',
    'best_time_character_id' => 'characters\/(\d+)\.png',
    'best_time_url' => '"(https:\/\/www\.youtube\.com\/.+?)"',

    'row_switching_1' => '<\/tr>.*?<tr>',

    'best_lap_time' => '((?:\d:)?\d{2}\.\d{2})',
    'best_lap_time_character_id' => 'characters\/(\d+)\.png',
    'best_lap_time_url' => '"(https:\/\/www\.youtube\.com\/.+?)"',

    'close_row_2' => '<\/tr>'
];

$pattern = '/' . join('.+?', $subpatterns) . '/ms';
//$pattern = '/<tr>.+?track_choice=(\d+).+?((?:\d:)?\d{2}\.\d{2}).+?characters\/(\d+)\.png.+?"(https:\/\/www\.youtube\.com\/.+?)".+?<\/tr>.*?<tr>.+?((?:\d:)?\d{2}\.\d{2}).+?"(https:\/\/www\.youtube\.com\/.+?)".+?<\/tr>/ms';
$ctranking_src = htmlspecialchars(HttpRequest::post('ctranking_src'));

$ctranking_track_ids = [];

$best_times = [];
$best_time_character_ids = [];
$best_time_urls = [];

$best_lap_times = [];
$best_lap_time_urls = [];
$best_lap_time_character_ids = [];

if (preg_match_all(htmlspecialchars($pattern), $ctranking_src, $matches)) {
    $ctranking_track_ids = $matches[1];

    $best_times = $matches[2];
    $best_time_character_ids = $matches[3];
    $best_time_urls = $matches[4];

    $best_lap_times = $matches[5];
    $best_lap_time_character_ids = $matches[6];
    $best_lap_time_urls = $matches[7];
}

$i = 0;
foreach ($corr_tracks as $ctranking_track_id => $slug) {
    $track = Track::findBySlug($slug);

    if ($track) {
        $track->setWrTime($best_times[$i]);
        $track->setWrTimeUrl($best_time_urls[$i]);
        $track->setWrTimeCharacterId(Character::findBySlug($corr_characters[$best_time_character_ids[$i] - 1])->getId());

        $track->setWrLapTime($best_lap_times[$i]);
        $track->setWrLapTimeUrl($best_lap_time_urls[$i]);
        $track->setWrLapTimeCharacterId(Character::findBySlug($corr_characters[$best_lap_time_character_ids[$i] - 1])->getId());

        $track->save();
    }

    $i++;
}