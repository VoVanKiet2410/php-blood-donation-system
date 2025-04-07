<?php
// Define the content function that will be used in the layout
$content = function () {
    global $healthcheck;
    global $appointments;

    // Decode health metrics
    $healthMetrics = json_decode($healthcheck->health_metrics, true);

    // Decode vital signs if available
    $vitalSigns = isset($healthMetrics['vitalSigns']) ? $healthMetrics['vitalSigns'] : [];
?>
    <div class="container-fluid px-0">
        <!-- Page Header -->
        <div class="ant-page-header mb-4 rounded"
            style="background: linear-gradient(120deg, var(--accent-blue), var(--accent-cyan)); padding: 24px; color: white;">
            <div class="d-flex align-items-center">
                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="text-decoration-none text-white me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0 text-white">Chỉnh sửa kết quả kiểm tra sức khỏe</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Cập nhật thông tin kiểm tra sức khỏe #<?= $healthcheck->id ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Card -->
                <div class="ant-card"
                    style="border-top: 3px solid var(--accent-blue); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="ant-card-body">
                        <form action="?controller=Healthcheck&action=adminUpdate&id=<?= $healthcheck->id ?>" method="POST"
                            class="needs-validation" novalidate>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <!-- Appointment Selection -->
                                    <div class="ant-form-item">
                                        <label for="appointment_id" class="ant-form-label"
                                            style="color: var(--accent-blue); font-weight: 600;">
                                            Lịch hẹn <span class="text-danger">*</span>
                                        </label>
                                        <select name="appointment_id" id="appointment_id" class="ant-select"
                                            style="border-radius: 10px; border-color: #e2e8f0; padding: 10px 15px;"
                                            required>
                                            <option value="">-- Chọn lịch hẹn --</option>
                                            <?php foreach ($appointments as $appointment): ?>
                                                <option value="<?= $appointment->id ?>"
                                                    <?= $healthcheck->appointment_id == $appointment->id ? 'selected' : '' ?>
                                                    data-donor-info="<?= htmlspecialchars(json_encode([
                                                                            'name' => $appointment->user && $appointment->user->userInfo ? $appointment->user->userInfo->full_name : 'N/A',
                                                                            'cccd' => $appointment->user ? $appointment->user->cccd : 'N/A',
                                                                            'blood_type' => $appointment->user && $appointment->user->userInfo ? $appointment->user->userInfo->blood_type : 'N/A',
                                                                            'dob' => $appointment->user && $appointment->user->userInfo ? $appointment->user->userInfo->dob : 'N/A'
                                                                        ])) ?>">
                                                    ID: <?= $appointment->id ?> -
                                                    <?= date('d/m/Y', strtotime($appointment->appointment_date)) ?> -
                                                    <?= $appointment->user && $appointment->user->userInfo ? htmlspecialchars($appointment->user->userInfo->full_name) : 'N/A' ?>
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
                                        <label class="ant-form-label"
                                            style="color: var(--accent-blue); font-weight: 600;">Kết quả hiện tại</label>
                                        <div class="d-flex align-items-center">
                                            <?php if ($healthcheck->result == 'PASS'): ?>
                                                <div class="ant-tag ant-tag-success">
                                                    <i class="fas fa-check-circle me-1"></i>Đạt
                                                </div>
                                            <?php else: ?>
                                                <div class="ant-tag ant-tag-error">
                                                    <i class="fas fa-times-circle me-1"></i>Không đạt
                                                </div>
                                            <?php endif; ?>
                                            <small class="text-muted ms-2">
                                                (Kết quả sẽ được tự động tính toán lại dựa trên các tiêu chí đánh giá)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Donor Information Preview -->
                            <div id="donorInfoPreview" class="alert alert-info mt-3">
                                <h6 class="mb-2"><i class="fas fa-user-circle me-2"></i>Thông tin người hiến máu</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Họ tên:</strong> <span id="donorName">-</span></p>
                                        <p class="mb-1"><strong>CCCD/CMND:</strong> <span id="donorCCCD">-</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Nhóm máu:</strong> <span id="donorBloodType">-</span></p>
                                        <p class="mb-1"><strong>Ngày sinh:</strong> <span id="donorDOB">-</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Health Metrics Section -->
                            <div class="ant-card mt-4 mb-4"
                                style="box-shadow: none; border: none; border-radius: 15px; background-color: #f8f6ff; overflow: hidden;">
                                <div class="ant-card-head"
                                    style="background: linear-gradient(to right, var(--accent-blue), var(--accent-cyan)); border-bottom: none; border-radius: 15px 15px 0 0;">
                                    <div class="ant-card-head-title" style="color: white;">
                                        <i class="fas fa-clipboard-check me-2"></i> Tiêu chí đánh giá
                                    </div>
                                </div>
                                <div class="ant-card-body" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="hasChronicDiseases" name="healthMetrics[hasChronicDiseases]"
                                                    <?= isset($healthMetrics['hasChronicDiseases']) && $healthMetrics['hasChronicDiseases'] ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasChronicDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-blue);">Có bệnh mãn
                                                        tính</span> (tiểu đường, tim mạch, v.v.)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="hasRecentDiseases" name="healthMetrics[hasRecentDiseases]"
                                                    <?= isset($healthMetrics['hasRecentDiseases']) && $healthMetrics['hasRecentDiseases'] ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasRecentDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-blue);">Có bệnh trong
                                                        3 tháng qua</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasSymptoms"
                                                    name="healthMetrics[hasSymptoms]"
                                                    <?= isset($healthMetrics['hasSymptoms']) && $healthMetrics['hasSymptoms'] ? 'checked' : '' ?>>
                                                <label class="ms-2" for="hasSymptoms">
                                                    <span style="font-weight: 500; color: var(--accent-blue);">Có triệu
                                                        chứng sốt, ho, đau họng</span>, v.v.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="isPregnantOrNursing" name="healthMetrics[isPregnantOrNursing]"
                                                    <?= isset($healthMetrics['isPregnantOrNursing']) && $healthMetrics['isPregnantOrNursing'] ? 'checked' : '' ?>>
                                                <label class="ms-2" for="isPregnantOrNursing">
                                                    <span style="font-weight: 500; color: var(--accent-blue);">Đang mang
                                                        thai hoặc cho con bú</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="HIVTestAgreement" name="healthMetrics[HIVTestAgreement]"
                                                    <?= !isset($healthMetrics['HIVTestAgreement']) || $healthMetrics['HIVTestAgreement'] ? 'checked' : '' ?>>
                                                <label class="ms-2" for="HIVTestAgreement">
                                                    <span style="font-weight: 500; color: var(--accent-blue);">Đồng ý xét
                                                        nghiệm HIV</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vital Signs Section -->
                            <div class="ant-card mt-4 mb-4"
                                style="box-shadow: none; border: none; border-radius: 15px; background-color: #f0f7ff; overflow: hidden;">
                                <div class="ant-card-head"
                                    style="background: linear-gradient(to right, var(--accent-blue), var(--accent-cyan)); border-bottom: none; border-radius: 15px 15px 0 0;">
                                    <div class="ant-card-head-title" style="color: white;">
                                        <i class="fas fa-heartbeat me-2"></i> Chỉ số sinh hiệu
                                    </div>
                                </div>
                                <div class="ant-card-body" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="bloodPressure" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Huyết áp (mmHg)
                                            </label>
                                            <input type="text" class="form-control" id="bloodPressure"
                                                name="vitalSigns[bloodPressure]"
                                                value="<?= $vitalSigns['bloodPressure'] ?? '' ?>" placeholder="VD: 120/80">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="heartRate" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Nhịp tim (nhịp/phút)
                                            </label>
                                            <input type="number" class="form-control" id="heartRate"
                                                name="vitalSigns[heartRate]" value="<?= $vitalSigns['heartRate'] ?? '' ?>"
                                                placeholder="VD: 75">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="temperature" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Nhiệt độ (°C)
                                            </label>
                                            <input type="number" step="0.1" class="form-control" id="temperature"
                                                name="vitalSigns[temperature]"
                                                value="<?= $vitalSigns['temperature'] ?? '' ?>" placeholder="VD: 36.5">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hemoglobin" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Hemoglobin (g/dL)
                                            </label>
                                            <input type="number" step="0.1" class="form-control" id="hemoglobin"
                                                name="vitalSigns[hemoglobin]" value="<?= $vitalSigns['hemoglobin'] ?? '' ?>"
                                                placeholder="VD: 14.5">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes with colorful textarea -->
                            <div class="ant-form-item">
                                <label for="notes" class="ant-form-label"
                                    style="color: var(--accent-blue); font-weight: 600;">
                                    Ghi chú <span class="text-danger">*</span>
                                </label>
                                <textarea name="notes" id="notes" rows="4" class="ant-input"
                                    style="border-radius: 10px; border-color: #e2e8f0; padding: 10px 15px; transition: all 0.2s ease;"
                                    placeholder="Nhập ghi chú về kết quả kiểm tra sức khỏe..."
                                    required><?= htmlspecialchars($healthcheck->notes) ?></textarea>
                                <div class="invalid-feedback">
                                    Vui lòng nhập ghi chú.
                                </div>
                                <div class="alert alert-primary mt-3 d-none" id="resultPreview">
                                    <span>Dự đoán kết quả: <strong id="resultText"></strong></span>
                                </div>
                            </div>

                            <!-- Form Actions with gradient buttons -->
                            <div class="d-flex justify-content-between border-top pt-4 mt-4">
                                <a href="<?= HEALTH_CHECK_ROUTE ?>" class="ant-btn"
                                    style="background: var(--gray-light); color: var(--gray-dark); border: none; font-weight: 500; padding: 8px 16px; border-radius: 8px;">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                                <div>
                                    <button type="reset" class="ant-btn me-2"
                                        style="background: var(--warning-light); color: var(--warning-color); border: none; font-weight: 500; padding: 8px 16px; border-radius: 8px;">
                                        <i class="fas fa-redo me-2"></i>Làm mới
                                    </button>
                                    <button type="submit" class="ant-btn"
                                        style="background: linear-gradient(120deg, var(--accent-blue), var(--accent-cyan)); color: white; border: none; font-weight: 500; padding: 8px 16px; border-radius: 8px;">
                                        <i class="fas fa-save me-2"></i>Lưu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <!-- Help Card -->
                <div class="ant-card"
                    style="border-top: 3px solid var(--accent-cyan); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="ant-card-head" style="background: linear-gradient(to right, #f9f9ff, #f0f7ff);">
                        <div class="ant-card-head-title" style="color: var(--accent-blue);">
                            <i class="fas fa-info-circle me-2"></i>Lưu ý khi chỉnh sửa
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <p class="text-muted mb-3">
                            Việc thay đổi các tiêu chí đánh giá sẽ ảnh hưởng đến kết quả kiểm tra sức khỏe.
                            Hệ thống sẽ tự động tính toán lại kết quả dựa trên các tiêu chí được chọn.
                        </p>
                        <div class="alert alert-warning p-3 mb-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Việc chỉnh sửa kết quả kiểm tra có thể ảnh hưởng đến khả năng hiến máu của người dùng.
                            Vui lòng kiểm tra kỹ thông tin trước khi cập nhật.
                        </div>
                        <div class="alert alert-light border p-3 mb-0">
                            <h6 class="mb-2"><i class="fas fa-heartbeat me-2" style="color: var(--accent-blue);"></i>Chỉ số
                                sinh hiệu</h6>
                            <p class="small mb-2">
                                Các chỉ số sinh hiệu cần nằm trong khoảng:
                            </p>
                            <ul class="small mb-0">
                                <li>Huyết áp: 90/60 - 140/90 mmHg</li>
                                <li>Nhịp tim: 60 - 100 nhịp/phút</li>
                                <li>Nhiệt độ: 36.1 - 37.2 °C</li>
                                <li>Hemoglobin: ≥ 12 g/dL (nữ), ≥ 13 g/dL (nam)</li>
                            </ul>
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
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
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

        .ant-select:focus,
        .ant-input:focus {
            border-color: var(--accent-blue) !important;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15) !important;
            outline: none;
        }

        .form-check-input:checked {
            background-color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .ant-tag {
            display: inline-block;
            border-radius: 4px;
            padding: 3px 8px;
            font-size: 0.85rem;
            line-height: 1.5;
            transition: all 0.2s;
        }

        .ant-tag-success {
            background-color: var(--success-light);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .ant-tag-error {
            background-color: var(--error-light);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }
    </style>

    <script>
        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            const form = document.querySelector('.needs-validation');
            const resultPreview = document.getElementById('resultPreview');
            const resultText = document.getElementById('resultText');
            const appointmentSelect = document.getElementById('appointment_id');
            const donorInfoPreview = document.getElementById('donorInfoPreview');

            // Donor info elements
            const donorName = document.getElementById('donorName');
            const donorCCCD = document.getElementById('donorCCCD');
            const donorBloodType = document.getElementById('donorBloodType');
            const donorDOB = document.getElementById('donorDOB');

            // Show donor info when appointment is selected
            function updateDonorInfo() {
                if (appointmentSelect.value) {
                    const selectedOption = appointmentSelect.options[appointmentSelect.selectedIndex];
                    const donorInfo = JSON.parse(selectedOption.getAttribute('data-donor-info'));

                    donorName.textContent = donorInfo.name;
                    donorCCCD.textContent = donorInfo.cccd;
                    donorBloodType.textContent = donorInfo.blood_type;

                    // Format date if available
                    if (donorInfo.dob && donorInfo.dob !== 'N/A') {
                        const dobDate = new Date(donorInfo.dob);
                        const formattedDOB = dobDate.toLocaleDateString('vi-VN');
                        donorDOB.textContent = formattedDOB;
                    } else {
                        donorDOB.textContent = 'N/A';
                    }

                    donorInfoPreview.classList.remove('d-none');
                } else {
                    donorInfoPreview.classList.add('d-none');
                }
            }

            // Initialize donor info on page load
            updateDonorInfo();

            appointmentSelect.addEventListener('change', updateDonorInfo);

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
            const vitalSignInputs = document.querySelectorAll('[name^="vitalSigns"]');

            function updateResultPreview() {
                let hasFail = false;

                // Check health metrics
                healthMetricsCheckboxes.forEach(checkbox => {
                    if (checkbox !== HIVTestAgreement && checkbox.checked) {
                        hasFail = true;
                    }
                });

                if (!HIVTestAgreement.checked) {
                    hasFail = true;
                }

                // Check vital signs if they have values
                const hemoglobin = document.getElementById('hemoglobin').value;
                if (hemoglobin && parseFloat(hemoglobin) < 12) {
                    hasFail = true;
                }

                resultPreview.classList.remove('d-none', 'alert-success', 'alert-danger', 'alert-primary');

                if (hasFail) {
                    resultPreview.classList.add('alert-danger');
                    resultText.textContent = "Không đạt";
                } else {
                    resultPreview.classList.add('alert-success');
                    resultText.textContent = "Đạt";
                }

                resultPreview.classList.remove('d-none');
            }

            // Update result on any change
            healthMetricsCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateResultPreview);
            });

            vitalSignInputs.forEach(input => {
                input.addEventListener('input', updateResultPreview);
            });

            // Show initial result preview
            updateResultPreview();

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
        });
    </script>
<?php
};
include_once __DIR__ . '/../../layouts/AdminLayout/AdminLayout.php';
?>