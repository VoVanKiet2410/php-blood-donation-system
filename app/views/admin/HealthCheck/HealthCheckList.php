<?php
// Define the content function that will be used in the layout
$content = function () {
    global $healthchecks;
?>
    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded" style="background: linear-gradient(120deg, var(--accent-blue), var(--accent-cyan)); padding: 24px; color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-white">Quản lý Kiểm tra Sức khỏe</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Danh sách và quản lý các kết quả kiểm tra sức khỏe người hiến máu</p>
                </div>
                <a href="?controller=Healthcheck&action=adminCreate" class="ant-btn" style="background: white; color: var(--accent-blue); border: none; font-weight: 500;">
                    <i class="fas fa-plus me-2"></i>Thêm mới
                </a>
            </div>
        </div>

        <!-- Main Content Card with colored border -->
        <div class="ant-card" style="border-top: 3px solid var(--accent-blue); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <div class="ant-card-body p-0">
                <!-- Filter and Search with gradient background -->
                <div class="p-4 border-bottom" style="background: linear-gradient(to right, #f9f9ff, #f0f7ff);">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="me-3 text-nowrap" style="color: var(--accent-purple); font-weight: 500;">Trạng thái:</span>
                                <div class="ant-radio-group">
                                    <label class="ant-radio-wrapper" style="background: white; padding: 5px 12px; border-radius: 20px; border: 1px solid #eee; margin-right: 8px;">
                                        <input type="radio" name="status" value="all" class="ant-radio" checked>
                                        <span class="ant-radio-label">Tất cả</span>
                                    </label>
                                    <label class="ant-radio-wrapper ms-0" style="background: var(--success-light); padding: 5px 12px; border-radius: 20px; border: 1px solid #eee; margin-right: 8px;">
                                        <input type="radio" name="status" value="pass" class="ant-radio">
                                        <span class="ant-radio-label" style="color: var(--success-color);">Đạt</span>
                                    </label>
                                    <label class="ant-radio-wrapper ms-0" style="background: var(--error-light); padding: 5px 12px; border-radius: 20px; border: 1px solid #eee;">
                                        <input type="radio" name="status" value="fail" class="ant-radio">
                                        <span class="ant-radio-label" style="color: var(--error-color);">Không đạt</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="search-form ms-auto">
                                <input type="text" class="ant-input" placeholder="Tìm kiếm..." style="border-radius: 20px; padding-left: 16px; border: 1px solid #eee; box-shadow: 0 2px 6px rgba(0,0,0,0.03);">
                                <button type="button" class="search-form-button" style="color: var(--accent-blue);">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table with colorful elements -->
                <div class="table-responsive">
                    <table class="ant-table">
                        <thead style="background: linear-gradient(to right, #fafafa, #f5f8ff);">
                            <tr>
                                <th style="width: 60px">ID</th>
                                <th style="width: 120px">Kết quả</th>
                                <th>Ghi chú</th>
                                <th style="width: 120px">Lịch hẹn</th>
                                <th style="width: 160px">Ngày tạo</th>
                                <th style="width: 150px" class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($healthchecks) && count($healthchecks) > 0): ?>
                                <?php foreach($healthchecks as $healthcheck): ?>
                                    <tr class="hover-effect" style="transition: all 0.2s ease;">
                                        <td><span class="badge rounded-pill" style="background-color: var(--accent-purple); color: white;"><?= $healthcheck->id ?></span></td>
                                        <td>
                                            <?php if($healthcheck->result == 'PASS'): ?>
                                                <div class="pulse-animation" style="display: inline-block;">
                                                    <span class="ant-tag" style="background: linear-gradient(120deg, var(--success-color), var(--accent-lime)); color: white; border: none; border-radius: 20px; font-weight: 500; padding: 5px 10px;">
                                                        <i class="fas fa-check-circle me-1"></i>Đạt
                                                    </span>
                                                </div>
                                            <?php else: ?>
                                                <span class="ant-tag" style="background: linear-gradient(120deg, var(--error-color), var(--accent-magenta)); color: white; border: none; border-radius: 20px; font-weight: 500; padding: 5px 10px;">
                                                    <i class="fas fa-times-circle me-1"></i>Không đạt
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 300px;" title="<?= htmlspecialchars($healthcheck->notes) ?>">
                                                <?= htmlspecialchars($healthcheck->notes) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border" style="border-color: var(--accent-blue) !important; color: var(--accent-blue) !important;">
                                                №<?= $healthcheck->appointment_id ?>
                                            </span>
                                        </td>
                                        <td><?= date('d/m/Y H:i', strtotime($healthcheck->created_at)) ?></td>
                                        <td>
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="?controller=Healthcheck&action=adminEdit&id=<?= $healthcheck->id ?>" 
                                                   class="btn btn-sm rounded-circle" 
                                                   style="background: var(--info-light); color: var(--info-color); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border: none;"
                                                   title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm rounded-circle" 
                                                        style="background: var(--error-light); color: var(--error-color); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border: none;"
                                                        title="Xóa"
                                                        onclick="confirmDelete(<?= $healthcheck->id ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <a href="#" 
                                                   class="btn btn-sm rounded-circle" 
                                                   style="background: var(--primary-light); color: var(--primary-color); width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border: none;"
                                                   title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3" style="color: var(--accent-blue); opacity: 0.5;"></i>
                                            <p>Không có dữ liệu</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination with gradient background -->
                <div class="p-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(to right, #f9f9ff, #f0f7ff);">
                    <div class="text-muted">
                        Hiển thị <?= isset($healthchecks) ? count($healthchecks) : 0 ?> kết quả
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous" style="border-color: var(--accent-blue); color: var(--accent-blue);">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#" style="background: var(--accent-blue); border-color: var(--accent-blue);">1</a></li>
                            <li class="page-item"><a class="page-link" href="#" style="border-color: #eee; color: var(--accent-blue);">2</a></li>
                            <li class="page-item"><a class="page-link" href="#" style="border-color: #eee; color: var(--accent-blue);">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next" style="border-color: #eee; color: var(--accent-blue);">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Additional page-specific styles */
    .hover-effect:hover {
        background-color: #f8faff !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    /* Pulse animation for success labels */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }

    /* Custom scrollbar */
    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--accent-blue);
        border-radius: 10px;
    }
    </style>

    <script>
    // Delete confirmation 
    function confirmDelete(id) {
        if (confirm('Bạn có chắc chắn muốn xóa kết quả kiểm tra sức khỏe này?')) {
            window.location.href = `?controller=Healthcheck&action=adminDelete&id=${id}`;
        }
    }

    // Status filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const statusRadios = document.querySelectorAll('input[name="status"]');
        const tableRows = document.querySelectorAll('.ant-table tbody tr');

        statusRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const value = this.value;
                
                tableRows.forEach(row => {
                    const statusCell = row.querySelector('td:nth-child(2)');
                    if (!statusCell) return;
                    
                    if (value === 'all') {
                        row.style.display = '';
                    } else if (value === 'pass') {
                        row.style.display = statusCell.textContent.trim().includes('Đạt') ? '' : 'none';
                    } else if (value === 'fail') {
                        row.style.display = statusCell.textContent.trim().includes('Không đạt') ? '' : 'none';
                    }
                });
            });
        });

        // Search functionality
        const searchInput = document.querySelector('.search-form input');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Add subtle row highlight effect
        tableRows.forEach(row => {
            row.addEventListener('mouseover', function() {
                this.style.backgroundColor = '#f8faff';
            });
            row.addEventListener('mouseout', function() {
                this.style.backgroundColor = '';
            });
        });
    });
    </script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>