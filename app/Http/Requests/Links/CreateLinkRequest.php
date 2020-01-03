<?php

namespace App\Http\Requests\Links;

use App\Validators\AvailableDomain;
use App\Validators\OperationTimeLimit;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $link string
 */
class CreateLinkRequest extends FormRequest
{
    public function rules()
    {
        return [
            'link' => ['url', 'required', app(AvailableDomain::class), app(OperationTimeLimit::class)],
        ];
    }

}
