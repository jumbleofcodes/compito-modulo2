<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostDestroyRequest;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param PostIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(PostIndexRequest $request)
    {
        $posts = Post::query();

        // Filter by text
        if ($text = $request->query('title')) {
            $posts->where(function ($query) use ($text) {
                $query->where('title', 'like', '%' . $text . '%');
            });
        }

        if ($text = $request->query('descr')) {
            $posts->where(function ($query) use ($text) {
                $query->where('description', 'like', '%' . $text . '%');
            });
        }

        //Pagination
        $per_page = $request->query('per_page') ?: 15;
        $posts = $posts->paginate((int)$per_page);

        return  PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostStoreRequest $request
     * @return PostResource
     * @throws Exception
     */
    public function store(PostStoreRequest $request)
    {
        DB::beginTransaction();

        try {

            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->author_id = Auth::id();

            if ($request->has('tagged_users')) {
                $users_array = [];
                foreach ($request->tagged_users as $tagged_user) {
                    array_push($users_array, new UserResource(User::where('name', $tagged_user)->firstOrFail()));
                }
                $post->tagged_users = $users_array;
            }

            $post->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param Post $post
     * @return PostResource
     * @throws Exception
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        DB::beginTransaction();

        try {
            if (Auth::id() != $post->author_id) {
                throw new Exception("Cannot update this post");
            }

            $post->update($request->only(['title', 'description']));

            if ($request->has('tagged_users')) {
                $users_array = [];
                foreach ($request->tagged_users as $tagged_user) {
                    array_push($users_array, new UserResource(User::where('name', $tagged_user)->firstOrFail()));
                }
                $post->tagged_users = $users_array;
            }
            $post->save();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param PostDestroyRequest $request
     * @param Post $post
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function destroy(PostDestroyRequest $request, Post $post)
    {

        DB::beginTransaction();

        try {
            if (Auth::id() != $post->author_id) {
                throw new Exception("Cannot delete this post");
            }

            $post->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return response(null, 204);
    }
}
