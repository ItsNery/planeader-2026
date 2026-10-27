<x-guest-layout>
    @section('title', 'Inicio de sesión')
    <section class="login-planeader">
        <div class="contenedor">
            @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <div class="login-form">
                <h2>Bienvenido</h2>
                <p>Sistema Estatal de Planeación Democrática</p>
                <form method="POST" action="{{ route('login') }}" class="contenedor-formulario" novalidate>
                    @csrf
                    <div class="mb-3 w-100">
                        <label for="email" class="visually-hidden">Correo</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} w-100" type="email"
                            id="email" name="email" :value="old('email')" placeholder="Correo" required autocomplete="email">
                        @error('email')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>

                    <div class="mb-3 w-100 password-field">
                        <label for="password" class="visually-hidden">Contraseña</label>
                        <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} w-100" type="password"
                            id="password" name="password" required autocomplete="current-password" placeholder="Contraseña">
                        <button type="button" class="password-toggle" aria-controls="password" aria-pressed="false"
                            aria-label="Mostrar contraseña" title="Mostrar contraseña">
                            <svg class="password-toggle__show" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true" focusable="false">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg class="password-toggle__hide d-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true" focusable="false">
                                <path d="m3 3 18 18" />
                                <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8" />
                                <path d="M9.9 4.2A10.9 10.9 0 0 1 12 4c6.5 0 10 8 10 8a18.5 18.5 0 0 1-3 4.2M6.6 6.6C3.7 8.5 2 12 2 12s3.5 7 10 7c1.2 0 2.3-.2 3.3-.6" />
                            </svg>
                        </button>
                        @error('password')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <div class="d-flex justify-content-start custom-control custom-checkbox"
                            style="align-items: baseline">
                            <x-checkbox id="remember_me" name="remember" />
                            <label class="custom-control-label mx-3" for="remember_me">
                                {{ __('Recordarme') }}
                            </label>
                        </div>
                    </div> --}}

                    <div class="mb-0">
                        <div class="d-flex justify-content-end align-items-center">
                            {{-- @if (Route::has('password.request'))
                                <a class="text-white me-3" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu contraseña?') }}
                                </a>
                            @endif --}}

                            <x-button>
                                {{ __('Entrar') }}
                            </x-button>
                        </div>
                    </div>
                </form>
                <div class="footer">
                    <img src="{{ asset('img/logos-negativo.png') }}" alt="Gobierno de Puebla">
                </div>
            </div>
            <div class="image-container">
                <img src="{{ asset('img/fondo-login.jpg') }}" alt="Dogs and People"
                    tabindex="Imagen de fondo de la pantalla de Login">
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const password = document.getElementById('password');
                const toggle = document.querySelector('.password-toggle');

                if (!password || !toggle) return;

                toggle.addEventListener('click', function() {
                    const isVisible = password.type === 'password';
                    password.type = isVisible ? 'text' : 'password';
                    toggle.setAttribute('aria-pressed', String(isVisible));
                    toggle.setAttribute('aria-label', isVisible ? 'Ocultar contraseña' : 'Mostrar contraseña');
                    toggle.setAttribute('title', isVisible ? 'Ocultar contraseña' : 'Mostrar contraseña');
                    toggle.querySelector('.password-toggle__show').classList.toggle('d-none', isVisible);
                    toggle.querySelector('.password-toggle__hide').classList.toggle('d-none', !isVisible);
                });
            });
        </script>
    @endpush
    {{-- <x-authentication-card>
        <x-slot name="logo">
            <img src="/imagen/LOGO CORTADO.png" alt="" width="90PX">
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Usuario:') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Contraseña:') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Iniciar sesión') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card> --}}
</x-guest-layout>
{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="card-body">

            <x-validation-errors class="mb-3 rounded-0" />

            @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <x-label value="{{ __('Email') }}" />

                    <x-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                 name="email" :value="old('email')" required />
                    <x-input-error for="email"></x-input-error>
                </div>

                <div class="mb-3">
                    <x-label value="{{ __('Password') }}" />

                    <x-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                                 name="password" required autocomplete="current-password" />
                    <x-input-error for="password"></x-input-error>
                </div>

                <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <x-checkbox id="remember_me" name="remember" />
                        <label class="custom-control-label" for="remember_me">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end align-items-baseline">
                        @if (Route::has('password.request'))
                            <a class="text-muted me-3" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif

                        <x-button>
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout> --}}
