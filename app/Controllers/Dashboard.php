<?php namespace  App\Controllers;

Class Dashboard extends BaseController
{
    public function index()
    {
        $data = [];

        echo view('templates/header', $data);
        echo view('dashboard');
        echo view('templates/footer');
    }
}