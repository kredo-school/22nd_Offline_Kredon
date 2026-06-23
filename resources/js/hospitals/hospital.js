// _card.blade.php ブックマーク機能
// DOMが完全に読み込まれてから実行するおまじない
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-bookmark').forEach(button => {
        button.addEventListener('click', function() {
            const hospitalId = this.dataset.id;
            const type = this.dataset.type;
            const buttonElement = this; // クリックされたボタン自身

            // サーバーへPOST送信
            fetch('/bookmarks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF対策
                },
                body: JSON.stringify({
                    id: hospitalId,
                    type: type
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('成功:', data);
                // ここでアイコンの色を変えるなどの処理を追加
                buttonElement.classList.toggle('is-active');
            })
            .catch(error => {
                console.error('失敗:', error);
            });
        });
    });
});