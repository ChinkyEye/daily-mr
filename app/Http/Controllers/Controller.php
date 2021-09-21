<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Helper\Helper;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Request $request, Helper $helper, Guard $auth)
    {
      $this->request = $request;
      $this->helper = $helper;
    }
}
