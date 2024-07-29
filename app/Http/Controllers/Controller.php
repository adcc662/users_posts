<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Users Post API",
 *     description="API documentation for the Users Post API",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 */

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
