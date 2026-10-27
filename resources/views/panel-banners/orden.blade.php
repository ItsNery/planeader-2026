<x-app-layout>
    @section('title', 'Reordenar banners')

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 mb-4">
            <h2>Reordenar banners</h2>
            <p class="text-white mb-0">Arrastra los banners para cambiar su posición. También puedes usar las flechas para subirlos o bajarlos.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>No fue posible guardar el orden.</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($banners->isEmpty())
            <div class="alert alert-info mb-0">Aún no hay banners para ordenar.</div>
        @else
            <form action="{{ route('panel-banners.actualizar-orden') }}" method="POST" id="banners-order-form">
                @csrf
                @method('PUT')

                <ol class="banners-order-list" id="banners-order-list">
                    @foreach ($banners as $banner)
                        <li class="banners-order-item" draggable="true" data-id="{{ $banner->id }}">
                            <input type="hidden" name="banners[]" value="{{ $banner->id }}">
                            <span class="banners-order-item__position" aria-hidden="true"></span>
                            <button type="button" class="banners-order-item__handle" title="Arrastrar para reordenar" aria-label="Arrastrar {{ $banner->nombre }}">
                                <i class="fa-solid fa-grip-vertical"></i>
                            </button>
                            <img src="{{ asset('baners/' . $banner->imagen) }}" alt="" class="banners-order-item__image">
                            <div class="banners-order-item__content">
                                <strong>{{ $banner->nombre }}</strong>
                                <span>{{ $banner->estado }} · {{ $banner->seccion }}</span>
                            </div>
                            <div class="banners-order-item__controls">
                                <button type="button" class="btn btn-sm btn-outline-secondary js-move-up" title="Subir {{ $banner->nombre }}" aria-label="Subir {{ $banner->nombre }}">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary js-move-down" title="Bajar {{ $banner->nombre }}" aria-label="Bajar {{ $banner->nombre }}">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <div class="d-flex justify-content-end flex-wrap gap-2 mt-4">
                    <a href="{{ route('panel-banners.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-custom-primary">
                        <i class="fa-solid fa-floppy-disk me-1"></i>Guardar nuevo orden
                    </button>
                </div>
            </form>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const list = document.getElementById('banners-order-list');
                if (!list) return;

                let draggedItem = null;

                const updatePositions = () => {
                    [...list.children].forEach((item, index) => {
                        item.querySelector('.banners-order-item__position').textContent = index + 1;
                    });
                };

                const moveItem = (item, direction) => {
                    const sibling = direction === 'up' ? item.previousElementSibling : item.nextElementSibling;
                    if (!sibling) return;

                    if (direction === 'up') {
                        list.insertBefore(item, sibling);
                    } else {
                        list.insertBefore(sibling, item);
                    }
                    updatePositions();
                };

                list.addEventListener('click', function(event) {
                    const item = event.target.closest('.banners-order-item');
                    if (!item) return;

                    if (event.target.closest('.js-move-up')) moveItem(item, 'up');
                    if (event.target.closest('.js-move-down')) moveItem(item, 'down');
                });

                list.addEventListener('dragstart', function(event) {
                    draggedItem = event.target.closest('.banners-order-item');
                    if (!draggedItem) return;

                    draggedItem.classList.add('is-dragging');
                    event.dataTransfer.effectAllowed = 'move';
                });

                list.addEventListener('dragover', function(event) {
                    event.preventDefault();
                    const target = event.target.closest('.banners-order-item');
                    if (!draggedItem || !target || target === draggedItem) return;

                    const { top, height } = target.getBoundingClientRect();
                    list.insertBefore(draggedItem, event.clientY < top + height / 2 ? target : target.nextSibling);
                });

                list.addEventListener('dragend', function() {
                    draggedItem?.classList.remove('is-dragging');
                    draggedItem = null;
                    updatePositions();
                });

                updatePositions();
            });
        </script>
    @endpush
</x-app-layout>
