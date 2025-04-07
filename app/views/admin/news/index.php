<?php
// filepath: /app/views/admin/news/index.php

// Define the content function that will be used in the admin layout
$content = function ($data)  {
    // Đảm bảo có quyền truy cập vào biến $data từ controller
    $news = isset($data['news']) ? $data['news'] : [];
    
    // Bỏ dòng debug ở đây
    // echo '<pre>'; print_r($news); echo '</pre>';
?>

<div class="container-fluid px-0">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded" 
         style="background: linear-gradient(120deg, #1890ff, #52c41a); padding: 24px; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white">Quản Lý Tin Tức</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Danh sách và quản lý tin tức</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=create" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Thêm tin tức mới
                </a>
            </div>
        </div>
    </div>

    <!-- Success and Error messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Main Content Card -->
    <div class="ant-card">
        <div class="ant-card-head">
            <div class="ant-card-head-title">
                <i class="fas fa-newspaper me-2" style="color: #1890ff;"></i> Danh sách tin tức
            </div>
        </div>
        <div class="ant-card-body p-0">
            <!-- Search -->
            <div class="p-4 border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="search-form">
                            <input type="text" id="searchInput" class="form-control custom-input" placeholder="Tìm kiếm tin tức...">
                            <button type="button" class="search-form-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- News List -->
            <div class="table-responsive">
                <table class="table table-hover" id="newsTable">
                    <thead>
                        <tr>
                            <th style="width: 50px">ID</th>
                            <th style="width: 200px">Hình ảnh</th>
                            <th>Tiêu đề</th>
                            <th style="width: 120px">Ngày đăng</th>
                            <th style="width: 120px" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($news) || count($news) === 0): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-newspaper empty-state-icon"></i>
                                        <p>Không có tin tức nào. Hãy thêm tin tức mới!</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($news as $item): ?>
                                <tr>
                                    <td><?= $item->id ?></td>
                                    <td>
                                        <?php if (!empty($item->image_url)): ?>
                                            <img src="<?= htmlspecialchars($item->image_url) ?>" alt="<?= htmlspecialchars($item->title) ?>" class="img-thumbnail" style="max-height: 80px;">
                                        <?php else: ?>
                                            <div class="no-image">Không có hình</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-medium"><?= htmlspecialchars($item->title) ?></div>
                                        <div class="text-muted small">
                                            <?= mb_substr(strip_tags($item->content), 0, 100) . (mb_strlen(strip_tags($item->content)) > 100 ? '...' : '') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $dateField = isset($item->created_at) ? $item->created_at : 
                                                        (isset($item->timestamp) ? $item->timestamp : 
                                                        (isset($item->date_created) ? $item->date_created : date('Y-m-d')));
                                            echo date('d/m/Y', strtotime($dateField)); 
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=view&id=<?= $item->id ?>" 
                                           class="btn btn-sm btn-info btn-icon me-1" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=edit&id=<?= $item->id ?>" 
                                           class="btn btn-sm btn-primary btn-icon me-1" title="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon delete-news" 
                                                data-id="<?= $item->id ?>" data-bs-toggle="modal" data-bs-target="#deleteNewsModal" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($news) && count($news) > 0): ?>
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Hiển thị <?= count($news) ?> tin tức
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete News Modal -->
<div class="modal fade" id="deleteNewsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc muốn xóa tin tức này? Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Xác nhận xóa</a>
            </div>
        </div>
    </div>
</div>

<style>
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
        border-color: #1890ff;
        background-color: #f0f7ff;
    }
    
    .custom-radio input[type="radio"] {
        margin-right: 6px;
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
        cursor: pointer;
    }
    
    .empty-state {
        padding: 30px;
        text-align: center;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: #d9d9d9;
        margin-bottom: 1rem;
    }
    
    .no-image {
        width: 100%;
        height: 80px;
        background-color: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-size: 12px;
        border-radius: 4px;
    }
    
    .ant-card {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.03);
        border-radius: 2px;
        border: 1px solid #f0f0f0;
    }
    
    .ant-card-head {
        min-height: 48px;
        padding: 0 24px;
        color: rgba(0, 0, 0, 0.85);
        font-weight: 500;
        font-size: 16px;
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        border-radius: 2px 2px 0 0;
        display: flex;
        align-items: center;
    }
    
    .ant-card-head-title {
        padding: 16px 0;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-icon i {
        font-size: 14px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#newsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Delete news functionality
    const deleteButtons = document.querySelectorAll('.delete-news');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const newsId = this.getAttribute('data-id');
            confirmDeleteBtn.href = `<?= BASE_URL ?>/index.php?controller=NewsAdmin&action=delete&id=${newsId}`;
        });
    });
});
</script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>