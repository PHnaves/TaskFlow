import './bootstrap';

// Aviso (toast): some sozinho depois de alguns segundos ou ao clicar em fechar.
document.querySelectorAll('[data-toast]').forEach((toast) => {
    const close = () => {
        toast.classList.add('is-leaving');
        setTimeout(() => toast.remove(), 250);
    };

    toast.querySelector('[data-toast-close]')?.addEventListener('click', close);
    setTimeout(close, 5000);
});

// Modal de confirmação de exclusão de tarefa.
const deleteModal = document.getElementById('delete-modal');

if (deleteModal) {
    const form = deleteModal.querySelector('form');
    const title = deleteModal.querySelector('[data-delete-target]');

    document.querySelectorAll('[data-delete-url]').forEach((button) => {
        button.addEventListener('click', () => {
            form.action = button.dataset.deleteUrl;
            title.textContent = button.dataset.deleteTitle;
            deleteModal.showModal();
        });
    });

    deleteModal.querySelectorAll('[data-modal-close]').forEach((button) => {
        button.addEventListener('click', () => deleteModal.close());
    });

    // Clicar no fundo escurecido (fora da caixa) também fecha o modal.
    deleteModal.addEventListener('click', (event) => {
        if (event.target === deleteModal) {
            deleteModal.close();
        }
    });
}
