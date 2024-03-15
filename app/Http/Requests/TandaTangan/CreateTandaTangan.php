<?php

namespace App\Http\Requests\TandaTangan;

use Illuminate\Foundation\Http\FormRequest;

class CreateTandaTangan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if($this->user()->level == 'admin'){
            return true;
        }

        if($this->user()->id == $this->id_users){
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "image"=> "required|image|mimes: jpeg,jpg,png",
            "id_users" => "required|integer|unique:tanda_tangans,id_users,".$this->id_users,
        ];
    }
}
