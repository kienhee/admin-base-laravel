"use strict";

$(function () {
    const $form = $("#form_blog");
    const $submitBtn = $("#submit_btn");
    const $thumbnail = $("#thumbnail");
    const $editor = $("#editor");

    // Helpers
    const setError = ($el, msg, border = true) => {
        clearErrorBelowInput($el);
        if (msg) {
            showErrorBelowInput($el, msg);
            if (border) $el.addClass("is-invalid");
        } else {
            $el.removeClass("is-invalid");
        }
    };

    const validateEditor = () => {
        const content = tinymce.get("editor")?.getContent().trim() || "";
        $editor.val(content);
        setError(
            $editor,
            !content || content === "<p><br></p>"
                ? "Vui lòng nhập nội dung bài viết"
                : "",
            false
        );
        $(".tox-tinymce").css(
            "border",
            content ? "" : "1px solid var(--bs-form-invalid-color, red)"
        );
        return !!content;
    };

    const validateThumbnail = () => {
        const val = $thumbnail.val();
        setError($thumbnail, val ? "" : "Vui lòng chọn ảnh đại diện", false);
        $("#upload_box, .upload_box").css(
            "border",
            val ? "" : "2px dashed var(--bs-form-invalid-color, red)"
        );
        return !!val;
    };

    // FormValidation init
    if ($form.length) {
        FormValidation.formValidation($form[0], {
            fields: {
                title: {
                    validators: {
                        notEmpty: { message: "Vui lòng nhập tiêu đề bài viết" },
                        stringLength: {
                            min: 6,
                            message: "Tiêu đề phải có ít nhất 6 ký tự",
                        },
                    },
                },
                slug: {
                    validators: {
                        notEmpty: { message: "Vui lòng nhập slug" },
                        stringLength: {
                            min: 6,
                            message: "Slug phải có ít nhất 6 ký tự",
                        },
                        regexp: {
                            regexp: /^[a-z0-9]+(?:-[a-z0-9]+)*$/,
                            message:
                                "Slug chỉ được chứa chữ thường, số và dấu gạch ngang",
                        },
                    },
                },
                category_id: {
                    validators: {
                        notEmpty: { message: "Vui lòng chọn danh mục" },
                    },
                },
                "hashtags[]": {
                    validators: {
                        notEmpty: {
                            message: "Vui lòng chọn ít nhất 1 hashtag",
                        },
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
                    if (
                        e.element.parentElement.classList.contains(
                            "input-group"
                        )
                    ) {
                        e.element.parentElement.insertAdjacentElement(
                            "afterend",
                            e.messageElement
                        );
                    }
                });
            },
        });

        // Realtime validate
        $thumbnail.on("change input", validateThumbnail);
        tinymce.get("editor").on("change keyup", validateEditor);

        // Submit
        $submitBtn.on("click", function (e) {
            e.preventDefault();
            const valid = validateThumbnail() & validateEditor();
            if (!valid) return;

            $submitBtn
                .prop("disabled", true)
                .find(".spinner-border")
                .removeClass("d-none");
            $form.submit();
        });
    }

    // Preview
    $("#btn_preview").on("click", function () {
        const data = {
            title: $("#inputSlug").val()?.trim() || "Không có tiêu đề",
            slug: $("#outputSlug").val()?.trim(),
            author: $("#currentUser").text().trim() || "Tác giả Ẩn danh",
            category:
                $("#category_id option:selected").text().trim() ||
                "Chưa có danh mục",
            hashtags: $("#hashtag option:selected")
                .map((_, el) => $(el).text().trim())
                .get(),
            thumb: $thumbnail.val()?.trim() || "https://picsum.photos/960/540",
            content:
                tinymce.get("editor")?.getContent() || $editor.val()?.trim(),
        };

        if (!data.content)
            data.content = `<p class="text-muted">Chưa có nội dung.</p>`;
        if (!data.content.includes("<"))
            data.content = `<p>${data.content.replace(/\n/g, "<br>")}</p>`;

        const stats = { views: 1234, likes: 56, comments: 7 };

        const tagBadges = data.hashtags.length
            ? data.hashtags
                  .map(
                      (t) =>
                          `<span class="badge bg-light text-body border me-2 mb-2">#${t}</span>`
                  )
                  .join("")
            : '<span class="text-muted">Chưa có hashtag</span>';

        $("#preview_container").html(`
            <article>
                <img src="${
                    data.thumb
                }" class="img-fluid rounded mb-3 w-100" style="object-fit:cover;max-height:420px;">
                <h2 class="mb-2">${data.title}</h2>
                ${
                    data.slug
                        ? `<div class="text-muted small mb-2">/ ${data.slug}</div>`
                        : ""
                }
                <div class="d-flex flex-wrap align-items-center gap-3 text-secondary mb-3">
                    <div><i class="bx bx-user"></i> ${data.author}</div>
                    <div><i class="bx bx-folder"></i> ${data.category}</div>
                    <div class="vr d-none d-sm-inline mx-1"></div>
                    <div><i class="bx bx-show"></i> ${
                        stats.views
                    } lượt xem</div>
                    <div><i class="bx bx-like"></i> ${
                        stats.likes
                    } lượt thích</div>
                    <div><i class="bx bx-comment"></i> ${
                        stats.comments
                    } bình luận</div>
                </div>
                <div class="mb-4">${data.content}</div>
                <div class="d-flex flex-wrap align-items-center">${tagBadges}</div>
            </article>
        `);

        $("#preview_post_Label").text("Xem trước: " + data.title);
        $("#preview_post").modal("show");
    });

    // handle delete click
    const $modal = $("#confirmDeleteModal");
    const $deleteForm = $("#deleteForm");
    const $deleteTitle = $("#deleteTitle");
    $(document).on("click", ".btn-delete", function () {
        const url = $(this).data("url");
        const title = $(this).data("title");
        $deleteForm.attr("action", url);
        $deleteTitle.text(title);
        const modal = new bootstrap.Modal($modal[0]);
        modal.show();
    });

    $("#confirmDeleteBtn").on("click", function (e) {
        e.preventDefault();
        $(this).prop("disabled", true)
            .find(".spinner-border")
            .removeClass("d-none");
        $deleteForm.submit();
    });
});
