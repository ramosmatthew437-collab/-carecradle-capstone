{{--
    Send / Retry / Review forms: ask for confirmation, then disable the button
    and show progress so a second click cannot submit again. The server also
    refuses duplicates (atomic claim), so this is a convenience, not the guard.
--}}
@once
<script>
    (function () {
        function arm(form) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.busy === '1') {
                    event.preventDefault();
                    return;
                }

                var question = form.getAttribute('data-confirm');
                if (question && !window.confirm(question)) {
                    event.preventDefault();
                    return;
                }

                form.dataset.busy = '1';
                var button = form.querySelector('button[type="submit"]');
                if (button) {
                    button.disabled = true;
                    button.setAttribute('aria-busy', 'true');
                    button.innerHTML = '<span class="smx-spinner" aria-hidden="true"></span> ' + (form.getAttribute('data-busy-label') || 'Working…');
                }
            });
        }

        document.querySelectorAll('form[data-smx-submit]').forEach(arm);

        // Returning with the Back button must not leave a button stuck as busy;
        // the page is reloaded so it shows the current status.
        window.addEventListener('pageshow', function (event) {
            if (event.persisted && document.querySelector('form[data-busy="1"]')) {
                window.location.reload();
            }
        });
    })();
</script>
@endonce
