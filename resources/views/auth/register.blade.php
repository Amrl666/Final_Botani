<x-guest-layout>
    <style>
        .corner-logo {
            position: absolute;
            top: 1rem;
            left: 1rem;
            width: 40px;
            height: auto;
            z-index: 10;
        }

        .login-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            background-color: #f0fdf4;
            position: relative;
        }

        .login-image {
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-image img {
            height: 83.33%;
            object-fit: contain;
            margin-top: 5rem;
        }

        .login-form-wrapper {
            width: 50%;
            height: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .login-form-box {
            background-color: white;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 28rem;
            margin-top: 6rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
            text-align: left;
            line-height: 1.3;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }

        .register-button {
            width: 100%;
            background-color: #22c55e;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.375rem;
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
            cursor: pointer;
            text-transform: capitalize;
        }

        .logo-text {
            position: absolute;
            top: calc(1.32rem + 1.05px);
            left: 4.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            line-height: 1;
            user-select: none;
            white-space: nowrap;
            z-index: 10;
        }

        .text-green {
            color: #22c55e;
        }

        .text-black {
            color: #000000;
        }
    </style>

    <div class="login-container">
        <img src="{{ asset('images/logo/logobotani.png') }}" alt="Logo Bo Tani" class="corner-logo">
        <span class="logo-text">
            <span class="text-green">BO</span><span class="text-black" style="margin-left: 0.4rem;">TANI</span>
        </span>

        <div class="login-image">
            <img src="{{ asset('images/content/Login Logo.png') }}" alt="Login Logo">
        </div>

        <div class="login-form-wrapper">
            <div class="login-form-box">
                <h2 class="login-title">Buat Akun <br>Bo Tani Anda</h2>

                <x-validation-errors class="mb-4" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <x-input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
                    </div>

                    <div class="form-group">
                        <x-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
                    </div>

                    <div class="form-group" style="position: relative;">
                        <x-input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="***************" />
                    </div>

                    <div class="form-group">
                        <x-input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Kata Sandi" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                        <div class="form-group">
                            <x-label for="terms">
                                <div class="flex items-center">
                                    <x-checkbox name="terms" id="terms" required />
                                    <div class="ms-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">'.__('Terms of Service').'</a>',
                                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">'.__('Privacy Policy').'</a>',
                                        ]) !!}
                                    </div>
                                </div>
                            </x-label>
                        </div>
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-green-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-button class="ms-4 bg-green-500 hover:bg-green-600 text-white">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
