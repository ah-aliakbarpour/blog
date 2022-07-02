<?php

namespace app\controllers;

use app\core\App;
use app\core\exception\NotFoundException;
use app\core\View;
use app\models\Blog;
use app\models\SearchContext;
use app\models\Search;

class BlogController
{
    public Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

    protected function checkId($id)
    {
        $blog = $this->blog->findOne(['id' => ['=', $id]]);

        if (!$blog)
            throw new NotFoundException();

        return $blog;
    }

    public function index($params)
    {
        // Search
        $search = new Search();
        $search->loadData(App::request()->getBody());

        // Pagination
        $currentPage = $params['page'] ?? 1;
        if (!is_numeric($currentPage) || $currentPage < 1)
            $currentPage = 1;
        $currentPage = intval($currentPage);

        $limit = 5;
        // Count all records
        $allRecords = $this->blog->count([
            'title' => ['LIKE' , $search->search, '%', '%'],
        ]);

        $blogs = $this->blog->paginate($currentPage, $limit, [
            'title' => ['LIKE' , $search->search, '%', '%'],
        ]);

        return new View('blog/index', [
            'blogs' => $blogs,
            'search' => $search,
            'allRecords' => $allRecords,
            'currentPage' => $currentPage,
            'limit' => $limit,
        ]);
    }

    public function show($params)
    {
        $id = $params['id'];
        $blog = $this->checkId($id);

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
        echo 111;
        exit();
        return true;
    }

    public function edit($params)
    {
        $id = $params['id'];
        $blog = $this->checkId($id);

        $this->blog->id = $blog->id;
        $this->blog->title = $blog->title;
        $this->blog->author = $blog->author;
        $this->blog->context = $blog->context;

        return new View('blog/edit', [
            'blog' => $this->blog,
            'id' => $id,
        ]);
    }

    public function update($params)
    {
        $id = $params['id'];
        $this->checkId($id);

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

    public function destroy($params)
    {
        $id = $params['id'];
        $blog = $this->checkId($id);

        $this->blog->destroy($id);

        App::session()->setFlash('success', 'Blog deleted successfully!');
        App::response()->redirect('/blog');
        return true;
    }
}