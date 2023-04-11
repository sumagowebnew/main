<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Laravel\Lumen\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API",
 *      description="API description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
*/
class Controller extends BaseController
{
    use ApiResponse;
}
