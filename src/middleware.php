<?php
// Application middleware


/*
 * Enable Cross-origin resource sharing
 */
$corsOptions = array(
    "origin" => "*",
    "exposeHeaders" => array("X-My-Custom-Header", "X-Another-Custom-Header"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$cors = new \CorsSlim\CorsSlim($corsOptions);
$app->add($cors);




/*
 * Enable Session Control
 */
$app->add(new \Slim\Middleware\Session([
    'name' => 'system',
    'autorefresh' => true,
    'lifetime' => '1 hour'
]));


// Check permissions
$app->add(function ($request, $response, $next) {
    
    $session = new \SlimSession\Helper;
    $user = $session->get("user", NULL);
       
//     var_dump($request);
//     die;
    
    $route = $request->getAttribute('route');
    
   // var_dump($route->getName());die;
    $routeName = $route->getName();

    //If user not logged allow public pages
    $allowed = $user->allowed ?? array( "home",
                                        "logout",
                                        "login");

    
    if (!in_array($routeName, $allowed)) {        
        $response = $response->withRedirect('/logout/Usuário sem previlégios para este acesso.');
    }
    
    return $response = $next($request, $response);
});