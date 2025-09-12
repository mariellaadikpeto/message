const form = document.getElementById('formMessage');
const messagesDiv = document.getElementById('messages');
const destinataireSelect = document.getElementById('destinataire_id');

function chargerMessages() {
    const dest = destinataireSelect.value;
    if (!dest) return;

    fetch(`recuperer_messages.php?destinataire_id=${dest}`)
        .then(res => res.json())
        .then(data => {
            messagesDiv.innerHTML = '';
            data.forEach(msg => {
                const div = document.createElement('div');
                div.classList.add('message');
                div.classList.add(msg.expediteur_id == utilisateur_id ? 'moi' : 'lui');
                div.textContent = msg.contenu;
                messagesDiv.appendChild(div);
            });
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        });
}

// Envoyer un message
form.addEventListener('submit', e => {
    e.preventDefault();
    const dest = destinataireSelect.value;
    if (!dest) { alert("Choisir un utilisateur !"); return; }

    const formData = new FormData(form);
    formData.append("destinataire_id", dest);

    fetch('envoyer_message.php', { method: 'POST', body: formData })
        .then(res => res.text())
        .then(txt => {
            if (txt === "ok") {
                form.reset();
                chargerMessages();
            } else {
                alert(txt);
            }
        });
});

// Rafraîchir toutes les 1,5 secondes
setInterval(chargerMessages, 1500);
