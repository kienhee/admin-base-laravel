/**
 * Xác thực Trang
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Validation form cho việc thêm bản ghi mới
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          full_name: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập họ tên của bạn'
              },
              stringLength: {
                min: 6,
                message: 'Thông tin phải có nhiều hơn 6 ký tự'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập email của bạn'
              },
              emailAddress: {
                message: 'Vui lòng nhập địa chỉ email hợp lệ'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập email / tên người dùng'
              },
              stringLength: {
                min: 6,
                message: 'Tên người dùng phải có nhiều hơn 6 ký tự'
              }
            }
          },
          currentPassword: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập mật khẩu của bạn'
              },
              stringLength: {
                min: 6,
                message: 'Mật khẩu phải có nhiều hơn 6 ký tự'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Vui lòng nhập mật khẩu của bạn'
              },
              stringLength: {
                min: 6,
                message: 'Mật khẩu phải có nhiều hơn 6 ký tự'
              }
            }
          },
          password_confirmation: {
            validators: {
              notEmpty: {
                message: 'Vui lòng xác nhận mật khẩu'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Mật khẩu và xác nhận không giống nhau'
              },
              stringLength: {
                min: 6,
                message: 'Mật khẩu phải có nhiều hơn 6 ký tự'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Vui lòng đồng ý các điều khoản & điều kiện'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }

    // Xác nhận Hai Bước
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Masquerade Verification
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});
