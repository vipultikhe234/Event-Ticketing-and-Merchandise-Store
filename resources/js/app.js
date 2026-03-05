// Bootstrap
import 'bootstrap';

// Spotify integration
document.addEventListener('DOMContentLoaded', function() {
    // Spotify modal functionality
    const spotifyModal = document.getElementById('spotifyModal');
    if (spotifyModal) {
        spotifyModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const performerName = button.getAttribute('data-performer');
            const spotifyId = button.getAttribute('data-spotify-id');

            const modalTitle = spotifyModal.querySelector('.modal-title');
            const tracksContainer = spotifyModal.querySelector('.tracks-container');

            modalTitle.textContent = `Top Tracks - ${performerName}`;
            tracksContainer.innerHTML = '<div class="text-center"><div class="spinner-border"></div></div>';

            // Fetch tracks from API
            fetch(`/api/spotify/tracks/${spotifyId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.tracks.length > 0) {
                        let tracksHtml = '';
                        data.tracks.slice(0, 5).forEach(track => {
                            tracksHtml += `
                                <div class="track-item d-flex align-items-center mb-3">
                                    <img src="${track.album.images[2].url}" class="me-3" style="width: 50px; height: 50px;">
                                    <div>
                                        <strong>${track.name}</strong><br>
                                        <small class="text-muted">Album: ${track.album.name}</small>
                                    </div>
                                    <audio controls class="ms-auto">
                                        <source src="${track.preview_url}" type="audio/mpeg">
                                    </audio>
                                </div>
                            `;
                        });
                        tracksContainer.innerHTML = tracksHtml;
                    } else {
                        tracksContainer.innerHTML = '<p class="text-muted">No tracks found</p>';
                    }
                })
                .catch(error => {
                    tracksContainer.innerHTML = '<p class="text-danger">Error loading tracks</p>';
                });
        });
    }

    // Auto-dismiss alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
