<?php

use App\Game\Category;
use App\View;
use App\Game\Option;
use App\Game\Track;

$track_of_the_day = Track::getTrackOfTheDay();

?>

<div class="information">
    <label>
        <b><?= __('Circuit du jour :') ?></b>
        <?= $track_of_the_day->getName('fr') ?>
        <small><?= $track_of_the_day->getName() ?></small>
    </label>
</div>

<table id="ctrnf-table">
    <thead>
    <tr>
        <th class="bg-blue" colspan="2" data-col="track-name"><?= __('Circuits') ?></th>
        <th data-col="console-rank">Rank <?= Option::findBySlug('console')->getValue() ?> (<?= __('Objectif') ?> <?= Option::findBySlug('console-rank-goal')->getValue() ?>)</th>
        <th class="bg-blue" data-col="tropy-time"><?= __('Temps de N. Tropy') ?></th>
        <th class="bg-blue" data-col="oxide-time"><?= __('Temps d\'Oxide') ?></th>
        <!--        <th class="bg-blue" data-col="master-time">Temps du maître</th>-->
        <th data-col="best-time"><?= __('Meilleur Temps') ?></th>
        <th class="secondary-th" data-col="lap-1-time"><?= __('Tour 1') ?></th>
        <th class="secondary-th" data-col="lap-2-time"><?= __('Tour 2') ?></th>
        <th class="secondary-th" data-col="lap-3-time"><?= __('Tour 3') ?></th>
        <th data-col="best-lap-time"><?= __('Meilleur Tour') ?></th>
        <th class="secondary-th" data-col="best-first-lap-time"><?= __('Meilleur Tour 1') ?></th>
        <th class="secondary-th" data-col="theoric-time"><?= __('MT Théorique') ?></th>
        <th class="bg-blue" data-col="wr-time"><?= __('Meilleur Temps WR') ?></th>
        <th class="bg-blue" data-col="wr-lap-time"><?= __('Meilleur Tour WR') ?></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach (Category::get() as $category): ?>
        <tr data-category-row="<?= $category->getId() ?>">
            <th class="bg-blue" colspan="15"><?= $category->getName('fr') ?>
                <small><?= $category->getName() ?></small>
            </th>
        </tr>

        <?php foreach ($category->getTracks() as $track): ?>
            <tr
                    class="<?= ($track_of_the_day->getId() === $track->getId()) ? 'track-of-the-day' : '' ?>"
                    data-track-row="<?= $track->getId() ?>"><?php View::render('track-row', ['track_id' => $track->getId()]); ?></tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>
</table>