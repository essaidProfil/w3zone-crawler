# w3zone-crawler

Good example to proceed  data scraping tests !
This is only for training and demonstration purposes.

For more details you can visit the source of package:
Source : https://packagist.org/packages/w3zone/crawler



Installation

composer require w3zone/Crawler

Requirements

    node.js > 4.x
    libcurl
    php-curl
    node.js request module

npm install request

Usage

require_once 'vendor/autoload.php';

use w3zone\Crawler\{Crawler, Services\phpCurl};

$crawler = new Crawler(new phpCurl);

$link = 'http://www.example.com';

// return an array [statusCode, body, headers, cookies]
// get method may contain link string or an array [url, query string]
$homePage = $crawler->get($link)->dumpHeaders()->run();

$response = $crawler->get($link)->dumpHeaders()->cookies($homePage['cookies'], 'r+w')->run();

Available Services

    phpCurl
    use w3zone\Crawler\Services\phpCurl;
    nodejsRequest
    use w3zone\Crawler\Services\nodejsRequest;
    cliCurl
    use w3zone\Crawler\Services\cliCurl;

Available Methods

    Get
    Crawler::get(mixed $arguments);
    set the request to GET method,
    accepts parameter holding the requested URL.

    Post
    Crawler::post(mixed $arguments);
    set the request to POST method,
    accepts an array of options

$arguments = [
    'url' => 'www.example.com/login',
    'data' => [
        'username' => '',
        'password' => ''
    ]
];

    Json
    Crawler::json(void)
    an easy way to create a json request.

    XML
    Crawler::xml(void)
    an easy way to create a xml request.

    Referer
    Crawler::referer(string $referer)
    set the current request referer.

    Headers
    Crawler::headers(array $headers)
    set the request additional headers,
    note that this function will overwrite json && xml functions.

    DumpHeaders
    Crawler::dumpHeaders(void)
    include the response headers in the object response.

    Proxy Crawler::proxy(mixed $proxy)
    set the request proxy IP and proxy type,
    note proxy method accepts an array of proxy IP and proxy Type or an IP string

$proxy = [
    'ip' => 'xx.xx.xx.xx:xx',
    'type' => 'socks5'
];

if you've passed an IP as a string the default type will be HTTP.

    Cookies
    Crawler::cookies(string $file, string $mode)
    set your proxy type, the first argument is a cookie string,
    the seccond argument is the cookie mode ,
    available modes :
    -- w : write only mode -- r : read only mode -- w+r : read and write

    Initialize
    Crawler::initialize(array $arguments)
    initialize or re-initialize your request
    note that , this method will overwrite the other options

    Run Crawler::run(void)
    fire the request.

Examples:-

Quick example to login into Github :-

require_once 'vendor/autoload.php';

use w3zone\Crawler\{Crawler, Services\phpCurl};

$crawler = new Crawler(new phpCurl);

$url = 'https://domaine.com/login';
$response = $crawler->get($url)->dumpHeaders()->run();

preg_match('#<input name="token".*?value="(.*?)"#', $response['body'], $token);

$url = 'https://domain.com/session';
$post['submit'] = 'Sign in';
$post['token'] = $token[1];
$post['login'] = 'valid email';
$post['password'] = '';

$response = $crawler
    ->post(['url' => $url, 'data' => $post])
    ->cookies($response['cookies'], 'w+r')
    ->initialize([
        CURLOPT_FOLLOWLOCATION => true
    ])
    ->dumpHeaders()
->run();


