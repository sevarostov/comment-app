<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class NewsController extends Controller
{
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
				status: $e->getCode());
		}
	}

	/**
	 * Creating a new resource.
	 */
	public function store(NewsRequest $request) {
		try {
			$news = self::$model::create($request->all());

			return response()->json($news, ResponseAlias::HTTP_CREATED);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: $e->getCode());
		}
	}

	/**
	 * Display the specified resource.
	 */
	public function show(News $news) {
		try {
			$news = self::$model::findOrFail($news->id);

			return response()->json($news, ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: $e->getCode());
		}
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(NewsRequest $request, string $id) {
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
				status: $e->getCode());
		}
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
		try {
			$news = self::$model::findOrFail($news->id);
			$news->delete();

			return response()->json(['message' => 'Success'], ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: $e->getCode());
		}
    }
}
