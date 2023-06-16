<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Agendas | Login</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div class="flex h-screen bg-project-primary">
        <div class="flex flex-1 p-10 text-white">
            <div class="flex flex-col">
                <p class="font-bold text-5xl">AGENDAS</p>
                <p class="self-end">For Admin</p>
            </div>
        </div>

        <div class="flex flex-1 items-center justify-center bg-white">

            <form method="POST" action="{{route('authenticate')}}" class="flex flex-col p-10 gap-10 w-3/4">
                @csrf
                <p class="text-3xl font-normal">Log in to <span class="font-bold">AGENDAS</span></p>

                <div class="flex flex-col gap-5">
                    <div class="form-input-container">
                        <label for="username">Username</label>
                        <input class="form-input" name="username" id="username" type="text">
                    </div>
                    <div class="form-input-container">
                        <label for="password">Password</label>
                        <input class="form-input" name="password" id="password" type="password">
                    </div>
                </div>

                @if (session()->has('error'))
                    <p>{{session()->get('error')}}</p>
                @endif

                <x-button class="text-center" label="Login"></x-button>
            </form>
        </div>
    </div>
</body>
</html>