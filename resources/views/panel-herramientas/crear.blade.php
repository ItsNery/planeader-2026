<x-app-layout>
    <div class="container bg-white py-12 mx-auto">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="form-container p-6 bg-white shadow-md rounded-lg">
                <form action="{{ route('panel-herramientas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h3 class="text-lg font-bold mb-4 text-gray-800"><i class="fa-solid fa-paperclip mr-2"></i>Anexos
                    </h3>
                    <div id="anexos-container">
                        <!-- Dynamic Annexes rows here -->
                    </div>
                    <button type="button" id="add-anexo" class="btn btn-info mt-2">
                        <i class="fa-solid fa-plus mr-1"></i> Agregar Anexo
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let anexoIndex = 0;

            $('#add-anexo').click(function() {
                const row = `
                    <div class="anexo-row p-3 mb-3 bg-gray-50 border rounded flex items-center space-x-3">
                        <div class="flex-1">
                            <input name="anexos[${anexoIndex}][titulo]" type="text" placeholder="Título del anexo" class="form-control w-full mb-2">
                            <input name="anexos[${anexoIndex}][archivo]" type="file" class="form-control w-full">
                        </div>
                        <button type="button" class="remove-anexo text-red-500 text-xl font-bold px-2">&times;</button>
                    </div>
                `;
                $('#anexos-container').append(row);
                anexoIndex++;
            });

            $(document).on('click', '.remove-anexo', function() {
                $(this).closest('.anexo-row').remove();
            });

            $('#portadaInput').change(function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#portadaPreview').attr('src', e.target.result).show();
                }
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
</x-app-layout>
