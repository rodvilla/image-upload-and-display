<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Validation\ValidationException;

class ImageUploadController extends Controller
{
    public function __invoke(ImageUploadRequest $request)
    {
        // Image is validated at this point, make the request
        $response = Http::asForm()->post("https://test.rxflodev.com", [
            'imageData' => $request->getEncodedImage(),
        ]);

        // Validate the status from the remote storage endpoing
        if (($response['status'] ?? 'failed') !== 'success') {
            throw ValidationException::withMessages([
                'the_image' => $response['message'] ?? 'Something went wrong while transferring the image.'
            ]);
        }

        // Store the image in the session
        $sessionImages = session('images', collect());
        $sessionImages->prepend([
            'url'  => $response['url']
        ]);
        session(['images' => $sessionImages]);

        // Return the image view
        return response()->json([
            'html' => view('image', ['url' => $response['url']])->render(),
        ]);
    }
}
