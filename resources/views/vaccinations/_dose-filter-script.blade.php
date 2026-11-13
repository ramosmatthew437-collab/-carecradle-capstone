{{--
    Shared by vaccinations/create and vaccinations/edit.
    Narrows the Dose dropdown to the doses offered for the selected vaccine
    (from App\Models\Vaccination::DOSES_BY_VACCINE, passed in data attributes).
    The same rule is enforced on the server, so the form still validates
    correctly when JavaScript is disabled.
--}}
<script>
    (function () {
        document.querySelectorAll('select[data-dose-select]').forEach(function (doseSelect) {
            var vaccineSelect = doseSelect.form ? doseSelect.form.querySelector('select[data-vaccine-select]') : null;
            if (!vaccineSelect) {
                return;
            }

            var doseMap = JSON.parse(doseSelect.getAttribute('data-dose-map') || '{}');
            var allDoses = JSON.parse(doseSelect.getAttribute('data-all-doses') || '[]');
            var legacyVaccine = doseSelect.getAttribute('data-legacy-vaccine') || '';
            var legacyDose = doseSelect.getAttribute('data-legacy-dose') || '';
            var placeholder = doseSelect.querySelector('option[value=""]');
            var placeholderText = placeholder ? placeholder.textContent.trim() : 'Select Dose';

            function rebuild() {
                var vaccine = vaccineSelect.value;
                var current = doseSelect.value;
                var doses = (doseMap[vaccine] || allDoses).slice();
                var labels = {};

                // Keep a stored dose that is no longer offered visible (edit form only).
                if (legacyDose && vaccine === legacyVaccine && doses.indexOf(legacyDose) === -1) {
                    doses.push(legacyDose);
                    labels[legacyDose] = legacyDose + ' (no longer offered)';
                }

                doseSelect.innerHTML = '';
                doseSelect.add(new Option(placeholderText, ''));
                doses.forEach(function (dose) {
                    doseSelect.add(new Option(labels[dose] || dose, dose));
                });

                if (doses.indexOf(current) !== -1) {
                    doseSelect.value = current;
                } else if (doses.length === 1) {
                    doseSelect.value = doses[0]; // e.g. BCG: Birth Dose only
                } else {
                    doseSelect.value = '';
                }
            }

            vaccineSelect.addEventListener('change', rebuild);
            rebuild();
        });
    })();
</script>
