<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('selectAll');
    const auditCheckboxes = document.querySelectorAll('.audit-checkbox');
    const deleteMultipleBtn = document.getElementById('deleteMultipleBtn');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const deleteForm = document.getElementById('deleteForm');
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const exportForm = document.getElementById('exportForm');
    const exportModal = new bootstrap.Modal(document.getElementById('exportModal'));

    // Handle select all
    selectAllCheckbox?.addEventListener('change', function () {
        auditCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            updateDeleteButtonState();
        });
    });

    // Handle individual checkbox
    auditCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            updateDeleteButtonState();
            updateSelectAllCheckbox();
        });
    });

    function updateDeleteButtonState() {
        const selectedCount = document.querySelectorAll('.audit-checkbox:checked').length;
        deleteMultipleBtn.disabled = selectedCount === 0;
    }

    function updateSelectAllCheckbox() {
        const allChecked = Array.from(auditCheckboxes).every(cb => cb.checked);
        const someChecked = Array.from(auditCheckboxes).some(cb => cb.checked);
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
    }

    // Handle delete multiple
    deleteMultipleBtn?.addEventListener('click', function () {
        const selectedCount = document.querySelectorAll('.audit-checkbox:checked').length;
        if (selectedCount === 0) {
            alert('Please select at least one record.');
            return;
        }

        // Show confirmation
        if (confirm(`You are about to delete ${selectedCount} audit record(s). This cannot be undone.\n\nContinue?`)) {
            // Create and submit the form with password prompt
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("super_adminaudits.destroyMultiple") }}';
            
            const selectedIds = Array.from(document.querySelectorAll('.audit-checkbox:checked'))
                .map(cb => cb.value);
            
            form.innerHTML = `
                @csrf
                ${selectedIds.map(id => `<input type="hidden" name="audit_ids[]" value="${id}">`).join('')}
                <input type="password" id="multiDeletePassword" name="password" style="display:none;" required>
            `;
            
            const passwordInput = form.querySelector('input[type="password"]');
            const password = prompt('Enter your password to confirm deletion:');
            
            if (password !== null) {
                passwordInput.value = password;
                document.body.appendChild(form);
                form.submit();
            }
        }
    });

    // Handle delete single
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const auditId = this.getAttribute('data-audit-id');
            deleteForm.action = `/super-admin/audits/${auditId}`;
            document.getElementById('delete_password').value = '';
            deleteModal.show();
        });
    });

    // Handle export form submission
    exportForm?.addEventListener('submit', function (e) {
        const password = document.getElementById('export_password').value;
        if (!password) {
            e.preventDefault();
            alert('Please enter your password.');
        }
    });

    // Show success/error messages
    const alerts = document.querySelectorAll('[role="alert"]');
    if (alerts.length > 0) {
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    }
});
</script>
