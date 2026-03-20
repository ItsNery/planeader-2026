<x-app-layout>
    @section('title', isset($user->id) ? 'Editar Usuario' : 'Nuevo Usuario')
    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($user->id) ? 'Editar usuario' : 'Nuevo usuario' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($user->id) ? 'Modifique la información y valide los cambios.' : 'Complete el formulario para registrar un nuevo usuario.' }}
                </p>
            </div>
            <form action="{{ isset($user->id) ? route('panel-admin.update', $user->id) : route('panel-admin.store') }}"
                method="POST">
                @csrf
                @if (isset($user->id))
                    @method('PUT')
                @endif
                <div class="row g-4">
                    <div class="col-lg-12 border-end-lg pe-lg-4">
                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-file-signature text-primary-integration"></i> Información
                            Principal
                        </div>
                        <div class="mb-3">
                            <label for="name" class="fw-bold mb-1">Nombre: *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" required value="{{ old('name', $user->name ?? '') }}"
                                placeholder="Ej: Nombre del usuario">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="fw-bold mb-1">Correo electrónico: *</label>
                                <input class="form-control @error('email') is-invalid @enderror" name="email"
                                    id="email" placeholder="Ingresa el email"
                                    value="{{ old('email', $user->email ?? '') }}" @error('email') autofocus @enderror
                                    required>
                                @error('email')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="validador" class="fw-bold mb-1">Tipo de usuario: *</label>
                                <select name="validador" id="validador"
                                    class="form-control @error('validador') is-invalid @enderror">
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="1"
                                        {{ old('validador', $user->validador ?? '') == '1' ? 'selected' : '' }}>
                                        Validador
                                    </option>
                                    <option value="0"
                                        {{ old('validador', $user->validador ?? '') == '0' ? 'selected' : '' }}>
                                        Capturista
                                    </option>
                                </select>
                                @error('validador')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="fw-bold mb-1">Contraseña: *</label>
                                <input class="form-control @error('password') is-invalid @enderror" name="password"
                                    id="password" placeholder="Ingresa la password"
                                    @error('password') autofocus @enderror type="password">
                                @if ($user->id)
                                    <span class="text-muted">
                                        Deja el campo en blanco para mantener la contraseña actual.
                                    </span>
                                @endif
                                @error('password')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="fw-bold mb-1">Confirmación de contraseña:
                                    *</label>
                                <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" id="password_confirmation"
                                    placeholder="Ingresa la misma contraseña"
                                    @error('password_confirmation') autofocus @enderror type="password">
                                @if ($user->id)
                                    <span class="text-muted">
                                        Deja el campo en blanco para mantener la contraseña actual.
                                    </span>
                                @endif
                                @error('password_confirmation')
                                    <small class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="col-6 offset-6">
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('panel-admin.index') }}"
                                        class="btn btn-outline-secondary px-4">Cancelar</a>
                                    <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">
                                        <i class="fa-solid fa-save me-2"></i>
                                        {{ isset($user->id) ? 'Actualizar' : 'Guardar' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
