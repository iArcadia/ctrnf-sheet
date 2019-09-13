<?php

require_once 'vendor/autoload.php';

use App\DB;
use Database\DatabaseSeeder;
use App\View;
use App\Lang;

DB::connect();
DatabaseSeeder::execute();

?>

<!DOCTYPE html>
<html lang="<?= Lang::getLang() ?>">
<head>
    <meta charset="UTF-8">

    <title>CTRNF Sheet</title>

    <link rel="stylesheet" href="assets/css/theme.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/js/fontawesome.min.js"></script>

    <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <script src="node_modules/axios/dist/axios.min.js"></script>

    <script src="assets/js/Loading.js"></script>

    <script>
        const ROOT_URL = '<?= env('ROOT_URL') ?>';
        const AJAX_URL = ROOT_URL + 'ajax/';

        /**
         * Réinitialise toutes les données.
         * @returns void
         */
        function resetData() {
            Loading.show();

            axios.get(AJAX_URL + 'reset-data.php').then(() => window.location.reload());
        }

        /**
         * Met à jour les WRs.
         * @returns void
         */
        function updateWorldRecords() {
            axios.get(AJAX_URL + 'cors.php', {
                headers: {
                    'X-Proxy-Url': 'https://crashteamranking.com/nfrecords/'
                }
            }).then(response => {
                axios.post(
                    AJAX_URL + 'update-track-world-record.php', {
                        ctranking_src: response.data
                    }
                ).then(response2 => updateCtrnfTable());
            });
        }

        /**
         * test api github
         * @returns void
         */
        function testGithub() {
            axios.get(AJAX_URL + 'cors.php', {
                headers: {
                    'X-Proxy-Url': 'https://github.com/iArcadia/magic-api-php-wrapper/releases/latest'
                }
            }).then(response => {
                console.log(response);
            });
        }

        /**
         * Met à jour la tableau.
         * @returns void
         */
        function updateCtrnfTable() {
            Loading.show();
            axios.get(AJAX_URL + 'get-ctrnf-table.php')
                .then(response => {
                    $('#update-track-data-form').html(response.data);

                    toggleCtrnfTableCols();

                    Loading.success();
                })
                .catch(error => {
                    Loading.error();
                    console.log(error);
                });
        }

        /**
         * Corrige la largeur du tableau.
         * @returns void
         */
        function fixCtrnfTableWidth() {
            $('main').css('width', `${$('#ctrnf-table').width() + 40}px`);
        }

        /**
         * Affiche ou cache certaines colonnes du tableau.
         * @returns void
         */
        function toggleCtrnfTableCols() {
            for (let input of $('#ctrnf-table-manager input')) {
                const jInput = $(input),
                    col = jInput.data('col'),
                    isChecked = jInput.is(':checked');

                for (let t of $('#ctrnf-table').find(`th[data-col="${col}"], td[data-col="${col}"]`)) {
                    if (isChecked) {
                        $(t).show();
                    } else {
                        $(t).hide();
                    }
                }
            }

            fixCtrnfTableWidth();
        }

        $(document).ready(() => {
            Loading.show();

            $('#reset-data-submit').on('click', () => {
                $('.popup-overlay').fadeIn();
                $('#reset-data-popup').fadeIn();
            });

            $('#reset-data-confirm-btn').on('click', () => {
                $('.popup-overlay').fadeOut();
                $('#reset-data-popup').fadeOut();

                resetData();
            });
            $('#reset-data-cancel-btn').on('click', () => {
                $('.popup-overlay').fadeOut();
                $('#reset-data-popup').fadeOut();
            });

            $('#update-track-data-submit').on('click', () => $('#update-track-data-form').submit());
            $('#update-track-data-form').on('submit', function (e) {
                e.preventDefault();

                axios.post(
                    AJAX_URL + $(this).attr('action'),
                    $(this).serialize()
                ).then(response => updateCtrnfTable());
            });

            $('#select-language').on('change', () => {
                axios.post(
                    AJAX_URL + 'switch-language.php', {
                        lang: $('#select-language').val()
                    }
                ).then(response => window.location.reload());
            });

            $('#update-track-data-form').on('click', '[data-col="best-time"] input, [data-col="best-lap-time"] input', function () {
                $(this).siblings('select').show();
            });

            $('#update-track-data-form').on('click', '[data-col="best-time"] img, [data-col="best-lap-time"] img', function () {
                $(this).parent().siblings('select').show();
            });

            $('#update-track-data-form').on('change keyup', 'input, select', function () {
                $(this).css('color', '#f00').addClass('bg-red');
                $(this).parent('td').addClass('bg-red');
            });

            updateWorldRecords();

            $('#ctrnf-table-manager-popup-btn').on('click', () => {
                $('.popup-overlay').fadeIn();
                $('#ctrnf-table-manager-popup').fadeIn();
            });

            $('#ctrnf-table-options-popup-btn').on('click', () => {
                $('.popup-overlay').fadeIn();
                $('#ctrnf-table-options-popup').fadeIn();
            });

            $('#ctrnf-table-manager').on('submit', e => {
                e.preventDefault();

                toggleCtrnfTableCols();

                $('.popup-overlay').fadeOut();
                $('#ctrnf-table-manager-popup').fadeOut();
            });

            $('#ctrnf-table-options').on('submit', function (e) {
                e.preventDefault();

                axios.post(
                    AJAX_URL + $(this).attr('action'),
                    $(this).serialize()
                ).then(response => updateCtrnfTable());

                $('.popup-overlay').fadeOut();
                $('#ctrnf-table-options-popup').fadeOut();
            });
        });
    </script>
</head>
<body>
<header>
    <nav>
        <?php /*if (!is_last_app_version()): ?>
            <a href="update.php" class="c-red bg-red" style="float:right;">Mettre à jour en v<?= get_last_available_version() ?></a>
        <?php endif;*/ ?>

        <select id="select-language" style="float:right;">
            <option value="en" <?= (Lang::getLang() === 'en') ? 'selected' : '' ?>>English</option>
            <option value="fr" <?= (Lang::getLang() === 'fr') ? 'selected' : '' ?>>Français</option>
        </select>

        <button style="float:right;">CTRNF Sheet v<?= app_version() ?></button>

        <button id="reset-data-submit"><?= __('Réinitialiser') ?></button>
        <button id="update-track-data-submit"><?= __('Sauvegarder') ?></button>
        <button id="ctrnf-table-manager-popup-btn"><?= __('Gérer le tableau') ?></button>
        <button id="ctrnf-table-options-popup-btn"><?= __('Options') ?></button>
    </nav>
</header>

<main>
    <section>
        <form id="update-track-data-form" action="update-track-data.php" method="post">
        </form>
    </section>
</main>

<div class="popup-overlay">
    <?php View::render('ctrnf-table-manager-popup'); ?>
    <?php View::render('ctrnf-table-options-popup'); ?>
    <?php View::render('reset-data-popup'); ?>
</div>
</body>
</html>
