import './bootstrap';

document.addEventListener('DOMContentLoaded', async () => {
  const box = document.getElementById('api-message');
  try {
    const res = await fetch('/api/message');
    const data = await res.json();
    box.textContent = data.message;
  } catch (e) {
    console.error(e);
    box.textContent = 'Failed to load message.';
  }
});

