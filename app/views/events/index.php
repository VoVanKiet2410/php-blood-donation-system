<?php
// Define any constants needed
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}

/**
 * Format date to a more readable format
 * @param string $date Date in Y-m-d format
 * @return string Formatted date
 */
function formatDate($date)
{
    if (empty($date)) return 'N/A';
    $dateObj = new DateTime($date);
    return $dateObj->format('d/m/Y');
}

/**
 * Format time to a more readable format
 * @param string $time Time in H:i:s format
 * @return string Formatted time without seconds
 */
function formatTime($time)
{
    if (empty($time)) return 'N/A';
    $timeObj = new DateTime($time);
    return $timeObj->format('H:i');
}

/**
 * Calculate progress percentage for registration
 * @param int $current Current registrations
 * @param int $max Maximum registrations
 * @return int Percentage filled
 */
function calculateProgress($current, $max)
{
    if ($max <= 0) return 0;
    return min(round(($current / $max) * 100), 100);
}
?>

<!-- Hero Banner Section -->

<div class="container-fluid py-4">
    <div class="hero-banner bg-info text-white mb-4 rounded-3 overflow-hidden shadow position-relative">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">Hiến Máu Cứu Người</h1>
                    <p class="lead mb-4">Mỗi lần hiến máu có thể cứu sống 3 người. Hãy tham gia cùng chúng tôi trong
                        sứ mệnh cao cả này!</p>
                    <div class="d-flex gap-3 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded-circle p-2 me-2">
                                <i class="fas fa-tint text-info fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="fs-5 mb-0">450ml</h3>
                                <p class="mb-0 small text-white-50">Lượng máu hiến tặng</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-white rounded-circle p-2 me-2">
                                <i class="fas fa-clock text-info fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="fs-5 mb-0">30-45 phút</h3>
                                <p class="mb-0 small text-white-50">Thời gian thực hiện</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="<?= BASE_URL ?>/images/event-index-hero.png" alt="Blood Donation Hero"
                        class="img-fluid hero-image" style="max-height: 300px;">
                </div>
            </div>
        </div>
        <!-- Decorative elements -->
        <div class="position-absolute top-0 end-0 translate-middle-y d-none d-lg-block">
            <svg width="200" height="200" viewBox="0 0 200 200"></svg>
        </div>
    </div>

    <div class="container py-3">
        <!-- Info Cards Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center hover-card">
                    <div class="card-body">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-heartbeat text-info fa-3x"></i>
                        </div>
                        <h3 class="fs-5 mb-3">Cứu Sống Người Khác</h3>
                        <p class="text-muted">Máu của bạn giúp cứu sống những bệnh nhân trong tình trạng nguy kịch,
                            phẫu thuật và các tai nạn.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center hover-card">
                    <div class="card-body">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-medkit text-info fa-3x"></i>
                        </div>
                        <h3 class="fs-5 mb-3">Kiểm Tra Sức Khỏe Miễn Phí</h3>
                        <p class="text-muted">Bạn sẽ được kiểm tra nhóm máu, huyết áp và một số chỉ số sức khỏe khác
                            khi tham gia hiến máu.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center hover-card">
                    <div class="card-body">
                        <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                            style="width: 80px; height: 80px;">
                            <i class="fas fa-hand-holding-heart text-info fa-3x"></i>
                        </div>
                        <h3 class="fs-5 mb-3">Hành Động Nhân Ái</h3>
                        <p class="text-muted">Hiến máu là một hành động cao đẹp thể hiện tinh thần "tương thân tương
                            ái" trong cộng đồng.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="card border-0 shadow mb-5">
            <div class="card-header bg-white py-3 border-0">
                <h2 class="fs-4 mb-0">Tìm Kiếm Sự Kiện Hiến Máu</h2>
            </div>
            <div class="card-body">
                <form action="<?= BASE_URL ?>/index.php" method="get" class="mb-0">
                    <input type="hidden" name="controller" value="Event">
                    <input type="hidden" name="action" value="clientIndex">

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                <i class="fas fa-calendar-alt text-info me-2"></i>Từ ngày
                            </label>
                            <input type="date" class="form-control" name="startDate"
                                value="<?= $_GET['startDate'] ?? '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                <i class="fas fa-calendar-alt text-info me-2"></i>Đến ngày
                            </label>
                            <input type="date" class="form-control" name="endDate"
                                value="<?= $_GET['endDate'] ?? '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">
                                <i class="fas fa-hospital text-info me-2"></i>Đơn vị hiến máu
                            </label>
                            <select name="unitId" class="form-select">
                                <option value="">Tất cả đơn vị</option>
                                <?php foreach ($donationUnits as $unit): ?>
                                    <option value="<?= $unit->id ?>"
                                        <?= (isset($_GET['unitId']) && $_GET['unitId'] == $unit->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($unit->name) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex gap-2 mb-3 mb-md-0">
                            <button type="button" class="btn btn-outline-info px-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Gần tôi
                            </button>
                            <button type="button" class="btn btn-outline-info px-4">
                                <i class="fas fa-star me-2"></i>Đề xuất
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info px-4">
                                <i class="fas fa-search me-2"></i>Tìm kiếm
                            </button>
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-sync-alt me-2"></i>Đặt lại
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Events Section -->
        <div class="card border-0 shadow">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h2 class="fs-4 mb-0">Sự Kiện Hiến Máu</h2>
                <?php if (!empty($events)): ?>
                    <span class="badge bg-info rounded-pill"><?= count($events) ?> sự kiện</span>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <?php if (empty($events)): ?>
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="fas fa-calendar-times text-muted fa-4x"></i>
                        </div>
                        <h3 class="fs-5">Không tìm thấy sự kiện phù hợp</h3>
                        <p class="text-muted">Vui lòng thử lại với tiêu chí tìm kiếm khác hoặc liên hệ chúng tôi để biết
                            thêm chi tiết.</p>
                        <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                            class="btn btn-outline-info mt-2">
                            <i class="fas fa-sync-alt me-2"></i>Đặt lại bộ lọc
                        </a>
                    </div>
                <?php else: ?>
                    <div class="event-list">
                        <?php foreach ($currentEvents as $event): ?>
                            <?php
                            // Sử dụng mảng eventStates thay vì thuộc tính của đối tượng event
                            $eventId = $event['id'];
                            $isFull = $eventStates[$eventId]['is_full'] ?? false;
                            $isPast = $eventStates[$eventId]['is_past'] ?? false;
                            $isToday = $eventStates[$eventId]['is_today'] ?? false;
                            $isOngoing = $eventStates[$eventId]['is_ongoing'] ?? false;
                            $canRegister = $eventStates[$eventId]['can_register'] ?? false;
                            $slotsLeft = $eventStates[$eventId]['slots_left'] ?? 0;
                            $progressPercent = $eventStates[$eventId]['progress_percent'] ?? 0;
                            ?>
                            <div
                                class="card event-card mb-3 border-0 <?= $isFull ? 'event-full' : '' ?> <?= $isPast ? 'event-past' : '' ?>">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <!-- Event Date Column -->
                                        <div class="col-md-2 event-date-section">
                                            <div class="text-center p-3">
                                                <div class="event-day fs-1 fw-bold">
                                                    <?= date('d', strtotime($event['event_date'])) ?></div>
                                                <div class="event-month"><?= date('M Y', strtotime($event['event_date'])) ?>
                                                </div>
                                                <div class="event-time mt-2 small">
                                                    <i
                                                        class="far fa-clock me-1"></i><?= formatTime($event['event_start_time']) ?>
                                                    - <?= formatTime($event['event_end_time']) ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Event Details Column -->
                                        <div class="col-md-7 p-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <?php if (isset($event['donation_unit']) && isset($event['donation_unit']['photo_url']) && !empty($event['donation_unit']['photo_url'])): ?>
                                                    <img src="<?= htmlspecialchars($event['donation_unit']['photo_url']) ?>"
                                                        alt="<?= htmlspecialchars($event['donation_unit']['name']) ?>"
                                                        class="me-2 rounded-circle" width="40" height="40">
                                                <?php else: ?>
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="fas fa-hospital text-info"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h5 class="mb-0 fw-bold"><?= htmlspecialchars($event['name']) ?></h5>
                                                    <p class="mb-0 text-muted small">
                                                        <?= htmlspecialchars($event['donation_unit']['name'] ?? 'Không có tên đơn vị') ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-wrap mb-3">
                                                <div class="me-4">
                                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                    <span
                                                        class="small"><?= htmlspecialchars($event['donation_unit']['address'] ?? $event['donation_unit']['location'] ?? 'Không có địa chỉ') ?></span>
                                                </div>
                                                <div>
                                                    <i class="fas fa-users text-info me-1"></i>
                                                    <span class="small fw-bold"><?= $event['current_registrations'] ?></span>
                                                    <span class="small"> / <?= $event['max_registrations'] ?> người đăng
                                                        ký</span>
                                                </div>
                                            </div>

                                            <!-- Progress bar -->
                                            <div class="progress mb-2" style="height: 6px;">
                                                <?php
                                                $progressClass = 'bg-success';
                                                if ($progressPercent > 70) $progressClass = 'bg-warning';
                                                if ($progressPercent > 90) $progressClass = 'bg-danger';
                                                if ($isFull) $progressClass = 'bg-secondary';
                                                ?>
                                                <div class="progress-bar <?= $progressClass ?>" role="progressbar"
                                                    style="width: <?= $progressPercent ?>%"
                                                    aria-valuenow="<?= $progressPercent ?>" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>

                                            <?php if ($isPast): ?>
                                                <span class="badge bg-secondary">Sự kiện đã kết thúc</span>
                                            <?php elseif ($isOngoing): ?>
                                                <span class="badge bg-success">Đang diễn ra</span>
                                            <?php elseif ($isToday): ?>
                                                <span class="badge bg-warning text-dark">Diễn ra hôm nay</span>
                                            <?php elseif ($slotsLeft <= 5 && !$isFull): ?>
                                                <span class="badge bg-warning text-dark">Chỉ còn <?= $slotsLeft ?> chỗ</span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Action Column -->
                                        <div
                                            class="col-md-3 p-3 bg-light d-flex flex-column justify-content-center align-items-center">
                                            <?php if ($isPast): ?>
                                                <div class="text-center mb-2">
                                                    <i class="fas fa-calendar-times fa-2x text-secondary mb-2"></i>
                                                    <p class="text-muted mb-1">Sự kiện đã kết thúc</p>
                                                </div>
                                            <?php elseif ($isFull): ?>
                                                <div class="text-center mb-2">
                                                    <i class="fas fa-users-slash fa-2x text-danger mb-2"></i>
                                                    <p class="text-muted mb-1">Đã đủ số lượng</p>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center mb-3">
                                                    <div class="fw-bold fs-4 text-success mb-1">
                                                        <?= $slotsLeft ?>
                                                    </div>
                                                    <div class="text-muted small">Chỗ còn trống</div>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Action Button -->
                                            <?php if (!$isPast && !$isFull): ?>
                                                <a href="<?= BASE_URL ?>/index.php?controller=Event&action=bookAppointment&id=<?= $event['id'] ?>"
                                                    class="btn btn-danger booking-btn w-100">
                                                    <i class="fas fa-calendar-plus me-2"></i>Đặt lịch
                                                </a>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-outline-secondary w-100 booking-btn disabled">
                                                    <i class="fas fa-calendar-times me-2"></i>Không khả dụng
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination with improved design -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4 d-flex justify-content-center">
                            <ul class="pagination pagination-sm">
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?controller=Event&action=clientIndex&page=<?= $page - 1 ?>&startDate=<?= $_GET['startDate'] ?? '' ?>&endDate=<?= $_GET['endDate'] ?? '' ?>&unitId=<?= $_GET['unitId'] ?? '' ?>"
                                        aria-label="Previous">
                                        <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                                    </a>
                                </li>

                                <?php
                                // Show a limited number of page links
                                $startPage = max(1, $page - 2);
                                $endPage = min($totalPages, $page + 2);

                                // Add first page if needed
                                if ($startPage > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?controller=Event&action=clientIndex&page=1&startDate=' . ($_GET['startDate'] ?? '') . '&endDate=' . ($_GET['endDate'] ?? '') . '&unitId=' . ($_GET['unitId'] ?? '') . '">1</a></li>';
                                    if ($startPage > 2) {
                                        echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                    }
                                }

                                // Main pages
                                for ($i = $startPage; $i <= $endPage; $i++) {
                                    echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                                    <a class="page-link" href="?controller=Event&action=clientIndex&page=' . $i . '&startDate=' . ($_GET['startDate'] ?? '') . '&endDate=' . ($_GET['endDate'] ?? '') . '&unitId=' . ($_GET['unitId'] ?? '') . '">' . $i . '</a>
                                </li>';
                                }

                                // Add last page if needed
                                if ($endPage < $totalPages) {
                                    if ($endPage < $totalPages - 1) {
                                        echo '<li class="page-item disabled"><a class="page-link">...</a></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="?controller=Event&action=clientIndex&page=' . $totalPages . '&startDate=' . ($_GET['startDate'] ?? '') . '&endDate=' . ($_GET['endDate'] ?? '') . '&unitId=' . ($_GET['unitId'] ?? '') . '">' . $totalPages . '</a></li>';
                                }
                                ?>

                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?controller=Event&action=clientIndex&page=<?= $page + 1 ?>&startDate=<?= $_GET['startDate'] ?? '' ?>&endDate=<?= $_GET['endDate'] ?? '' ?>&unitId=<?= $_GET['unitId'] ?? '' ?>"
                                        aria-label="Next">
                                        <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Call to Action Section -->
        <div class="mt-5 mb-4 text-center">
            <div class="card border-0 bg-light shadow-sm">
                <div class="card-body py-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-lg-start text-center">
                            <h2 class="fw-bold mb-3">Hãy là người anh hùng - Cứu sống nhiều người với một giọt máu
                            </h2>
                            <p class="lead mb-0">Chưa tìm thấy sự kiện phù hợp? Đăng ký nhận thông báo khi có sự
                                kiện hiến máu gần bạn!</p>
                        </div>
                        <div class="col-lg-4 mt-3 mt-lg-0 text-center">
                            <a href="#" class="btn btn-info btn-lg px-4 py-3 shadow-sm fw-medium">
                                <i class="fas fa-bell me-2"></i> Đăng ký nhận thông báo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonial Section -->
        <div class="card border-0 shadow mb-5">
            <div class="card-header bg-white py-3 border-0">
                <h2 class="fs-4 mb-0">Câu chuyện từ người hiến máu</h2>
            </div>
            <div class="card-body pb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="testimonial text-center p-3">
                            <div class="testimonial-image mx-auto mb-3">
                                <img src="<?= BASE_URL ?>/images/testimonials/user3.png" alt="Người hiến máu"
                                    class="rounded-circle mx-auto" style="width:80px;height:80px;object-fit:cover;"
                                    onerror="this.src='<?= BASE_URL ?>/images/logo-hutech-short.png'">
                            </div>
                            <p class="mb-3"><i class="fas fa-quote-left text-info me-2 opacity-50"></i>Hiến máu
                                giúp tôi cảm thấy mình đã làm điều gì đó có ý nghĩa. Đặc biệt khi biết rằng máu của mình
                                sẽ
                                cứu sống một ai đó.<i class="fas fa-quote-right text-info ms-2 opacity-50"></i></p>
                            <p class="fw-bold mb-0">Nguyễn Văn A</p>
                            <p class="small text-muted">Đã hiến máu 5 lần</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial text-center p-3">
                            <div class="testimonial-image mx-auto mb-3">
                                <img src="<?= BASE_URL ?>/images/testimonials/user2.png" alt="Người hiến máu"
                                    class="rounded-circle mx-auto" style="width:80px;height:80px;object-fit:cover;"
                                    onerror="this.src='<?= BASE_URL ?>/images/logo-hutech-short.png'">
                            </div>
                            <p class="mb-3"><i class="fas fa-quote-left text-info me-2 opacity-50"></i>Ban đầu tôi
                                lo lắng, nhưng thực sự quá trình hiến máu rất đơn giản và không đau. Các nhân viên y tế
                                rất chu đáo và tận tâm.<i class="fas fa-quote-right text-info ms-2 opacity-50"></i></p>
                            <p class="fw-bold mb-0">Trần Thị B</p>
                            <p class="small text-muted">Người hiến máu lần đầu</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial text-center p-3">
                            <div class="testimonial-image mx-auto mb-3">
                                <img src="<?= BASE_URL ?>/images/testimonials/user1.png" alt="Người hiến máu"
                                    class="rounded-circle mx-auto" style="width:80px;height:80px;object-fit:cover;"
                                    onerror="this.src='<?= BASE_URL ?>/images/logo-hutech-short.png'">
                            </div>
                            <p class="mb-3"><i class="fas fa-quote-left text-info me-2 opacity-50"></i>Tôi hiến
                                máu định kỳ 3 tháng/lần. Đó là cách tôi đóng góp cho cộng đồng mà không tốn quá nhiều
                                thời
                                gian hay công sức.<i class="fas fa-quote-right text-info ms-2 opacity-50"></i></p>
                            <p class="fw-bold mb-0">Lê Văn C</p>
                            <p class="small text-muted">Đã hiến máu 12 lần</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add custom styles -->
<style>
    /* Hero section */
    .hero-banner {
        background: linear-gradient(135deg, #4885ed 0%, #3562a8 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-image {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    /* Event cards */
    .event-card {
        transition: all 0.3s ease;
        background-color: #fff;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .event-date-section {
        position: relative;
        background-color: rgba(220, 53, 69, 0.05);
    }

    .event-full .event-date-section {
        background-color: rgba(108, 117, 125, 0.05);
    }

    .event-full {
        opacity: 0.85;
    }

    .event-past {
        opacity: 0.7;
    }

    /* Hover cards */
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    /* Buttons */
    .booking-btn {
        transition: all 0.3s ease;
    }

    .booking-btn:not(.disabled):hover {
        transform: scale(1.05);
    }

    /* Pagination */
    .pagination .page-link {
        color: #dc3545;
    }

    .pagination .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    /* Testimonials */
    .testimonial {
        transition: all 0.3s ease;
    }

    .testimonial:hover {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
    }

    .testimonial-image {
        position: relative;
    }

    .testimonial-image::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: #dc3545;
        border-radius: 50%;
        bottom: 0;
        right: 35%;
        border: 3px solid white;
    }
</style>