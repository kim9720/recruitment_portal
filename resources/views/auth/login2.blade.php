@extends('layouts.guest')

@section('content')
    <div id="dreamworks_container" class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md" style="width: 30%; margin: 0 auto;">
            <div id="login">
                <div class="panel-default1" style="align: center;">
                    <div class="panel-body bg-white shadow-lg rounded-lg p-8">

                        {{-- Flash Messages --}}
                        @if (session('success'))
                            <p class="done">{{ session('success') }}</p>
                        @endif
                        @if (session('error'))
                            <p class="msg error">{{ session('error') }}</p>
                        @endif
                        @if (session('warning'))
                            <p class="msg warning">{{ session('warning') }}</p>
                        @endif
                        @if (session('info'))
                            <p class="msg info">{{ session('info') }}</p>
                        @endif

                        <h1 class="card-title text-2xl font-bold mb-6" style="color: #262261; text-align:left">
                            <strong>Login</strong>
                        </h1>

                        {{-- Login Form --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="input_box mb-4">
                                <input id="email" type="email" name="email" value="{{ old('email') }}"
                                    placeholder="User Name / Email"
                                    class="form-control w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="input_box mb-4">
                                <input id="password" type="password" name="password" placeholder="Password"
                                    class="form-control w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">
                                @error('password')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between mb-4">
                                <button type="submit"
                                    class="button bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md">
                                    Login
                                </button>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="register text-sm text-gray-600 hover:text-indigo-600">
                                        Register
                                    </a>
                                @endif
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="forgot_password text-sm text-indigo-600 hover:text-indigo-800">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Inline styles similar to your old setup --}}
    <style>
        .done {
            padding: 5px;
            background: #ADCA96;
            color: #333;
            border-radius: 5px;
            width: 80%;
            font-weight: bold;
            font-size: 15px;
            text-align: center;
            margin: 15px auto;
        }

        .msg.error {
            background: #f8d7da;
            color: #721c24;
            padding: 5px;
            border-radius: 5px;
            margin: 10px auto;
            text-align: center;
        }

        .msg.warning {
            background: #fff3cd;
            color: #856404;
            padding: 5px;
            border-radius: 5px;
            margin: 10px auto;
            text-align: center;
        }

        .msg.info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 5px;
            border-radius: 5px;
            margin: 10px auto;
            text-align: center;
        }

        .input_box input {
            padding: 10px;
            width: 100%;
        }

        .button {
            cursor: pointer;
            font-weight: bold;
            background-color: #262261;
            border-radius: 5px;
            width: 100px;
        }
    </style>
@endsection
