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

        tinymce.init({
            selector: 'textarea#note-content',
            plugins: 'code table lists',
            toolbar: true,
            menubar: true,
            statusbar: true,
            readonly: 0,
            content_css: true,
            branding: false
        });

        var editor_config = {
            path_absolute: "/",
            selector: 'textarea#page-create',
            relative_urls: false,
            plugins: ['advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'emoticons'],
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | image | emoticons | language | paste',
            language: 'vi',
            file_picker_callback: function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                    'body')[0].clientWidth;
                var y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };

        tinymce.init(editor_config);
    </script>
