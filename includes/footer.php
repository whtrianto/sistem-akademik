</main>

<script>
// Delete confirmation modal
function confirmDelete(url, name) {
    const overlay = document.getElementById('deleteModal');
    const itemName = document.getElementById('deleteItemName');
    const deleteLink = document.getElementById('deleteLink');
    itemName.textContent = name;
    deleteLink.href = url;
    overlay.classList.add('show');
}

function closeModal() {
    document.getElementById('deleteModal').classList.remove('show');
}

// Close modal on overlay click
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        closeModal();
    }
});
</script>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <div style="font-size:48px; margin-bottom:16px;">⚠️</div>
        <h4>Konfirmasi Hapus</h4>
        <p>Apakah Anda yakin ingin menghapus <strong id="deleteItemName"></strong>?</p>
        <div class="btn-group">
            <button onclick="closeModal()" class="btn btn-secondary">Batal</button>
            <a href="#" id="deleteLink" class="btn btn-danger">Ya, Hapus</a>
        </div>
    </div>
</div>

</body>
</html>
