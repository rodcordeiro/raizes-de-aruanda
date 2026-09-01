(function () {
  var dialog = document.getElementById('delete-dialog');
  if (!dialog || typeof dialog.showModal !== 'function') {
    return;
  }

  var idInput = document.getElementById('delete-id');
  var preview = document.getElementById('delete-preview');

  document.querySelectorAll('[data-delete-open]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-id') || '';
      var text = btn.getAttribute('data-preview') || '';
      if (idInput) {
        idInput.value = id;
      }
      if (preview) {
        if (text) {
          preview.hidden = false;
          preview.textContent = text;
        } else {
          preview.hidden = true;
          preview.textContent = '';
        }
      }
      dialog.showModal();
    });
  });

  document.querySelectorAll('[data-delete-cancel]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      dialog.close();
    });
  });

  dialog.addEventListener('click', function (event) {
    if (event.target === dialog) {
      dialog.close();
    }
  });
})();
