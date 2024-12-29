@extends('voyager::master')

@section('page_title', __('voyager::generic.' . (isset($dataTypeContent->id) ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.' . (isset($dataTypeContent->id) ? 'edit' : 'add')) . ' ' . $dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
            action="@if (!is_null($dataTypeContent->getKey())) {{ route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.' . $dataType->slug . '.store') }} @endif"
            method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if (isset($dataTypeContent->id))
                {{ method_field('PUT') }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">
                            <div class="form-group">
                                <a target="blank" type="button" class="btn btn-primary float-right"
                                    href="https://checkout.wompi.co/l/0vsdUZ"><i class="voyager-paypal"></i> PAGOS EN
                                    LINEA</a>
                            </div>
                            @php
                                $tipoPeticiones = Voyager::tipo_peticion();
                            @endphp
                            @php
                                if (isset($dataTypeContent->tipo_peticion)) {
                                    $selected_tipo_peticion = $dataTypeContent->tipo_peticion;
                                } else {
                                    $selected_tipo_peticion = null; // Cambia '' por null
                                }
                            @endphp
                            <div class="form-group">
                                <h5 for="tipo_peticion">{{ __('Tipo de Petición') }}</h5>
                                <select class="form-control select2" id="tipo_peticion" name="tipo_peticion">
                                    @foreach ($tipoPeticiones as $tipo_peticion)
                                        <option value="{{ $tipo_peticion->tipo_peticion }}"
                                            {{ $tipo_peticion->tipo_peticion == $selected_tipo_peticion ? 'selected' : '' }}>
                                            {{ $tipo_peticion->tipo_peticion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Cargar Una Sola Imagen --}}
                            <div class="form-group" id="imagen_option">
                                <h5 for="foto">{{ __('Imagen') }}</h5>
                                @if (!empty($dataTypeContent->foto))
                                    @foreach (json_decode($dataTypeContent->foto) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInput"><i class="voyager-images"></i>
                                        Seleccionar imagen</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInput" data-name="foto"
                                        accept="image/*, .pdf" name="foto" style="display: none;">
                                    <span id="fileLabel"></span>
                                </div>
                            </div>

                            {{-- Opción de carga de cédula --}}
                            <div class="form-group" id="cedula_option">
                                <h5 for="cedula">{{ __('Cédula') }}</h5>
                                @if (!empty($dataTypeContent->cedula))
                                    @foreach (json_decode($dataTypeContent->cedula) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInputCedula"><i class="voyager-credit-card"></i>
                                        Seleccionar cédula</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInputCedula" data-name="cedula"
                                        accept="image/*, .pdf" name="cedula" style="display: none;">
                                    <span id="fileLabelCedula"></span>
                                </div>
                            </div>

                            {{-- Opción de carga de pago --}}
                            <div class="form-group" id="pago_option">
                                <h5 for="pago">{{ __('Pago') }}</h5>
                                @if (!empty($dataTypeContent->pago))
                                    @foreach (json_decode($dataTypeContent->pago) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInputPago"><i class="voyager-images"></i>
                                        Seleccionar Imagen de Pago</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInputPago" data-name="pago"
                                        accept="image/*, .pdf" name="pago" style="display: none;">
                                    <span id="fileLabelPago"></span>
                                </div>
                            </div>
                            
                            {{-- Opción de carga de pago --}}
                            <div class="form-group" id="pago_option">
                                <h5 for="pago">{{ __('Pago') }}</h5>
                                @if (!empty($dataTypeContent->pago))
                                    @foreach (json_decode($dataTypeContent->pago) as $pdf)
                                        <div class="file-preview">
                                            <a href="{{ filter_var($pdf->download_link ?? '', FILTER_VALIDATE_URL) ? $pdf->download_link : Voyager::image($pdf->download_link) }}"
                                                target="_blank">
                                                {{ $pdf->original_name ?? basename($pdf->download_link) }}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInputPago"><i class="voyager-images"></i>
                                        Seleccionar Imagen de Pago</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInputPago" data-name="pago"
                                        accept="image/*, .pdf" name="pago" style="display: none;">
                                    <span id="fileLabelPago"></span>
                                </div>
                            </div>


                            {{-- Cargar Una Sola Imagen --}}
                            {{-- <div class="form-group" id="imagen_option">
                                <h5 for="imagen">{{ __('Imagen') }}</h5>
                                @if (isset($dataTypeContent->imagen))
                                    <img src="{{ filter_var($dataTypeContent->imagen, FILTER_VALIDATE_URL) ? $dataTypeContent->imagen : Voyager::image($dataTypeContent->imagen) }}"
                                        style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif --}}

                            {{-- Cargar Multiples Imagenes  --}}
                            {{-- <div class="form-group" id="imagen_option">
                                <h5 for="imagen">{{ __('Imágenes') }}</h5>
                                @if (isset($dataTypeContent->imagen))
                                    @foreach (json_decode($dataTypeContent->imagen) as $imagen)
                                        <img src="{{ filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : Voyager::image($imagen) }}"
                                            style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                    @endforeach
                                @endif --}}

                            {{-- <div class="custom-file">
                                    <!-- Botón personalizado -->
                                    <label class="btn btn-primary" for="fileInput"><i class="voyager-images"></i>
                                        Seleccionar imágenes</label>
                                    <!-- Input de archivo oculto -->
                                    <input type="file" class="custom-file-input" id="fileInput" data-name="imagen[]"
                                        accept="image/*" name="imagen[]" multiple style="display: none;">
                                    <label class="invalid-feedback" style="display: none;">Por favor, seleccione una
                                        imagen.</label>
                                    <span id="fileLabel"></span>

                                </div>
                            </div> --}}

                            <div class="form-group">
                                <h5 for="valor_consignado">{{ __('Valor Consignado') }}</h5>
                                <input type="text" class="form-control" id="valor_consignado" name="valor_consignado"
                                    placeholder="{{ __('Valor Consignado') }}"
                                    value="{{ old('valor_consignado', $dataTypeContent->valor_consignado ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="asunto">{{ __('Asunto') }}</h5>
                                <input type="text" class="form-control" id="asunto" name="asunto"
                                    placeholder="{{ __('Asunto') }}"
                                    value="{{ old('asunto', $dataTypeContent->asunto ?? '') }}">
                            </div>

                            <div class="form-group">
                                <h5 for="mensaje">{{ __('Mensaje') }}</h5>
                                <textarea class="form-control" id="richtext mensaje" name="mensaje"></textarea>
                                {{-- <textarea required="true"  class="form-control richTextBox" id="richtext mensaje" name="mensaje"></textarea> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <button type="submit" class="btn btn-primary pull-right save">
        {{-- {{ __('voyager::generic.save') }} --}}
        Enviar
    </button>
    </form>
    <div style="display:none">
        <input type="hidden" id="upload_url" value="{{ route('voyager.upload') }}">
        <input type="hidden" id="upload_type_slug" value="{{ $dataType->slug }}">
    </div>
    </div>
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
            return function() {
                $file = $(this).siblings(tag);

                params = {
                    slug: '{{ $dataType->slug }}',
                    filename: $file.data('file-name'),
                    id: $file.data('id'),
                    field: $file.parent().data('field-name'),
                    multi: isMulti,
                    _token: '{{ csrf_token() }}'
                }

                $('.confirm_delete_name').text(params.filename);
                $('#confirm_delete_modal').modal('show');
            };
        }

        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function(idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: ['YYYY-MM-DD']
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({
                    "editing": true
                });
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function() {
                $.post('{{ route('voyager.' . $dataType->slug . '.media.remove') }}', params, function(
                    response) {
                    if (response &&
                        response.data &&
                        response.data.status &&
                        response.data.status == 200) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() {
                            $(this).remove();
                        })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                // Validar campo de imagen solo si está visible
                if ($('#imagen_option').is(':visible') && $('#fileInput').get(0).files.length === 0) {
                    // Mostrar mensaje de error
                    $('#fileInput').siblings('.invalid-feedback').show();
                    // Detener el envío del formulario
                    event.preventDefault();
                } else {
                    // Ocultar mensaje de error si hay archivos seleccionados o el campo no está visible
                    $('#fileInput').siblings('.invalid-feedback').hide();
                }

                // Validar campo de cédula solo si está visible
                if ($('#cedula_option').is(':visible') && $('#fileInputCedula').get(0).files.length === 0) {
                    // Mostrar mensaje de error
                    $('#fileInputCedula').siblings('.invalid-feedback').show();
                    // Detener el envío del formulario
                    event.preventDefault();
                } else {
                    // Ocultar mensaje de error si hay archivos seleccionados o el campo no está visible
                    $('#fileInputCedula').siblings('.invalid-feedback').hide();
                }

                // Validar campo de pago solo si está visible
                if ($('#pago_option').is(':visible') && $('#fileInputPago').get(0).files.length === 0) {
                    // Mostrar mensaje de error
                    $('#fileInputPago').siblings('.invalid-feedback').show();
                    // Detener el envío del formulario
                    event.preventDefault();
                } else {
                    // Ocultar mensaje de error si hay archivos seleccionados o el campo no está visible
                    $('#fileInputPago').siblings('.invalid-feedback').hide();
                }
            });
        });
    </script>
    {{-- <script>
        var tipoPeticiones = @json($tipoPeticiones);

        $(document).ready(function() {
            var tipoPeticionSelect = $('#tipo_peticion');
            var imagenOption = $('#imagen_option');
            var cedulaOption = $('#cedula_option');
            var pagoOption = $('#pago_option');

            tipoPeticionSelect.change(function() {
                var selectedTipoPeticion = $(this).val();
                var selectedPeticion = tipoPeticiones.find(function(peticion) {
                    return peticion.tipo_peticion === selectedTipoPeticion;
                });

                if (selectedPeticion) {
                    if (selectedPeticion.foto === 1) {
                        imagenOption.show();
                    } else {
                        imagenOption.hide();
                    }

                    if (selectedPeticion.cedula === 1) {
                        cedulaOption.show();
                    } else {
                        cedulaOption.hide();
                    }

                    if (selectedPeticion.pago === 1) {
                        pagoOption.show();
                    } else {
                        pagoOption.hide();
                    }
                } else {
                    // Si no se encuentra la petición seleccionada, ocultar todas las opciones
                    imagenOption.hide();
                    cedulaOption.hide();
                    pagoOption.hide();
                }
            });

            // Ejecutar el cambio inicialmente para configurar el estado según el valor seleccionado inicialmente
            tipoPeticionSelect.trigger('change');
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            var additionalConfig = {
                selector: 'textarea.richTextBox[name="mensaje"]',
            }

            $.extend(additionalConfig, {!! json_encode($options->tinymceOptions ?? (object) []) !!})

            tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
        });
    </script>

    <script>
        $(document).ready(function() {
            // Función para actualizar el nombre de los archivos seleccionados con su extensión original
            function updateFileLabel(inputId, labelId, baseFileName) {
                $('#' + inputId).on('change', function() {
                    var files = $(this)[0].files;
                    if (files.length > 0) {
                        // Obtener el archivo y su extensión original
                        var file = files[0];
                        var fileExtension = file.name.split('.').pop(); // Extraer la extensión

                        // Crear un nuevo nombre con la extensión original
                        var newFileName = baseFileName + '.' + fileExtension;

                        // Crear un nuevo archivo con el nombre modificado
                        var renamedFile = new File([file], newFileName, {
                            type: file.type
                        });

                        // Crear un nuevo objeto FileList con el archivo renombrado
                        var dataTransfer = new DataTransfer();
                        dataTransfer.items.add(renamedFile);

                        // Asignar el nuevo objeto FileList al input de archivo
                        $('#' + inputId)[0].files = dataTransfer.files;

                        // Actualizar la etiqueta del archivo
                        $('#' + labelId).text(newFileName);
                    }
                });
            }

            // Llamar a la función para cada grupo de archivos con el nuevo nombre base deseado
            updateFileLabel('fileInput', 'fileLabel', 'imagen');
            updateFileLabel('fileInputCedula', 'fileLabelCedula', 'cedula');
            updateFileLabel('fileInputPago', 'fileLabelPago', 'pago');
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var tipoPeticiones = @json($tipoPeticiones);

    $(document).ready(function () {
        var tipoPeticionSelect = $('#tipo_peticion');
        var imagenOption = $('#imagen_option');
        var cedulaOption = $('#cedula_option');
        var pagoOption = $('#pago_option');

        // Cambiar estado de campos según la selección
        tipoPeticionSelect.change(function () {
            var selectedTipoPeticion = $(this).val();
            var selectedPeticion = tipoPeticiones.find(function (peticion) {
                return peticion.tipo_peticion === selectedTipoPeticion;
            });

            if (selectedPeticion) {
                if (selectedPeticion.foto === 1) {
                    imagenOption.show();
                } else {
                    imagenOption.hide();
                }

                if (selectedPeticion.cedula === 1) {
                    cedulaOption.show();
                } else {
                    cedulaOption.hide();
                }

                if (selectedPeticion.pago === 1) {
                    pagoOption.show();
                } else {
                    pagoOption.hide();
                }
            } else {
                imagenOption.hide();
                cedulaOption.hide();
                pagoOption.hide();
            }
        });

        // Ejecutar el cambio inicialmente
        tipoPeticionSelect.trigger('change');

        // Validar formulario antes de enviarlo
        $('.form-edit-add').on('submit', function (event) {
            let errors = [];

            const selectedTipoPeticion = tipoPeticionSelect.val();
            const selectedPeticion = tipoPeticiones.find(function (peticion) {
                return peticion.tipo_peticion === selectedTipoPeticion;
            });

            // Validar solo los campos visibles
            if (selectedPeticion) {
                if (selectedPeticion.foto === 1 && $('input[name="foto"]').get(0).files.length === 0) {
                    errors.push('Debes adjuntar una imagen.');
                }

                if (selectedPeticion.cedula === 1 && $('input[name="cedula"]').get(0).files.length === 0) {
                    errors.push('Debes adjuntar la cédula.');
                }

                if (selectedPeticion.pago === 1 && $('input[name="pago"]').get(0).files.length === 0) {
                    errors.push('Debes adjuntar la imagen de pago.');
                }
            }

           
            const valor_consignado = $('input[name="valor_consignado"]').val().trim();
            if (!valor_consignado) {
                errors.push('Si no hay Valor Consignado, ingresar $0.');
            }

        
            const asunto = $('input[name="asunto"]').val().trim();
            if (!asunto) {
                errors.push('El campo "Asunto" es obligatorio.');
            }

            const mensaje = $('textarea[name="mensaje"]').val().trim();
            if (!mensaje) {
                errors.push('El campo "Mensaje" es obligatorio.');
            }

            // Mostrar errores con SweetAlert2 si hay
            if (errors.length > 0) {
                event.preventDefault();
                Swal.fire({
                    title: '¡Campos faltantes!',
                    html: `<ul style="text-align: left;">${errors.map(error => `<li>${error}</li>`).join('')}</ul>`,
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    });
</script>

<script>
    // Formatear el campo de valor consignado al formato de pesos colombianos
    $(document).ready(function () {
        var valorConsignadoInput = $('#valor_consignado');

        // Aplicar el formato al cargar el valor
        if (valorConsignadoInput.val()) {
            valorConsignadoInput.val(formatCurrency(valorConsignadoInput.val()));
        }

        // Formatear al escribir
        valorConsignadoInput.on('input', function () {
            var formattedValue = formatCurrency(valorConsignadoInput.val());
            valorConsignadoInput.val(formattedValue);
        });

        // Función para formatear el valor como moneda colombiana
        function formatCurrency(value) {
            // Remover todo lo que no sea un número
            var number = value.replace(/[^0-9]/g, '');

            // Convertir el número a formato de moneda
            var formattedNumber = new Intl.NumberFormat('es-CO', {
                minimumFractionDigits: 0,
            }).format(number);

            return formattedNumber;
        }
    });
</script>
    
@stop
