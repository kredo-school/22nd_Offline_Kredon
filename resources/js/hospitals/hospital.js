document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.hs-btn-bookmark').forEach(button => {
        button.addEventListener('click', function () {
            const hospitalId = this.dataset.id;
            const buttonElement = this;

            fetch(`/bookmarks/${hospitalId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.bookmarked !== undefined) {
                        buttonElement.classList.toggle('is-active', data.bookmarked);
                    }
                })
                .catch(error => {
                    console.error('ブックマーク操作に失敗:', error);
                });
        });
    });
});
