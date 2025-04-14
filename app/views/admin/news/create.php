<?php
// filepath: /app/views/admin/news/create.php

// Define the content function that will be used in the admin layout
$content = function () {
?>
    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded"
            style="background: linear-gradient(120deg, #dc3545, #ff6b6b); padding: 24px; color: white;">
            <div class="d-flex align-items-center">
                <a href="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=index" class="text-decoration-none text-white me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0 text-white">Thêm Bài Viết Mới</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Tạo bài viết hoặc tin tức mới</p>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="ant-card" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <div class="ant-card-body">
                <form action="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=store" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column - Main Info -->
                        <div class="col-lg-8 pe-lg-4">
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-4">
                                <label for="summary" class="form-label fw-bold">Tóm tắt</label>
                                <textarea class="form-control" id="summary" name="summary" rows="3" placeholder="Nhập tóm tắt ngắn gọn về bài viết"></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="content" class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" name="content" rows="12" required></textarea>
                            </div>
                        </div>

                        <!-- Right Column - Settings and Publishing -->
                        <div class="col-lg-4">
                            <div class="settings-card mb-4">
                                <h5 class="settings-card-title">
                                    <i class="fas fa-image me-2"></i>Ảnh bài viết
                                </h5>
                                <div class="settings-card-body">
                                    <div class="image-preview mb-3">
                                        <img id="imagePreview" src="<?= BASE_URL ?>/images/no-image.png" class="img-fluid rounded">
                                    </div>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    </div>
                                    <small class="text-muted mt-2 d-block">Hỗ trợ: JPG, PNG, GIF. Kích thước tối đa: 2MB</small>
                                </div>
                            </div>

                            <div class="settings-card mb-4">
                                <h5 class="settings-card-title">
                                    <i class="fas fa-cog me-2"></i>Cài đặt xuất bản
                                </h5>
                                <div class="settings-card-body">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published">
                                        <label class="form-check-label" for="is_published">Xuất bản ngay</label>
                                    </div>
                                    <small class="text-muted d-block">Bài viết chưa xuất bản sẽ được lưu dưới dạng bản nháp.</small>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu bài viết
                                </button>
                                <a href="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=index" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Hủy bỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Custom styling for news create form */
        .settings-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .settings-card-title {
            background-color: #f0f0f0;
            padding: 12px 15px;
            margin: 0;
            font-size: 1rem;
            color: #495057;
            border-bottom: 1px solid #e9ecef;
        }

        .settings-card-body {
            padding: 15px;
        }

        .image-preview {
            width: 100%;
            height: 200px;
            background-color: #f0f0f0;
            border: 1px dashed #ced4da;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Custom styling for checkbox */
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }

        .form-check-label {
            padding-left: 8px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize rich text editor (CKEditor or similar)
            // This is a placeholder - you would actually implement a rich text editor here

            // Image preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Form validation before submit
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const title = document.getElementById('title').value;
                const content = document.getElementById('content').value;

                if (!title.trim() || !content.trim()) {
                    event.preventDefault();
                    alert('Vui lòng điền đầy đủ thông tin tiêu đề và nội dung');
                }
            });
        });

        // Add rich text editor (you'd need to include CKEditor or TinyMCE script)
        // Example for CKEditor:
        // ClassicEditor
        //     .create(document.querySelector('#content'))
        //     .catch(error => {
        //         console.error(error);
        //     });
    </script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>