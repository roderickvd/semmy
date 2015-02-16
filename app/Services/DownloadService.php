<?php namespace App\Services;

class DownloadService {

    /*
	|--------------------------------------------------------------------------
    | HTTP Connection
    |--------------------------------------------------------------------------
    |
    | This  service downloads resources from an inverter. It implements cURL
    | with graceful degradation to fopen wrappers. Access it through the
    | HTTP facade.
    |
    */

    /**
     * Download an inverter resource using cURL.
     *
     * @param  string  $uri
     * @return string
     */
    protected function get_curl($url)
    {
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($session);

        curl_close($session);
        return $response;
    }

    /**
     * Download an inverter resource. cURL is preferred over fopen
     * wrappers, because cURL typically has better performance.
     *
     * @param  string  $uri
     * @return string
     */
    public function get($url)
    {
        if (function_exists('curl_version')) {
            $response = $this->get_curl($url);

        } else if (ini_get('allow_url_fopen')) {
            $response = file_get_contents($url);

        } else {
            Log::error('Load the cURL module or enable allow_url_fopen in your PHP configuration.');
        }

        return $response;
    }

}

?>
