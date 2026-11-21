{{--
    Keeps the appointment date and time pickers from offering past values,
    using the Irosin RHU's local time (Asia/Manila). Same rule as
    AppointmentController::notInPastRules(), which enforces it on the server.

    Expects $onlyWhenChanged (bool): on the Edit page the limits apply only
    once the date or time is changed, so a past appointment can still be
    edited (e.g. its status) while its date and time stay as they are.
--}}
<script>
    (function () {
        var date = document.getElementById('appointment_date');
        var time = document.getElementById('appointment_time');
        if (!date || !time) return;

        var onlyWhenChanged = @json((bool) ($onlyWhenChanged ?? false));
        // Server clock (not the device clock), converted to Manila time below.
        var offset = @json(now()->getTimestampMs()) - Date.now();
        var originalDate = date.value;
        var originalTime = (time.value || '').slice(0, 5);
        var formatter = new Intl.DateTimeFormat('en-CA', {
            timeZone: 'Asia/Manila', year: 'numeric', month: '2-digit', day: '2-digit',
            hour: '2-digit', minute: '2-digit', hourCycle: 'h23'
        });

        function manilaNow() {
            var parts = {};
            formatter.formatToParts(new Date(Date.now() + offset)).forEach(function (p) { parts[p.type] = p.value; });
            return { date: parts.year + '-' + parts.month + '-' + parts.day, time: parts.hour + ':' + parts.minute };
        }

        function apply() {
            var currentTime = (time.value || '').slice(0, 5);
            var changed = !onlyWhenChanged || date.value !== originalDate || currentTime !== originalTime;

            if (!changed) {
                date.removeAttribute('min');
                time.removeAttribute('min');
                date.setCustomValidity('');
                time.setCustomValidity('');
                return;
            }

            var now = manilaNow();
            date.min = now.date;
            if (date.value === now.date) { time.min = now.time; } else { time.removeAttribute('min'); }

            date.setCustomValidity(date.value && date.value < now.date
                ? 'The appointment date cannot be in the past. Choose today or a later date.' : '');
            time.setCustomValidity(date.value === now.date && currentTime && currentTime < now.time
                ? 'The appointment time has already passed today. Choose a later time, or a later date.' : '');
        }

        ['input', 'change', 'focus'].forEach(function (type) {
            date.addEventListener(type, apply);
            time.addEventListener(type, apply);
        });
        // Re-check just before the browser validates the form on submit.
        if (date.form) {
            date.form.querySelectorAll('[type="submit"]').forEach(function (button) {
                button.addEventListener('click', apply);
            });
        }
        apply();
    })();
</script>
