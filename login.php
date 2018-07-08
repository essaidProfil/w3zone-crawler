<?php
require_once 'vendor/autoload.php';

use w3zone\Crawler\{Crawler, Services\phpCurl};

$crawler = new Crawler(new phpCurl);

$url = 'http://domaine.com/login';
$response = $crawler->get($url)->dumpHeaders()->run();

preg_match('#<input name="token".*?value="(.*?)"#', $response['body'], token);

$url = 'https://domaine.com/session';
$post['submit'] = 'Sign in';
$post['token'] = token[1];
$post['login'] = '';
$post['password'] = '';

$response = $crawler
    ->post(['url' => $url, 'data' => $post])
    ->cookies($response['cookies'], 'w+r')
    ->initialize([
        CURLOPT_FOLLOWLOCATION => true
    ])
    ->dumpHeaders()
->run();


// Just for testing purposes
var_dump($response);


?>
