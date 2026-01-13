<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoPostRequest;
use App\Models\VideoPost;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
				status: $e->getCode());
		}
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(VideoPostRequest $request) {
		try {
			$videoPost = self::$model::create($request->all());

			return response()->json($videoPost, ResponseAlias::HTTP_CREATED);
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
	public function show(VideoPost $videoPost) {
		try {
			$videoPost = self::$model::findOrFail($videoPost->id);

			return response()->json($videoPost, ResponseAlias::HTTP_OK);
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
	public function update(VideoPostRequest $request, string $id) {
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
				status: $e->getCode());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(VideoPost $videoPost) {
		try {
			$videoPost = self::$model::findOrFail($videoPost->id);
			$videoPost->delete();

			return response()->json(['message' => 'Success'], ResponseAlias::HTTP_OK);
		} catch (ModelNotFoundException|\Exception $e) {
			return response()->json([
				'message' => $e->getMessage(),
				'details' => $e->getMessage()],
				status: $e->getCode());
		}
	}
}
