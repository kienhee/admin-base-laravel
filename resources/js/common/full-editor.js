// Full Toolbar
// --------------------------------------------------------------------
const fullToolbar = [
    [
        {
            font: []
        },
        {
            size: []
        }
    ],
    ['bold', 'italic', 'underline', 'strike'],
    [
        {
            color: []
        },
        {
            background: []
        }
    ],
    [
        {
            script: 'super'
        },
        {
            script: 'sub'
        }
    ],
    [
        {
            header: '1'
        },
        {
            header: '2'
        },
        'blockquote',
        'code-block'
    ],
    [
        {
            list: 'ordered'
        },
        {
            list: 'bullet'
        },
        {
            indent: '-1'
        },
        {
            indent: '+1'
        }
    ],
    [{ direction: 'rtl' }],
    ['link', 'image', 'video', 'formula'],
    ['clean']
];
const fullEditor = new Quill('#full-editor', {
    bounds: '#full-editor',
    placeholder: 'Type Something...',
    modules: {
        formula: true,
        toolbar: fullToolbar
    },
    theme: 'snow'
});
// Mở Laravel File Manager
function openLFM(callback) {
  const routePrefix = '/laravel-filemanager';
  window.open(routePrefix + '?type=image', 'FileManager', 'width=900,height=600');

  window.SetUrl = function (items) {
    const filePath = items[0].url;
    callback(filePath);
  };
}

// Ghi đè nút insert image
fullEditor.getModule('toolbar').addHandler('image', () => {
  openLFM(function (url) {
    const range = fullEditor.getSelection();
    fullEditor.insertEmbed(range.index, 'image', url);
  });
});
