<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
    function initializeCKEditor(selector) {
        document.querySelectorAll(selector).forEach((textarea) => {
            ClassicEditor
                .create(textarea, {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'subscript', 'superscript', '|',
                            'link', 'bulletedList', 'numberedList', '|',
                            'insertImage', 'blockQuote', '|',
                            'undo', 'redo'
                        ]
                    },
                    language: 'es',
                    image: {
                        toolbar: ['imageTextAlternative', 'imageStyle:full', 'imageStyle:side']
                    },
                })
                .catch(error => {
                    console.error(error);
                });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initializeCKEditor('textarea.rich-text');

        document.getElementById('questions-container')?.addEventListener('DOMNodeInserted', function (e) {
            if (e.target.querySelectorAll) {
                e.target.querySelectorAll('textarea.rich-text').forEach(el => {
                    if (!el.classList.contains('ck-editor__editable_inline')) {
                        ClassicEditor.create(el).catch(err => console.error(err));
                    }
                });
            }
        });
    });
</script>
