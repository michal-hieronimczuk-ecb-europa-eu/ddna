(function (Drupal, once) {
  'use strict';

  var preview_hide_timer;

  function createDialog() {
    var dialog = document.createElement('dialog');
    dialog.className = 'ddna-json-dialog';
    dialog.setAttribute('aria-labelledby', 'ddna-json-dialog-title');
    dialog.innerHTML = '<header class="ddna-json-dialog__header"><h2 id="ddna-json-dialog-title">JSON value</h2><button type="button" class="ddna-json-dialog__close" aria-label="Close JSON viewer" title="Close">&times;</button></header><pre class="ddna-json-dialog__content"><code></code></pre>';
    dialog.querySelector('.ddna-json-dialog__close').addEventListener('click', function () {
      dialog.close();
    });
    dialog.addEventListener('click', function (event) {
      if (event.target === dialog) {
        dialog.close();
      }
    });
    document.body.appendChild(dialog);
    return dialog;
  }

  function createPreview() {
    var preview = document.createElement('div');
    preview.className = 'ddna-text-preview';
    preview.setAttribute('role', 'tooltip');
    preview.hidden = true;
    document.body.appendChild(preview);
    preview.addEventListener('pointerenter', function () {
      window.clearTimeout(preview_hide_timer);
    });
    preview.addEventListener('pointerleave', hidePreview);
    return preview;
  }

  function showPreview(trigger, preview) {
    window.clearTimeout(preview_hide_timer);
    preview.textContent = trigger.getAttribute('data-preview-text') || '';
    preview.hidden = false;
    var trigger_rect = trigger.getBoundingClientRect();
    var preview_rect = preview.getBoundingClientRect();
    var left = Math.min(Math.max(8, trigger_rect.left), window.innerWidth - preview_rect.width - 8);
    var top = trigger_rect.bottom + 6;
    if (top + preview_rect.height > window.innerHeight - 8) {
      top = Math.max(8, trigger_rect.top - preview_rect.height - 6);
    }
    preview.style.left = left + 'px';
    preview.style.top = top + 'px';
  }

  function hidePreview() {
    window.clearTimeout(preview_hide_timer);
    preview_hide_timer = window.setTimeout(function () {
      var preview = document.querySelector('.ddna-text-preview');
      if (preview) {
        preview.hidden = true;
      }
    }, 120);
  }

  Drupal.behaviors.ddnaJsonValueViewer = {
    attach: function (context) {
      once('ddna-json-value-viewer', 'body', context).forEach(function () {
        var dialog = createDialog();
        var preview = createPreview();

        document.addEventListener('click', function (event) {
          var button = event.target.closest('.ddna-json-value-button');
          if (!button) {
            return;
          }

          try {
            var value = JSON.parse(button.dataset.jsonValue);
            dialog.querySelector('code').textContent = JSON.stringify(value, null, 2);
            dialog.showModal();
          }
          catch (error) {
            console.error('Unable to display ddna JSON value.', error);
          }
        });

        document.addEventListener('pointerover', function (event) {
          var trigger = event.target.closest('.ddna-text-preview-trigger');
          if (trigger) {
            showPreview(trigger, preview);
          }
        });
        document.addEventListener('pointerout', function (event) {
          if (event.target.closest('.ddna-text-preview-trigger') &&
            !event.relatedTarget?.closest('.ddna-text-preview-trigger, .ddna-text-preview')) {
            hidePreview();
          }
        });
        document.addEventListener('focusin', function (event) {
          var trigger = event.target.closest('.ddna-text-preview-trigger');
          if (trigger) {
            showPreview(trigger, preview);
          }
        });
        document.addEventListener('focusout', function (event) {
          if (event.target.closest('.ddna-text-preview-trigger')) {
            hidePreview();
          }
        });
        window.addEventListener('scroll', hidePreview, true);
        window.addEventListener('resize', hidePreview);
      });
    }
  };
})(Drupal, once);
