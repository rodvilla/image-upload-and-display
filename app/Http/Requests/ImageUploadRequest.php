<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'the_image' => 'file|mimes:png',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'the_image.file' => 'There was a problem while uploading the image. Please try again.',
            'the_image.mimes' => 'The image must have PNG format. Please try another one.',
        ];
    }

    /**
     * Get the uploaded image encoded as base64
    */
    public function getEncodedImage()
    {
        return base64_encode(
            $this->file('the_image')->get()
        );
    }
}
