<script src="https://cdn.tiny.cloud/1/{{env('TINYMCE_API_KEY')}}/tinymce/8/tinymce.min.js" referrerpolicy="origin"
    crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        tinymce.init({
            selector: 'textarea#editor',
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
            image_advtab: true,
            height: 500,
            setup: function (editor) {
                editor.on('init', function () {
                    // Hide Bootstrap spinner
                    $('#editor-loading').addClass('d-none');
                    // Show the editor
                    $('#editor').removeClass('d-none');
                });
            }
        });
    });
</script>
