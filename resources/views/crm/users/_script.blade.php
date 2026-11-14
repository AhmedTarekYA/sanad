<script>
    (function () {
        const form = document.getElementById('crm-user-form');
        if (!form) return;

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const errorBox = document.getElementById('crm-user-error');
            const formData = new FormData(form);

            errorBox.classList.add('d-none');
            errorBox.innerHTML = '';

            $.ajax({
                url: form.dataset.action,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'Accept': 'application/json' },
                success: function (response) {
                    if (window.successToster) successToster('{{ __('auth.done successfully') }}');
                    window.location.href = (response.data || {}).url || '{{ route('crm.users.index') }}';
                },
                error: function (xhr) {
                    const data = xhr.responseJSON || {};
                    const errors = data.data || {};
                    const messages = Object.keys(errors).map(function (key) {
                        const value = errors[key];
                        return Array.isArray(value) ? value[0] : value;
                    });

                    errorBox.innerHTML = messages.length ? messages.join('<br>') : '{{ __('whatsapp_request_failed') }}';
                    errorBox.classList.remove('d-none');
                }
            });
        });
    })();
</script>
