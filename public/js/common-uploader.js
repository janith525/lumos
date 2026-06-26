/**
 * Reusable FilePond Common Uploader Configuration Helper
 * Bind any FilePond instance to the secure, asynchronous temporary upload endpoints.
 */
(function() {
    window.initCommonUploader = function(element, options = {}) {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
        
        const defaultOptions = {
            server: {
                process: {
                    url: '/admin/uploads/process',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                },
                revert: {
                    url: '/admin/uploads/revert',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                },
                load: (source, load, error, progress, abort, headers) => {
                    fetch(source)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.blob();
                        })
                        .then(load)
                        .catch(err => {
                            error(err.message);
                        });
                }
            },
            labelIdle: 'Drag & Drop or <span class="filepond--label-action">Browse</span>',
            imagePreviewHeight: 250,
            stylePanelLayout: 'compact',
            styleLoadIndicatorPosition: 'center bottom',
            styleProgressIndicatorPosition: 'right bottom',
            styleButtonRemoveItemPosition: 'left bottom',
            styleButtonProcessItemPosition: 'right bottom',
        };

        return FilePond.create(element, Object.assign({}, defaultOptions, options));
    };
})();
