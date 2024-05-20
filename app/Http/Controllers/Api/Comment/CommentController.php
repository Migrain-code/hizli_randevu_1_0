<?php

namespace App\Http\Controllers\Api\Comment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentListResource;
use Illuminate\Http\Request;

/**
 * @group Yorumlarım
 *
 */
class CommentController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->customer = auth('api')->user();
            return $next($request);
        });
    }

    /**
     * Yorum Listesi
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $comments = $this->customer->comments;
        return response()->json(CommentListResource::collection($comments));
    }
}
