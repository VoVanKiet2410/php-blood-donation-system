<?php
// Define the content function that will be used in the layout
$content = function () {
?>
    <style>
        :root {
            --accent-purple: #8e44ad;
            --accent-pink: #e84393;
            --blood-red: #e74c3c;
            --blood-dark: #c0392b;
        }

        .blood-type-badge {
            padding: 8px 16px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .blood-type-A {
            background: linear-gradient(120deg, #4caf50, #2e7d32);
        }

        .blood-type-B {
            background: linear-gradient(120deg, #2196f3, #1565c0);
        }

        .blood-type-AB {
            background: linear-gradient(120deg, #9c27b0, #6a1b9a);
        }

        .blood-type-O {
            background: linear-gradient(120deg, #e74c3c, #c0392b);
        }

        .ant-form-item {
            margin-bottom: 24px;
        }

        .ant-form-item-label {
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }

        .custom-input {
            border-radius: 8px !important;
            border-color: #e2e8f0 !important;
            padding: 8px 16px !important;
            transition: all 0.3s ease !important;
        }

        .custom-input:hover {
            border-color: var(--blood-red) !important;
            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.1) !important;
        }

        .custom-input:focus {
            border-color: var(--blood-red) !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15) !important;
        }

        .custom-select {
            border-radius: 8px !important;
            border-color: #e2e8f0 !important;
            padding: 8px 16px !important;
            transition: all 0.3s ease !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23718096' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .custom-select:hover {
            border-color: var(--blood-red) !important;
            box-shadow: 0 2px 4px rgba(231, 76, 60, 0.1) !important;
        }

        .custom-select:focus {
            border-color: var(--blood-red) !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15) !important;
        }

        /* Input focus animation */
        .input-focused .ant-form-item-label label {
            color: var(--blood-red);
        }

        .ant-btn-primary {
            background: linear-gradient(120deg, var(--blood-red), var(--blood-dark)) !important;
            border: none !important;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3) !important;
            transition: all 0.3s ease !important;
        }

        .ant-btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4) !important;
        }

        .ant-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .blood-preview {
            width: 120px;
            height: 120px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 100%;
            font-size: 36px;
            font-weight: bold;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .blood-type-help {
            border-radius: 8px;
            background-color: rgba(231, 76, 60, 0.1);
            padding: 15px;
            margin-top: 20px;
        }

        .blood-type-help h6 {
            color: var(--blood-red);
            margin-bottom: 10px;
        }

        .blood-type-help ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .blood-type-help li {
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
    </style>

    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded"
            style="background: linear-gradient(120deg, #e74c3c, #c0392b); padding: 24px; color: white;">
            <div class="d-flex align-items-center">
                <a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=index"
                    class="text-decoration-none text-white me-2">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h4 class="mb-0 text-white">Thêm Mới Kho Máu</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Thêm một bản ghi mới vào kho máu</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="ant-card mb-4" style="border-top: 3px solid #e74c3c;">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: #e74c3c;"><i class="fas fa-flask me-2"></i>Thông Tin Kho Máu</h5>

                        <form action="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=store" method="POST">
                            <!-- Blood Type -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="ant-form-item">
                                        <div class="ant-form-item-label">
                                            <label for="bloodType" class="form-label"><i class="fas fa-tint me-2"></i>Nhóm
                                                Máu <span class="text-danger">*</span></label>
                                        </div>
                                        <select id="bloodType" name="bloodType" class="form-select custom-select" required
                                            onchange="updatePreview()">
                                            <option value="" disabled selected>Chọn nhóm máu</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="ant-form-item">
                                        <div class="ant-form-item-label">
                                            <label for="quantity" class="form-label"><i class="fas fa-fill-drip me-2"></i>Số
                                                Lượng (đơn vị) <span class="text-danger">*</span></label>
                                        </div>
                                        <input type="number" id="quantity" name="quantity" class="form-control custom-input"
                                            required min="1" max="1000">
                                    </div>
                                </div>
                            </div>

                            <!-- Dates -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="ant-form-item">
                                        <div class="ant-form-item-label">
                                            <label for="expirationDate" class="form-label"><i
                                                    class="fas fa-calendar-alt me-2"></i>Ngày Hết Hạn <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <input type="date" id="expirationDate" name="expirationDate"
                                            class="form-control custom-input" required min="<?= date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="ant-form-item">
                                <div class="ant-form-item-label">
                                    <label for="notes" class="form-label"><i class="fas fa-sticky-note me-2"></i>Ghi
                                        Chú</label>
                                </div>
                                <textarea id="notes" name="notes" class="form-control custom-input" rows="3"
                                    placeholder="Nhập ghi chú về kho máu này nếu cần"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-4">
                                <a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=index"
                                    class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-times me-1"></i> Hủy
                                </a>
                                <button type="submit" class="btn btn-primary ant-btn-primary">
                                    <i class="fas fa-save me-1"></i> Lưu Kho Máu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Blood Type Preview -->
                <div class="ant-card mb-4">
                    <div class="card-body p-4 text-center">
                        <h5 class="mb-4" style="color: #e74c3c;"><i class="fas fa-eye me-2"></i>Xem Trước</h5>

                        <div id="bloodPreview" class="blood-preview mb-3"
                            style="background: linear-gradient(120deg, #718096, #4a5568);">
                            ?
                        </div>

                        <h4 id="bloodTypeDisplay">Chọn nhóm máu</h4>
                        <p id="compatibilityInfo" class="text-muted">Chọn nhóm máu để xem khả năng phù hợp</p>
                    </div>
                </div>

                <!-- Blood Type Information -->
                <div class="ant-card">
                    <div class="card-body p-4">
                        <h5 class="mb-3" style="color: #e74c3c;"><i class="fas fa-info-circle me-2"></i>Thông Tin Nhóm Máu
                        </h5>

                        <div class="blood-type-help">
                            <h6><i class="fas fa-lightbulb me-2"></i>Hướng dẫn nhanh</h6>
                            <ul>
                                <li>Nhóm máu O- là người cho phổ quát</li>
                                <li>Nhóm máu AB+ là người nhận phổ quát</li>
                                <li>Bệnh nhân tốt nhất nên nhận được máu cùng nhóm</li>
                                <li>Đơn vị máu thường có thời hạn 42 ngày nếu được lưu trữ đúng cách</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add subtle animation effects
            const inputs = document.querySelectorAll('.custom-input, .custom-select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.ant-form-item').classList.add('input-focused');
                });

                input.addEventListener('blur', function() {
                    this.closest('.ant-form-item').classList.remove('input-focused');
                });
            });

            // Set default expiration date to 42 days from now (typical blood shelf life)
            const expirationDate = document.getElementById('expirationDate');
            const today = new Date();
            const defaultExpiration = new Date();
            defaultExpiration.setDate(today.getDate() + 42);

            const year = defaultExpiration.getFullYear();
            let month = defaultExpiration.getMonth() + 1;
            let day = defaultExpiration.getDate();

            // Ensure month and day are 2 digits
            month = month < 10 ? '0' + month : month;
            day = day < 10 ? '0' + day : day;

            expirationDate.value = `${year}-${month}-${day}`;
        });

        function updatePreview() {
            const bloodType = document.getElementById('bloodType').value;
            const bloodPreview = document.getElementById('bloodPreview');
            const bloodTypeDisplay = document.getElementById('bloodTypeDisplay');
            const compatibilityInfo = document.getElementById('compatibilityInfo');

            bloodTypeDisplay.textContent = bloodType || "Chọn nhóm máu";

            // Reset classes
            bloodPreview.className = 'blood-preview mb-3';

            if (!bloodType) {
                bloodPreview.textContent = "?";
                bloodPreview.style.background = "linear-gradient(120deg, #718096, #4a5568)";
                compatibilityInfo.textContent = "Chọn nhóm máu để xem khả năng phù hợp";
                return;
            }

            bloodPreview.textContent = bloodType;

            // Set appropriate styling based on blood type
            if (bloodType.includes('AB')) {
                bloodPreview.style.background = "linear-gradient(120deg, #9c27b0, #6a1b9a)";
                compatibilityInfo.textContent = bloodType.includes('+') ?
                    "Người nhận phổ quát - Có thể nhận tất cả nhóm máu" :
                    "Có thể nhận từ: AB-, A-, B-, O-";
            } else if (bloodType.includes('A')) {
                bloodPreview.style.background = "linear-gradient(120deg, #4caf50, #2e7d32)";
                compatibilityInfo.textContent = bloodType.includes('+') ?
                    "Có thể nhận từ: A+, A-, O+, O-" :
                    "Có thể nhận từ: A-, O-";
            } else if (bloodType.includes('B')) {
                bloodPreview.style.background = "linear-gradient(120deg, #2196f3, #1565c0)";
                compatibilityInfo.textContent = bloodType.includes('+') ?
                    "Có thể nhận từ: B+, B-, O+, O-" :
                    "Có thể nhận từ: B-, O-";
            } else if (bloodType.includes('O')) {
                bloodPreview.style.background = "linear-gradient(120deg, #e74c3c, #c0392b)";
                compatibilityInfo.textContent = bloodType.includes('-') ?
                    "Người cho phổ quát - Có thể cho tất cả nhóm máu" :
                    "Có thể nhận từ: O+, O-";
            }
        }
    </script>
<?php
};

// Include the Admin Layout (blood inventory is typically managed by admins)
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>