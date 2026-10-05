<x-app-layout>
    @section('title', 'Reordenar herramientas de planeación')

    <div class="container tarjeta-admin py-3">
        <div class="form-header py-3 mb-4">
            <h2>Reordenar herramientas de planeación</h2>
            <p class="text-white mb-0">Arrastra los elementos para cambiar su posición. También puedes usar las flechas para subirlos o bajarlos.</p>
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

        @if ($herramientas->isEmpty())
            <div class="alert alert-info mb-0">Aún no hay herramientas para ordenar.</div>
        @else
            <form action="{{ route('panel-herramientas.actualizar-orden') }}" method="POST" id="herramientas-order-form">
                @csrf
                @method('PUT')

                <ol class="herramientas-order-list" id="herramientas-order-list">
                    @foreach ($herramientas as $herramienta)
                        <li class="herramientas-order-item" draggable="true" data-id="{{ $herramienta->id }}">
                            <input type="hidden" name="herramientas[]" value="{{ $herramienta->id }}">
                            <span class="herramientas-order-item__position" aria-hidden="true"></span>
                            <button type="button" class="herramientas-order-item__handle" title="Arrastrar para reordenar" aria-label="Arrastrar {{ $herramienta->titulo }}">
                                <i class="fa-solid fa-grip-vertical"></i>
                            </button>
                            @if ($herramienta->imagen)
                                <img src="{{ asset('imagen/herramientas/' . $herramienta->imagen) }}" alt="" class="herramientas-order-item__image">
                            @endif
                            <div class="herramientas-order-item__content">
                                <strong>{{ $herramienta->titulo }}</strong>
                                <span>{{ $herramienta->publicado ? 'Publicado' : 'Borrador' }}</span>
                            </div>
                            <div class="herramientas-order-item__controls">
                                <button type="button" class="btn btn-sm btn-outline-secondary js-move-up" title="Subir {{ $herramienta->titulo }}" aria-label="Subir {{ $herramienta->titulo }}">
                                    <i class="fa-solid fa-chevron-up"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary js-move-down" title="Bajar {{ $herramienta->titulo }}" aria-label="Bajar {{ $herramienta->titulo }}">
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ol>

                <div class="d-flex justify-content-end flex-wrap gap-2 mt-4">
                    <a href="{{ route('panel-herramientas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
                const list = document.getElementById('herramientas-order-list');
                if (!list) return;

                let draggedItem = null;

                const updatePositions = () => {
                    [...list.children].forEach((item, index) => {
                        item.querySelector('.herramientas-order-item__position').textContent = index + 1;
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
                    const item = event.target.closest('.herramientas-order-item');
                    if (!item) return;

                    if (event.target.closest('.js-move-up')) moveItem(item, 'up');
                    if (event.target.closest('.js-move-down')) moveItem(item, 'down');
                });

                list.addEventListener('dragstart', function(event) {
                    draggedItem = event.target.closest('.herramientas-order-item');
                    if (!draggedItem) return;

                    draggedItem.classList.add('is-dragging');
                    event.dataTransfer.effectAllowed = 'move';
                });

                list.addEventListener('dragover', function(event) {
                    event.preventDefault();
                    const target = event.target.closest('.herramientas-order-item');
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
