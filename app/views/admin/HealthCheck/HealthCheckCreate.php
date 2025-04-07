<?php
// Define the content function that will be used in the layout
$content = function () {
    global $appointments;
    global $previousHealthData;

    // Log:
    error_log("appointments (View): " . json_encode($appointments));
    error_log("previousHealthData (View): " . json_encode($previousHealthData));
?>
    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded"
            style="background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); padding: 24px; color: white;">
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
                <div class="ant-card"
                    style="border-top: 3px solid var(--accent-violet); box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <div class="ant-card-body">
                        <form action="?controller=Healthcheck&action=adminStore" method="POST" class="needs-validation"
                            novalidate>
                            <!-- Appointment Selection with custom styling -->
                            <div class="ant-form-item">
                                <label for="appointment_id" class="ant-form-label"
                                    style="color: var(--accent-violet); font-weight: 600;">
                                    Lịch hẹn <span class="text-danger">*</span>
                                </label>
                                <select name="appointment_id" id="appointment_id" class="ant-select"
                                    style="border-radius: 10px; border-color: #e2e8f0; padding: 10px 15px;" required>
                                    <option value="">-- Chọn lịch hẹn --</option>
                                    <?php if (isset($appointments) && count($appointments) > 0): ?>
                                        <?php foreach ($appointments as $appointment): ?>
                                            <?php
                                            $userName = 'N/A';
                                            $userCCCD = 'N/A';
                                            $userDOB = 'N/A';
                                            $userBloodType = 'N/A';

                                            if ($appointment->user) {
                                                $userCCCD = $appointment->user->cccd ?? 'N/A';

                                                if ($appointment->user->userInfo) {
                                                    $userName = $appointment->user->userInfo->full_name ?? 'N/A';
                                                    $userDOB = $appointment->user->userInfo->dob ?? 'N/A';
                                                    $userBloodType = $appointment->user->userInfo->blood_type ?? 'N/A';
                                                }
                                            }

                                            $donorInfo = [
                                                'name' => $userName,
                                                'cccd' => $userCCCD,
                                                'blood_type' => $userBloodType,
                                                'dob' => $userDOB
                                            ];
                                            ?>
                                            <option value="<?= $appointment->id ?>"
                                                data-donor-info='<?= htmlspecialchars(json_encode($donorInfo)) ?>'>
                                                ID: <?= $appointment->id ?> -
                                                <?= date('d/m/Y', strtotime($appointment->appointment_date_time)) ?> -
                                                <?= htmlspecialchars($userName) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="" disabled>Không có lịch hẹn nào khả dụng</option>
                                    <?php endif; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Vui lòng chọn lịch hẹn.
                                </div>
                            </div>

                            <!-- Donor Information Preview -->
                            <div id="donorInfoPreview" class="alert alert-info mt-3 d-none">
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

                            <!-- Health Metrics Section with fancy styling -->
                            <div class="ant-card mt-4 mb-4"
                                style="box-shadow: none; border: none; border-radius: 15px; background-color: #f8f6ff; overflow: hidden;">
                                <div class="ant-card-head"
                                    style="background: linear-gradient(to right, var(--accent-violet), var(--accent-purple)); border-bottom: none; border-radius: 15px 15px 0 0;">
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
                                                    id="hasChronicDiseases" name="healthMetrics[hasChronicDiseases]">
                                                <label class="ms-2" for="hasChronicDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có bệnh mãn
                                                        tính</span> (tiểu đường, tim mạch, v.v.)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="hasRecentDiseases" name="healthMetrics[hasRecentDiseases]">
                                                <label class="ms-2" for="hasRecentDiseases">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có bệnh
                                                        trong 3 tháng qua</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1" id="hasSymptoms"
                                                    name="healthMetrics[hasSymptoms]">
                                                <label class="ms-2" for="hasSymptoms">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Có triệu
                                                        chứng sốt, ho, đau họng</span>, v.v.
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="isPregnantOrNursing" name="healthMetrics[isPregnantOrNursing]">
                                                <label class="ms-2" for="isPregnantOrNursing">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Đang mang
                                                        thai hoặc cho con bú</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ant-checkbox-wrapper"
                                                style="background-color: white; padding: 12px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: all 0.2s ease;">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="HIVTestAgreement" name="healthMetrics[HIVTestAgreement]" checked>
                                                <label class="ms-2" for="HIVTestAgreement">
                                                    <span style="font-weight: 500; color: var(--accent-violet);">Đồng ý xét
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
                                                name="vitalSigns[bloodPressure]" placeholder="VD: 120/80">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="heartRate" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Nhịp tim (nhịp/phút)
                                            </label>
                                            <input type="number" class="form-control" id="heartRate"
                                                name="vitalSigns[heartRate]" placeholder="VD: 75">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="temperature" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Nhiệt độ (°C)
                                            </label>
                                            <input type="number" step="0.1" class="form-control" id="temperature"
                                                name="vitalSigns[temperature]" placeholder="VD: 36.5">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="hemoglobin" class="form-label"
                                                style="font-weight: 500; color: var(--accent-blue);">
                                                Hemoglobin (g/dL)
                                            </label>
                                            <input type="number" step="0.1" class="form-control" id="hemoglobin"
                                                name="vitalSigns[hemoglobin]" placeholder="VD: 14.5">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes with colorful textarea -->
                            <div class="ant-form-item">
                                <label for="notes" class="ant-form-label"
                                    style="color: var(--accent-violet); font-weight: 600;">
                                    Ghi chú <span class="text-danger">*</span>
                                </label>
                                <textarea name="notes" id="notes" rows="4" class="ant-input"
                                    style="border-radius: 10px; border-color: #e2e8f0; padding: 10px 15px; transition: all 0.2s ease;"
                                    placeholder="Nhập ghi chú về kết quả kiểm tra sức khỏe..." required></textarea>
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
                                        style="background: linear-gradient(120deg, var(--accent-violet), var(--accent-purple)); color: white; border: none; font-weight: 500; padding: 8px 16px; border-radius: 8px;">
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
                            <i class="fas fa-info-circle me-2"></i>Hướng dẫn
                        </div>
                    </div>
                    <div class="ant-card-body">
                        <p class="text-muted mb-3">
                            Kiểm tra sức khỏe là bước quan trọng để đảm bảo người hiến máu đủ điều kiện tham gia hiến máu an
                            toàn.
                        </p>
                        <div class="alert alert-light border p-3 mb-3">
                            <h6 class="mb-2"><i class="fas fa-clipboard-check me-2"
                                    style="color: var(--accent-violet);"></i>Tiêu chí đánh giá</h6>
                            <p class="small mb-0">
                                Đánh dấu các tiêu chí không đạt yêu cầu. Nếu người hiến máu có bất kỳ vấn đề sức khỏe nào,
                                hệ thống sẽ tự động đánh giá là "Không đạt".
                            </p>
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
            const appointmentSelect = document.getElementById('appointment_id');
            const donorInfoPreview = document.getElementById('donorInfoPreview');

            // Donor info elements
            const donorName = document.getElementById('donorName');
            const donorCCCD = document.getElementById('donorCCCD');
            const donorBloodType = document.getElementById('donorBloodType');
            const donorDOB = document.getElementById('donorDOB');

            // Show donor info when appointment is selected
            appointmentSelect.addEventListener('change', function() {
                if (this.value) {
                    const selectedOption = this.options[this.selectedIndex];
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
            });

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