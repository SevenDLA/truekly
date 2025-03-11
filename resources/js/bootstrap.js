import axios from 'axios';
window.axios = axios;

window.Echo.private(`conversation.${conversationId}`)
.listen('MessageSent', (data) => {
    const messagesContainer = document.getElementById('messages');
    messagesContainer.insertAdjacentHTML('beforeend', data.html);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';