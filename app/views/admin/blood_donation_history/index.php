<?php
// filepath: /app/views/admin/blood_donation_history/index.php

// Define the content function that will be used in the admin layout
$content = function ($data) {
    $donationHistories = isset($data['donationHistories']) ? $data['donationHistories'] : [];
?>
<div class="container-fluid px-0">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded" 
         style="background: linear-gradient(120deg, #dc3545, #ff6b6b); padding: 24px; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 text-white">Quản Lý Lịch Sử Hiến Máu</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Danh sách các lần hiến máu từ người hiến</p>
            </div>
            <div>
                <a href="#" class="btn text-white" style="background-color: rgba(255,255,255,0.2);" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i>Xuất Báo Cáo
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="ant-card" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div class="ant-card-body p-0">
            <!-- Filter and Search -->
            <div class="p-4 border-bottom" style="background: linear-gradient(to right, #fff5f5, #fff0f0);">
                <div class="row">
                    <div class="col-md-8 mb-3 mb-md-0">
                        <div class="d-flex flex-wrap gap-2">
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="all" checked>
                                <span>Tất cả</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="A+">
                                <span>A+</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="A-">
                                <span>A-</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="B+">
                                <span>B+</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="B-">
                                <span>B-</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="AB+">
                                <span>AB+</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="AB-">
                                <span>AB-</span>
                            </label>
                            <label class="custom-radio me-2">
                                <input type="radio" name="blood-type-filter" value="O+">
                                <span>O+</span>
                            </label>
                            <label class="custom-radio">
                                <input type="radio" name="blood-type-filter" value="O-">
                                <span>O-</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="search-form">
                            <input type="text" id="searchInput" class="form-control custom-input" placeholder="Tìm kiếm người hiến...">
                            <button type="button" class="search-form-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="p-4 border-bottom bg-white">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="stat-card" style="border-left: 4px solid #dc3545;">
                            <div class="stat-card-body">
                                <div class="stat-card-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                                    <i class="fas fa-tint"></i>
                                </div>
                                <div>
                                    <div class="stat-card-title">Tổng số hiến máu</div>
                                    <div class="stat-card-value"><?= count($donationHistories) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="stat-card" style="border-left: 4px solid #28a745;">
                            <div class="stat-card-body">
                                <div class="stat-card-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <div>
                                    <div class="stat-card-title">Tổng lượng máu</div>
                                    <?php 
                                    $totalBlood = 0;
                                    foreach ($donationHistories as $history) {
                                        $totalBlood += $history->blood_amount ?? 0;
                                    }
                                    ?>
                                    <div class="stat-card-value"><?= number_format($totalBlood) ?> ml</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="stat-card" style="border-left: 4px solid #17a2b8;">
                            <div class="stat-card-body">
                                <div class="stat-card-icon" style="background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                                    <i class="fas fa-user-friends"></i>
                                </div>
                                <div>
                                    <div class="stat-card-title">Người hiến</div>
                                    <?php
                                    $uniqueDonors = [];
                                    foreach ($donationHistories as $history) {
                                        if (isset($history->user) && isset($history->user->cccd)) {
                                            $uniqueDonors[$history->user->cccd] = true;
                                        }
                                    }
                                    ?>
                                    <div class="stat-card-value"><?= count($uniqueDonors) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card" style="border-left: 4px solid #ffc107;">
                            <div class="stat-card-body">
                                <div class="stat-card-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <div class="stat-card-title">Tháng này</div>
                                    <?php
                                    $currentMonth = date('m');
                                    $currentYear = date('Y');
                                    $thisMonthDonations = 0;
                                    
                                    foreach ($donationHistories as $history) {
                                        if (isset($history->donation_date_time)) {
                                            $donationMonth = date('m', strtotime($history->donation_date_time));
                                            $donationYear = date('Y', strtotime($history->donation_date_time));
                                            if ($donationMonth == $currentMonth && $donationYear == $currentYear) {
                                                $thisMonthDonations++;
                                            }
                                        }
                                    }
                                    ?>
                                    <div class="stat-card-value"><?= $thisMonthDonations ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="ant-table table table-hover" id="donationHistoryTable">
                    <thead>
                        <tr>
                            <th style="width: 50px">ID</th>
                            <th style="width: 200px">Người hiến máu</th>
                            <th style="width: 100px">Nhóm máu</th>
                            <th style="width: 150px">Ngày hiến</th>
                            <th>Địa điểm</th>
                            <th style="width: 100px">Lượng máu</th>
                            <th style="width: 150px">Loại hiến máu</th>
                            <th style="width: 100px" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($donationHistories)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-tint-slash empty-state-icon"></i>
                                        <p>Không có lịch sử hiến máu nào</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($donationHistories as $history): ?>
                                <?php 
                                $bloodType = '';
                                $fullName = '';
                                $cccd = '';
                                
                                if (isset($history->user) && isset($history->user->userInfo)) {
                                    $bloodType = $history->user->userInfo->blood_type ?? '';
                                    $fullName = $history->user->userInfo->full_name ?? '';
                                    $cccd = $history->user->cccd ?? '';
                                }
                                ?>
                                <tr class="donation-row" data-blood-type="<?= htmlspecialchars($bloodType) ?>">
                                    <td><?= $history->id ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2"
                                                style="background-color: #dc3545; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                <?= substr($fullName, 0, 1) ?>
                                            </div>
                                            <div>
                                                <div class="fw-medium"><?= htmlspecialchars($fullName) ?></div>
                                                <div class="small text-muted"><?= htmlspecialchars($cccd) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="blood-type-pill"><?= htmlspecialchars($bloodType) ?></span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($history->donation_date_time)) ?></td>
                                    <td><?= htmlspecialchars($history->donation_location ?? 'N/A') ?></td>
                                    <td><?= $history->blood_amount ?? 0 ?> ml</td>
                                    <td><?= htmlspecialchars($history->donation_type ?? 'Hiến máu toàn phần') ?></td>
                                    <td class="text-center">
                                        <a href="<?= BASE_URL ?>/index.php?controller=BloodDonationHistory&action=view&id=<?= $history->id ?>" class="action-btn view-btn" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="action-btn print-btn" title="In chứng nhận" data-id="<?= $history->id ?>">
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($donationHistories)): ?>
                <div class="p-4 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Hiển thị <?= count($donationHistories) ?> kết quả
                    </div>
                    <nav>
                        <ul class="pagination mb-0">
                            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xuất Báo Cáo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Định dạng báo cáo</label>
                    <select class="form-select">
                        <option value="excel">Excel (.xlsx)</option>
                        <option value="csv">CSV (.csv)</option>
                        <option value="pdf">PDF (.pdf)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Khoảng thời gian</label>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" class="form-control" placeholder="Từ ngày">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control" placeholder="Đến ngày">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bao gồm</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeUserInfo" checked>
                        <label class="form-check-label" for="includeUserInfo">
                            Thông tin người hiến máu
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeEventInfo" checked>
                        <label class="form-check-label" for="includeEventInfo">
                            Thông tin sự kiện
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeStats" checked>
                        <label class="form-check-label" for="includeStats">
                            Thống kê tổng hợp
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button type="button" class="btn btn-primary">Xuất báo cáo</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for blood donation history admin view */
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
    
    .blood-type-pill {
        display: inline-block;
        padding: 4px 12px;
        background-color: #dc35451a;
        color: #dc3545;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9rem;
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
    
    .view-btn {
        color: #28a745;
    }
    
    .print-btn {
        color: #007bff;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        background-color: #f8f9fa;
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
    
    .page-link {
        color: #dc3545;
        border-color: #e2e8f0;
    }
    
    .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Blood type filter
    const bloodTypeRadios = document.querySelectorAll('input[name="blood-type-filter"]');
    const tableRows = document.querySelectorAll('.donation-row');
    
    bloodTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const value = this.value;
            
            tableRows.forEach(row => {
                const bloodType = row.dataset.bloodType;
                
                if (value === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = bloodType === value ? '' : 'none';
                }
            });
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchTerm) ? '' : 'none';
        });
    });
    
    // Print certificate button
    const printButtons = document.querySelectorAll('.print-btn');
    
    printButtons.forEach(button => {
        button.addEventListener('click', function() {
            const donationId = this.dataset.id;
            alert('Đang in chứng nhận hiến máu cho ID: ' + donationId);
            // In thực tế sẽ cần thêm logic để tạo và in chứng nhận
        });
    });
});
</script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>