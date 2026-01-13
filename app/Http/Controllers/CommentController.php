<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentController extends Controller
{
	protected static $model = Comment::class;

	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse {
		try {
			$comments = self::$model::all();

			return response()->json($comments, ResponseAlias::HTTP_OK);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}

	/**
	 * Creating a new resource.
	 *
	 * @param CommentRequest $request
	 * @return JsonResponse
	 */
	public function store(CommentRequest $request): JsonResponse {
		try {
			$comment = self::$model::create($request->all());

			return response()->json($comment, ResponseAlias::HTTP_CREATED);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}

    /**
     * Display the specified resource.
     *
	 * @param Comment $comment
	 * @return JsonResponse
	 */
    public function show(Comment $comment): JsonResponse
    {
		try {
			$comment = self::$model::findOrFail($comment->id);

			return response()->json($comment, ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_NOT_FOUND);
		}
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CommentRequest $request
	 * @param string $id
	 *
	 * @return JsonResponse
	 */
	public function update(CommentRequest $request, string $id): JsonResponse {
		try {
			$comment = self::$model::findOrFail($id);
			$comment->fill($request->all());

			if (!$comment->save()) {
				throw new \Exception("Bad Request", ResponseAlias::HTTP_BAD_REQUEST);
			}

			return response()->json($comment, ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Comment $comment
	 * @return JsonResponse
	 */
    public function destroy(Comment $comment): JsonResponse
    {
		try {
			$comment = self::$model::findOrFail($comment->id);
			$comment->delete();

			return response()->json(['message' => 'Success'], ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
    }
}
