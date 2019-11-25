<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;

class JsonMiddleware
{
    protected $factory;

    /**
    * JsonMiddleware constructor.
    *
    * @param ResponseFactory $factory
    */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Makes sure that all responses are json
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);

        // if the response is not a json we modify it.
        if (!$response instanceof JsonResponse) {
            $headers = $response->headers->all();
            $headers["content-type"] = "application/json";

            $response = $this->factory->json(
                $response->content(),
                $response->status(),
                $headers
            );
        }

        return $response;
    }
}
