<?php

namespace App\Http\Requests;

use App\Models\Comment;
use App\Models\News;
use App\Models\VideoPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BaseRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return true;
	}

	/**
	 * Error messages
	 *
	 * @return array
	 */
	public function messages() {
		return [
			'title.required' => 'The "title" field is required.',
			'title.min' => 'The "title" field must not be empty.',
			'title.max' => 'The "title" field cannot exceed :max characters.',
			'description.max' => 'The "description" field cannot exceed :max characters.',
			'description.required' => 'The "description" field is required.',
			'url.max' => 'The "url" field cannot exceed :max characters.',
			'url.required' => 'The "url" field is required.',
		];
	}

	/**
	 * Interception and handling of validation errors
	 *
	 * @param Validator $validator
	 *
	 * @return mixed
	 * @throws HttpResponseException
	 *
	 */
	protected function failedValidation(Validator $validator) {
		throw new HttpResponseException(response()->json(
			['errors' => $validator->errors()], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
		));
	}

	/**
	 * Проверить наличие модели для привязки к ней комментария
	 *
	 * @return \stdClass|null
	 */
	public function getModel(): ?\stdClass {

		$tableName = $this->get(Comment::FIELD_COMMENTABLE_TYPE);
		$modelId = $this->get(Comment::FIELD_COMMENTABLE_ID);

		if (!in_array($tableName, [News::TABLE_NANE, VideoPost::TABLE_NANE, Comment::TABLE_NANE]))
			return null;

		$modelData = DB::table($tableName)->find($modelId);

		if (empty($modelData))
			return null;

		return $modelData;
	}
}
