'use strict';

$(function () {
    // Configuración de AJAX para enviar el token CSRF
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Inicializar FormValidation en el formulario
    const form = document.getElementById('formulario');
    const fv = FormValidation.formValidation(form, {
        fields: {
            'respuesta[]': {
                validators: {
                    notEmpty: {
                        message: 'Selecciona una respuesta.'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap5: new FormValidation.plugins.Bootstrap5({
                eleValidClass: '',
                eleInvalidClass: 'is-invalid',
                rowSelector: '.resp'
            }),
            submitButton: new FormValidation.plugins.SubmitButton(),
            autoFocus: new FormValidation.plugins.AutoFocus()
        }
    }).on('core.form.valid', function () { 
        // Este evento se dispara cuando el formulario es válido

        // Crear un objeto FormData con todos los datos del formulario
        const formData = new FormData(form);

        // Enviar la solicitud AJAX con todos los datos del formulario
        $.ajax({
            url: '/registrar_revision',
            type: 'POST',
            data: formData,
            contentType: false,  // Importante para enviar los datos correctamente
            processData: false,  // Importante para evitar la transformación de los datos en cadena de consulta
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Revisión registrada exitosamente.',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    }
                }).then(() => {
                    // Redirigir a la ruta después de mostrar el mensaje de éxito
                    window.location.href = '/revision/personal';
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: xhr.responseJSON.message,
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    }
                });
            }
        });
        
    });
 
});
