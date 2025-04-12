<?php
// Define the content function that will be used in the layout
$title = "Câu hỏi sàng lọc trước khi đăng ký hiến máu";
$content = function () use ($data) {

    // In dữ liệu sự kiện
    $event = $data['event'];
    if (!isset($event) || empty($event)) {
        echo '<div class="alert alert-danger">Không tìm thấy sự kiện.</div>';
        return;
    }
?>
    <div class="container py-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="card border-0 shadow-sm mb-4"
                style="border-radius: 15px; border-top: 4px solid #dc3545 !important;">
                <div class="card-body p-4">
                    <h2 class="fs-4 mb-3 text-danger fw-bold">Câu hỏi sàng lọc trước khi đăng ký hiến máu</h2>
                    <p class="mb-1">Sự kiện: <strong><?= htmlspecialchars($event['name'] ?? 'N/A') ?></strong></p>
                    <p class="mb-1">Ngày diễn ra:
                        <strong><?= date('d/m/Y', strtotime($event['event_date'] ?? 'now')) ?></strong>
                    </p>
                    <p class="mb-1">Thời gian: <strong><?= date('H:i', strtotime($event['event_start_time'] ?? 'now')) ?> -
                            <?= date('H:i', strtotime($event['event_end_time'] ?? 'now')) ?></strong></p>
                    <p class="mb-1">Đơn vị tiếp nhận:
                        <strong><?= htmlspecialchars($event['donation_unit']['name'] ?? 'N/A') ?></strong>
                    </p>
                    <p class="mb-3">Địa điểm:
                        <strong><?= htmlspecialchars($event['donation_unit']['address'] ?? 'N/A') ?></strong>
                    </p>

                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle fa-lg me-2"></i>
                            </div>
                            <div>
                                <p class="mb-0">Để đảm bảo an toàn cho người hiến và người nhận máu, vui lòng trả lời trung
                                    thực các câu hỏi dưới đây. Nếu bạn không đáp ứng được điều kiện hiến máu, bạn sẽ được
                                    thông báo và không thể đăng ký sự kiện hiến máu này.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- Questionnaire Form -->
            <form action="<?= BASE_URL ?>/public/index.php?controller=Event&action=validatePreScreening" method="POST"
                id="questionnaireForm" class="needs-validation" novalidate>
                <input type="hidden" name="event_id" value="<?= $event['id'] ?? '' ?>">

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h3 class="fs-5 mb-3 text-primary fw-bold">Thông tin cơ bản</h3>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="age" class="form-label">Độ tuổi của bạn <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="age" name="age" min="18" max="60" required>
                                <div class="invalid-feedback">Vui lòng nhập độ tuổi của bạn (18-60 tuổi)</div>
                                <div class="form-text">Người hiến máu phải từ 18 đến 60 tuổi</div>
                            </div>
                            <div class="col-md-6">
                                <label for="weight" class="form-label">Cân nặng (kg) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="weight" name="weight" min="50" required>
                                <div class="invalid-feedback">Vui lòng nhập cân nặng của bạn (tối thiểu 50kg)</div>
                                <div class="form-text">Người hiến máu phải có cân nặng tối thiểu 50kg</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Giới tính <span class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                    <option value="other">Khác</option>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn giới tính</div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastDonationDate" class="form-label">Lần cuối hiến máu</label>
                                <input type="date" class="form-control" id="lastDonationDate" name="lastDonationDate">
                                <div class="form-text">Để trống nếu bạn chưa từng hiến máu</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h3 class="fs-5 mb-3 text-primary fw-bold">Sàng lọc sức khỏe</h3>

                        <div class="mb-3">
                            <label class="form-label">1. Bạn có đang khỏe mạnh không? <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_healthy" id="is_healthy_yes"
                                    value="yes" required>
                                <label class="form-check-label" for="is_healthy_yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_healthy" id="is_healthy_no"
                                    value="no">
                                <label class="form-check-label" for="is_healthy_no">Không</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn một lựa chọn</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">2. Bạn có đang uống thuốc kháng sinh hoặc thuốc khác không? <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="taking_medicine" id="taking_medicine_yes"
                                    value="yes" required>
                                <label class="form-check-label" for="taking_medicine_yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="taking_medicine" id="taking_medicine_no"
                                    value="no">
                                <label class="form-check-label" for="taking_medicine_no">Không</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn một lựa chọn</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">3. Bạn có các bệnh sau không? <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" id="disease_heart"
                                    value="heart">
                                <label class="form-check-label" for="disease_heart">Bệnh tim</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" id="disease_diabetes"
                                    value="diabetes">
                                <label class="form-check-label" for="disease_diabetes">Tiểu đường</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" id="disease_hepatitis"
                                    value="hepatitis">
                                <label class="form-check-label" for="disease_hepatitis">Viêm gan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" id="disease_hiv"
                                    value="hiv">
                                <label class="form-check-label" for="disease_hiv">HIV/AIDS</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="diseases[]" id="disease_none"
                                    value="none">
                                <label class="form-check-label" for="disease_none">Không có bệnh nào ở trên</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn ít nhất một lựa chọn</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">4. Trong 6 tháng qua, bạn có: <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="recent_activities[]"
                                    id="activity_tattoo" value="tattoo">
                                <label class="form-check-label" for="activity_tattoo">Xăm mình</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="recent_activities[]"
                                    id="activity_piercing" value="piercing">
                                <label class="form-check-label" for="activity_piercing">Xỏ khuyên</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="recent_activities[]"
                                    id="activity_surgery" value="surgery">
                                <label class="form-check-label" for="activity_surgery">Phẫu thuật</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="recent_activities[]"
                                    id="activity_abroad" value="abroad">
                                <label class="form-check-label" for="activity_abroad">Đi nước ngoài</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="recent_activities[]"
                                    id="activity_none" value="none">
                                <label class="form-check-label" for="activity_none">Không có hoạt động nào ở trên</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">5. Nếu bạn là nữ, bạn có đang mang thai hoặc cho con bú không? <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pregnancy" id="pregnancy_yes"
                                    value="yes">
                                <label class="form-check-label" for="pregnancy_yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pregnancy" id="pregnancy_no" value="no">
                                <label class="form-check-label" for="pregnancy_no">Không</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="pregnancy" id="pregnancy_na" value="na">
                                <label class="form-check-label" for="pregnancy_na">Không áp dụng (Nam)</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn một lựa chọn</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">6. Bạn có tiếp xúc với người mắc bệnh truyền nhiễm trong 14 ngày qua
                                không? <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="infection_contact"
                                    id="infection_contact_yes" value="yes" required>
                                <label class="form-check-label" for="infection_contact_yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="infection_contact"
                                    id="infection_contact_no" value="no">
                                <label class="form-check-label" for="infection_contact_no">Không</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn một lựa chọn</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">7. Bạn đã ăn và ngủ đủ giấc trong 24 giờ qua chưa? <span
                                    class="text-danger">*</span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rest_enough" id="rest_enough_yes"
                                    value="yes" required>
                                <label class="form-check-label" for="rest_enough_yes">Có</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rest_enough" id="rest_enough_no"
                                    value="no">
                                <label class="form-check-label" for="rest_enough_no">Không</label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn một lựa chọn</div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h3 class="fs-5 mb-3 text-primary fw-bold">Chấp thuận</h3>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="consent" id="consent" required>
                                <label class="form-check-label" for="consent">
                                    Tôi xác nhận rằng những thông tin tôi cung cấp là chính xác và đầy đủ. Tôi hiểu rằng
                                    việc hiến máu là hoàn toàn tự nguyện và tôi đồng ý với các quy trình hiến máu. Tôi đồng
                                    ý cho phép sử dụng máu của tôi để cứu người.
                                </label>
                                <div class="invalid-feedback">Bạn phải đồng ý với điều khoản này để tiếp tục</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-between mb-4">
                    <a href="<?= BASE_URL ?>/public/index.php?controller=Event&action=clientIndex"
                        class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-check-circle me-2"></i>Gửi đăng ký
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalTitle">Kết quả đánh giá</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="resultModalBody">
                    <!-- Content will be dynamically inserted -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" id="continueBtn" class="btn btn-primary">Tiếp tục</a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .card {
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #bb2d3b;
            border-color: #bb2d3b;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #dc3545;
            border-color: #dc3545;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.getElementById('questionnaireForm');
            const diseaseNone = document.getElementById('disease_none');
            const activityNone = document.getElementById('activity_none');
            const diseaseCheckboxes = document.querySelectorAll('input[name="diseases[]"]:not(#disease_none)');
            const activityCheckboxes = document.querySelectorAll(
                'input[name="recent_activities[]"]:not(#activity_none)');
            const genderSelect = document.getElementById('gender');
            const pregnancyRadios = document.querySelectorAll('input[name="pregnancy"]');

            // Client-side validation for pregnancy options based on gender
            genderSelect.addEventListener('change', function() {
                const isMale = this.value === 'male';
                if (isMale) {
                    document.getElementById('pregnancy_na').checked = true;
                    pregnancyRadios.forEach(radio => {
                        radio.disabled = radio.id !== 'pregnancy_na';
                    });
                } else {
                    pregnancyRadios.forEach(radio => {
                        radio.disabled = false;
                    });
                    if (document.getElementById('pregnancy_na').checked) {
                        document.getElementById('pregnancy_na').checked = false;
                    }
                }
            });

            // Handle "None" checkbox for diseases
            diseaseNone.addEventListener('change', function() {
                if (this.checked) {
                    diseaseCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                    });
                } else {
                    diseaseCheckboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                    });
                }
            });

            // Disable "None" if other options are selected
            diseaseCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        diseaseNone.checked = false;
                        diseaseNone.disabled = true;
                    } else if (![...diseaseCheckboxes].some(box => box.checked)) {
                        diseaseNone.disabled = false;
                    }
                });
            });

            // Handle "None" checkbox for recent activities
            activityNone.addEventListener('change', function() {
                if (this.checked) {
                    activityCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                    });
                } else {
                    activityCheckboxes.forEach(checkbox => {
                        checkbox.disabled = false;
                    });
                }
            });

            // Disable "None" if other activities are selected
            activityCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        activityNone.checked = false;
                        activityNone.disabled = true;
                    } else if (![...activityCheckboxes].some(box => box.checked)) {
                        activityNone.disabled = false;
                    }
                });
            });

            // Form validation on submit
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                // Check if either disease_none or at least one disease is selected
                const diseaseSelected = diseaseNone.checked || [...diseaseCheckboxes].some(checkbox => checkbox
                    .checked);
                if (!diseaseSelected) {
                    event.preventDefault();
                    alert('Vui lòng chọn ít nhất một lựa chọn cho câu hỏi về bệnh.');
                    return;
                }

                // Check if either activity_none or at least one recent activity is selected
                const activitySelected = activityNone.checked || [...activityCheckboxes].some(checkbox =>
                    checkbox.checked);
                if (!activitySelected) {
                    event.preventDefault();
                    alert('Vui lòng chọn ít nhất một lựa chọn cho câu hỏi về hoạt động gần đây.');
                    return;
                }

                // Check pregnancy question for females
                if (genderSelect.value === 'female') {
                    const pregnancySelected = [...pregnancyRadios].some(radio => radio.checked);
                    if (!pregnancySelected) {
                        event.preventDefault();
                        alert('Vui lòng trả lời câu hỏi về thai kỳ.');
                        return;
                    }
                }

                form.classList.add('was-validated');
            });
        });
    </script>
<?php
};
include_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
?>