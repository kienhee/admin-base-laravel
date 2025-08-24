"use strict";

(function () {
    // Datepicker
    const date = new Date();

    const productDate = document.querySelector(".product-date");

    if (productDate) {
        productDate.flatpickr({
            monthSelectorType: "static",
            defaultDate: date,
        });
    }
})();

//Jquery to handle the e-commerce product add page
$(function () {
    var formRepeater = $(".form-repeater");
    // Form Repeater
    // ! Using jQuery each loop to add dynamic id and class for inputs. You may need to improve it based on form fields.
    // -----------------------------------------------------------------------------------------------------------------

    if (formRepeater.length) {
        var row = 2;
        var col = 1;
        formRepeater.on("submit", function (e) {
            e.preventDefault();
        });
        formRepeater.repeater({
            show: function () {
                var fromControl = $(this).find(".form-control, .form-select");
                var formLabel = $(this).find(".form-label");

                fromControl.each(function (i) {
                    var id = "form-repeater-" + row + "-" + col;
                    $(fromControl[i]).attr("id", id);
                    $(formLabel[i]).attr("for", id);
                    col++;
                });

                row++;
                $(this).slideDown();
                $(".select2-container").remove();
                $(".select2.form-select").select2({
                    placeholder: "Placeholder text",
                });
                $(".select2-container").css("width", "100%");
                $(".form-repeater:first .form-select").select2({
                    dropdownParent: $(this).parent(),
                    placeholder: "Placeholder text",
                });
                $(".position-relative .select2").each(function () {
                    $(this).select2({
                        dropdownParent: $(this).closest(".position-relative"),
                    });
                });
            },
        });
    }
});

$('#sale_price').on('focus input', function (e) {
    let price = $('#base_price').val().replace(/[^0-9]/g, '');
    price = parseInt(price || 0, 10);

    // Xoá span cũ trước khi render
    $('#sale_price_message').remove();

    if (!price || price <= 0) {
        e.preventDefault();
        $(this).val(''); // xoá nếu có gõ vào
        let span = $(`<small id="sale_price_message" class="d-block mt-2 text-danger" style="display:none;">Vui lòng nhập giá gốc trước</small>`);
        $(this).after(span);
        span.fadeIn();
        return; // không cho nhập tiếp
    }

    // Nếu có giá gốc thì xử lý như bình thường
    let salePrice = $(this).val().replace(/[^0-9]/g, '');
    salePrice = parseInt(salePrice || 0, 10);

    let message = '';
    let type = 'error';

    if (!salePrice || salePrice <= 0) {
        message = 'Vui lòng nhập giá khuyến mãi hợp lệ';
    } else if (salePrice > price) {
        message = 'Giá khuyến mãi không được lớn hơn giá gốc';
    } else {
        let salePercent = (salePrice / price) * 100;
        message = `Tương đương ${salePercent.toFixed(2)}%`;
        type = 'success';
    }

    let color = (type === 'error') ? 'text-danger' : 'text-success';
    let span = $(`<small id="sale_price_message" class="d-block mt-2 ${color}" style="display:none;">${message}</small>`);
    $(this).after(span);
    span.fadeIn();
});


// form
(function () {
    let $form = $("#form_ecommerce");
    if ($form.length) {
        const fv = FormValidation.formValidation($form[0], {
            fields: {
                title: {
                    validators: {
                        notEmpty: { message: "Vui lòng nhập tên sản phẩm" },
                        stringLength: {
                            min: 6,
                            message: "Tiêu đề phải có ít nhất 6 ký tự",
                        },
                    },
                },

                base_price: {
                    validators: {
                        notEmpty: { message: "Vui lòng nhập giá gốc" },
                        greaterThan: {
                            min: 1,
                            message: "Giá gốc phải lớn hơn 0",
                        },
                    },
                },

                sale_price: {
                    validators: {
                        callback: {
                            message: "Giá khuyến mãi phải nhỏ hơn giá gốc",
                            callback: function (input) {
                                let base = $("#base_price").val().replace(/[^0-9]/g, "");
                                let sale = input.value.replace(/[^0-9]/g, "");
                                if (sale === "") return true; // không bắt buộc
                                return parseInt(sale) < parseInt(base || 0);
                            },
                        },
                    },
                },

                category_id: {
                    validators: {
                        notEmpty: { message: "Vui lòng chọn danh mục" },
                    },
                },

                images: {
                    validators: {
                        notEmpty: { message: "Vui lòng chọn ít nhất 1 hình ảnh" },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap5: new FormValidation.plugins.Bootstrap5({
                    rowSelector: ".mb-3",
                    eleValidClass: "",
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                autoFocus: new FormValidation.plugins.AutoFocus(),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            },
            init: (instance) => {
                instance.on("plugins.message.placed", (e) => {
                    if (e.element.parentElement.classList.contains("input-group")) {
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                    }
                });
            },
        });
    }
})();
