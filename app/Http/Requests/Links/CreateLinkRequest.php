<?php

namespace App\Http\Requests\Links;

use App\Validators\AvailableDomain;
use App\Validators\OperationTimeLimit;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $link string
 * @property $code string
 * @property $params array
 */
class CreateLinkRequest extends FormRequest
{
    public $code;
    public $params;

    public function rules()
    {
        return [
            'link' => ['url', 'required', app(AvailableDomain::class), app(OperationTimeLimit::class)],
        ];
    }

}
