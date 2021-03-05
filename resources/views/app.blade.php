<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gray-700">

        <div class="max-w-6xl mx-auto py-4">
            <form id="image-upload" action="" x-data="imageUploadForm()">
                <label for="the_image" class="border-dashed border-white border-4 cursor-pointer flex flex-col items-center justify-center hover:bg-gray-600 transition duration-200" style="min-height: 10rem;">
                    <input type="file" class="sr-only" id="the_image" x-ref="the_image" @change="formData.the_image = $refs.the_image.files[0]; submitForm()">
                    <span class="text-white font-bold text-xl">Choose an image (must be PNG)</span>
                    <span class="text-red-400 font-bold text-lg" x-show="message !== ''" x-text="message"></span>
                </label>
            </form>
        </div>

        <div class="max-w-6xl mx-auto py-4 mt-5">
            <div class="flex" id="images">
                @foreach($images as $image)
                    @include('image', ['url' => $image['url']])
                @endforeach
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" crossorigin="anonymous"></script>
    <script>
        var uploadEndpoint = '{{ route('api.image-upload') }}'
        function imageUploadForm() {
            return {
                formData: {
                    the_image: ''
                },
                message: '',
                
                submitForm() {
                    this.message = '';
                    // Usual code for file uploads
                    let formData = new FormData();
                    formData.append('the_image', this.formData.the_image);
                    // Upload the file
                    axios.post(
                        '{{ route('api.image-upload') }}',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then((response) => {
                        var images = document.getElementById('images');
                        images.innerHTML = response.data.html + images.innerHTML;
                    })
                    .catch((error) => {
                        this.message = error.response.data.errors.the_image[0] ||
                        'Something went wrong with the upload, please do try again';
                    });
                }
            }
        }
    </script>
</body>
</html>
