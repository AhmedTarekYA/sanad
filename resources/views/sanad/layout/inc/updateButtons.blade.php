<style>
    /* Keep button width stable (prevents jump when spinner appears) */
    .btn-fixed-width {
        min-width: 170px;
        /* adjust to your preferred width */
    }

    /* Wrapper used to align icon + text + spinner nicely */
    .btn-content {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        white-space: nowrap;
    }

    /* Small spinner sizing and alignment */
    .btn-spinner {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1rem;
        height: 1rem;
        margin-left: 0;
        /* spinner to the left of text when shown */
    }

    /* When loading, slightly dim and prevent clicks */
    .is-loading {
        pointer-events: none;
        opacity: 0.85;
    }

    /* Optional: better spacing for the icon */
    .btn-icon {
        margin-right: 6px;
        display: inline-flex;
        align-items: center;
    }
</style>

{{-- <button id="checkUpdateBtn" class="btn btn-primary me-1">
    <i class="fas fa-sync-alt btn-icon"></i> {{ __('Check for Updates') }}
</button> --}}

<button id="pullBtn" onclick="runUpdate()" class="btn btn-success d-none">
    <i class="fas fa-download btn-icon"></i> {{ __('Pull Latest Updates') }}
</button>

<script>
    function setLoading(btn, loading = true) {
        if (!btn) return;

        if (!btn.dataset.origHtml) {
            btn.dataset.origHtml = btn.innerHTML;
        }

        if (loading) {
            if (btn.classList.contains('is-loading')) return;

            btn.classList.add('is-loading', 'btn-fixed-width');

            // Use the existing content but inject spinner element on the left
            // Keep original HTML (icon + text) and wrap it for alignment
            const orig = btn.dataset.origHtml;

            // spinner: use text-white for dark/colored buttons; adjust if button is light
            const spinnerHtml =
                '<span class="btn-spinner"><span class="spinner-border spinner-border-sm text-white" role="status" aria-hidden="true"></span></span>';

            // Put spinner before the original content
            btn.innerHTML = `${spinnerHtml}<span class="btn-content">${orig}</span>`;
        } else {
            btn.classList.remove('is-loading');

            // restore original HTML
            if (btn.dataset.origHtml) {
                btn.innerHTML = btn.dataset.origHtml;
            }
        }
    }

    // ---------- Check for updates ----------
    // document.getElementById('checkUpdateBtn').onclick = async function() {
    //     const btn = this;
    //     setLoading(btn, true);

    //     try {
    //         const response = await fetch("{{ route('updates.index') }}");
    //         const data = await response.json();

    //         if (data.update_available) {
    //             Swal.fire({
    //                 icon: 'warning',
    //                 title: "{{ __('Update Available') }}",
    //                 text: "{{ __('A new update is available!') }}",
    //                 confirmButtonText: "{{ __('OK') }}"
    //             });

    //             document.getElementById('pullBtn').classList.remove('d-none');
    //         } else {
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: "{{ __('Up to Date') }}",
    //                 text: "{{ __('Your system is already up to date!') }}",
    //                 confirmButtonText: "{{ __('Great!') }}"
    //             });
    //         }
    //     } catch (error) {
    //         Swal.fire({
    //             icon: 'error',
    //             title: "{{ __('Error') }}",
    //             text: "{{ __('Could not check for updates') }}",
    //         });
    //         console.error(error);
    //     }

    //     setLoading(btn, false);
    // };


    // ---------- Run system update ----------
    async function runUpdate() {
        Swal.fire({
            title: "{{ __('Updating System...') }}",
            text: "{{ __('Please wait...') }}",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const response = await fetch("{{ route('terminal.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    command: "php artisan system:update"
                })
            });

            const data = await response.json();

            Swal.fire({
                icon: 'success',
                title: "{{ __('Update Completed') }}",
                // html: `<pre style="text-align:left; font-size:14px;">${data.output}</pre>`,
                width: 650
            }).then(() => {
                window.location.reload();
            });

        } catch (error) {
            Swal.fire({
                icon: "{{ __('Error') }}",
                title: "{{ __('Update Failed') }}",
                text: "{{ __('Something went wrong') }}"
            }).then(() => {
                window.location.reload();
            });
            console.error(error);
        }
    }

    // auto check update
    document.addEventListener("DOMContentLoaded", async function() {
        const pullBtn = document.getElementById('pullBtn');

        try {
            const response = await fetch("{{ route('updates.index') }}");
            const data = await response.json();

            if (data.update_available) {
                pullBtn.classList.remove('d-none'); // show button
            } else {
                pullBtn.classList.add('d-none'); // hide button
            }
        } catch (error) {
            console.error("Auto update check failed:", error);
        }
    });
</script>
