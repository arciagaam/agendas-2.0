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
            <div class="flex flex-col w-full gap-4 text-project-primary-700  fill-project-primary-700">
                <div class="relative border rounded-lg flex items-center justify-center w-fit p-2">
                    <div class="absolute rounded-full w-24 h-24 border border-gray-200 z-0"></div>
                    <div class="absolute rounded-full w-48 h-48 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-72 h-72 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-96 h-96 border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-[30rem] h-[30rem] border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-[36rem] h-[36rem] border border-gray-100 z-0"></div>
                    <div class="absolute rounded-full w-[42rem] h-[42rem] border border-gray-50 z-0"></div>
                    <box-icon name='search' class="z-20"></box-icon>
                </div>
                <h1 class="text-lg font-bold text-amber-500 z-20 mt-4">404 error</h1>
                <h1 class="text-6xl font-bold z-20">Under maintenance</h1>
                <p class="text-lg my-4 z-20">Sorry, the page you are looking for doesn't exist yet or has been removed.</p>
                <a href="{{ route('admin.dashboard') }}"
                    @class([
                        'w-1/2 rounded-lg transition-all duration-200 ease-in-out font-medium z-20 px-4 py-2 text-sm bg-project-accent-500 text-white ring-1 ring-project-accent-500 fill-white hover:ring-project-accent-400 hover:fill-white hover:bg-project-accent-400',
                    ])>
                    <div class="flex items-center justify-center gap-1">
                        <box-icon name='arrow-back' class="z-20"></box-icon>
                        <p class="whitespace-nowrap">Return to dashboard</p>
                    </div>
                </a>
            </div>
        </div>
        {{-- <div class="p-6 flex w-full h-full justify-center items-center overflow-hidden md:w-1/2 sm:h-full">
            <!-- Replace the image URL with your desired image -->
            <img class="m-auto h-full w-full object-cover bg-project-primary-800">
        </div> --}}
    </div>
</body>
</html>






