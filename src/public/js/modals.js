function closeModal(container) {
    container.style.display = 'none';
}

function showModal(container) {
    container.style.display = 'flex';
}

function addBtnCloseListener(container) {
    container.querySelector('#btnCloseModal').addEventListener('click', function () {
        closeModal(container);
    });
}

function addWindowListener(container) {
    window.addEventListener('click', function (event) {
        if (event.target === container) {
            closeModal(container);
        }
    });
}

/* Message Modal */
const modalContainerMessage = document.getElementById('modalContainerMessage');
addBtnCloseListener(modalContainerMessage);
addWindowListener(modalContainerMessage);

function showMessageModal(title, message) {
    showModal(modalContainerMessage);
    modalContainerMessage.querySelector('#modalTitle').innerHTML = title;
    modalContainerMessage.querySelector('#modalMessage').innerHTML = message;
}

/* Export Modal */
const modalContainerExport = document.getElementById('modalContainerExport');
addBtnCloseListener(modalContainerExport);
addWindowListener(modalContainerExport);

function showExportModal() {
    showModal(modalContainerExport);
}

/* Book Compose Modal */
const modalContainerComposeBook = document.getElementById('modalContainerComposeBook');
addBtnCloseListener(modalContainerComposeBook);
addWindowListener(modalContainerComposeBook);

function showComposeBookModal(id, title, author) {
    showModal(modalContainerComposeBook);
    modalContainerComposeBook.querySelector('#modalTitle').innerHTML = id ? 'Edit Book' : "Add Book";
    modalContainerComposeBook.querySelector('#modalBookId').value = id ?? '';
    modalContainerComposeBook.querySelector('#modalBookTitle').value = title ?? '';
    modalContainerComposeBook.querySelector('#modalBookAuthor').value = author ?? '';
}