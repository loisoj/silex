<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Hashids\Hashids;
use Symfony\Component\Validator\Constraints as Assert;
use Predis\Client;

/**
 * $client Predis\Client
 */
$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'redis',
    'port'   => 6379,
]);

//Request::setTrustedProxies(array('127.0.0.1'));

/**
 * @var $app Silex\Application
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->get('/{hash}',function($hash) use ($app, $client){

    $link['url'] = $client->get($hash);

    if($link['url'] == null) {
        $hashids = new Hashids('', 6);

        $ids = $hashids->decode($hash);

        $hashId = $ids[0];

        $sql = "SELECT url FROM silex_link WHERE id = ?";

        $link = $app['db']->fetchAssoc($sql, array($hashId));

        if($link !== false) {
            $client->set($hash, $link['url']);
        }
    }


    if($link !== null && $link !== false && strlen($link['url'])) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: " . $link['url']);
    }
    exit();

})->bind('get');

$app->post('/',function(Request $request) use ($app, $client){

    $link = array(
        'url' => $request->request->get('url')
    );

    $app['db']->insert('silex_link', array(
            'url' => $link['url']
        )
    );

    $urlId = $app['db']->lastInsertId();

    $hashids = new Hashids('', 6);

    $id = $hashids->encode($urlId);

    $client->set($id, $link['url']);

    return $app->json(['url' => 'http://'.$_ENV['HTTP_HOST'].'/'.$id]);

})->bind('post');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});