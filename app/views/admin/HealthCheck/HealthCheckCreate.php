<?php
// Define the content function that will be used in the layout
$content = function () {
    global $appointments;
?>
    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded" style="background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); padding: 24px; color: white;">
            <div class="d-flex align-items-center">
                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="text-decoration-none text-white me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0 text-white">Thêm kết quả kiểm tra sức khỏe</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Tạo mới kết quả kiểm tra sức khỏe cho người hiến máu</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Card with top border accent -->
                <div class="ant-card" style="border-top: 3px solid var(--accent-violet); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="ant-card-body">
                        <form action="?controller=Healthcheck&action=adminStore" method="POST" class="needs-validation" novalidate>
                            <!-- Appointment Selection with custom styling -->
                            <div class="ant-form-item">
                                <label for="appointment_id" class="ant-form-label" style="color: var(--accent-violet); font-weight: 600;">
                                    Lịch hẹn <span class="text-danger">*</span>
                                </label>
                                <select name="appointment_id" id="appointment_id" class="ant-select" 
                                        style="border-radius: 10px; border-color: #e2e8f0; padding: 10px 15px;" required>
                                    <option value="">-- Chọn lịch hẹn --</option>
                                    <?php foreach ($appointments as $appointment): ?>
                                        <option value="<?= $appointment->id ?>">
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

                            <!-- Health Metrics Section with fancy styling -->
                            <div class="ant-card mt-4 mb-4" style="box-shadow: none; border: none; border-radius: 15px; background-color: #f8f6ff; overflow: hidden;">
                                <div class="ant-card-head" style="background: linear-gradient(to right, var(--accent-violet), var(--accent-purple)); border-bottom: none; border-radius: 15px 15px 0 0;">
                                    <div class="ant-card-head-title" style="color: white;">
                                        <i class="fas fa-clipboard-check me-2"></i> Tiêu chí đánh giá
                                    </div>
                                </div>
                                <div class="ant-card-body" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper" style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasChronicDiseases" name="healthMetrics[hasChronicDiseases]">
                                                <label class="ms-2" for="hasChronicDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có bệnh mãn tính</span> (tiểu đường, tim mạch, v.v.)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper" style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasRecentDiseases" name="healthMetrics[hasRecentDiseases]">
                                                <label class="ms-2" for="hasRecentDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có bệnh trong 3 tháng qua</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper" style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasSymptoms" name="healthMetrics[hasSymptoms]">
                                                <label class="ms-2" for="hasSymptoms">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có triệu chứng sốt, ho, đau họng</span>, v.v.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper" style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="isPregnantOrNursing" name="healthMetrics[isPregnantOrNursing]">
                                                <label class="ms-2" for="isPregnantOrNursing">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Đang mang thai hoặc cho con bú</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ant-checkbox-wrapper" style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="HIVTestAgreement" name="healthMetrics[HIVTestAgreement]" checked>
                                                <label class="ms-2" for="HIVTestAgreement">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Đồng ý xét nghiệm HIV</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes with colorful textarea -->
                            <div class="ant-form-item">
                                <label for="notes" class="ant-form-label" style="color: var(--accent-violet); font-weight: 600;">
                                    Ghi chú <span class="text-danger">*</span>
                                </label>
                                <textarea name="notes" id="notes" class="ant-input" rows="4" 
                                          style="border-radius: 10px; border-color: #e2e8f0; padding: 12px 15px; transition: all 0.3s ease;" 
                                          required></textarea>
                                <div class="invalid-feedback">
                                    Vui lòng nhập ghi chú.
                                </div>
                            </div>

                            <!-- Result preview section -->
                            <div id="resultPreview" class="d-none alert mb-4 rounded-3" style="border: none; border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <span>Dự đoán kết quả: <strong id="resultText"></strong></span>
                                </div>
                            </div>

                            <!-- Form Actions with gradient buttons -->
                            <div class="d-flex justify-content-between border-top pt-4 mt-4">
                                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="ant-btn" 
                                   style="background: white; border: 1px solid #e4e4e4; color: var(--accent-violet); border-radius: 10px; padding: 10px 16px; font-weight: 500;">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <div>
                                    <button type="reset" class="ant-btn me-2"
                                            style="background: white; border: 1px solid #e4e4e4; color: var(--text-color); border-radius: 10px; padding: 10px 16px; font-weight: 500;">
                                        <i class="fas fa-redo me-2"></i>Làm mới
                                    </button>
                                    <button type="submit" class="ant-btn" 
                                            style="background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); color: white; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 500; box-shadow: 0 4px 10px rgba(123, 50, 248, 0.3);">
                                        <i class="fas fa-save me-2"></i>Lưu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card with vibrant colors -->
            <div class="col-lg-4">
                <div class="ant-card" style="border: none; border-radius: 15px; background: linear-gradient(145deg, #fdfbff, #f5f0ff); box-shadow: 0 10px 20px rgba(114, 46, 209, 0.1);">
                    <div class="ant-card-head" style="background: transparent; border-bottom: none;">
                        <div class="ant-card-head-title" style="color: var(--accent-violet);">
                            <i class="fas fa-info-circle me-2"></i>Hướng dẫn
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <div class="mb-4 pb-3 border-bottom" style="border-color: rgba(114, 46, 209, 0.2) !important;">
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px; height: 30px; background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-violet);">Tiêu chí đánh giá</h6>
                            </div>
                            <p class="text-muted mb-0 small mt-2">
                                Nếu người hiến máu có bất kỳ điều kiện về sức khỏe không phù hợp (các ô được đánh dấu), 
                                hệ thống sẽ tự động đánh giá là không đủ điều kiện hiến máu.
                            </p>
                        </div>
                        <div class="mb-4 pb-3 border-bottom" style="border-color: rgba(114, 46, 209, 0.2) !important;">
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px; height: 30px; background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-violet);">Lịch hẹn</h6>
                            </div>
                            <p class="text-muted mb-0 small mt-2">
                                Mỗi kết quả kiểm tra sức khỏe phải được liên kết với một lịch hẹn. Đảm bảo rằng bạn chọn đúng 
                                lịch hẹn cho người hiến máu.
                            </p>
                        </div>
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px; height: 30px; background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                    <i class="fas fa-star"></i>
                                </div>
                                <h6 class="fw-bold mb-0" style="color: var(--accent-violet);">Ghi chú quan trọng</h6>
                            </div>
                            <p class="text-muted mb-0 small mt-2">
                                Vui lòng cung cấp thông tin chi tiết về tình trạng sức khỏe của người hiến máu trong phần ghi chú,
                                bao gồm các chỉ số như huyết áp, nhịp tim, nhiệt độ, v.v. nếu có.
                            </p>
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
    
    .ant-checkbox-wrapper:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        transform: translateY(-2px);
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
    
    .ant-select:focus, .ant-input:focus {
        border-color: var(--accent-violet) !important;
        box-shadow: 0 0 0 3px rgba(114, 46, 209, 0.15) !important;
        outline: none;
    }
    
    .form-check-input:checked {
        background-color: var(--accent-violet);
        border-color: var(--accent-violet);
    }
    </style>

    <script>
    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';
        
        const form = document.querySelector('.needs-validation');
        const resultPreview = document.getElementById('resultPreview');
        const resultText = document.getElementById('resultText');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
        
        // Show result preview based on health metrics
        const healthMetricsCheckboxes = document.querySelectorAll('[name^="healthMetrics"]');
        const HIVTestAgreement = document.getElementById('HIVTestAgreement');
        
        function updateResultPreview() {
            let hasFail = false;
            
            healthMetricsCheckboxes.forEach(checkbox => {
                if (checkbox !== HIVTestAgreement && checkbox.checked) {
                    hasFail = true;
                }
            });
            
            if (!HIVTestAgreement.checked) {
                hasFail = true;
            }
            
            resultPreview.classList.remove('d-none', 'alert-success', 'alert-danger');
            
            if (hasFail) {
                resultPreview.classList.add('alert-danger');
                resultText.textContent = "Không đạt";
            } else {
                resultPreview.classList.add('alert-success');
                resultText.textContent = "Đạt";
            }
            
            resultPreview.classList.remove('d-none');
        }
        
        healthMetricsCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateResultPreview);
        });
        
        // Add subtle hover effects to checkboxes
        const checkboxWrappers = document.querySelectorAll('.ant-checkbox-wrapper');
        checkboxWrappers.forEach(wrapper => {
            wrapper.addEventListener('mouseover', function() {
                this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
                this.style.transform = 'translateY(-2px)';
            });
            
            wrapper.addEventListener('mouseout', function() {
                this.style.boxShadow = '0 2px 5px rgba(0,0,0,0.03)';
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>