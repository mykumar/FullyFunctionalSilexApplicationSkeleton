<?php
namespace App\Controllers;

use App\Models\Users;
use Silex\Application;

class IndexController extends BaseController
{
    public function index()
    {
        $this->status_code   = 200;
        $this->json['error'] = false;
        $this->json['users'] = Users::limit(5)->get(['id', 'email'])->toArray();

        return $this->sendJson();
    }
}