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

    $app->post('/delete_all_brands', function() use ($app){
        Brand::deleteAll();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post('/delete_all_stores', function() use ($app){
        Store::deleteAll();
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

    $app->get('/brand/{id}', function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render('stores.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->post('/brand/{id}', function($id) use ($app){
        $brand = Brand::find($id);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        return $app['twig']->render('stores.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

    $app->delete("/delete_store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' =>Store::getAll()));
    });

    $app->delete("/delete_brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();
        return $app['twig']->render('index.html.twig', array('brands' => Brand::getAll(), 'stores' =>Store::getAll()));
    });

    $app->get('/store/{id}', function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render('brands.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->post('/store/{id}', function($id) use ($app){
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($id);
        $store->addBrand($brand);
        return $app['twig']->render('brands.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });



    return $app;
?>
