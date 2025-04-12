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
        <div class="col-md-10">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Câu hỏi sàng lọc trước khi hiến máu</h3>
                    <p class="mb-0">Để đảm bảo sức khỏe của bạn và chất lượng máu hiến tặng, vui lòng trả lời các câu
                        hỏi sau</p>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if ($event): ?>
                    <div class="mb-4 p-3 bg-light rounded">
                        <h5 class="text-primary mb-2">Thông tin sự kiện</h5>
                        <p class="mb-1"><strong>Tên sự kiện:</strong> <?= htmlspecialchars($event['name']) ?></p>
                        <p class="mb-1"><strong>Ngày diễn ra:</strong>
                            <?= date('d/m/Y', strtotime($event['event_date'])) ?></p>
                        <p class="mb-1"><strong>Thời gian:</strong>
                            <?= date('H:i', strtotime($event['event_start_time'])) ?> -
                            <?= date('H:i', strtotime($event['event_end_time'])) ?></p>
                        <p class="mb-0"><strong>Địa điểm:</strong>
                            <?php if (isset($event['donation_unit']) && isset($event['donation_unit']['location'])): ?>
                            <?= htmlspecialchars($event['donation_unit']['location']) ?>
                            <?php else: ?>
                            Không có thông tin
                            <?php endif; ?>
                        </p>
                    </div>
                    <form action="<?= BASE_URL ?>/public/index.php?controller=Event&action=validatePreScreening"
                        method="POST" id="prescreeningForm">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">

                        <div class="alert alert-info">
                            <p><strong>Lưu ý:</strong> Trả lời "Có" cho các câu hỏi có đánh dấu (*) có thể ảnh hưởng đến
                                khả năng hiến máu của bạn. Vui lòng trả lời trung thực để đảm bảo an toàn.</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Thông tin chung</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">1. Bạn đã từng hiến máu trước đây chưa?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="donated_before" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="donated_before" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 donation-date-container d-none">
                                <label class="form-label">Thời gian hiến máu gần nhất?</label>
                                <input type="date" class="form-control" name="last_donation_date">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Tiêu chuẩn cơ bản</h5>
                            </div>

                            <div class="col-md-6 mb-3"> <label class="form-label">2. Bạn có đủ 18 tuổi không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="age_requirement" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="age_requirement" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3"> <label class="form-label">3. Bạn có cân nặng trên 50kg
                                    không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="weight_requirement"
                                            value="yes" required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="weight_requirement"
                                            value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Tình trạng sức khỏe hiện tại</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">4. Bạn có khỏe mạnh và cảm thấy tốt hôm nay không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="feeling_well" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="feeling_well" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">5. (*) Bạn có đang mắc bệnh cảm, cúm hoặc sốt không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="recent_fever" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="recent_fever" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">6. (*) Bạn có đang dùng bất kỳ loại thuốc nào không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="medication" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="medication" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 medication-details d-none">
                                <label class="form-label">Vui lòng liệt kê các loại thuốc:</label>
                                <textarea class="form-control" name="medication_details" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Tiền sử bệnh lý</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">7. (*) Bạn có tiền sử bệnh tim mạch không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="heart_disease" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="heart_disease" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">8. (*) Bạn có mắc bệnh tiểu đường không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="diabetes" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="diabetes" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">9. (*) Bạn có mắc bệnh gan như viêm gan B/C không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="hepatitis" value="yes"
                                            required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hepatitis" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">10. (*) Bạn có từng xét nghiệm dương tính với HIV
                                    không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="hiv" value="yes" required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="hiv" value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 text-primary">Thông tin bổ sung</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">11. (*) Trong 6 tháng qua, bạn có phẫu thuật hoặc xăm hình
                                    không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="surgery_or_tattoo"
                                            value="yes" required>
                                        <label class="form-check-label">Có</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="surgery_or_tattoo"
                                            value="no">
                                        <label class="form-check-label">Không</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">12. (*) Nữ giới: Bạn có đang mang thai hoặc cho con bú
                                    không?</label>
                                <div class="d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input gender-specific" type="radio"
                                            name="pregnant_or_nursing" value="yes" id="pregnant_yes">
                                        <label class="form-check-label" for="pregnant_yes">Có</label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input gender-specific" type="radio"
                                            name="pregnant_or_nursing" value="no" id="pregnant_no">
                                        <label class="form-check-label" for="pregnant_no">Không</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pregnant_or_nursing"
                                            value="na" id="pregnant_na">
                                        <label class="form-check-label" for="pregnant_na">Không áp dụng (Nam)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="confirmation"
                                        id="confirmCheck" required>
                                    <label class="form-check-label" for="confirmCheck">
                                        Tôi xác nhận rằng tất cả thông tin tôi cung cấp là đúng sự thật và chính xác.
                                        Tôi hiểu rằng việc cung cấp thông tin không chính xác có thể ảnh hưởng đến sức
                                        khỏe của tôi và người nhận máu.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-4">
                            <a href="<?= BASE_URL ?>/public/index.php?controller=Event&action=clientIndex"
                                class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách sự kiện
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                Hoàn tất sàng lọc và tiếp tục <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                    <?php else: ?>
                    <div class="alert alert-danger">
                        <h5>Lỗi!</h5>
                        <p>Không tìm thấy thông tin sự kiện. Vui lòng quay lại và thử lại.</p>
                        <a href="<?= BASE_URL ?>/public/index.php?controller=Event&action=clientIndex"
                            class="btn btn-outline-primary mt-2">
                            Quay lại danh sách sự kiện
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle donation date field visibility
    const donatedBeforeRadios = document.querySelectorAll('input[name="donated_before"]');
    const donationDateContainer = document.querySelector('.donation-date-container');

    donatedBeforeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'yes') {
                donationDateContainer.classList.remove('d-none');
            } else {
                donationDateContainer.classList.add('d-none');
            }
        });
    });

    // Toggle medication details field visibility
    const medicationRadios = document.querySelectorAll('input[name="medication"]');
    const medicationDetails = document.querySelector('.medication-details');

    medicationRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'yes') {
                medicationDetails.classList.remove('d-none');
            } else {
                medicationDetails.classList.add('d-none');
            }
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
        <label class="form-label">Giới tính <span class="text-danger">*</span></label>
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