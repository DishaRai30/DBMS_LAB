<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <p id="modal-message"></p>
    </div>
</div>

<script>
    document.querySelector('.close-button').addEventListener('click', () => {
        document.getElementById('modal').style.display = 'none';
    });

    function showModal(message) {
        document.getElementById('modal-message').innerText = message;
        document.getElementById('modal').style.display = 'block';
    }
</script>
