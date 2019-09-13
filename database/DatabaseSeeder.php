<?php

namespace Database;

use App\DB;
use App\Game\Category;
use App\Game\Character;
use App\Game\Option;
use App\Game\Track;
use App\Game\TrackData;

/**
 * Class DatabaseSeeder
 * @package Database
 */
class DatabaseSeeder
{
    /**
     *
     */
    public static function execute()
    {
        self::createCharactersTable();
        self::createCategoriesTable();
        self::createTracksTable();
        self::createTrackDataTable();
        self::createOptionsTable();

        self::seedCharactersTable();
        self::seedCategoriesTable();
        self::seedTracksTable();
        self::seedTrackDataTable();
        self::seedOptionsTable();
    }

    /**
     * @param string $table
     * @param array $attributes
     * @return array|bool
     */
    protected static function create(string $table, array $attributes)
    {
        $values = [];

        foreach ($attributes as $attribute => $options) {
            $values[] = $attribute . ' ' . $options;
        }

        $values = join(',', $values);

        $query = " CREATE TABLE IF NOT EXISTS $table ($values)";

        return DB::execute($query);
    }

    /**
     * @return array|bool
     */
    protected static function createCategoriesTable()
    {
        $attributes = [
            'id' => 'integer not null primary key autoincrement',
            'slug' => 'text not null unique',
            'en_name' => 'text not null',
            'fr_name' => 'text not null'
        ];

        return self::create('categories', $attributes);
    }

    /**
     * @return array|bool
     */
    protected static function createTracksTable()
    {
        $attributes = [
            'id' => 'integer not null primary key autoincrement',
            'slug' => 'text not null unique',
            'en_name' => 'text not null',
            'fr_name' => 'text not null',
            'is_glitched' => 'integer default 0',
            'tropy_time' => 'integer',
            'oxide_time' => 'integer',
            'master_time' => 'integer',
            'master_time_url' => 'text',
            'wr_time' => 'integer',
            'wr_lap_time' => 'integer',
            'wr_time_character_id' => 'integer',
            'wr_lap_time_character_id' => 'integer',
            'wr_time_url' => 'text',
            'wr_lap_time_url' => 'text',
            'category_id' => 'integer'
        ];

        return self::create('tracks', $attributes);
    }

    protected static function createTrackDataTable()
    {
        $attributes = [
            'id' => 'integer not null primary key autoincrement',
            'console_rank' => 'integer',
            'best_time' => 'integer',
            'best_lap_time' => 'integer',
            'best_first_lap_time' => 'integer',
            'lap_1_time' => 'integer',
            'lap_2_time' => 'integer',
            'lap_3_time' => 'integer',
            'best_time_character_id' => 'integer',
            'best_lap_time_character_id' => 'integer',
            'track_id' => 'integer'
        ];

        return self::create('track_data', $attributes);
    }

    /**
     * @return array|bool
     */
    protected static function createOptionsTable()
    {
        $attributes = [
            'id' => 'integer not null primary key autoincrement',
            'slug' => 'text',
            'value' => 'text',
        ];

        return self::create('options', $attributes);
    }

    /**
     * @return array|bool
     */
    protected static function createCharactersTable()
    {
        $attributes = [
            'id' => 'integer not null primary key autoincrement',
            'slug' => 'text',
            'en_name' => 'text',
            'fr_name' => 'text',
            'class' => 'integer default ' . Character::CLASS_BALANCED
        ];

        return self::create('characters', $attributes);
    }

    /**
     *
     */
    protected static function seedCategoriesTable()
    {
        $data = [
            [
                'en_name' => 'N. Sanity Beach Area',
                'fr_name' => 'Zone N. Sanity Beach'
            ],
            [
                'en_name' => 'The Lost Ruins Area',
                'fr_name' => 'Zone Ruines Perdues'
            ],
            [
                'en_name' => 'Glacier Park Area',
                'fr_name' => 'Zone du Parc Glacier'
            ],
            [
                'en_name' => 'Citadel City Area',
                'fr_name' => 'Zone Ville de la Citadelle'
            ],
            [
                'en_name' => 'Gem Stone Valley Area',
                'fr_name' => 'Zone Vallée des Gemmes'
            ],
            [
                'en_name' => 'Crash Nitro Kart',
                'fr_name' => 'Crash Nitro Kart'
            ],
            [
                'en_name' => 'Bonus Tracks',
                'fr_name' => 'Circuits Bonus'
            ]
        ];

        foreach ($data as $item) {
            if (!Category::findBySlug(string_to_slug($item['en_name']))) {
                Category::build([
                    'en_name' => $item['en_name'],
                    'fr_name' => $item['fr_name']
                ])->save();
            }
        }
    }

    /**
     *
     */
    protected static function seedTracksTable()
    {
        $data = [
            'n-sanity-beach-area' => [
                [
                    'en_name' => 'Crash Cove',
                    'fr_name' => 'Crique Crash',
                    'is_glitched' => false,
                    'tropy_time' => 94860,
                    'oxide_time' => 87520,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Mystery Caves',
                    'fr_name' => 'Grotte Mystère',
                    'is_glitched' => false,
                    'tropy_time' => 144450,
                    'oxide_time' => 134000,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Sewer Speedway',
                    'fr_name' => 'Circuits Egoûts',
                    'is_glitched' => false,
                    'tropy_time' => 133700,
                    'oxide_time' => 116180,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Roo\'s Tubes',
                    'fr_name' => 'Tubes Roo',
                    'is_glitched' => true,
                    'tropy_time' => 94190,
                    'oxide_time' => 83650,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'the-lost-ruins-area' => [
                [
                    'en_name' => 'Coco Park',
                    'fr_name' => 'Parc Coco',
                    'is_glitched' => true,
                    'tropy_time' => 97530,
                    'oxide_time' => 89350,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Tiger Temple',
                    'fr_name' => 'Temple Tigre',
                    'is_glitched' => false,
                    'tropy_time' => 122750,
                    'oxide_time' => 115910,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Papu\'s Pyramid',
                    'fr_name' => 'Pyramide Papu',
                    'is_glitched' => true,
                    'tropy_time' => 119840,
                    'oxide_time' => 106240,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Dingo Canyon',
                    'fr_name' => 'Canyon Dingo',
                    'is_glitched' => true,
                    'tropy_time' => 108540,
                    'oxide_time' => 105470,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'glacier-park-area' => [
                [
                    'en_name' => 'Polar Pass',
                    'fr_name' => 'Col Polar',
                    'is_glitched' => false,
                    'tropy_time' => 180850,
                    'oxide_time' => 166970,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Tiny Arena',
                    'fr_name' => 'Arène Tiny',
                    'is_glitched' => false,
                    'tropy_time' => 231430,
                    'oxide_time' => 223220,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Dragon Mines',
                    'fr_name' => 'Mines Dragon',
                    'is_glitched' => false,
                    'tropy_time' => 105540,
                    'oxide_time' => 94620,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Blizzard Bluff',
                    'fr_name' => 'Falaises Glacées',
                    'is_glitched' => false,
                    'tropy_time' => 97380,
                    'oxide_time' => 88190,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'citadel-city-area' => [
                [
                    'en_name' => 'Hot Air Skyway',
                    'fr_name' => 'Piste Air',
                    'is_glitched' => false,
                    'tropy_time' => 201430,
                    'oxide_time' => 189890,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Cortex Castle',
                    'fr_name' => 'Château Cortex',
                    'is_glitched' => false,
                    'tropy_time' => 160390,
                    'oxide_time' => 156090,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'N. Gin Labs',
                    'fr_name' => 'Labo N.Gin',
                    'is_glitched' => true,
                    'tropy_time' => 171540,
                    'oxide_time' => 159650,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Oxide Station',
                    'fr_name' => 'Station Oxide',
                    'is_glitched' => false,
                    'tropy_time' => 210400,
                    'oxide_time' => 207670,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'gem-stone-valley-area' => [
                [
                    'en_name' => 'Slide Coliseum',
                    'fr_name' => 'Stade Glissade',
                    'is_glitched' => false,
                    'tropy_time' => 128490,
                    'oxide_time' => 120880,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Turbo Track',
                    'fr_name' => 'Circuit Turbo',
                    'is_glitched' => false,
                    'tropy_time' => 138540,
                    'oxide_time' => 126350,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'crash-nitro-kart' => [
                [
                    'en_name' => 'Inferno Island',
                    'fr_name' => 'Ile Infernale',
                    'is_glitched' => false,
                    'tropy_time' => 114410,
                    'oxide_time' => 106470,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Jungle Boogie',
                    'fr_name' => 'Jungle en Folie',
                    'is_glitched' => false,
                    'tropy_time' => 93890,
                    'oxide_time' => 87380,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Clockwork Wompa',
                    'fr_name' => 'Horloge Wumpa',
                    'is_glitched' => false,
                    'tropy_time' => 160090,
                    'oxide_time' => 143970,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Android Alley',
                    'fr_name' => 'Androïdes',
                    'is_glitched' => false,
                    'tropy_time' => 197590,
                    'oxide_time' => 178470,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Electron Avenue',
                    'fr_name' => 'Electrons',
                    'is_glitched' => false,
                    'tropy_time' => 253520,
                    'oxide_time' => 232230,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Deep Sea Driving',
                    'fr_name' => 'Eaux Profondes',
                    'is_glitched' => false,
                    'tropy_time' => 142900,
                    'oxide_time' => 125960,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Thunder Struck',
                    'fr_name' => 'Foudre',
                    'is_glitched' => true,
                    'tropy_time' => 184180,
                    'oxide_time' => 178680,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Tiny Temple',
                    'fr_name' => 'Petit Temple',
                    'is_glitched' => false,
                    'tropy_time' => 126890,
                    'oxide_time' => 107710,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Meteor Gorge',
                    'fr_name' => 'Gorges du Météore',
                    'is_glitched' => false,
                    'tropy_time' => 105560,
                    'oxide_time' => 99000,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Barin Ruins',
                    'fr_name' => 'Ruines de Barin',
                    'is_glitched' => false,
                    'tropy_time' => 127790,
                    'oxide_time' => 115210,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Out of Time',
                    'fr_name' => 'Hors-Temps',
                    'is_glitched' => false,
                    'tropy_time' => 180050,
                    'oxide_time' => 160090,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Assembly Lane',
                    'fr_name' => 'Production',
                    'is_glitched' => false,
                    'tropy_time' => 188760,
                    'oxide_time' => 180410,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Hyper Spaceway',
                    'fr_name' => 'Hyperespace',
                    'is_glitched' => false,
                    'tropy_time' => 180910,
                    'oxide_time' => 160790,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ],
            'bonus-tracks' => [
                [
                    'en_name' => 'Twilight Tour',
                    'fr_name' => 'Circuit du Crépuscule',
                    'is_glitched' => false,
                    'tropy_time' => 179990,
                    'oxide_time' => 157990,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Prehistoric Playground',
                    'fr_name' => 'Parc Préhistorique',
                    'is_glitched' => false,
                    'tropy_time' => 180080,
                    'oxide_time' => 161360,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ],
                [
                    'en_name' => 'Spyro Circuit',
                    'fr_name' => 'Circuit Spyro',
                    'is_glitched' => true,
                    'tropy_time' => 153090,
                    'oxide_time' => 140540,
                    'master_time' => 0,
                    'master_time_url' => 'https://www.youtube.com/'
                ]
            ]
        ];

        foreach ($data as $category_slug => $category_tracks) {
            $category = Category::findBySlug($category_slug);

            foreach ($category_tracks as $item) {
                if (!Track::findBySlug(string_to_slug($item['en_name']))) {
                    Track::buildForCategory($category->getId(),
                        [
                            'en_name' => $item['en_name'],
                            'fr_name' => $item['fr_name'],
                            'is_glitched' => $item['is_glitched'],
                            'tropy_time' => $item['tropy_time'],
                            'oxide_time' => $item['oxide_time'],
                            'master_time' => $item['master_time'],
                            'master_time_url' => $item['master_time_url'],
                            'wr_time' => null,
                            'wr_lap_time' => null,
                            'wr_time_url' => null,
                            'wr_lap_time_url' => null
                        ])->save();
                }
            }
        }
    }

    /**
     *
     */
    protected static function seedTrackDataTable()
    {
        $tracks = Track::get();

        foreach ($tracks as $track) {
            if (!$track->getData()) {
                TrackData::buildForTrack($track->getId())->save();
            }
        }
    }

    /**
     *
     */
    protected static function seedOptionsTable()
    {
        if (!Option::findBySlug('language')) {
            Option::build([
                'slug' => 'language',
                'value' => 'en'
            ])->save();
        }

        if (!Option::findBySlug('app-major-version')) {
            Option::build([
                'slug' => 'app-major-version',
                'value' => '0'
            ])->save();
        }

        if (!Option::findBySlug('app-minor-version')) {
            Option::build([
                'slug' => 'app-minor-version',
                'value' => '1'
            ])->save();
        }

        if (!Option::findBySlug('app-build-version')) {
            Option::build([
                'slug' => 'app-build-version',
                'value' => '0'
            ])->save();
        }

        if (!Option::findBySlug('console')) {
            Option::build([
                'slug' => 'console',
                'value' => 'PS4'
            ])->save();
        }

        if (!Option::findBySlug('console-rank-goal')) {
            Option::build([
                'slug' => 'console-rank-goal',
                'value' => '1000'
            ])->save();
        }
    }

    /**
     *
     */
    protected static function seedCharactersTable()
    {
        $data = [
            Character::CLASS_BALANCED => [
                'Crash Bandicoot', 'Dr. Neo Cortex', 'Komodo Joe', 'Fake Crash', 'Oxide', 'Small Norm', 'Geary', 'Hunter'
            ],
            Character::CLASS_ACCELERATION => [
                'Coco Bandicoot', 'Dr. N. Gin', 'Pinstripe', 'N. Trance', 'Nash', 'Tawna', 'Isabella', 'Baby Coco'
            ],
            Character::CLASS_TURN => [
                'Polar', 'Pura', 'Penta Penguin', 'Zam', 'Krunk', 'Real Velo', 'Megumi', 'Liz', 'Gnasty Gnorc', 'Ripper Roo', 'Baby Crash'
            ],
            Character::CLASS_SPEED => [
                'Tiny Tiger', 'Dingodile', 'Papu Papu', 'N. Tropy', 'Crunch Bandicoot', 'Zem', 'Big Norm', 'Ami', 'Spyro', 'Baby T'
            ],
        ];

        foreach ($data as $class => $characters) {
            foreach ($characters as $name) {
                if (!Character::findBySlug(string_to_slug($name))) {
                    Character::build([
                        'en_name' => $name,
                        'fr_name' => $name,
                        'class' => $class
                    ])->save();
                }
            }
        }
    }
}