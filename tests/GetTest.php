<?php

namespace Seblhaire\QueryCache\Test;

use Illuminate\Support\Facades\Cache;
use Seblhaire\QueryCache\Test\Models\Post;

class GetTest extends TestCase
{
    /**
     * @dataProvider strictModeContextProvider
     */
    public function test_get()
    {
        $post = factory(Post::class)->create();
        $storedPosts = Post::cacheFor(now()->addHours(1))->get();
        $cache = Cache::get('leqc:sqlitegetselect * from "posts"a:0:{}');

        $this->assertNotNull($cache);

        $this->assertEquals(
            $cache->first()->id,
            $storedPosts->first()->id
        );

        $this->assertEquals(
            $cache->first()->id,
            $post->id
        );
    }

    /**
     * @dataProvider strictModeContextProvider
     */
    public function test_get_with_columns()
    {
        $post = factory(Post::class)->create();
        $storedPosts = Post::cacheFor(now()->addHours(1))->get(['name']);
        $cache = Cache::get('leqc:sqlitegetselect "name" from "posts"a:0:{}');

        $this->assertNotNull($cache);

        $this->assertEquals(
            $cache->first()->name,
            $storedPosts->first()->name
        );

        $this->assertEquals(
            $cache->first()->name,
            $post->name
        );
    }

    /**
     * @dataProvider strictModeContextProvider
     */
    public function test_get_with_string_columns()
    {
        $post = factory(Post::class)->create();
        $storedPosts = Post::cacheFor(now()->addHours(1))->get('name');
        $cache = Cache::get('leqc:sqlitegetselect "name" from "posts"a:0:{}');

        $this->assertNotNull($cache);

        $this->assertEquals(
            $cache->first()->name,
            $storedPosts->first()->name
        );

        $this->assertEquals(
            $cache->first()->name,
            $post->name
        );
    }
}
