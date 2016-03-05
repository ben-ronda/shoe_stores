<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
     'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app){
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post("/added_brands", function() use ($app){
        $new_brand = new Brand($_POST['brand_name']);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post("/added_stores", function() use ($app){
        $new_store = new Store($_POST['store_name']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->get('/add_brand', function() use ($app){
        return $app['twig']->render('add_brand.html.twig', array('brands' => Brand::getAll()));
    });

    $app->get('/add_store', function() use ($app){
        return $app['twig']->render('add_store.html.twig', array('stores' => Store::getAll()));
    });

    $app->get('/brands/{id}', function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('brands.html.twig', array('store' => $store, 'brands' => $store->getBrands()));
    });

    return $app;
?>
