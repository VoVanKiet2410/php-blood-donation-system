<?php
// Define the content function that will be used in the layout
$content = function () {
    global $healthcheck;
    global $appointments;
    
    // Decode health metrics
    $healthMetrics = json_decode($healthcheck->health_metrics);
?>
    <div class="container-fluid px-0">
        <!-- Page Header -->
        <div class="ant-page-header mb-4">
            <div class="d-flex align-items-center">
                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="text-decoration-none text-secondary me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0">Chỉnh sửa kết quả kiểm tra sức khỏe</h4>
                    <p class="text-muted mb-0 mt-1">Cập nhật thông tin kiểm tra sức khỏe #<?= $healthcheck->id ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Card -->
                <div class="ant-card">
                    <div class="ant-card-body">
                        <form action="?controller=Healthcheck&action=adminUpdate&id=<?= $healthcheck->id ?>" method="POST" class="needs-validation" novalidate>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Appointment Selection -->
                                    <div class="ant-form-item">
                                        <label for="appointment_id" class="ant-form-label">
                                            Lịch hẹn <span class="text-danger">*</span>
                                        </label>
                                        <select name="appointment_id" id="appointment_id" class="ant-select" required>
                                            <option value="">-- Chọn lịch hẹn --</option>
                                            <?php foreach ($appointments as $appointment): ?>
                                                <option value="<?= $appointment->id ?>" <?= $healthcheck->appointment_id == $appointment->id ? 'selected' : '' ?>>
                                                    ID: <?= $appointment->id ?> - 
                                                    <?= date('d/m/Y', strtotime($appointment->appointment_date)) ?> - 
                                                    <?= $appointment->user ? htmlspecialchars($appointment->user->name) : 'N/A' ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Vui lòng chọn lịch hẹn.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Current Result -->
                                    <div class="ant-form-item">
                                        <label class="ant-form-label">Kết quả hiện tại</label>
                                        <div class="d-flex align-items-center">
                                            <?php if($healthcheck->result == 'PASS'): ?>
                                                <div class="ant-tag ant-tag-success">
                                                    <i class="fas fa-check-circle me-1"></i>Đạt
                                                </div>
                                            <?php else: ?>
                                                <div class="ant-tag ant-tag-error">
                                                    <i class="fas fa-times-circle me-1"></i>Không đạt
                                                </div>
                                            <?php endif; ?>
                                            <small class="text-muted ms-2">
                                                (Kết quả sẽ được tính lại dựa trên tiêu chí đánh giá)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Health Metrics Section -->
                            <div class="ant-card mt-4 mb-4" style="box-shadow: none; border: 1px solid var(--border-color);">
                                <div class="ant-card-head">
                                    <div class="ant-card-head-title">
                                        <i class="fas fa-clipboard-check me-2"></i> Tiêu chí đánh giá
                                    </div>
                                </div>
                                <div class="ant-card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasChronicDiseases" name="healthMetrics[hasChronicDiseases]" <?= isset($healthMetrics->hasChronicDiseases) && $healthMetrics->hasChronicDiseases ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasChronicDiseases">
                                                    Có bệnh mãn tính (tiểu đường, tim mạch, v.v.)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasRecentDiseases" name="healthMetrics[hasRecentDiseases]" <?= isset($healthMetrics->hasRecentDiseases) && $healthMetrics->hasRecentDiseases ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasRecentDiseases">
                                                    Có bệnh trong 3 tháng qua
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasSymptoms" name="healthMetrics[hasSymptoms]" <?= isset($healthMetrics->hasSymptoms) && $healthMetrics->hasSymptoms ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasSymptoms">
                                                    Có triệu chứng sốt, ho, đau họng, v.v.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper">
                                                <input class="form-check-input" type="checkbox" value="1" id="isPregnantOrNursing" name="healthMetrics[isPregnantOrNursing]" <?= isset($healthMetrics->isPregnantOrNursing) && $healthMetrics->isPregnantOrNursing ? 'checked' : '' ?>>
                                                <label class="ms-2" for="isPregnantOrNursing">
                                                    Đang mang thai hoặc cho con bú
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ant-checkbox-wrapper">
                                                <input class="form-check-input" type="checkbox" value="1" id="HIVTestAgreement" name="healthMetrics[HIVTestAgreement]" <?= isset($healthMetrics->HIVTestAgreement) && $healthMetrics->HIVTestAgreement ? 'checked' : '' ?>>
                                                <label class="ms-2" for="HIVTestAgreement">
                                                    Đồng ý xét nghiệm HIV
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="ant-form-item">
                                <label for="notes" class="ant-form-label">
                                    Ghi chú <span class="text-danger">*</span>
                                </label>
                                <textarea name="notes" id="notes" class="ant-input" rows="4" required><?= htmlspecialchars($healthcheck->notes) ?></textarea>
                                <div class="invalid-feedback">
                                    Vui lòng nhập ghi chú.
                                </div>
                            </div>

                            <!-- Last updated -->
                            <div class="text-muted mb-4 small">
                                <i class="fas fa-history me-1"></i>
                                Cập nhật lần cuối: <?= date('d/m/Y H:i:s', strtotime($healthcheck->updated_at)) ?>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between border-top pt-4 mt-4">
                                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="ant-btn ant-btn-default">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <div>
                                    <button type="submit" class="ant-btn ant-btn-primary">
                                        <i class="fas fa-save me-2"></i>Cập nhật
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-lg-4">
                <div class="ant-card mb-4">
                    <div class="ant-card-head">
                        <div class="ant-card-head-title">
                            <i class="fas fa-info-circle me-2"></i>Thông tin kiểm tra
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <div class="info-item d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">ID:</span>
                            <span class="fw-medium"><?= $healthcheck->id ?></span>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Lịch hẹn:</span>
                            <span class="fw-medium">№<?= $healthcheck->appointment_id ?></span>
                        </div>
                        <div class="info-item d-flex justify-content-between mb-3 pb-3 border-bottom">
                            <span class="text-muted">Ngày tạo:</span>
                            <span class="fw-medium"><?= date('d/m/Y H:i', strtotime($healthcheck->created_at)) ?></span>
                        </div>
                        <div class="info-item d-flex justify-content-between">
                            <span class="text-muted">Kết quả:</span>
                            <?php if($healthcheck->result == 'PASS'): ?>
                                <span class="ant-tag ant-tag-success">
                                    <i class="fas fa-check-circle me-1"></i>Đạt
                                </span>
                            <?php else: ?>
                                <span class="ant-tag ant-tag-error">
                                    <i class="fas fa-times-circle me-1"></i>Không đạt
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="ant-card">
                    <div class="ant-card-head">
                        <div class="ant-card-head-title">
                            <i class="fas fa-lightbulb me-2"></i>Lưu ý khi chỉnh sửa
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <p class="text-muted small mb-3">
                            Việc thay đổi các tiêu chí đánh giá sẽ ảnh hưởng đến kết quả kiểm tra sức khỏe. 
                            Hệ thống sẽ tự động tính toán lại kết quả dựa trên các tiêu chí được chọn.
                        </p>
                        <div class="alert alert-warning p-2 small mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Việc chỉnh sửa kết quả kiểm tra có thể ảnh hưởng đến khả năng hiến máu của người dùng. 
                            Vui lòng kiểm tra kỹ thông tin trước khi cập nhật.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Additional Form-specific styles */
    .ant-checkbox-wrapper {
        display: flex;
        align-items: center;
    }
    
    .ant-checkbox-wrapper label {
        margin-bottom: 0;
        cursor: pointer;
    }

    .ant-select {
        padding-right: 30px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23595959' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: calc(100% - 12px) center;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .fw-medium {
        font-weight: 500;
    }
    </style>

    <script>
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';
        
        const form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
        
        // Form change warning
        const originalForm = form.innerHTML;
        let formChanged = false;
        
        form.addEventListener('input', function() {
            formChanged = true;
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (formChanged) {
                e.returnValue = 'Bạn có thông tin chưa lưu. Bạn có chắc chắn muốn rời đi?';
                return e.returnValue;
            }
        });
        
        // Preview healthcheck result based on selected metrics
        const healthMetricsCheckboxes = document.querySelectorAll('[name^="healthMetrics"]');
        const HIVTestAgreement = document.getElementById('HIVTestAgreement');
        
        function updateResultPreview() {
            // Preview logic could be added here
        }
        
        healthMetricsCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateResultPreview);
        });
    });
    </script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>