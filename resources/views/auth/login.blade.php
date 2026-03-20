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
                <h2 style="font-weight: 600; text-transform:uppercase;">Bienvenido</h2>
                <p>Sistema Estatal de Planeación Democrática</p>
                <form method="POST" action="{{ route('login') }}" class="w-sm-50 w-md-100">
                    @csrf
                    <div class="mb-3 w-100">
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} w-100" type="email"
                            name="email" :value="old('email')" placeholder="Correo" required>
                        @error('email')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>

                    <div class="mb-3 w-100">
                        <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} w-100" type="password"
                            name="password" required autocomplete="current-password" placeholder="Contraseña">
                        @error('password')
                            <small class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </small>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <div class="d-flex justify-content-start custom-control custom-checkbox"
                            style="align-items: baseline">
                            <x-jet-checkbox id="remember_me" name="remember" />
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

                            <x-jet-button>
                                {{ __('Entrar') }}
                            </x-jet-button>
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
    {{-- <x-jet-authentication-card>
        <x-slot name="logo">
            <img src="/imagen/LOGO CORTADO.png" alt="" width="90PX">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Usuario:') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Contraseña:') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Recordarme') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Iniciar sesión') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card> --}}
</x-guest-layout>
{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="card-body">

            <x-jet-validation-errors class="mb-3 rounded-0" />

            @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <x-jet-label value="{{ __('Email') }}" />

                    <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}" type="email"
                                 name="email" :value="old('email')" required />
                    <x-jet-input-error for="email"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <x-jet-label value="{{ __('Password') }}" />

                    <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                                 name="password" required autocomplete="current-password" />
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="mb-3">
                    <div class="custom-control custom-checkbox">
                        <x-jet-checkbox id="remember_me" name="remember" />
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

                        <x-jet-button>
                            {{ __('Log in') }}
                        </x-jet-button>
                    </div>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout> --}}