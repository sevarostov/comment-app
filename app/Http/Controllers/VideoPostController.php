<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoPostRequest;
use App\Models\Comment;
use App\Models\VideoPost;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VideoPostController extends Controller {

	protected static $model = VideoPost::class;

	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse {
		try {
			$videoPosts = self::$model::all();

			return response()->json($videoPosts, ResponseAlias::HTTP_OK);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param VideoPostRequest $request
	 *
	 * @return JsonResponse
	 */
	public function store(VideoPostRequest $request): JsonResponse {
		try {
			$videoPost = self::$model::create($request->all());

			return response()->json($videoPost, ResponseAlias::HTTP_CREATED);
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
	 * @param VideoPost $videoPost
	 * @param VideoPostRequest $videoPostRequest
	 *
	 * @return JsonResponse
	 */
	public function show(VideoPost $videoPost, VideoPostRequest $videoPostRequest): JsonResponse {
		try {
			/** @var VideoPost $videoPost */
			$videoPost = self::$model::find($videoPost->id);
			$comments = Comment::where(COMMENT::FIELD_COMMENTABLE_TYPE, '=',VideoPost::TABLE_NANE)
				->where(COMMENT::FIELD_COMMENTABLE_ID, $videoPost->id)
				->cursorPaginate(
					perPage: self::PER_PAGE,
					cursor: $videoPostRequest->get('cursor'),
				);

			return response()->json(['videoPost' => $videoPost, 'comments' => $comments], ResponseAlias::HTTP_OK);
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
	 * @param VideoPostRequest $request
	 * @param string $id
	 *
	 * @return JsonResponse
	 */
	public function update(VideoPostRequest $request, string $id): JsonResponse {
		try {
			$videoPost = self::$model::findOrFail($id);
			$videoPost->fill($request->all());

			if (!$videoPost->save()) {
				throw new \Exception("Bad Request", ResponseAlias::HTTP_BAD_REQUEST);
			}

			return response()->json($videoPost, ResponseAlias::HTTP_OK);
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
	 * @param VideoPost $videoPost
	 *
	 * @return JsonResponse
	 */
	public function destroy(VideoPost $videoPost): JsonResponse {
		try {
			$videoPost = self::$model::findOrFail($videoPost->id);
			$videoPost->delete();

			return response()->json(['message' => 'Success'], ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}
}
