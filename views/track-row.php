<?php

use App\Game\Track;
use App\Game\Character;
use App\Game\Option;

$track = Track::find($track_id);
$data = $track->getData();
$did = $data->getId();

?>

<th class="bg-blue" data-col="track-name"><?= $track->getName('fr') ?></th>
<th class="bg-blue" data-col="track-name"><?= $track->getName() ?></th>

<td data-col="console-rank">
    <input
            type="text"
            name="track_data[<?= $did ?>][console_rank]"
            value="<?= $data->getConsoleRank() ?>"
            placeholder="Votre rank"
            pattern="\d+">

    <div>
        <?php if ($data->getConsoleRank()
            && (int)Option::findBySlug('console-rank-goal')->getValue() > $data->getConsoleRank()): ?>
            <i class="fas fa-check c-green" title="<?= __('Objectif') ?> <?= Option::findBySlug('console-rank-goal')->getValue() ?>"></i>
        <?php elseif ($data->getConsoleRank()): ?>
            <i class="fas fa-times c-red" title="<?= __('Objectif') ?> <?= Option::findBySlug('console-rank-goal')->getValue() ?>"></i>
        <?php endif; ?>
    </div>
</td>

<td class="bg-light-blue" data-col="tropy-time">
    <input
            type="text"
            value="<?= ($track->getTropyTime()) ? $track->getTropyTime()->formatMSC() : '' ?>"
            readonly>

    <div>
        <img src="assets/img/characters/n-tropy.png" alt="N. Tropy" title="N. Tropy" style="width:15px; height: 15px;">

        <?php if ($data->getBestTime()
            && $track->getTropyTime()
            && $data->getBestTime()->getTime() <= $track->getTropyTime()->getTime()): ?>
            <i class="fas fa-check c-green"></i>
        <?php else: ?>
            <i class="fas fa-times c-red"></i>
        <?php endif; ?>
    </div>
</td>

<td class="bg-light-blue" data-col="oxide-time">
    <input
            type="text"
            value="<?= ($track->getOxideTime()) ? $track->getOxideTime()->formatMSC() : '' ?>"
            readonly>

    <div>
        <img src="assets/img/characters/oxide.png" alt="Oxide" title="Oxide" style="width:15px; height: 15px;">

        <?php if ($data->getBestTime()
            && $track->getOxideTime()
            && $data->getBestTime()->getTime() <= $track->getOxideTime()->getTime()): ?>
            <i class="fas fa-check c-green"></i>
        <?php else: ?>
            <i class="fas fa-times c-red"></i>
        <?php endif; ?>
    </div>
</td>

<?php /*
<td class="bg-light-blue" data-col="master-time">
    <input
            type="text"
            value="<?= ($track->getMasterTime()) ? $track->getMasterTime()->formatMSC() : '' ?>"
            readonly>

    <div>
        <?php if ($track->getMasterTimeUrl()): ?>
            <a href="<?= $track->getMasterTimeUrl() ?>" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
        <?php endif; ?>
    </div>
</td>
 */ ?>

<td data-col="best-time">
    <input
            type="text"
            name="track_data[<?= $did ?>][best_time]"
            value="<?= ($data->getBestTime()) ? $data->getBestTime()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">

    <div>
        <?php if ($data->getBestTimeCharacterId()): ?>
            <img src="assets/img/characters/<?= $data->getBestTimeCharacter()->getSlug() ?>.png" alt="<?= $data->getBestTimeCharacter()->getName() ?>"
                 title="<?= $data->getBestTimeCharacter()->getName() ?>" style="width:15px; height: 15px;">
        <?php elseif ($data->getBestTime()): ?>
            <img src="assets/img/characters/null.jpg" alt="<?= __('Aucun personnage selectionné') ?>"
                 title="<?= __('Aucun personnage selectionné') ?>" style="width:15px; height: 15px;">
        <?php endif; ?>
    </div>

    <select name="track_data[<?= $did ?>][best_time_character_id]" style="display:none;">
        <option></option>
        <?php foreach (Character::get() as $character): ?>
            <option value="<?= $character->getId() ?>" <?= ($character->getId() === $data->getBestTimeCharacterId()) ? 'selected' : '' ?>>
                <?= $character->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</td>

<td class="secondary-td" data-col="lap-1-time">
    <input
            type="text"
            name="track_data[<?= $did ?>][lap_1_time]"
            value="<?= ($data->getLap1Time()) ? $data->getLap1Time()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">
</td>

<td class="secondary-td" data-col="lap-2-time">
    <input
            type="text"
            name="track_data[<?= $did ?>][lap_2_time]"
            value="<?= ($data->getLap2Time()) ? $data->getLap2Time()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">
</td>

<td class="secondary-td" data-col="lap-3-time">
    <input
            type="text"
            name="track_data[<?= $did ?>][lap_3_time]"
            value="<?= ($data->getLap3Time()) ? $data->getLap3Time()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">
</td>

<td data-col="best-lap-time">
    <input
            class="block"
            type="text"
            name="track_data[<?= $did ?>][best_lap_time]"
            value="<?= ($data->getBestLapTime()) ? $data->getBestLapTime()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">

    <div>
        <?php if ($data->getLap1Time() && $data->getBestLapTime()): ?>
            <small>-<?= $data->getLap1Time()->getDiff($data->getBestLapTime())->formatMSC() ?> |</small>
        <?php endif; ?>

        <?php if ($data->getLap2Time() && $data->getBestLapTime()): ?>
            <small>-<?= $data->getLap2Time()->getDiff($data->getBestLapTime())->formatMSC() ?> |</small>
        <?php endif; ?>

        <?php if ($data->getLap3Time() && $data->getBestLapTime()): ?>
            <small>-<?= $data->getLap3Time()->getDiff($data->getBestLapTime())->formatMSC() ?></small>
        <?php endif; ?>
    </div>

    <div>
        <?php if ($data->getBestLapTimeCharacterId()): ?>
            <img src="assets/img/characters/<?= $data->getBestLapTimeCharacter()->getSlug() ?>.png" alt="<?= $data->getBestLapTimeCharacter()->getName() ?>"
                 title="<?= $data->getBestLapTimeCharacter()->getName() ?>" style="width:15px; height: 15px;">
        <?php elseif ($data->getBestLapTime()): ?>
            <img src="assets/img/characters/null.jpg" alt="<?= __('Aucun personnage selectionné') ?>"
                 title="<?= __('Aucun personnage selectionné') ?>" style="width:15px; height: 15px;">
        <?php endif; ?>
    </div>

    <select name="track_data[<?= $did ?>][best_lap_time_character_id]" style="display:none;">
        <option></option>
        <?php foreach (Character::get() as $character): ?>
            <option value="<?= $character->getId() ?>" <?= ($character->getId() === $data->getBestLapTimeCharacterId()) ? 'selected' : '' ?>>
                <?= $character->getName() ?>
            </option>
        <?php endforeach; ?>
    </select>
</td>

<td class="secondary-td" data-col="best-first-lap-time">
    <input
            class="block"
            type="text"
            name="track_data[<?= $did ?>][best_first_lap_time]"
            value="<?= ($data->getBestFirstLapTime()) ? $data->getBestFirstLapTime()->formatMSC() : '' ?>"
            placeholder="mm:ss.cc">

    <div>
        <?php if ($data->getLap1Time() && $data->getBestFirstLapTime()): ?>
            <small>-<?= $data->getLap1Time()->getDiff($data->getBestFirstLapTime())->formatMSC() ?></small>
        <?php endif; ?>
    </div>
</td>

<td class="secondary-td" data-col="theoric-time">
    <?php if ($data->getBestLapTime() && $data->getBestFirstLapTime()): ?>
        <input
                class="block"
                type="text"
                value="<?= ($data->getTheoricTime()) ? $data->getTheoricTimeInterval()[0]->formatMSC() . ' ... ' . $data->getTheoricTimeInterval()[1]->formatMSC() : '' ?>"
                readonly>
    <?php else: ?>
        <input
                class="block"
                type="text"
                readonly>
    <?php endif; ?>

    <div>
        <?php if ($data->getBestTime() && $data->getBestLapTime() && $data->getBestFirstLapTime()): ?>
            <small>-<?= $data->getBestTime()->getDiff($data->getTheoricTimeInterval()[0])->formatMSC() ?> ...
                -<?= $data->getBestTime()->getDiff($data->getTheoricTimeInterval()[1])->formatMSC() ?></small>
        <?php else: ?>
            <i class="fas fa-question" title="<?= __('Le meilleur temps théorique est calculé à partir du meilleur temps au tour et du meilleur temps du tour 1') ?>"></i>
        <?php endif; ?>
    </div>
</td>

<td class="bg-light-blue" data-col="wr-time">
    <input
            type="text"
            value="<?= ($track->getWrTime()) ? $track->getWrTime()->formatMSC() : '' ?>"
            readonly>

    <div>
        <?php if ($track->getWrTime() && $data->getBestTime()): ?>
            <small>+<?= $track->getWrTime()->getDiff($data->getBestTime())->formatMSC() ?></small>
        <?php endif; ?>
    </div>

    <div>
        <?php if ($track->getWrTimeCharacterId()): ?>
            <img src="assets/img/characters/<?= $track->getWrTimeCharacter()->getSlug() ?>.png" alt="<?= $track->getWrTimeCharacter()->getName() ?>"
                 title="<?= $track->getWrTimeCharacter()->getName() ?>" style="width:15px; height: 15px;">
        <?php endif; ?>

        <?php if ($track->getWrTimeUrl()): ?>
            <a href="<?= $track->getWrTimeUrl() ?>" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
        <?php endif; ?>
    </div>
</td>

<td class="bg-light-blue" data-col="wr-lap-time">
    <input
            type="text"
            value="<?= ($track->getWrLapTime()) ? $track->getWrLapTime()->formatMSC() : '' ?>"
            readonly>

    <div>
        <?php if ($track->getWrLapTime() && $data->getBestLapTime()): ?>
            <small>+<?= $track->getWrLapTime()->getDiff($data->getBestLapTime())->formatMSC() ?></small>
        <?php endif; ?>
    </div>

    <div>
        <?php if ($track->getWrLapTimeCharacterId()): ?>
            <img src="assets/img/characters/<?= $track->getWrLapTimeCharacter()->getSlug() ?>.png" alt="<?= $track->getWrLapTimeCharacter()->getName() ?>"
                 title="<?= $track->getWrLapTimeCharacter()->getName() ?>" style="width:15px; height: 15px;">
        <?php endif; ?>

        <?php if ($track->getWrLapTimeUrl()): ?>
            <a href="<?= $track->getWrLapTimeUrl() ?>" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>
        <?php endif; ?>
    </div>
</td>