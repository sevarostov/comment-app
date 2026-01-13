<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NewsController extends Controller {

	protected static $model = News::class;

	/**
	 * Display a listing of the resource.
	 *
	 * @return JsonResponse
	 */
	public function index(): JsonResponse {
		try {
			$news = self::$model::all();

			return response()->json($news, ResponseAlias::HTTP_OK);
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
	 * @param NewsRequest $request
	 *
	 * @return JsonResponse
	 */
	public function store(NewsRequest $request): JsonResponse {
		try {
			$news = self::$model::create($request->all());

			return response()->json($news, ResponseAlias::HTTP_CREATED);
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
	 * @param News $news
	 * @param NewsRequest $newsRequest
	 *
	 * @return JsonResponse
	 */
	public function show(News $news, NewsRequest $newsRequest): JsonResponse {

		try {
			/** @var News $news */
			$news = self::$model::find($news->id);
			$comments = Comment::where(COMMENT::FIELD_COMMENTABLE_TYPE, '=',News::TABLE_NANE)
				->cursorPaginate(
					perPage: self::PER_PAGE,
					cursor: $newsRequest->get('cursor'),
				);

			return response()->json(['news' => $news, 'comments' => $comments], ResponseAlias::HTTP_OK);
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
	 * @param NewsRequest $request
	 * @param string $id
	 *
	 * @return JsonResponse
	 */
	public function update(NewsRequest $request, string $id): JsonResponse {
		try {
			$news = self::$model::findOrFail($id);
			$news->fill($request->all());

			if (!$news->save()) {
				throw new \Exception("Bad Request", ResponseAlias::HTTP_BAD_REQUEST);
			}

			return response()->json($news, ResponseAlias::HTTP_OK);
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
	 * @param News $news
	 * @return JsonResponse
	 */
	public function destroy(News $news): JsonResponse {
		try {
			$news = self::$model::findOrFail($news->id);
			$news->delete();

			return response()->json(['message' => 'Success'], ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: ResponseAlias::HTTP_EXPECTATION_FAILED);
		}
	}
}
