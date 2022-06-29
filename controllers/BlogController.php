<?php

namespace app\controllers;

use app\core\View;

class BlogController
{
    public function index()
    {
        //
    }

    public function show($id)
    {
        echo $id;
        exit();
    }

    public function create()
    {
        return new View('create');
    }

    public function save()
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}