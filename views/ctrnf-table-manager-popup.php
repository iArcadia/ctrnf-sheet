<div id="ctrnf-table-manager-popup" class="popup">
    <p><?= __('Selectionnez les colonnes du tableau que vous voulez afficher.') ?></p>

    <form id="ctrnf-table-manager">
        <ul>
            <li>
                <label>
                    <input type="checkbox" data-col="console-rank" checked>
                    <span>Rank</span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="tropy-time" checked>
                    <span><?= __('Temps de N. Tropy') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="oxide-time" checked>
                    <span><?= __('Temps d\'Oxide') ?></span>
                </label>
            </li>

            <!--            <li>-->
            <!--                <label>-->
            <!--                    <input type="checkbox" data-col="master-time" checked>-->
            <!--                    <span>Temps du maître</span>-->
            <!--                </label>-->
            <!--            </li>-->

            <li>
                <label>
                    <input type="checkbox" data-col="best-time" checked>
                    <span><?= __('Meilleur Temps') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="lap-1-time" checked>
                    <span><?= __('Tour 1') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="lap-2-time" checked>
                    <span><?= __('Tour 2') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="lap-3-time" checked>
                    <span><?= __('Tour 3') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="best-lap-time" checked>
                    <span><?= __('Meilleur Tour') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="best-first-lap-time" checked>
                    <span><?= __('Meilleur Tour 1') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="theoric-time" checked>
                    <span><?= __('MT Théorique') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="wr-time" checked>
                    <span><?= __('Meilleur Temps WR') ?></span>
                </label>
            </li>

            <li>
                <label>
                    <input type="checkbox" data-col="wr-lap-time" checked>
                    <span><?= __('Meilleur Tour WR') ?></span>
                </label>
            </li>
        </ul>

        <button type="submit"><?= __('Valider') ?></button>
    </form>
</div>