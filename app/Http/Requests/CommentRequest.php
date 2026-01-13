<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CommentRequest extends BaseRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array {

		if ($this->isMethod('POST')) {
			return [
				'user_id' => 'required|int',
				'commentable_id' => 'required|int',
				'commentable_type' => 'required|string|min:1|max:255',
				'text' => 'required|string|min:1|max:1000',
			];
		}
		return [];
	}

}
