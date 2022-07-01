<?php

namespace app\controllers;

use app\core\App;
use app\core\exception\NotFoundException;
use app\core\View;
use app\models\Blog;

class BlogController
{
    public Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

    public function index()
    {
        $blogs = $this->blog->get();

        return new View('blog/index', [
            'blogs' => $blogs
        ]);
    }

    public function show($id)
    {
        $blog = $this->blog->findOne(['id' => $id]);

        if (!$blog)
            throw new NotFoundException();

        return new View('blog/show', [
            'blog' => $blog,
            'id' => $id,
        ]);
    }

    public function create()
    {
        return new View('blog/create', [
            'blog' => $this->blog,
        ]);
    }

    public function save()
    {
        $this->blog->loadData(App::request()->getBody());

        if (!$this->blog->validation())
            return new View('blog/create', [
                'blog' => $this->blog,
            ]);

        $this->blog->save();

        App::session()->setFlash('success', 'Blog created successfully!');

        App::response()->redirect('/blog');

        return true;
    }

    public function edit($id)
    {
        $blog = $this->blog->findOne(['id' => $id]);

        if (!$blog)
            throw new NotFoundException();

        $this->blog->id = $blog->id;
        $this->blog->title = $blog->title;
        $this->blog->author = $blog->author;
        $this->blog->context = $blog->context;

        return new View('blog/edit', [
            'blog' => $this->blog,
            'id' => $id,
        ]);
    }

    public function update($id)
    {
        $blog = $this->blog->findOne(['id' => $id]);

        if (!$blog)
            throw new NotFoundException();

        $this->blog->loadData(App::request()->getBody());

        if (!$this->blog->validation())
            return new View('blog/edit', [
                'blog' => $this->blog,
                'id' => $id,
            ]);

        $this->blog->update($id);

        App::session()->setFlash('success', 'Blog edited successfully!');

        App::response()->redirect('/blog');

        return true;
    }

    public function destroy($id)
    {
        $blog = $this->blog->findOne(['id' => $id]);

        if (!$blog)
            throw new NotFoundException();

        $this->blog->destroy($id);

        App::session()->setFlash('success', 'Blog deleted successfully!');

        App::response()->redirect('/blog');

        return true;
    }
}