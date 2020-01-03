<?php

namespace App\Http\Requests\Links;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $datetime string
 * @property $city string
 */
class ClickLinkRequest extends FormRequest
{
    public $datetime;
    public $city;

    public function rules()
    {
        return [];
    }

}
