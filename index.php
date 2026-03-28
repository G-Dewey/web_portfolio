<?php
session_start();

error_reporting(E_ALL & ~E_DEPRECATED);

// Aviods hard coded URLs
define('BASE_URL', '/web_portfolio');

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$prefix = '/web_portfolio';

require "vendor/autoload.php";

$router = new RouteCollector();


$router->filter("admin", function(){
    if (!isset($_SESSION['userID']) || $_SESSION['role'] != "admin") {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "Please login to access this page.";
        echo "<a href='login'>click here to be redirected</a>";
        exit(); 
    }
});

$router->filter("user", function(){
    $validRole = ["trainee" , "admin"];

    if (!isset($_SESSION['userID']) || !in_array($_SESSION['role'], $validRole)) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "Please login to access this page.";
        echo "<a href='login'>click here to be redirected</a>";
        exit(); 
    }
});


$router->group(['prefix' => $prefix], function($router) {

    $router->get('/', function() {
        require "pages/auth/login.php";
    });

    $router->get('/login', function() {
        require 'pages/auth/login.php';
    });
    
    $router->get('/password-reset', function(){
        require 'pages/auth/password-reset.php';
    });

    $router->POST('/auth', function() {
        require 'pages/auth/auth.php';
    });

    $router->POST('/check-locked', function() {
        require 'api/check-locked.php';
    });

    $router->get('/logout', function() {
        require 'pages/auth/logout.php';
    });


    // USER FILTER
    $router->group(['before' => 'user'], function($router){
        $router->get('/dashboard', function() {
            require 'pages/user/dashboard.php';
        });

        $router->get('/explore-courses', function() {
            require 'pages/user/explore-courses.php';
        });

        $router->get('/view-enrollments', function() {
            require 'pages/user/view-enrollment.php';
        });

        $router->get('/user-details', function() {
            require 'pages/user/user-details.php';
        });

        // USER API CALLS
        $router->get('/api/get-self', function(){
            require 'api/users/get-self.php';
        });
        
        $router->get('/api/get-courses', function(){
            require 'api/courses/get-all.php';
        });

        $router->get('/api/completed-count', function(){
            require 'api/enrollments/completed-count.php';
        });
        
        $router->POST('/api/get-single-course', function() {
            require 'api/courses/get-one.php';
        });

        $router->POST('/api/enroll-course', function() {
            require 'api/enrollments/enroll-course.php';
        });

        $router->POST('/api/delete-enrollment', function() {
            require 'api/enrollments/unenroll-course.php';
        });

        $router->POST('/api/check-enrollment', function() {
            require 'api/enrollments/check-enrolled.php';
        });

        $router->POST('/api/user-enrollments', function() {
            require 'api/enrollments/user-enrollments.php';
        });
    });

    //ADMIN FILTER
    $router->group(['before' => 'admin'], function($router){
        $router->get('/admin-dashboard', function() {
            require 'pages/admin/dashboard-admin.php';
        });

        $router->get('/course-administration', function() {
            require 'pages/admin/course-administration.php';
        });

        $router->get('/user-administration', function() {
            require 'pages/admin/user-administration.php';
        });

        //ADMIN API CALLS  
        $router->get('/api/get-users', function(){
            require 'api/users/get-all.php';
        });

        $router->get('/api/user-count', function() {
            require 'api/users/user-count.php';
        });

        $router->get('api/all-users-table', function() {
            require 'api/users/user-table.php';
        });

        $router->POST('api/create-new-user', function() {
            require 'api/users/add-user.php';
        });

        $router->POST('api/edit-user', function() {
            require 'api/users/edit-user.php';
        });

        $router->POST('api/delete-user', function() {
            require 'api/users/delete-user.php';
        });

        $router->POST('api/create-new-course', function() {
            require 'api/courses/add-course.php';
        });

        $router->POST('api/delete-course', function() {
            require 'api/courses/delete-course.php';
        });

        $router->POST('api/edit-course', function() {
            require 'api/courses/edit-course.php';
        });

        $router->get('/api/course-count', function() {
            require 'api/courses/course-count.php';
        });

        $router->POST('/api/course-enrollments', function() {
            require 'api/enrollments/course-enrollments.php';
        }); 

        $router->get('/api/enrollment-count', function() {
            require 'api/enrollments/enrollment-count.php';
        });
    });
});

$dispatcher = new Dispatcher($router->getData());

try {
    $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $path);
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    echo "<p>The page you are looking for does not exist.</p>";
    echo "<a href='" . BASE_URL . "'>Go to Home</a>";
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    http_response_code(405);
    echo "<h1>405 Method Not Allowed</h1>";
    echo "<p>The request method is not supported for this route.</p>";
}

?>