<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Entities\BlogComment;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        BlogCategory::insert([
            [
                'user_id' => 1,
                'title' => 'PHP',
                'position_order' => 1,
                'parent_id' => null,
            ],
            [
                'user_id' => 1,
                'title' => 'Laravel',
                'position_order' => 2,
                'parent_id' => 1,
            ],
            [
                'user_id' => 1,
                'title' => 'Python',
                'position_order' => 1,
                'parent_id' => null,
            ]
        ]);

        Blog::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Learn Laravel (Best Laravel Tutorials for Beginners)',
            'slug' => 'yzZ6fM',
            'description' => "Laravel is a powerful open-source PHP framework designed to create the full-featured web application in a simple and elegant way. It is robust and easy to learn framework which follows MVC design pattern, the de facto standard of setting up web applications. You just need to be familiar with PHP basics to learn Laravel effectively. Laravel is a secure framework and prevents your website from several web attacks.
Laravel was initially released in June 2011 to provide a more advanced alternative to the CodeIgniter framework. Laravel has clean routing, Object Relational Mapping (ORM), decent queue library, and ease of authentication etc.",
            'status' => 1,
            'image' => 'public/demo/blog/image/1.png',
            'thumbnail' => 'public/demo/blog/thumb/1.png',
            'viewed' => 105,
            'authored_date' => date("F j, Y")
        ]);

        Blog::create([
            'user_id' => 1,
            'category_id' => 2,
            'title' => 'Laravel 5.8 From Scratch: Intro, Setup , MVC Basics, and Views.',
            'slug' => Str::random(6),
            'description' => "Laravel is the most popular PHP framework built by Taylor Otwell and community. It uses MVC architecture pattern. It provides a lot of features like a complete Authentication System, Database Migrations , A Powerful ORM, Pagination, and so on. Before creating the application, you will need to have PHP 7.2 and MySQL (we are not using apache in this series) and composer installed. I use xampp which is a package that comes with PHP, MySQL, and Apache. Composer is a dependency manager for PHP. It’s similar to npm which is a dependency manager for Javascript. Also, read the server requirements for laravel if you run into installation errors",
            'status' => 1,
            'image' => 'public/demo/blog/image/2.png',
            'thumbnail' => 'public/demo/blog/thumb/2.png',
            'viewed' => 105,
            'authored_date' => date("F j, Y")
        ]);

        Blog::create([
            'user_id' => 1,
            'category_id' => 3,
            'title' => 'Learning Python: From Zero to Hero',
            'slug' => Str::random(6),
            'description' => "For me, the first reason to learn Python was that it is, in fact, a beautiful programming language. It was really natural to code in it and express my thoughts.
Another reason was that we can use coding in Python in multiple ways: data science, web development, and machine learning all shine here. Quora, Pinterest and Spotify all use Python for their backend web development. So let’s learn a bit about it.",
            'status' => 1,
            'image' => 'public/demo/blog/image/3.png',
            'thumbnail' => 'public/demo/blog/thumb/3.png',
            'viewed' => 105,
            'authored_date' => date("F j, Y")
        ]);

        Blog::create([
            'user_id' => 1,
            'category_id' => 3,
            'title' => 'Everything About Python — Beginner To Advanced',
            'slug' => Str::random(6),
            'description' => "This article aims to outline all of the key points of the Python programming language. My target is to keep the information short, relevant, and focus on the most important topics which are absolutely required to be understood.
After reading this blog, you will be able to use any Python library or implement your own Python packages.
You are not expected to have any prior programming knowledge and it will be very quick to grasp all…",
            'status' => 1,
            'image' => 'public/demo/blog/image/4.png',
            'thumbnail' => 'public/demo/blog/thumb/4.png',
            'viewed' => 105,
            'authored_date' => date("F j, Y")
        ]);
        Blog::create([
            'user_id' => 1,
            'category_id' => 1,
            'title' => 'Introduction to PHP for web developers 2018',
            'slug' => Str::random(6),
            'description' => "The more things are tangled up and depend on each other, the harder they are to work with. If you want to change your HTML, it’s a bit hard without your SQL stuff getting in the way. If you’re trying to fix something in the way the data is structured, you’ve got HTML in up in your grill. Bear in mind this is a simple example. An actual app would be much more complex and that gets exponentially more tangly.",
            'status' => 1,
            'image' => 'public/demo/blog/image/5.png',
            'thumbnail' => 'public/demo/blog/thumb/5.png',
            'viewed' => 105,
            'authored_date' => date("F j, Y")
        ]);

        $comments = [
            [
                'name' => 'John',
                'email' => 'john@example.com',
                'comment' => 'This is the first comment. It can be up to 100 characters long.',
                'comment_id' => '',
                'blog_id' => 1,
                'type' => 1,
            ],
            [
                'name' => 'Jane',
                'email' => 'jane@example.com',
                'comment' => 'Another comment on the same blog post.',
                'comment_id' => '',
                'blog_id' => 2,
                'type' => 1,
            ],
            [
                'name' => 'Bob',
                'email' => 'bob@example.com',
                'comment' => 'A reply to the first comment.',
                'comment_id' => 1, // Assuming the comment_id from the first comment.
                'blog_id' => 1,
                'type' => 2,
            ],
            [
                'name' => 'Alice',
                'email' => 'alice@example.com',
                'comment' => 'Yet another comment.',
                'comment_id' => '',
                'blog_id' => 3,
                'type' => 1,
            ],
            [
                'name' => 'Charlie',
                'email' => 'charlie@example.com',
                'comment' => 'A reply to the second comment.',
                'comment_id' => 2, // Assuming the comment_id from the second comment.
                'blog_id' => 2,
                'type' => 2,
            ],
            [
                'name' => 'Eva',
                'email' => 'eva@example.com',
                'comment' => 'This is the sixth comment.',
                'comment_id' => '',
                'blog_id' => 4,
                'type' => 1,
            ],
            [
                'name' => 'David',
                'email' => 'david@example.com',
                'comment' => 'A reply to the third comment.',
                'comment_id' => 3, // Assuming the comment_id from the third comment.
                'blog_id' => 3,
                'type' => 2,
            ],
            [
                'name' => 'Grace',
                'email' => 'grace@example.com',
                'comment' => 'Seventh comment on a different blog post.',
                'comment_id' => '',
                'blog_id' => 5,
                'type' => 1,
            ],
            [
                'name' => 'Frank',
                'email' => 'frank@example.com',
                'comment' => 'Eighth comment on a different blog post.',
                'comment_id' => '',
                'blog_id' => 5,
                'type' => 1,
            ],
            [
                'name' => 'Helen',
                'email' => 'helen@example.com',
                'comment' => 'A reply to the fifth comment.',
                'comment_id' => 5, // Assuming the comment_id from the fifth comment.
                'blog_id' => 2,
                'type' => 2,
            ],
        ];

        foreach ($comments as $commentDetails) {
            BlogComment::create($commentDetails);
        }
    }
}
