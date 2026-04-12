<script>
function openModal(modalName) {
    window.dispatchEvent(new CustomEvent('open-modal', { detail: modalName }));
}

function closeModal(modalName) {
    window.dispatchEvent(new CustomEvent('close-modal', { detail: modalName }));
}
</script>
