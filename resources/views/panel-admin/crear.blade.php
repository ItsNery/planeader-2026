<x-app-layout>
    @section('title', 'Usuarios: Crear')
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>
    @if (Auth::user()->validador)
        <div class="container bg-white">
            <div class="form-container">
                <div class="form-header py-3">
                    <h2>Crear Nuevo Usuario</h2>
                </div>
                <form action="{{ route('panel-admin.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="row">
                        <div class="container">
                            <p class="encabezado-seccion-formulario">
                                Datos generales
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="custom-section-title"><i class="fa-solid fa-pen-nib"></i> Nombre *</div>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    placeholder="Ingresa el nombre" value="{{ old('name') }}"
                                    @error('name') autofocus @enderror required>
                                @error('name')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <p class="encabezado-seccion-formulario">
                                Datos de acceso
                            </p>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="custom-section-title"><i class="fa-regular fa-envelope"></i> Correo
                                    electrónico
                                </div>
                                <input class="form-control @error('email') is-invalid @enderror" name="email"
                                    id="email" placeholder="Ingresa el email" value="{{ old('email') }}"
                                    @error('email') autofocus @enderror required>
                                @error('email')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="custom-section-title"><i class="fa-solid fa-key"></i> Contraseña *</div>
                                <input class="form-control @error('password') is-invalid @enderror" name="password"
                                    id="password" placeholder="Ingresa la contraseña" value="{{ old('password') }}"
                                    @error('password') autofocus @enderror required type="password">
                                @error('password')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="custom-section-title"><i class="fa-solid fa-key"></i> Confirmar Contraseña *
                                </div>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" id="password_confirmation"
                                    placeholder="Confirma la contraseña" value="{{ old('password_confirmation') }}"
                                    @error('password_confirmation') autofocus @enderror required type="password">
                                @error('password_confirmation')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="custom-section-title"><i class="fa-solid fa-user-check"></i> Validador *
                                </div>
                                <select class="form-control @error('validador') is-invalid @enderror" name="validador"
                                    id="validador" required>
                                    <option value="1" {{ old('validador') == '1' ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('validador') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                                @error('validador')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mb-3 w-100" style="background-color: green">Crear
                            Usuario</button>
                        <a href="{{ route('panel-admin.index') }}" class="btn btn-secondary mb-3 w-100">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    @else
        <p>No tienes los permisos necesarios</p>
    @endif

</x-app-layout>
