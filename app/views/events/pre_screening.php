<?php
// Define any constants needed
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}
// Use global variables from controller
if (!isset($event)) {
    $event = null;
    // Notication message to page
    if (isset($_SESSION['notification_message'])) {
        $notificationMessage = $_SESSION['notification_message'];
        unset($_SESSION['notification_message']);
    } else {
        $notificationMessage = null;
        // SHow Data Table in the page

    }
} else {
    // Check if the event is valid
    if (isset($event['id'])) {
        $eventId = $event['id'];
    } else {
        $eventId = null;
    }
}

// Log complete event data for debugging
if (isset($event)) {
    error_log("Event data: " . json_encode($event));
} else {
    error_log("No event data available.");
}
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Progress Bar -->
            <div class="progress mb-4 rounded-pill" style="height: 10px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: 50%;" aria-valuenow="50"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mb-4">
                <span class="badge bg-info rounded-pill px-3 py-2">
                    <i class="fas fa-clipboard-list me-2"></i>Bước 1: Sàng lọc
                </span>
                <span class="badge bg-secondary rounded-pill px-3 py-2">
                    <i class="fas fa-calendar-check me-2"></i>Bước 2: Đặt lịch
                </span>
            </div>

            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-info text-white py-3 border-0">
                    <h3 class="mb-1 fw-bold"><i class="fas fa-heartbeat me-2"></i>Câu hỏi sàng lọc trước khi hiến máu
                    </h3>
                    <p class="mb-0"><i class="fas fa-info-circle me-1"></i>Để đảm bảo sức khỏe của bạn và chất lượng máu
                        hiến tặng, vui lòng trả lời các câu hỏi sau</p>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-info d-flex align-items-center fade show" role="alert">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1">Có một số vấn đề cần khắc phục</h5>
                            <ul class="mb-0 ps-3">
                                <?php foreach ($errors as $error): ?>
                                <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($event): ?>
                    <div class="card border mb-4 event-info-card">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-md-8 p-3">
                                    <h5 class="card-title text-info mb-3">
                                        <i class="fas fa-calendar-day me-2"></i>Thông tin sự kiện
                                    </h5>
                                    <div class="mb-3">
                                        <h4 class="fw-bold mb-2"><?= htmlspecialchars($event['name']) ?></h4>
                                        <p class="mb-2 d-flex align-items-center">
                                            <i class="far fa-calendar-alt text-info me-2"></i>
                                            <span><?= date('d/m/Y', strtotime($event['event_date'])) ?></span>
                                        </p>
                                        <p class="mb-2 d-flex align-items-center">
                                            <i class="far fa-clock text-info me-2"></i>
                                            <span><?= date('H:i', strtotime($event['event_start_time'])) ?> -
                                                <?= date('H:i', strtotime($event['event_end_time'])) ?></span>
                                        </p>
                                        <p class="mb-0 d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-info me-2"></i>
                                            <span>
                                                <?php if (isset($event['donation_unit']) && isset($event['donation_unit']['location'])): ?>
                                                <?= htmlspecialchars($event['donation_unit']['location']) ?>
                                                <?php elseif (isset($event['donation_unit']) && isset($event['donation_unit']['address'])): ?>
                                                <?= htmlspecialchars($event['donation_unit']['address']) ?>
                                                <?php else: ?>
                                                Không có thông tin
                                                <?php endif; ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="col-md-4 bg-light d-flex flex-column justify-content-center align-items-center p-3 border-start">
                                    <?php if (isset($event['donation_unit']) && !empty($event['donation_unit']['photo_url'])): ?>
                                    <img src="<?= htmlspecialchars($event['donation_unit']['photo_url']) ?>"
                                        alt="<?= htmlspecialchars($event['donation_unit']['name'] ?? 'Đơn vị hiến máu') ?>"
                                        class="img-fluid rounded mb-2" style="max-height: 100px;">
                                    <?php else: ?>
                                    <div class="text-center mb-2">
                                        <i class="fas fa-hospital text-info fa-3x"></i>
                                    </div>
                                    <?php endif; ?>
                                    <h6 class="text-center mb-0">
                                        <?= htmlspecialchars($event['donation_unit']['name'] ?? 'Đơn vị hiến máu') ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info d-flex mb-4">
                        <div class="flex-shrink-0 me-3">
                            <i class="fas fa-lightbulb fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Lưu ý quan trọng</h5>
                            <p class="mb-0">Trả lời <strong>"Có"</strong> cho các câu hỏi có đánh dấu <span
                                    class="text-info">(*)</span> có thể ảnh hưởng đến khả năng hiến máu của bạn. Vui
                                lòng trả lời trung thực để đảm bảo an toàn.</p>
                        </div>
                    </div>

                    <form action="<?= BASE_URL ?>/index.php?controller=Event&action=validatePreScreening" method="POST"
                        id="prescreeningForm" class="needs-validation" novalidate> <input type="hidden" name="event_id"
                            value="<?= $event['id'] ?>">

                        <!-- Thông tin chung -->
                        <div class="card mb-4 question-card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom border-info border-2">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-user-circle text-info me-2"></i>Thông tin chung
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">1. Bạn đã từng hiến máu trước đây
                                                chưa?</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="donated_before"
                                                        value="yes" id="donated_before_yes" required>
                                                    <label class="form-check-label" for="donated_before_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="donated_before"
                                                        value="no" id="donated_before_no">
                                                    <label class="form-check-label" for="donated_before_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Chưa từng</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Vui lòng chọn một phương án</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 donation-date-container d-none">
                                        <div class="form-group">
                                            <label class="form-label fw-medium">Lần hiến máu gần nhất?</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i
                                                        class="fas fa-calendar-alt"></i></span>
                                                <input type="date" class="form-control" name="last_donation_date"
                                                    id="last_donation_date" max="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="form-text">Cần cách nhau ít nhất 3 tháng giữa các lần hiến máu
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tiêu chuẩn cơ bản -->
                        <div class="card mb-4 question-card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom border-info border-2">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-check-circle text-info me-2"></i>Tiêu chuẩn cơ bản
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">2. Bạn có đủ 18 tuổi không?</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="age_requirement"
                                                        value="yes" id="age_requirement_yes" required>
                                                    <label class="form-check-label" for="age_requirement_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Đủ/ trên 18 tuổi</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="age_requirement"
                                                        value="no" id="age_requirement_no">
                                                    <label class="form-check-label" for="age_requirement_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Dưới</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text">Người hiến máu phải đủ 18 tuổi trở lên</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">3. Bạn có cân nặng từ 50kg trở lên
                                                không?</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio"
                                                        name="weight_requirement" value="yes"
                                                        id="weight_requirement_yes" required>
                                                    <label class="form-check-label" for="weight_requirement_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio"
                                                        name="weight_requirement" value="no" id="weight_requirement_no">
                                                    <label class="form-check-label" for="weight_requirement_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Dưới 50kg</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text">Người hiến máu phải có cân nặng tối thiểu 50kg</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Tình trạng sức khỏe hiện tại -->
                        <div class="card mb-4 question-card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom border-info border-2">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-heartbeat text-info me-2"></i>Tình trạng sức khỏe hiện tại
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">4. Bạn có khỏe mạnh và cảm thấy tốt hôm
                                                nay không?</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="feeling_well"
                                                        value="yes" id="feeling_well_yes" required>
                                                    <label class="form-check-label" for="feeling_well_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="feeling_well"
                                                        value="no" id="feeling_well_no">
                                                    <label class="form-check-label" for="feeling_well_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Vui lòng chọn một phương án</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                5. <span class="text-info">(*)</span> Bạn có đang mắc bệnh cảm, cúm hoặc
                                                sốt không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="recent_fever" value="yes" id="recent_fever_yes" required>
                                                    <label class="form-check-label" for="recent_fever_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="recent_fever"
                                                        value="no" id="recent_fever_no">
                                                    <label class="form-check-label" for="recent_fever_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text text-info">Ghi chú: Nếu bạn đang mắc bệnh cảm, cúm
                                                hoặc sốt, bạn có thể không đủ điều kiện hiến máu.</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                6. <span class="text-info">(*)</span> Bạn có đang dùng bất kỳ loại thuốc
                                                nào không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="medication" value="yes" id="medication_yes" required>
                                                    <label class="form-check-label" for="medication_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="medication"
                                                        value="no" id="medication_no">
                                                    <label class="form-check-label" for="medication_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 medication-details d-none">
                                        <div class="form-group">
                                            <label class="form-label fw-medium">Vui lòng liệt kê các loại thuốc đang sử
                                                dụng:</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                                <textarea class="form-control" name="medication_details" rows="2"
                                                    placeholder="VD: Paracetamol, kháng sinh, v.v."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Tiền sử bệnh lý -->
                        <div class="card mb-4 question-card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom border-info border-2">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-file-medical text-info me-2"></i>Tiền sử bệnh lý
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="alert alert-light border-start border-info border-3">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <i class="fas fa-info-circle text-info fa-lg"></i>
                                                </div>
                                                <div>
                                                    Các câu hỏi trong phần này liên quan đến tiền sử bệnh lý của bạn.
                                                    Vui lòng trả lời trung thực để đảm bảo an toàn cho bạn và người nhận
                                                    máu.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                7. <span class="text-info">(*)</span> Bạn có tiền sử bệnh tim mạch
                                                không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="heart_disease" value="yes" id="heart_disease_yes"
                                                        required>
                                                    <label class="form-check-label" for="heart_disease_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="heart_disease"
                                                        value="no" id="heart_disease_no">
                                                    <label class="form-check-label" for="heart_disease_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text text-info">Bao gồm: rối loạn nhịp tim, bệnh van tim,
                                                đau thắt ngực, nhồi máu cơ tim, v.v.</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                8. <span class="text-info">(*)</span> Bạn có mắc bệnh tiểu đường không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="diabetes" value="yes" id="diabetes_yes" required>
                                                    <label class="form-check-label" for="diabetes_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="diabetes"
                                                        value="no" id="diabetes_no">
                                                    <label class="form-check-label" for="diabetes_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                9. <span class="text-info">(*)</span> Bạn có mắc bệnh gan như viêm gan
                                                B/C không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="hepatitis" value="yes" id="hepatitis_yes" required>
                                                    <label class="form-check-label" for="hepatitis_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="hepatitis"
                                                        value="no" id="hepatitis_no">
                                                    <label class="form-check-label" for="hepatitis_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                10. <span class="text-info">(*)</span> Bạn có từng xét nghiệm dương tính
                                                với HIV không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="hiv" value="yes" id="hiv_yes" required>
                                                    <label class="form-check-label" for="hiv_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio" name="hiv" value="no"
                                                        id="hiv_no">
                                                    <label class="form-check-label" for="hiv_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text">Thông tin này được bảo mật nghiêm ngặt</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Thông tin bổ sung -->
                        <div class="card mb-4 question-card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom border-info border-2">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-clipboard-list text-info me-2"></i>Thông tin bổ sung
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                11. <span class="text-info">(*)</span> Trong 6 tháng qua, bạn có phẫu
                                                thuật hoặc xăm hình không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input critical-question" type="radio"
                                                        name="surgery_or_tattoo" value="yes" id="surgery_or_tattoo_yes"
                                                        required>
                                                    <label class="form-check-label" for="surgery_or_tattoo_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio"
                                                        name="surgery_or_tattoo" value="no" id="surgery_or_tattoo_no">
                                                    <label class="form-check-label" for="surgery_or_tattoo_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text text-info">Phẫu thuật hoặc xăm hình trong 6 tháng qua
                                                có thể ảnh hưởng đến khả năng hiến máu.</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group question-item">
                                            <label class="form-label fw-medium">
                                                12. <span class="text-info">(*)</span> Nữ giới: Bạn có đang mang thai
                                                hoặc cho con bú không?
                                            </label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input gender-specific critical-question"
                                                        type="radio" name="pregnant_or_nursing" value="yes"
                                                        id="pregnant_yes">
                                                    <label class="form-check-label" for="pregnant_yes">
                                                        <span class="response-icon"><i class="fas fa-check"></i></span>
                                                        <span>Có</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input gender-specific" type="radio"
                                                        name="pregnant_or_nursing" value="no" id="pregnant_no">
                                                    <label class="form-check-label" for="pregnant_no">
                                                        <span class="response-icon"><i class="fas fa-times"></i></span>
                                                        <span>Không</span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline custom-radio-btn">
                                                    <input class="form-check-input" type="radio"
                                                        name="pregnant_or_nursing" value="na" id="pregnant_na">
                                                    <label class="form-check-label" for="pregnant_na">
                                                        <span class="response-icon"><i class="fas fa-minus"></i></span>
                                                        <span>Không áp dụng (Nam)</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-text text-info">Phụ nữ đang mang thai hoặc đang cho con bú
                                                không nên hiến máu.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Xác nhận và nút gửi -->
                        <div class="card mb-4 border-0 shadow-sm">
                            <div class="card-body p-4">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="confirmation"
                                        id="confirmCheck" required>
                                    <label class="form-check-label ps-2" for="confirmCheck">
                                        <span class="fw-medium">Xác nhận:</span> Tôi xác nhận rằng tất cả thông tin tôi
                                        cung cấp là đúng sự thật và chính xác.
                                        Tôi hiểu rằng việc cung cấp thông tin không chính xác có thể ảnh hưởng đến sức
                                        khỏe của tôi và người nhận máu.
                                    </label>
                                    <div class="invalid-feedback">Bạn phải xác nhận thông tin trước khi tiếp tục.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Phần nút điều hướng -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-outline-secondary px-4 py-2">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                            </a>
                            <button type="submit" class="btn btn-info px-4 py-2 d-flex align-items-center">
                                <span>Hoàn tất và tiếp tục</span>
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="alert alert-info d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-exclamation-circle fa-3x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading fw-bold">Không tìm thấy thông tin!</h5>
                            <p>Không tìm thấy thông tin sự kiện. Vui lòng quay lại và thử lại.</p>
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-info mt-2">
                                <i class="fas fa-undo me-2"></i>Quay lại danh sách sự kiện
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thêm modal thông báo -->
<div class="modal fade" id="validationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header border-0 bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Thông báo quan trọng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body py-4" id="validationModalBody">
                <p>Dựa trên câu trả lời của bạn, có thể bạn không đủ điều kiện để hiến máu lúc này.</p>
                <p>Vui lòng liên hệ với nhân viên y tế để được tư vấn thêm.</p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Thêm CSS tùy chỉnh -->
<style>
/* Card styles */
.question-card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
}

.question-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.event-info-card {
    border-left: 4px solid #3879d1 !important;
    border-radius: 0.5rem;
    overflow: hidden;
}

/* Custom radio buttons */
.custom-radio-btn {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 8px 16px;
    margin-right: 10px;
    transition: all 0.2s ease;
    border: 1px solid #dee2e6;
}

.custom-radio-btn:hover {
    background-color: #e9ecef;
}

.custom-radio-btn input:checked~label {
    font-weight: 500;
}

.custom-radio-btn input[value="yes"]:checked~label {
    color: #198754;
}

.custom-radio-btn input[value="no"]:checked~label {
    color: #dc3545;
}

.custom-radio-btn input[value="na"]:checked~label {
    color: #6c757d;
}

.response-icon {
    display: inline-block;
    width: 24px;
    height: 24px;
    line-height: 24px;
    text-align: center;
    background: #fff;
    border-radius: 50%;
    margin-right: 8px;
}

input[value="yes"]:checked~label .response-icon {
    background-color: #198754;
    color: white;
}

input[value="no"]:checked~label .response-icon {
    background-color: #dc3545;
    color: white;
}

input[value="na"]:checked~label .response-icon {
    background-color: #6c757d;
    color: white;
}

/* Custom checkbox */
.custom-checkbox .form-check-input {
    width: 1.5em;
    height: 1.5em;
}

.custom-checkbox .form-check-label {
    padding-top: 0.2em;
}

.custom-checkbox .form-check-input:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}

.form-check-input:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

/* Progress bar animation */
@keyframes progress-animation {
    0% {
        width: 0%;
    }

    100% {
        width: 50%;
    }
}

.progress-bar {
    animation: progress-animation 1.5s ease-in-out;
}

/* Question highlight animation */
.question-item {
    position: relative;
    padding: 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.question-item:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

/* Critical questions marker */
.critical-question:checked[value="yes"]~.form-text {
    color: #dc3545 !important;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .custom-radio-btn {
        padding: 6px 12px;
    }

    .donation-date-container {
        margin-top: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('prescreeningForm');

    if (form) {
        // Bootstrap validation
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');

            // Validate critical questions
            const criticalQuestions = document.querySelectorAll(
                '.critical-question[value="yes"]:checked');
            if (criticalQuestions.length > 0) {
                // Show modal with warning
                const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));

                let warningMessages =
                    '<p>Dựa trên câu trả lời của bạn cho các câu hỏi sau, có thể bạn không đủ điều kiện hiến máu:</p><ul>';

                criticalQuestions.forEach(question => {
                    const questionLabel = question.closest('.form-group').querySelector(
                        '.form-label').textContent.trim();
                    warningMessages += `<li>${questionLabel.substring(3)}</li>`;
                });

                warningMessages +=
                    '</ul><p>Bạn vẫn có thể tiếp tục quy trình, nhưng hãy lưu ý rằng bạn có thể không đủ điều kiện khi đến địa điểm hiến máu.</p>';

                document.getElementById('validationModalBody').innerHTML = warningMessages;

                // Hiển thị modal
                event.preventDefault();
                validationModal.show();

                // Khi đóng modal, người dùng có thể tiếp tục submit form
                document.querySelector('#validationModal .btn-secondary').addEventListener('click',
                    function() {
                        form.submit();
                    });
            }
        });
    }

    // Toggle donation date field visibility
    const donatedBeforeRadios = document.querySelectorAll('input[name="donated_before"]');
    const donationDateContainer = document.querySelector('.donation-date-container');

    if (donatedBeforeRadios.length > 0 && donationDateContainer) {
        donatedBeforeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'yes') {
                    donationDateContainer.classList.remove('d-none');
                    donationDateContainer.classList.add('fade');
                    setTimeout(() => {
                        donationDateContainer.classList.add('show');
                    }, 50);
                } else {
                    donationDateContainer.classList.remove('show');
                    setTimeout(() => {
                        donationDateContainer.classList.add('d-none');
                    }, 300);
                }
            });

            // Check initial state
            if (radio.checked && radio.value === 'yes') {
                donationDateContainer.classList.remove('d-none');
            }
        });
    }

    // Toggle medication details field visibility
    const medicationRadios = document.querySelectorAll('input[name="medication"]');
    const medicationDetails = document.querySelector('.medication-details');

    if (medicationRadios.length > 0 && medicationDetails) {
        medicationRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'yes') {
                    medicationDetails.classList.remove('d-none');
                    medicationDetails.classList.add('fade');
                    setTimeout(() => {
                        medicationDetails.classList.add('show');
                    }, 50);
                } else {
                    medicationDetails.classList.remove('show');
                    setTimeout(() => {
                        medicationDetails.classList.add('d-none');
                    }, 300);
                }
            });

            // Check initial state
            if (radio.checked && radio.value === 'yes') {
                medicationDetails.classList.remove('d-none');
            }
        });
    }

    // Handle gender-specific questions
    const maleRadio = document.createElement('input');
    maleRadio.type = 'radio';
    maleRadio.name = 'gender';
    maleRadio.value = 'male';
    maleRadio.id = 'gender_male';
    maleRadio.className = 'form-check-input';

    const femaleRadio = document.createElement('input');
    femaleRadio.type = 'radio';
    femaleRadio.name = 'gender';
    femaleRadio.value = 'female';
    femaleRadio.id = 'gender_female';
    femaleRadio.className = 'form-check-input';

    const formFirstSection = document.querySelector('.question-card');
    const genderFieldset = document.createElement('div');
    genderFieldset.className = 'col-md-6';
    genderFieldset.innerHTML = `
            <div class="form-group question-item">
                <label class="form-label fw-medium">0. Giới tính của bạn là gì? <span class="text-info">*</span></label>
                <div class="d-flex mt-2">
                    <div class="form-check form-check-inline custom-radio-btn">
                        <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" required>
                        <label class="form-check-label" for="gender_male">
                            <span class="response-icon"><i class="fas fa-mars"></i></span>
                            <span>Nam</span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline custom-radio-btn">
                        <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                        <label class="form-check-label" for="gender_female">
                            <span class="response-icon"><i class="fas fa-venus"></i></span>
                            <span>Nữ</span>
                        </label>
                    </div>
                </div>
                <div class="invalid-feedback">Vui lòng chọn giới tính của bạn</div>
            </div>
        `;

    if (formFirstSection && formFirstSection.querySelector('.card-body .row')) {
        formFirstSection.querySelector('.card-body .row').prepend(genderFieldset);
    }

    // Toggle pregnancy field based on gender
    const genderRadios = document.querySelectorAll('input[name="gender"]');
    const pregnancyRadios = document.querySelectorAll('input[name="pregnant_or_nursing"]');
    const pregnancyNaRadio = document.getElementById('pregnant_na');
    const genderSpecificRadios = document.querySelectorAll('.gender-specific');

    if (genderRadios.length > 0 && pregnancyNaRadio) {
        genderRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'male') {
                    pregnancyNaRadio.checked = true;
                    genderSpecificRadios.forEach(r => {
                        r.disabled = true;
                        r.closest('.custom-radio-btn').classList.add('text-muted');
                    });
                } else {
                    pregnancyNaRadio.checked = false;
                    genderSpecificRadios.forEach(r => {
                        r.disabled = false;
                        r.closest('.custom-radio-btn').classList.remove('text-muted');
                    });
                }
            });

            // Check initial state
            if (radio.checked && radio.value === 'male') {
                pregnancyNaRadio.checked = true;
                genderSpecificRadios.forEach(r => {
                    r.disabled = true;
                    r.closest('.custom-radio-btn').classList.add('text-muted');
                });
            }
        });
    }

    // Animate questions on scroll
    const animateOnScroll = () => {
        const questionCards = document.querySelectorAll('.question-card');

        questionCards.forEach(card => {
            const cardTop = card.getBoundingClientRect().top;
            const triggerPoint = window.innerHeight * 0.9;

            if (cardTop < triggerPoint) {
                card.classList.add('animated');
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }
        });
    };

    // Initial setup for animation
    document.querySelectorAll('.question-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `all 0.5s ease ${index * 0.1}s`;
    });

    // Trigger animations
    setTimeout(animateOnScroll, 100);
    window.addEventListener('scroll', animateOnScroll);

    // Add smooth scrolling to form sections
    document.querySelectorAll('.card-header').forEach(header => {
        header.addEventListener('click', function() {
            const cardBody = this.nextElementSibling;

            if (cardBody.style.maxHeight) {
                cardBody.style.maxHeight = null;
                this.querySelector('i').classList.replace('fa-chevron-up', 'fa-chevron-down');
            } else {
                cardBody.style.maxHeight = cardBody.scrollHeight + "px";
                this.querySelector('i').classList.replace('fa-chevron-down', 'fa-chevron-up');
            }
        });
    });
}); // Handle gender-specific questions
const maleRadio = document.createElement('input');
maleRadio.type = 'radio';
maleRadio.name = 'gender';
maleRadio.value = 'male';
maleRadio.id = 'gender_male';
maleRadio.className = 'form-check-input';

const femaleRadio = document.createElement('input');
femaleRadio.type = 'radio';
femaleRadio.name = 'gender';
femaleRadio.value = 'female';
femaleRadio.id = 'gender_female';
femaleRadio.className = 'form-check-input';

const formFirstSection = document.querySelector('.row.mb-4');
const genderFieldset = document.createElement('div');
genderFieldset.className = 'col-md-6 mb-3';
genderFieldset.innerHTML = `
        <label class="form-label">Giới tính <span class="text-info">*</span></label>
        <div class="d-flex">
            <div class="form-check me-3">
                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" required>
                <label class="form-check-label" for="gender_male">Nam</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                <label class="form-check-label" for="gender_female">Nữ</label>
            </div>
        </div>
    `;

if (formFirstSection) {
    formFirstSection.appendChild(genderFieldset);
}

// Toggle pregnancy field based on gender
const genderRadios = document.querySelectorAll('input[name="gender"]');
const pregnancyRadios = document.querySelectorAll('input[name="pregnant_or_nursing"]');
const pregnancyNaRadio = document.getElementById('pregnant_na');
const genderSpecificRadios = document.querySelectorAll('.gender-specific');

genderRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'male') {
            pregnancyNaRadio.checked = true;
            genderSpecificRadios.forEach(r => {
                r.disabled = true;
            });
        } else {
            pregnancyNaRadio.checked = false;
            genderSpecificRadios.forEach(r => {
                r.disabled = false;
            });
        }
    });
});

// Form validation
const form = document.getElementById('prescreeningForm');

form.addEventListener('submit', function(event) {
const isOver18 = document.querySelector('input[name="age_requirement"]:checked')?.value;
const weightOver50kg = document.querySelector('input[name="weight_requirement"]:checked')
    ?.value;
const feelingWell = document.querySelector('input[name="feeling_well"]:checked')?.value;
const gender = document.querySelector('input[name="gender"]:checked')?.value;

// Validate gender selection
if (!gender) {
    event.preventDefault();
    alert('Vui lòng chọn giới tính của bạn.');
    return;
}

// Validate pregnancy question for females
if (gender === 'female') {
    const pregnancySelected = [...pregnancyRadios].some(radio => radio.checked);
    if (!pregnancySelected) {
        event.preventDefault();
        alert('Vui lòng trả lời câu hỏi về thai kỳ.');
        return;
    }
}

// Basic eligibility check
if (isOver18 === 'no' || weightOver50kg === 'no' || feelingWell === 'no') {
    event.preventDefault();
    alert(
        'Rất tiếc, bạn không đủ điều kiện cơ bản để hiến máu. Vui lòng liên hệ nhân viên y tế để biết thêm chi tiết.'
    );
}
});
});
</script>