<?php

use App\Game\Option;
use App\Lang;
use App\GithubApi;

/*
 * String helpers.
 */
if (!function_exists('uc_after_spechars')) {
    /**
     * @param string $string
     * @return string
     */
    function uc_after_spechars(string $string): string
    {
        return ucfirst(
            preg_replace_callback('/([^\w]|_)([a-z0-9])/', function ($matches) {
                return ucfirst($matches[2]);
            }, $string)
        );
    }
}

if (!function_exists('string_to_slug')) {
    /**
     * @param string $string
     * @return string
     */
    function string_to_slug(string $string): string
    {
        $string = strtolower($string);
        $string = preg_replace('/[^\w]/', '-', $string);
        $string = preg_replace('/-{2,}/', '-', $string);
        $string = preg_replace('/_/', '-', $string);

        return $string;
    }
}

/*
 * Object helpers.
 */
if (!function_exists('has_getter')) {
    /**
     * @param $object
     * @param string $property
     * @return bool
     */
    function has_getter($object, string $property): bool
    {
        return method_exists($object, get_getter($object, $property));
    }
}

if (!function_exists('get_getter')) {
    /**
     * @param $object
     * @param string $property
     * @return string
     */
    function get_getter($object, string $property): string
    {
        $getter = 'get' . uc_after_spechars($property);

        if (!method_exists($object, $getter)) {
            $getter = lcfirst(uc_after_spechars($property));
        }

        return $getter;
    }
}

if (!function_exists('has_setter')) {
    /**
     * @param $object
     * @param string $property
     * @return bool
     */
    function has_setter($object, string $property): bool
    {
        return method_exists($object, get_setter($object, $property));
    }
}

if (!function_exists('get_setter')) {
    /**
     * @param $object
     * @param string $property
     * @return string
     */
    function get_setter($object, string $property): string
    {
        $setter = 'set' . uc_after_spechars($property);

        if (!method_exists($object, $setter)) {
            $setter = lcfirst(uc_after_spechars($property));
        }

        return $setter;
    }
}

if (!function_exists('is_property_complete')) {
    /**
     * @param $object
     * @param string $property
     * @return bool
     */
    function is_property_complete($object, string $property): bool
    {
        return property_exists($object, $property)
            && has_getter($object, $property)
            && has_setter($object, $property);
    }
}

/*
 * File & Directory helpers.
 */
if (!function_exists('remove_directory')) {
    /**
     * @param string $dir
     * @return bool
     */
    function remove_directory(string $dir): bool
    {
        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            (is_dir("$dir/$file"))
                ? remove_directory("$dir/$file")
                : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
}

if (!function_exists('copy_directory')) {
    /**
     * @param string $source
     * @param string $destination
     */
    function copy_directory(string $source, string $destination)
    {
        $dir = opendir($source);

        @mkdir($destination);

        while ($file = readdir($dir)) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($source . '/' . $file)) {
                    copy_directory($source . '/' . $file, $destination . '/' . $file);
                } else {
                    copy($source . '/' . $file, $destination . '/' . $file);
                }
            }
        }

        closedir($dir);
    }
}

/*
 * App helpers.
 */
if (!function_exists('env')) {
    /**
     * @param string|null $key
     * @return array
     */
    function env(?string $key = null)
    {
        if (preg_match('/\/|\\\\$/', $_SERVER['DOCUMENT_ROOT'])) {
            $content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . 'env');
        } else {
            $content = file_get_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'env');
        }

        $key = strtolower($key);
        $data = [];

        foreach (explode("\n", $content) as $line) {
            $line_data = explode('=', strtolower($line));

            if ($key === trim($line_data[0])) {
                return trim($line_data[1]);
            }

            $data[trim($line_data[0])] = trim($line_data[1]);
        }

        return $data;
    }
}

if (!function_exists('app_version')) {
    /**
     * @return string
     */
    function app_version(): string
    {
        return join('.', [
            Option::findBySlug('app-major-version')->getValue(),
            Option::findBySlug('app-minor-version')->getValue(),
            Option::findBySlug('app-build-version')->getValue()
        ]);
    }
}

if (!function_exists('is_last_app_version')) {
    function is_last_app_version(): bool
    {
        $local_app_version = explode('.', app_version());
        $last_app_version = explode('.', get_last_available_version());

        if ((int)$local_app_version[0] < (int)$last_app_version[0]) {
            return false;
        } else if ((int)$local_app_version[1] < (int)$last_app_version[1]) {
            return false;
        } else if ((int)$local_app_version[2] < (int)$last_app_version[2]) {
            return false;
        }

        return true;
    }
}

if (!function_exists('github')) {
    /**
     * @param array $query
     * @param array|null $variables
     * @return mixed
     */
    function github(array $query, ?array $variables = null)
    {
        return GithubApi::call($query, $variables);
    }
}

if (!function_exists('get_last_available_version')) {
    /**
     * @return string
     */
    function get_last_available_version(): string
    {
        $query = [
            'query ($orderBy: ReleaseOrder)' => [
                'repository(owner: "iArcadia", name: "' . env('GITHUB_REPOSITORY') . '")' => [
                    'releases(first: 1, orderBy: $orderBy)' => [
                        'nodes' => [
                            'name',
                            'tagName',
                            'createdAt'
                        ]
                    ]
                ]
            ]
        ];

        $variables = [
            'orderBy' => [
                'field' => 'CREATED_AT',
                'direction' => 'DESC'
            ]
        ];

        return github($query, $variables)->data->repository->releases->nodes[0]->tagName;
    }
}

if (!function_exists('download_last_available_version_sources')) {
    function download_last_available_version_sources()
    {
        $version = get_last_available_version();
        $url = 'https://github.com/iArcadia/' . env('GITHUB_REPOSITORY') . '/archive/' . $version . '.zip';

        file_put_contents('update.zip', fopen($url, 'r'));

        $zip = new \ZipArchive;

        if ($zip->open('update.zip') === true) {
            $zip->extractTo('__update/');
            $zip->close();

            unlink('update.zip');

            $directory = '__update/' . env('GITHUB_REPOSITORY') . '-' . $version . '/';

            remove_directory($directory . 'examples');

            remove_directory('__update');
        }

        return;

        $version = explode('.', $version);

        Option::findBySlug('app-major-version')->setValue($version[0])->save();
        Option::findBySlug('app-minor-version')->setValue($version[1])->save();
        Option::findBySlug('app-build-version')->setValue($version[2])->save();
    }
}

if (!function_exists('composer')) {
    /**
     * @param string $params
     * @return array
     */
    function composer(string $params): array
    {
        exec('php composer.phar ' . $params . ' 2>&1', $output);

        return $output;
    }
}

if (!function_exists('refresh')) {
    /**
     *
     */
    function refresh()
    {
        header('Location: ' . env('ROOT_URL'));
    }
}

if (!function_exists('__')) {
    /**
     * @param string $key
     * @return string
     */
    function __(string $key): string
    {
        return Lang::translate($key);
    }
}