<?php

namespace app\controllers;

use app\core\App;
use app\core\View;
use app\models\Blog;

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
        $blog = new Blog();

        return new View('create', [
            'model' => $blog,
        ]);
    }

    public function save()
    {
        $blog = new Blog();
        $blog->loadData(App::request()->getBody());

        if (!$blog->validation())
            return new View('create', [
                'model' => $blog,
            ]);

        $blog->save();

        App::session()->setFlash('success', 'Thanks for registering!');

        App::response()->redirect('/');
        return 1;
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