<?php

error_reporting(E_ERROR);
define('CACHE_LOCATION', __DIR__ . '/.cache');

if(!function_exists('sanitize')) {
    /**
     * @inheritDoc
     * @param string $input User input
     *
     * @return string
     */
    function sanitize($input) {
        return htmlspecialchars(stripslashes(trim($input)));
    }
}

if(!function_exists('resolveCachePath')) {
    /**
     * @inheritDoc
     * @param string $file Path to cache file
     *
     * @return string
     */
    function resolveCachePath($file) {
        if(!file_exists(CACHE_LOCATION)) {
            if (!mkdir(CACHE_LOCATION, 0777, true) && !is_dir(CACHE_LOCATION)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', CACHE_LOCATION));
            }
        }

        return CACHE_LOCATION . '/' . $file;
    }
}

if(!function_exists('fileTTL')) {
    /**
     * @inheritDoc
     * @param string $filePath Path to cache file
     *
     * @return int
     */
    function fileTTL($filePath) {
        if(!file_exists($filePath)) {
            return 0;
        }

        return filemtime($filePath);
    }
}

if(!function_exists('cacheFetchURL')) {
    /**
     * @inheritDoc
     * @param string $name Cache key
     * @param string $url URL to load data from
     * @param int $cacheFor Cache ttl in seconds
     *
     * @return bool|false|string
     */
    function cacheFetchURL($name, $url, $cacheFor = 600) {
        $cachePath = resolveCachePath($name);
        clearstatcache(true, $cachePath);

        if (!file_exists($cachePath) || fileTTL($cachePath) < time() - $cacheFor) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_URL, $url);

            $response = curl_exec($ch);
            $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if($responseCode === 200) {
                file_put_contents($cachePath, $response);
                touch($cachePath);
            }

            curl_close($ch);
        }

        return file_get_contents($cachePath);
    }
}

switch (strtolower(sanitize($_GET['action']))) {
    case 'flag':

        $countryCode = strtoupper(sanitize($_GET['country']));
        $key = 'flag_of_' . $countryCode . '.png';
        $cacheTtl = 365 * 24 * 60 * 60;

        header('Content-Type: image/png');
        header('Cache-Control: public, max-age: ' . $cacheTtl);
        header('ETag: ' . fileTTL(resolveCachePath($key)));

        echo cacheFetchURL(
            $key,
            'https://www.countryflags.io/' . $countryCode . '/flat/64.png',
            $cacheTtl
        );

        break;

    case 'geojson':

        $key = 'geojson.json';
        $cacheTtl = 365 * 24 * 60 * 60;

        header('Content-Type: application/json');
        header('Cache-Control: public, max-age: ' . $cacheTtl);
        header('ETag: ' . fileTTL(resolveCachePath($key)));

        echo cacheFetchURL(
            $key,
            'https://api.quarantine.country/geojson.json',
            $cacheTtl
        );

        break;

    case 'summary':

        $key = 'summary.json';
        $cacheTtl = 5 * 60;

        header('Content-Type: application/json');
        header('Cache-Control: private, max-age: ' . $cacheTtl);
        header('ETag: ' . fileTTL(resolveCachePath($key)));

        echo cacheFetchURL(
            $key,
            'https://api.quarantine.country/api/v1/summary/latest',
            5 * 60
        );

        break;

    case 'spots':

        $key = 'spots.json';
        $cacheTtl = 5 * 60;

        header('Content-Type: application/json');
        header('Cache-Control: private, max-age: ' . $cacheTtl);
        header('ETag: ' . fileTTL(resolveCachePath($key)));

        echo cacheFetchURL(
            $key,
            'https://api.quarantine.country/api/v1/spots/summary',
            $cacheTtl
        );

        break;

    case 'news':

        $key = 'news.json';
        $cacheTtl = 5 * 60;

        header('Content-Type: application/json');
        header('Cache-Control: private, max-age: ' . $cacheTtl);
        header('ETag: ' . fileTTL(resolveCachePath($key)));

        echo cacheFetchURL(
            $key,
            'https://covid19-news.herokuapp.com/api/covid19/news',
            $cacheTtl
        );

        break;

    default:
        http_response_code(404);
        break;
}