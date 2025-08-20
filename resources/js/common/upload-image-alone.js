(function ($) {
  'use strict';

  // Resolve target elements (hidden input + preview box)
  function resolveTargets($trigger) {
    const inputSelector = $trigger.data('targetInput') || '#thumbnail';
    const previewSelector = $trigger.data('targetPreview') || '#upload_box';
    return {
      $input: $(inputSelector),
      $preview: $(previewSelector)
    };
  }

  // Open LFM window with sane default size
  function openFileManager(url) {
    const w = Math.min(1200, window.screen.width);
    const h = Math.min(800, window.screen.height);
    window.open(url, 'FileManager', `width=${w},height=${h},resizable=yes,scrollbars=yes`);
  }

  $.fn.filemanager = function (type, options) {
    type = type || 'file';

    return this.off('click.fm').on('click.fm', function (e) {
      e.preventDefault();

      const route_prefix = (options && options.prefix) ? options.prefix.replace(/\/$/, '') : '/filemanager';
      const $trigger = $(this);
      const { $input, $preview } = resolveTargets($trigger);

      // Open
      openFileManager(`${route_prefix}?type=${encodeURIComponent(type)}`);

      // Callback from LFM
      window.SetUrl = function (items) {
        if (!items || !items.length) return;
        const item = items[0];
        const fileUrl = item.url || '';
        const thumbUrl = item.thumb_url || fileUrl;

        // Set value & trigger validators
        if ($input.length) {
          $input.val(fileUrl).trigger('input').trigger('change');
        }

        if ($preview.length) {
          $preview.empty();
          const $img = $('<img>', {
            src: thumbUrl,
            alt: 'Thumbnail preview',
            class: 'upload_btn',
          }).css({
            width: '100%',
            height: '100%',
            objectFit: 'cover',
            cursor: 'pointer',
            borderRadius: '0.5rem'
          });

          // Re-bind filemanager on the image so user can re-pick
          $img.data('targetInput', $input.selector)
              .data('targetPreview', $preview.selector)
              .filemanager('image', { prefix: route_prefix });

          $preview.append($img);
        }

        // Hide original trigger if it is a button
        if ($trigger.is('button, a')) {
          $trigger.hide();
        }
      };

      return false;
    });
  };

  // Auto-bind and initial preview
  $(function () {
    // Auto-bind for elements with class upload_btn
    $('.upload_btn').filemanager('image', { prefix: '/filemanager' });

    // If thumbnail already has value, render preview and keep re-pick ability
    const $input = $('#thumbnail');
    const $preview = $('#upload_box');
    if ($input.length && $input.val()) {
      const url = $input.val();
      $preview.empty();
      const $img = $('<img>', {
        src: url,
        alt: 'Thumbnail preview',
        class: 'upload_btn',
      }).css({
        width: '100%',
        height: '100%',
        objectFit: 'cover',
        cursor: 'pointer',
        borderRadius: '0.5rem'
      });
      $img.data('targetInput', '#thumbnail')
          .data('targetPreview', '#upload_box')
          .filemanager('image', { prefix: '/filemanager' });
      $preview.append($img);
    }
  });

})(jQuery);
