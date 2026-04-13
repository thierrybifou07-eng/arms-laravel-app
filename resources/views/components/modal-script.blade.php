<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ Modal script loaded');
    console.log('✓ Bootstrap available:', typeof bootstrap !== 'undefined');
});

function openModal(modalName) {
    try {
        const elementId = 'modal-' + modalName;
        const modalElement = document.getElementById(elementId);
        
        if (!modalElement) {
            console.error('❌ Modal element not found with ID:', elementId);
            console.log('Available modals:', Array.from(document.querySelectorAll('[id^="modal-"]')).map(el => el.id));
            return;
        }
        
        if (typeof bootstrap === 'undefined') {
            console.error('❌ Bootstrap not loaded');
            return;
        }
        
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('✓ Modal opened:', modalName);
    } catch (error) {
        console.error('❌ Error opening modal:', error);
    }
}

function closeModal(modalName) {
    try {
        const elementId = 'modal-' + modalName;
        const modalElement = document.getElementById(elementId);
        
        if (modalElement && typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
                console.log('✓ Modal closed:', modalName);
            }
        }
    } catch (error) {
        console.error('❌ Error closing modal:', error);
    }
}
</script>
