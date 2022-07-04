<?php

namespace app\controllers;

use app\core\App;
use app\core\exception\NotFoundException;
use app\core\View;
use app\models\Blog;
use app\models\SearchContext;
use app\models\Search;
use mysql_xdevapi\Result;

class BlogController
{
    public Blog $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

//    protected function checkId($id)
//    {
//        $blog = $this->blog->findOne(['id' => ['=', $id]]);
//
//        if (!$blog)
//            throw new NotFoundException();
//
//        return $blog;
//    }

    public function index($params)
    {
        $search = new Search();
        $search->loadData(App::request()->getBody());

        $paginate = $this->blog->paginate($params['page'] ?? 1, 5, [
            ['title', 'context', 'name'], $search->search,
        ]);

        return new View('blog/index', [
            'paginate' => $paginate,
            'search' => $search,
        ]);
    }

    public function show($params)
    {
        $id = $params['id'];
        $this->blog->checkId($id);

        return new View('blog/show', [
            'blog' => $this->blog,
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

        return $this->blog->save();
    }

    public function edit($params)
    {
        if (!$this->blog->checkUserAccess())
            return false;

        $id = $params['id'];
        $this->blog->checkId($id);

        return new View('blog/edit', [
            'blog' => $this->blog,
            'id' => $id,
        ]);
    }

    public function update($params)
    {
        if (!$this->blog->checkUserAccess())
            return false;

        $id = $params['id'];
        $this->blog->checkId($id);

        $this->blog->loadData(App::request()->getBody());
        if (!$this->blog->validation())
            return new View('blog/edit', [
                'blog' => $this->blog,
                'id' => $id,
            ]);

        return $this->blog->update($id);
    }

    public function destroy($params)
    {
        if (!$this->blog->checkUserAccess())
            return false;

        $id = $params['id'];
        $this->blog->checkId($id);

        return $this->blog->destroy($id);
    }
}