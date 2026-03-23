<x-app-layout>
    @section('title', isset($role->id) ? 'Editar Rol' : 'Nuevo Rol')
    <div class="container py-3">
        <div class="tarjeta-admin p-4 rounded-3 bg-white">
            <div class="form-header py-3 mb-4">
                <h2 class="fw-bold m-0">
                    {{ isset($role->id) ? 'Editar rol' : 'Nuevo rol' }}
                </h2>
                <p class="text-white mb-0 small opacity-75">
                    {{ isset($role->id) ? 'Modifique el nombre y los permisos del rol.' : 'Defina el nombre y los permisos para el nuevo rol.' }}
                </p>
            </div>
            <form action="{{ isset($role->id) ? route('panel-roles.update', $role->id) : route('panel-roles.store') }}"
                method="POST">
                @csrf
                @if (isset($role->id))
                    @method('PUT')
                @endif
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <label for="name" class="fw-bold mb-1">Nombre del Rol: *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" required value="{{ old('name', $role->name ?? '') }}"
                                placeholder="Ej: editor-noticias" {{ $role->name === 'super-admin' ? 'readonly' : '' }}>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="custom-section-title mb-3">
                            <i class="fa-solid fa-key text-primary-integration"></i> Permisos Asignados
                        </div>
                        
                        <div class="row">
                            @php
                                $groupedPermissions = $permissions->groupBy(function($item) {
                                    $parts = explode('-', $item->name);
                                    return count($parts) > 1 ? end($parts) : 'otros';
                                });
                            @endphp
                            
                            @foreach($groupedPermissions as $group => $groupPermissions)
                                <div class="col-md-4 mb-4">
                                    <h5 class="fw-bold border-bottom pb-2">{{ ucfirst($group) }}</h5>
                                    @foreach($groupPermissions as $permission)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                                value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                                {{ (isset($rolePermissions) && in_array($permission->name, $rolePermissions)) || old('permissions') && in_array($permission->name, old('permissions')) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="perm-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('panel-roles.index') }}"
                                class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-custom-primary px-5 shadow-sm">
                                <i class="fa-solid fa-save me-2"></i>
                                {{ isset($role->id) ? 'Actualizar' : 'Guardar' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
