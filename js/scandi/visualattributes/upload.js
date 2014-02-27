document.observe('dom:loaded', function () {
    /* Prevent browser from sending empty file inputs */
    if (editForm && editForm.submit) {
        editForm.submit = editForm.submit.wrap(function (parent, url) {
            $$('input[type=file]').each(function (input) {
                if (!input.value) { input.disabled = true; }
            });
            parent(url);
        });
    }
});