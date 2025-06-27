    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea.article-content', // Phù hợp với class hoặc id textarea bạn dùng
            plugins: 'code table lists',
            toolbar: false, // Ẩn toàn bộ toolbar
            menubar: false, // Ẩn menu
            statusbar: false, // Ẩn status bar
            readonly: 1, // 1 = readonly
            content_css: false, // Dùng CSS mặc định của TinyMCE
            branding: false // Ẩn "Powered by TinyMCE"
        });
    </script>
