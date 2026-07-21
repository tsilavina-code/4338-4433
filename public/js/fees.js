function openModal() {
    document.getElementById('modalOverlay').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(e) {
    if (!e || e.target === document.getElementById('modalOverlay')) {
        document.getElementById('modalOverlay').classList.remove('active');
        document.body.style.overflow = '';
    }
}


document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
});
