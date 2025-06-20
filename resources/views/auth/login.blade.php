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
            margin-top: 10rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 1.5rem;
            text-align: left; /* Diratakan kiri */
            line-height: 1.3;
        }

        .social-login {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-start;
            margin-bottom: 1.5rem;
        }

        .social-button {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.75rem;
            border: 1px solid #d1d5db;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            height: 30px;
        }

        .social-button img {
            width: 16px;
            height: 16px;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: center;
        }
        .capitalize {
            text-transform: capitalize;
        }

        .form-input {
            width: 100%;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }
        .login-button,
        .admin-login-button {
            width: 100%;
            background-color: #22c55e;
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.375rem;
            text-align: center; /* HAPUS ini */
            cursor: pointer;
            border: none;
            text-transform: capitalize;

            /* TAMBAHKAN INI */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .admin-login-button {
            margin-top: 0.5rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .footer-link {
            font-size: 0.875rem;
            color: #22c55e;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            display: inline-block;
        }
        .footer-link:hover {
            transform: scale(1.1);
            opacity: 0.8;
        }
        .status-message {
            margin-bottom: 1rem;
            font-size: 0.875rem;
            color: #16a34a;
        }

        /* Menambahkan CSS untuk meratakan teks di dalam form-group */
        .form-group.text-align-center {
            text-align: center; /* Meratakan teks ke tengah */
        }
        #togglePassword {
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-top: 1rem;
            animation: fadeInUp 0.6s ease-out forwards;
            animation-delay: 0.2s;
            opacity: 0; /* mulai dari tidak terlihat */
        }

        .footer-link-combined {
            font-size: 0.875rem;
            color: #000;
        }
        @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
        }
        .login-container {
        position: relative;
        }

.corner-logo {
    position: absolute;
    top: 1rem;
    left: 1rem;
    width: 40px;
    height: auto;
    z-index: 10;
    display: inline-block;
    vertical-align: middle;
}

.logo-text {
    position: absolute;
    top: calc(1.32rem + 1.05px); /* turunkan tulisan sekitar 0,1 inci */
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

        {{-- Gambar kiri --}}
        <div class="login-image">
            <img src="{{ asset('images/content/Login Logo.png') }}" alt="Login Logo">
        </div>

        {{-- Form kanan --}}
        <div class="login-form-wrapper">
            <div class="login-form-box">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <x-validation-errors class="mb-4" />

                    @session('status')
                        <div class="status-message">
                            {{ $value }}
                        </div>
                    @endsession

                    <h2 class="login-title">Masuk ke Akun <br>Bo Tani Anda</h2>
                    <div class="form-group">
                        <x-input id="email"
                            class="form-input"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="contoh@email.com" />
                    </div>
                    <div class="form-group" style="position: relative;">
                        <x-input id="password"
                                class="form-input"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="***************" />
                                
                    <img id="togglePassword"
                            src="{{ asset('images/icons/hide.png') }}"
                            data-state="hidden"
                            onclick="togglePasswordVisibility()"
                            style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; cursor: pointer;" />
                    </div>
                   <div class="form-group">
                        <x-button class="login-button">Masuk</x-button>
                    </div>

                    <div class="form-footer" id="animatedFooter">
                    <div class="footer-link-combined">
                    </div>
                    <a href="{{ route('password.request') }}" class="footer-link">Lupa Sandi</a>
                </div>

                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassword');
    const currentState = toggleIcon.getAttribute('data-state');

    if (currentState === 'hidden') {
        passwordInput.type = 'text';
        toggleIcon.src = "{{ asset('images/icons/view.png') }}";
        toggleIcon.setAttribute('data-state', 'visible');
    } else {
        passwordInput.type = 'password';
        toggleIcon.src = "{{ asset('images/icons/hide.png') }}";
        toggleIcon.setAttribute('data-state', 'hidden');
    }

    // Optional animasi
    toggleIcon.style.transform = "translateY(-50%) scale(1.2)";
    setTimeout(() => {
        toggleIcon.style.transform = "translateY(-50%) scale(1)";
    }, 150);
}
</script>
</x-guest-layout>