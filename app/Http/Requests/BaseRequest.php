<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class BaseRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Error messages
	 *
	 * @return array
	 */
	public function messages()
	{
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
	 * @throws HttpResponseException
	 *
	 * @return mixed
	 */
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json(
			['errors' => $validator->errors()], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
		));
	}
}
