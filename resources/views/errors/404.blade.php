<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body class="h-screen flex items-center justify-center overflow-hidden">
    <div class="flex h-full w-[2048px] sm:flex-col md:flex-row">
        <div class="flex items-center justify-center p-24 sm:h-full sm:w-full md:w-1/2">
            <div class="flex flex-col w-full gap-4 text-project-primary-700">
                <div class="relative border rounded-md flex items-center justify-center w-fit p-2">
                    <div class="absolute rounded-full w-20 h-20 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-40 h-40 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-60 h-60 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-80 h-80 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-[25rem] h-[25rem] border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-[30rem] h-[30rem] border border-gray-100 z-0"></div>
                    <box-icon name='search' class="z-20"></box-icon>
                </div>
                <h1 class="text-lg font-bold text-purple-500 z-20">404 error</h1>
                <h1 class="text-6xl font-bold z-20">Under maintenance</h1>
                <p class="text-lg my-4 z-20">Sorry, the page you are looking for doesn't exist or has been removed.</p>
                <x-anchor label="Return to dashboard" class="z-20" url="{{ route('admin.dashboard') }}"></x-anchor>
            </div>
        </div>
        <div class="p-6 flex w-full h-full justify-center items-center overflow-hidden md:w-1/2 sm:h-full">
            <!-- Replace the image URL with your desired image -->
            <img src="{{ asset('storage/404.jpg') }}" alt="404" class="m-auto h-full w-full object-cover">
        </div>
    </div>
</body>
</html>






