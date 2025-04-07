<?php
// filepath: /app/views/admin/faqs/index.php

// Define the content function that will be used in the admin layout
$content = function ($data) {
    $faqs = isset($data['faqs']) ? $data['faqs'] : [];
    $faqsByCategory = isset($data['faqsByCategory']) ? $data['faqsByCategory'] : [];
?>
<div class="container-fluid px-0">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded" 
         style="background: linear-gradient(120deg, #dc3545, #ff6b6b); padding: 24px; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white">Quản Lý Câu Hỏi Thường Gặp (FAQ)</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Quản lý, thêm mới, chỉnh sửa các câu hỏi thường gặp</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=create" class="btn text-white" style="background-color: rgba(255,255,255,0.2);">
                    <i class="fas fa-plus me-2"></i>Thêm Câu Hỏi Mới
                </a>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error_message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- Statistics Card -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card" style="border-left: 4px solid #dc3545;">
                <div class="stat-card-body">
                    <div class="stat-card-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                        <i class="fas fa-question-circle"></i>
                    </div>
                    <div>
                        <div class="stat-card-title">Tổng số câu hỏi</div>
                        <div class="stat-card-value"><?= count($faqs) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card" style="border-left: 4px solid #28a745;">
                <div class="stat-card-body">
                    <div class="stat-card-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="stat-card-title">Đã đăng</div>
                        <div class="stat-card-value">0</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="stat-card" style="border-left: 4px solid #ffc107;">
                <div class="stat-card-body">
                    <div class="stat-card-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="stat-card-title">Chưa đăng</div>
                        <div class="stat-card-value"><?= count($faqs) ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left: 4px solid #17a2b8;">
                <div class="stat-card-body">
                    <div class="stat-card-icon" style="background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div>
                        <div class="stat-card-title">Danh mục</div>
                        <div class="stat-card-value"><?= count($faqsByCategory) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="ant-card mb-4" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div class="p-4" style="background: linear-gradient(to right, #fff5f5, #fff0f0);">
            <div class="row">
                <div class="col-md-8 mb-3 mb-md-0">
                    <div class="d-flex flex-wrap gap-2">
                        <label class="custom-radio me-2">
                            <input type="radio" name="status-filter" value="all" checked>
                            <span>Tất cả</span>
                        </label>
                        <label class="custom-radio me-2">
                            <input type="radio" name="status-filter" value="published">
                            <span>Đã đăng</span>
                        </label>
                        <label class="custom-radio">
                            <input type="radio" name="status-filter" value="unpublished">
                            <span>Chưa đăng</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="search-form">
                        <input type="text" id="searchInput" class="form-control custom-input" placeholder="Tìm kiếm câu hỏi...">
                        <button type="button" class="search-form-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($faqs)): ?>
        <!-- Empty State -->
        <div class="ant-card" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <div class="ant-card-body p-5 text-center">
                <div class="empty-state">
                    <i class="fas fa-question-circle empty-state-icon"></i>
                    <p class="mb-3">Chưa có câu hỏi thường gặp nào</p>
                    <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=create" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Thêm câu hỏi mới
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- FAQ Categories and Questions -->
        <div id="accordion">
            <?php foreach ($faqsByCategory as $category => $categoryFaqs): ?>
                <div class="category-section mb-4 faq-category" id="category-<?= md5($category) ?>">
                    <div class="category-header" data-bs-toggle="collapse" data-bs-target="#collapse-<?= md5($category) ?>" aria-expanded="true">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-folder me-2"></i><?= htmlspecialchars($category) ?>
                                <span class="badge rounded-pill bg-light text-dark ms-2"><?= count($categoryFaqs) ?></span>
                            </h5>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-outline-primary me-2 edit-category-btn" data-category="<?= htmlspecialchars($category) ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div id="collapse-<?= md5($category) ?>" class="collapse show">
                        <div class="category-body">
                            <div class="faq-list sortable" data-category="<?= htmlspecialchars($category) ?>">
                                <?php foreach ($categoryFaqs as $faq): ?>
                                    <div class="faq-item" data-id="<?= $faq->id ?>" data-status="unpublished">
                                        <div class="faq-item-header">
                                            <div class="d-flex align-items-center">
                                                <div class="drag-handle me-3">
                                                    <i class="fas fa-grip-vertical"></i>
                                                </div>
                                                <div class="question-text">
                                                    <?= htmlspecialchars($faq->question) ?>
                                                </div>
                                            </div>
                                            <div class="faq-actions">
                                                <span class="status-badge status-draft">
                                                    Chưa đăng
                                                </span>
                                                <div class="btn-group ms-3">
                                                    <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=edit&id=<?= $faq->id ?>" class="action-btn edit-btn" title="Chỉnh sửa">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal-<?= $faq->id ?>" title="Xóa">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                
                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal-<?= $faq->id ?>" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc chắn muốn xóa câu hỏi này?</p>
                                                                <div class="alert alert-secondary">
                                                                    <?= htmlspecialchars($faq->question) ?>
                                                                </div>
                                                                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                                <a href="<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=delete&id=<?= $faq->id ?>" class="btn btn-danger">Xóa</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="faq-item-body">
                                            <div class="answer-text">
                                                <?= nl2br(htmlspecialchars($faq->answer)) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="oldCategoryName">
                <div class="mb-3">
                    <label for="newCategoryName" class="form-label">Tên danh mục</label>
                    <input type="text" class="form-control" id="newCategoryName">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" id="saveCategoryBtn">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for FAQ admin view */
    .stat-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        padding: 0px 15px;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stat-card-body {
        display: flex;
        align-items: center;
        padding: 15px 0;
    }
    
    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }
    
    .stat-card-title {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .stat-card-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #343a40;
    }
    
    .custom-radio {
        display: inline-flex;
        align-items: center;
        background: white;
        padding: 6px 12px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .custom-radio:hover {
        border-color: #dc3545;
        background-color: #fff5f5;
    }
    
    .custom-radio input[type="radio"] {
        margin-right: 6px;
        accent-color: #dc3545;
    }
    
    .custom-input {
        border-radius: 20px;
        border-color: #e2e8f0;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    
    .custom-input:hover, .custom-input:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
    }
    
    .search-form {
        position: relative;
    }
    
    .search-form-button {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #dc3545;
        cursor: pointer;
    }
    
    .empty-state {
        padding: 30px;
        text-align: center;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: #dc354540;
        margin-bottom: 1rem;
    }
    
    .category-section {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .category-header {
        background-color: #f8f9fa;
        padding: 15px 20px;
        cursor: pointer;
        border-bottom: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .category-header:hover {
        background-color: #f0f0f0;
    }
    
    .category-body {
        padding: 0;
    }
    
    .faq-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    .faq-item {
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
        transition: all 0.3s ease;
    }
    
    .faq-item:last-child {
        border-bottom: none;
    }
    
    .faq-item:hover {
        background-color: #f8f9fa;
    }
    
    .faq-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .faq-item-body {
        padding-top: 10px;
        margin-top: 10px;
        border-top: 1px dashed #e9ecef;
        display: none;
    }
    
    .faq-actions {
        display: flex;
        align-items: center;
    }
    
    .question-text {
        font-weight: 600;
        color: #343a40;
    }
    
    .answer-text {
        color: #6c757d;
    }
    
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.8rem;
    }
    
    .status-published {
        background-color: #d4edda;
        color: #28a745;
    }
    
    .status-draft {
        background-color: #e2e3e5;
        color: #6c757d;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: none;
        margin: 0 2px;
    }
    
    .edit-btn {
        color: #007bff;
    }
    
    .toggle-btn {
        color: #28a745;
    }
    
    .delete-btn {
        color: #dc3545;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        background-color: #f8f9fa;
    }
    
    .drag-handle {
        cursor: move;
        color: #adb5bd;
        transition: all 0.3s ease;
    }
    
    .faq-item:hover .drag-handle {
        color: #6c757d;
    }
    
    .toggle-icon {
        transition: transform 0.2s ease;
    }
    
    .collapsed .toggle-icon {
        transform: rotate(-90deg);
    }
    
    /* Highlight for dragging */
    .ui-sortable-helper {
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .ui-sortable-placeholder {
        visibility: visible !important;
        background-color: #f8f9fa;
        border: 2px dashed #ced4da;
        border-radius: 8px;
        margin: 10px 0;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize jQuery UI sortable
    // Note: requires jQuery UI to be included
    try {
        if (typeof $.fn.sortable === 'function') {
            $('.sortable').sortable({
                handle: '.drag-handle',
                placeholder: 'ui-sortable-placeholder',
                update: function(event, ui) {
                    updateFaqOrder($(this).data('category'));
                }
            });
        } else {
            console.warn('jQuery UI sortable not available');
        }
    } catch (e) {
        console.error('Error initializing sortable:', e);
    }
    
    // Toggle FAQ answer visibility
    $('.question-text').on('click', function() {
        $(this).closest('.faq-item').find('.faq-item-body').slideToggle();
    });
    
    // Status filter
    const statusRadios = document.querySelectorAll('input[name="status-filter"]');
    const faqItems = document.querySelectorAll('.faq-item');
    
    statusRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const value = this.value;
            
            faqItems.forEach(item => {
                const status = item.dataset.status;
                
                if (value === 'all') {
                    item.style.display = '';
                } else {
                    item.style.display = status === value ? '' : 'none';
                }
            });
            
            // Check if categories are empty after filtering
            document.querySelectorAll('.faq-category').forEach(category => {
                const visibleItems = category.querySelectorAll('.faq-item[style="display: none;"]').length;
                const totalItems = category.querySelectorAll('.faq-item').length;
                
                if (visibleItems === totalItems) {
                    category.style.display = 'none';
                } else {
                    category.style.display = '';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        // Search in questions
        document.querySelectorAll('.faq-item').forEach(item => {
            const questionText = item.querySelector('.question-text').textContent.toLowerCase();
            const answerText = item.querySelector('.answer-text').textContent.toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
        
        // Check if categories are empty after searching
        document.querySelectorAll('.faq-category').forEach(category => {
            const visibleItems = category.querySelectorAll('.faq-item[style="display: none;"]').length;
            const totalItems = category.querySelectorAll('.faq-item').length;
            
            if (visibleItems === totalItems) {
                category.style.display = 'none';
            } else {
                category.style.display = '';
            }
        });
    });
    
    // Edit category functionality
    document.querySelectorAll('.edit-category-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const category = this.dataset.category;
            
            document.getElementById('oldCategoryName').value = category;
            document.getElementById('newCategoryName').value = category;
            
            $('#editCategoryModal').modal('show');
        });
    });
    
    document.getElementById('saveCategoryBtn').addEventListener('click', function() {
        const oldName = document.getElementById('oldCategoryName').value;
        const newName = document.getElementById('newCategoryName').value;
        
        if (!newName.trim()) {
            alert('Tên danh mục không được để trống');
            return;
        }
        
        // This would be an AJAX call to update the category name
        alert('Tính năng đổi tên danh mục sẽ được triển khai sau.');
        
        $('#editCategoryModal').modal('hide');
    });
    
    // Function to update FAQ order
    function updateFaqOrder(category) {
        const items = [];
        
        $(`.sortable[data-category="${category}"] .faq-item`).each(function(index) {
            items.push({
                id: $(this).data('id'),
                order: index + 1
            });
        });
        
        // Send order update to server via AJAX
        $.ajax({
            url: '<?= BASE_URL ?>/index.php?controller=FAQAdmin&action=updateOrder',
            method: 'POST',
            data: { items: items },
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    alert('Có lỗi xảy ra khi cập nhật thứ tự câu hỏi');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi cập nhật thứ tự câu hỏi');
            }
        });
    }
});
</script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>