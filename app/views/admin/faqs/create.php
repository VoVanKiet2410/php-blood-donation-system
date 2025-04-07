<?php
// filepath: /app/views/admin/faqs/create.php

// Define the content function that will be used in the admin layout
$content = function () {
    global $data;
?>
<div class="container-fluid px-0">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded" 
         style="background: linear-gradient(120deg, #dc3545, #ff6b6b); padding: 24px; color: white;">
        <div class="d-flex align-items-center">
            <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=index" class="text-decoration-none text-white me-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0 text-white">Thêm Câu Hỏi Mới</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Tạo câu hỏi và câu trả lời mới</p>
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
        <div class="ant-card-body p-4">
            <form action="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=store" method="post">
                <div class="row">
                    <!-- Main Content -->
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label for="question" class="form-label fw-bold">Câu hỏi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="question" name="question" required placeholder="Nhập câu hỏi...">
                            <small class="text-muted">Nhập câu hỏi một cách rõ ràng, súc tích.</small>
                        </div>
                        
                        <div class="mb-4">
                            <label for="answer" class="form-label fw-bold">Câu trả lời <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="answer" name="answer" rows="10" required placeholder="Nhập câu trả lời chi tiết..."></textarea>
                            <small class="text-muted">Viết câu trả lời đầy đủ, dễ hiểu.</small>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu câu hỏi
                            </button>
                            <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=index" class="btn btn-outline-secondary">
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
    /* Form styling */
    textarea.form-control {
        min-height: 150px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        const question = document.getElementById('question').value.trim();
        const answer = document.getElementById('answer').value.trim();
        
        if (!question || !answer) {
            event.preventDefault();
            alert('Vui lòng điền đầy đủ câu hỏi và câu trả lời');
        }
    });
});
</script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>