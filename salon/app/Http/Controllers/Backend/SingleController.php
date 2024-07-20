<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class SingleController extends Controller
{
    public function __invoke() {
        echo "Ben hemen çalıştım";
    }

}
