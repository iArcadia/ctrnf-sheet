<?php

use App\Game\Option;

?>

<div id="ctrnf-table-options-popup" class="popup">
    <p><?= __('Options') ?></p>

    <form id="ctrnf-table-options" action="update-options.php">
        <ul>
            <li>
                <label>
                    <span><?= __('Votre console :') ?></span>
                    <select name="console">
                        <option value="PS4" <?= (Option::findBySlug('console')->getValue() === 'PS4') ? 'selected' : '' ?>>PS4</option>
                        <option value="Xbox One" <?= (Option::findBySlug('console')->getValue() === 'Xbox One') ? 'selected' : '' ?>>Xbox One</option>
                        <option value="Switch" <?= (Option::findBySlug('console')->getValue() === 'Switch') ? 'selected' : '' ?>>Switch</option>
                    </select>
                </label>
            </li>

            <li>
                <label>
                    <span><?= __('Votre objectif du Rank console :') ?></span>
                    <input type="number" name="console-rank-goal" min="1" value="<?= Option::findBySlug('console-rank-goal')->getValue() ?>">
                </label>
            </li>
        </ul>

        <button type="submit"><?= __('Valider') ?></button>
    </form>
</div>