<?php

namespace Canvas\Http\Controllers;

use Canvas\Models\Post;
use Canvas\Models\Tag;
use Canvas\Models\Topic;
use Canvas\Models\UserMeta;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showPosts(Request $request): JsonResponse
    {
        $meta = UserMeta::where('user_id', $request->user()->id)->first();

        if (optional($meta)->isAdmin || optional($meta)->isEditor) {
            $posts = Post::select('id', 'title')->latest()->get();
        } else {
            $posts = Post::where('user_id', $request->user()->id)->select('id', 'title')->latest()->get();
        }

        $posts->map(function ($post) {
            $post['name'] = $post->title;
            $post['type'] = 'Post';
            $post['route'] = 'edit-post';

            return $post;
        });

        return response()->json(collect($posts)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showTags(Request $request): JsonResponse
    {
        $tags = Tag::select('id', 'name')->latest()->get();

        $tags->map(function ($tag) {
            $tag['type'] = 'Tag';
            $tag['route'] = 'edit-tag';

            return $tag;
        });

        return response()->json(collect($tags)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showTopics(Request $request): JsonResponse
    {
        $topics = Topic::select('id', 'name')->latest()->get();

        $topics->map(function ($topic) {
            $topic['type'] = 'Topic';
            $topic['route'] = 'edit-topic';

            return $topic;
        });

        return response()->json(collect($topics)->toArray(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function showUsers(Request $request): JsonResponse
    {
        $users = resolve(config('canvas.user', User::class))->select('id', 'name')->latest()->get();

        $users->map(function ($user) {
            $user['type'] = 'User';
            $user['route'] = 'edit-user';

            return $user;
        });

        return response()->json(collect($users)->toArray(), 200);
    }
}
