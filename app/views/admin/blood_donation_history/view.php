<?php
// Define the content function that will be used in the admin layout
$content = function ($data) {
    $donationHistory = isset($data['donationHistory']) ? $data['donationHistory'] : [];
?>
<div class="container-fluid px-0">
    <!-- Page Header with gradient background -->
    <div class="ant-page-header mb-4 rounded" 
         style="background: linear-gradient(120deg, #dc3545, #ff6b6b); padding: 24px; color: white;">
        <div class="d-flex align-items-center">
            <a href="<?= BASE_URL ?>/index.php?controller=BloodDonationHistory&action=index" class="text-decoration-none text-white me-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="mb-0 text-white">Chi Tiết Lịch Sử Hiến Máu</h4>
                <p class="mb-0 mt-1 text-white opacity-75">Thông tin về lần hiến máu #<?= $donationHistory->id ?></p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Donor and Donation Information -->
        <div class="col-lg-8">
            <!-- Donor Information Card -->
            <div class="ant-card mb-4" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-user-alt me-2" style="color: #dc3545;"></i>Thông tin người hiến máu
                    </div>
                </div>
                <div class="ant-card-body">
                    <?php if (isset($donationHistory->user) && isset($donationHistory->user->userInfo)): ?>
                        <div class="row">
                            <div class="col-md-2 text-center mb-3 mb-md-0">
                                <div class="avatar-large mb-2">
                                    <?= substr($donationHistory->user->userInfo->full_name ?? 'U', 0, 1) ?>
                                </div>
                                <div class="blood-type-large">
                                    <?= $donationHistory->user->userInfo->blood_type ?? '?' ?>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="info-label">Họ tên</label>
                                        <div class="info-value fw-bold">
                                            <?= htmlspecialchars($donationHistory->user->userInfo->full_name ?? 'N/A') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="info-label">CCCD/CMND</label>
                                        <div class="info-value">
                                            <?= htmlspecialchars($donationHistory->user->cccd ?? 'N/A') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="info-label">Ngày sinh</label>
                                        <div class="info-value">
                                            <?php if (!empty($donationHistory->user->userInfo->dob)): ?>
                                                <?= date('d/m/Y', strtotime($donationHistory->user->userInfo->dob)) ?>
                                                (<?= date_diff(date_create($donationHistory->user->userInfo->dob), date_create('now'))->y ?> tuổi)
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="info-label">Giới tính</label>
                                        <div class="info-value">
                                            <?= $donationHistory->user->userInfo->gender == 1 ? 'Nam' : 'Nữ' ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="info-label">Số điện thoại</label>
                                        <div class="info-value">
                                            <?= htmlspecialchars($donationHistory->user->userInfo->phone_number ?? 'N/A') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="info-label">Email</label>
                                        <div class="info-value">
                                            <?= htmlspecialchars($donationHistory->user->userInfo->email ?? 'N/A') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Không tìm thấy thông tin người hiến máu cho lần hiến này.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Donation Information Card -->
            <div class="ant-card mb-4" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-tint me-2" style="color: #dc3545;"></i>Thông tin lần hiến máu
                    </div>
                </div>
                <div class="ant-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="info-label">Ngày hiến</label>
                            <div class="info-value fw-bold">
                                <?= date('d/m/Y', strtotime($donationHistory->donation_date_time)) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="info-label">Giờ hiến</label>
                            <div class="info-value">
                                <?= date('H:i', strtotime($donationHistory->donation_date_time)) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="info-label">Lượng máu hiến</label>
                            <div class="info-value">
                                <span class="badge bg-danger"><?= $donationHistory->blood_amount ?? 0 ?> ml</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Loại hiến máu</label>
                            <div class="info-value">
                                <?= htmlspecialchars($donationHistory->donation_type ?? 'Hiến máu toàn phần') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Địa điểm hiến máu</label>
                            <div class="info-value">
                                <?= htmlspecialchars($donationHistory->donation_location ?? 'N/A') ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Ngày được hiến máu tiếp theo</label>
                            <div class="info-value">
                                <?php if (!empty($donationHistory->next_donation_eligible_date)): ?>
                                    <?= date('d/m/Y', strtotime($donationHistory->next_donation_eligible_date)) ?>
                                    <?php
                                        $now = new DateTime();
                                        $nextDate = new DateTime($donationHistory->next_donation_eligible_date);
                                        $diff = $now->diff($nextDate);
                                        if ($nextDate < $now) {
                                            echo '<span class="badge bg-success ms-2">Đã đủ điều kiện hiến máu</span>';
                                        } else {
                                            echo '<span class="badge bg-warning text-dark ms-2">Còn ' . $diff->days . ' ngày nữa</span>';
                                        }
                                    ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="info-label">Liên kết với cuộc hẹn</label>
                            <div class="info-value">
                                <?php if (!empty($donationHistory->appointment_id)): ?>
                                    <a href="<?= BASE_URL ?>/index.php?controller=Appointment&action=adminEdit&id=<?= $donationHistory->appointment_id ?>" class="text-decoration-none">
                                        <i class="fas fa-calendar-check me-1"></i> Cuộc hẹn #<?= $donationHistory->appointment_id ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Không có</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mt-4">
                        <label class="info-label">Ghi chú</label>
                        <div class="p-3 bg-light rounded border">
                            <?php if (!empty($donationHistory->notes)): ?>
                                <?= nl2br(htmlspecialchars($donationHistory->notes)) ?>
                            <?php else: ?>
                                <span class="text-muted">Không có ghi chú</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reaction After Donation -->
                    <div class="mt-4">
                        <label class="info-label">Phản ứng sau hiến máu</label>
                        <div class="p-3 rounded border <?= !empty($donationHistory->reaction_after_donation) ? 'border-warning bg-warning bg-opacity-10' : 'bg-light' ?>">
                            <?php if (!empty($donationHistory->reaction_after_donation)): ?>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <strong>Đã ghi nhận phản ứng:</strong>
                                </div>
                                <?= nl2br(htmlspecialchars($donationHistory->reaction_after_donation)) ?>
                            <?php else: ?>
                                <span class="text-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Không có phản ứng phụ
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Stats and Actions -->
        <div class="col-lg-4">
            <!-- Donation Statistics Card -->
            <div class="ant-card mb-4" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-chart-bar me-2" style="color: #dc3545;"></i>Thống kê hiến máu
                    </div>
                </div>
                <div class="ant-card-body">
                    <?php 
                    // Calculate donor statistics
                    $totalDonations = 0;
                    $totalBloodAmount = 0;
                    $firstDonationDate = null;
                    $lastDonationDate = null;
                    
                    if (isset($donationHistory->user) && isset($donationHistory->user->cccd)) {
                        $userId = $donationHistory->user->cccd;
                        
                        // This would be replaced with actual data fetching in a real implementation
                        // For now, we'll simulate some statistics
                        // Ideally, you'd calculate these from the database
                        $totalDonations = 5;  // Example value
                        $totalBloodAmount = 2250; // Example value (5 * 450ml)
                        $firstDonationDate = '2022-01-15'; // Example value
                        $lastDonationDate = $donationHistory->donation_date_time; // Current donation
                    }
                    ?>
                    <div class="donation-stat-item">
                        <div class="donation-stat-icon">
                            <i class="fas fa-tint"></i>
                        </div>
                        <div>
                            <div class="donation-stat-value"><?= $totalDonations ?></div>
                            <div class="donation-stat-label">Tổng số lần hiến</div>
                        </div>
                    </div>
                    <div class="donation-stat-item">
                        <div class="donation-stat-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div>
                            <div class="donation-stat-value"><?= number_format($totalBloodAmount) ?> ml</div>
                            <div class="donation-stat-label">Tổng lượng máu đã hiến</div>
                        </div>
                    </div>
                    <?php if ($firstDonationDate): ?>
                    <div class="donation-stat-item">
                        <div class="donation-stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="donation-stat-value"><?= date('d/m/Y', strtotime($firstDonationDate)) ?></div>
                            <div class="donation-stat-label">Lần đầu hiến máu</div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="donation-timeline mt-4">
                        <h6 class="timeline-title">Lịch sử hiến máu</h6>
                        <div class="timeline">
                            <?php 
                            // This would be replaced with actual data in a real implementation
                            // For now, we'll create some example donation history entries
                            $exampleHistory = [
                                ['date' => '2023-11-10', 'amount' => 450, 'location' => 'Bệnh viện Chợ Rẫy'],
                                ['date' => '2023-05-22', 'amount' => 450, 'location' => 'Sự kiện hiến máu HUTECH'],
                                ['date' => '2022-09-15', 'amount' => 350, 'location' => 'Trung tâm Hiến máu'],
                                ['date' => '2022-01-15', 'amount' => 450, 'location' => 'Bệnh viện Đại học Y Dược']
                            ];
                            
                            foreach ($exampleHistory as $index => $donation):
                            ?>
                                <div class="timeline-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="timeline-badge"></div>
                                    <div class="timeline-content">
                                        <div class="timeline-date"><?= date('d/m/Y', strtotime($donation['date'])) ?></div>
                                        <div class="timeline-body">
                                            <div><strong><?= $donation['amount'] ?> ml</strong></div>
                                            <div class="text-muted small"><?= $donation['location'] ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="ant-card" style="border-top: 3px solid #dc3545; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                <div class="ant-card-head">
                    <div class="ant-card-head-title">
                        <i class="fas fa-tasks me-2" style="color: #dc3545;"></i>Thao tác
                    </div>
                </div>
                <div class="ant-card-body">
                    <div class="d-grid gap-3">
                        <button type="button" class="btn btn-outline-primary w-100 text-start" id="printCertificate">
                            <i class="fas fa-print me-2"></i>In chứng nhận hiến máu
                        </button>
                        <button type="button" class="btn btn-outline-secondary w-100 text-start" id="emailDonor">
                            <i class="fas fa-envelope me-2"></i>Gửi email đến người hiến
                        </button>
                        <button type="button" class="btn btn-outline-success w-100 text-start" id="scheduleNextDonation">
                            <i class="fas fa-calendar-plus me-2"></i>Lên lịch hiến máu tiếp theo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom styling for blood donation history details view */
    .avatar-large {
        width: 80px;
        height: 80px;
        background-color: #dc3545;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        margin: 0 auto;
    }
    
    .blood-type-large {
        width: 40px;
        height: 40px;
        background-color: #dc35451a;
        color: #dc3545;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: bold;
        margin: 0 auto;
    }
    
    .info-label {
        display: block;
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 1rem;
        color: #343a40;
        margin-bottom: 10px;
    }
    
    .donation-stat-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .donation-stat-item:last-child {
        border-bottom: none;
    }
    
    .donation-stat-icon {
        width: 44px;
        height: 44px;
        background-color: #dc35451a;
        color: #dc3545;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 15px;
    }
    
    .donation-stat-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 5px;
    }
    
    .donation-stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    /* Timeline styles */
    .donation-timeline {
        padding-top: 10px;
    }
    
    .timeline-title {
        margin-bottom: 15px;
        color: #343a40;
    }
    
    .timeline {
        position: relative;
        padding: 0;
        margin: 0;
        list-style: none;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 10px;
        width: 2px;
        background: #f0f0f0;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 30px;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-badge {
        position: absolute;
        top: 3px;
        left: 4px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #f0f0f0;
        border: 2px solid white;
    }
    
    .timeline-item.active .timeline-badge {
        background-color: #dc3545;
    }
    
    .timeline-content {
        position: relative;
    }
    
    .timeline-date {
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .timeline-item.active .timeline-date {
        color: #dc3545;
    }
    
    .timeline-body {
        padding-bottom: 5px;
    }
    
    /* Button styles */
    .btn-outline-primary {
        color: #007bff;
        border-color: #007bff;
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
        transition: all 0.3s ease;
    }
    
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
        transform: translateY(-2px);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print certificate button
    const printCertificateBtn = document.getElementById('printCertificate');
    if (printCertificateBtn) {
        printCertificateBtn.addEventListener('click', function() {
            alert('Đang chuẩn bị in chứng nhận hiến máu...');
            // Implement printing functionality here
        });
    }
    
    // Email donor button
    const emailDonorBtn = document.getElementById('emailDonor');
    if (emailDonorBtn) {
        emailDonorBtn.addEventListener('click', function() {
            alert('Đang chuẩn bị gửi email...');
            // Implement email sending functionality here
        });
    }
    
    // Schedule next donation button
    const scheduleNextDonationBtn = document.getElementById('scheduleNextDonation');
    if (scheduleNextDonationBtn) {
        scheduleNextDonationBtn.addEventListener('click', function() {
            alert('Đang mở lịch hẹn hiến máu tiếp theo...');
            // Implement scheduling functionality here
        });
    }
});
</script>

<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>