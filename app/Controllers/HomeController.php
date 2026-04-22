<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Researcher;

class HomeController extends Controller
{
    public function index()
    {
        $researcherModel = new Researcher();
        $researchers = $researcherModel->getAll('id', 'DESC');

        $this->view('home', [
            'title' => 'Welcome to IRB System',
            'researchers' => $researchers,
        ]);
    }
}