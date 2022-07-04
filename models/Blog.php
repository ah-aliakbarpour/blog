<?php

namespace app\models;

use app\core\App;
use app\core\db\DbModel;
use app\core\exception\NotFoundException;

class Blog extends DbModel
{
    public const USER_ID = '1';

    public string $user_id = Blog::USER_ID;
    public string $id = '';
    public string $title = '';
    public string $author = '';
    public string $context = '';
    public string $created_at = '';
    public ?string $updated_at = null;

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'context' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title',
            'author' => 'Author',
            'context' => 'Context',
        ];
    }

    public function tableName(): string
    {
        return 'blogs';
    }

    public function attributes(): array
    {
        return [
            'user_id',
            'title',
            'context',
        ];
    }

    public function findOne($where)
    {
        $blog = parent::findOne($where);

        $this->id = $blog->id;
        $this->title = $blog->title;
        $this->context = $blog->context;
        $this->created_at = $blog->created_at;
        $this->updated_at = $blog->updated_at;

        $user = new User();
        $user = $user->findOne(['id' => ['=', Blog::USER_ID]]);
        $this->author = $user->name;

        return $blog;
    }

    public function loadData($data): void
    {
        foreach ($data as $key => $value)
            if (property_exists($this, $key))
                $this->{$key} = $value;

        $user = new User();
        $user = $user->findOne(['id' => ['=', Blog::USER_ID]]);
        $this->author = $user->name;
    }

    public function checkUserAccess(): bool
    {
        $user = new User();
        $user = $user->findOne(['id' => ['=', Blog::USER_ID]]);

        if ($user->access === '0') {
            App::session()->setFlash('danger', 'You don\'t have access to this action!');
            App::response()->redirect('/blog');
            return false;
        }

        return true;
    }

    public function checkId($id)
    {
        $blog = $this->findOne(['id' => ['=', $id]]);

        if (!$blog)
            throw new NotFoundException();

        return $blog;
    }

    public function save(): bool
    {
        parent::save();

        App::session()->setFlash('success', 'Blog created successfully!');
        App::response()->redirect('/blog');

        return true;
    }

    public function update($id): bool
    {
        parent::update($id);

        App::session()->setFlash('success', 'Blog edited successfully!');
        App::response()->redirect('/blog');

        return true;
    }

    public function destroy($id): bool
    {
        parent::destroy($id);

        App::session()->setFlash('success', 'Blog deleted successfully!');
        App::response()->redirect('/blog');

        return true;
    }
}