<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VideoPostRequest extends BaseRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array|string>
	 */
	public function rules(): array {

		if ($this->isMethod('POST')) {

			return [
				'title' => 'required|string|min:1|max:255',
				'description' => 'required|string|min:1|max:512',
				'url' => 'required|string|min:1|max:512',
			];
		}

		return [];
	}

}
