<?php
// Home page for blood donation system

// Get variables from the $data array
$bloodLevels = $data['bloodLevels'] ?? [];
$upcomingEvents = $data['upcomingEvents'] ?? [];
$latestNews = $data['latestNews'] ?? [];
$faqs = $data['faqs'] ?? [];
$donationStats = $data['donationStats'] ?? [
    'totalDonors' => 0,
    'totalUnits' => 0,
    'totalDonations' => 0
];

// Start content section
?>

<!-- Hero Section with Parallax Effect -->
<section class="hero-section">
    <div class="animated-bg"></div>
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                <div class="hero-content-wrapper">
                    <h1 class="hero-title" data-aos="fade-up" data-aos-delay="300">
                        <span class="hero-title-highlight">Mỗi giọt máu</span> hiến tặng, một <span
                            class="hero-title-accent">cuộc đời</span> được cứu
                    </h1>
                    <p class="hero-description mt-4 mb-4" data-aos="fade-up" data-aos-delay="400">
                        Hành động giản đơn của bạn hôm nay có thể tạo nên sự khác biệt giữa sự sống và cái chết của
                        người khác.
                        Hãy cùng chúng tôi lan tỏa tình người và cứu sống những mảnh đời đang cần sự giúp đỡ.
                    </p>
                    <div class="d-grid gap-3 d-md-flex justify-content-md-start mt-5" data-aos="fade-up"
                        data-aos-delay="500">
                        <a href="/php-blood-donation-system/register"
                            class="btn btn-primary btn-lg px-4 me-md-2 pulse-btn">
                            <i class="fas fa-heart me-2"></i>Đăng ký hiến máu
                        </a>
                        <a href="/php-blood-donation-system/?controller=events&action=index"
                            class="btn btn-outline-secondary btn-lg px-4 btn-hover-float">
                            <i class="fas fa-calendar-alt me-2"></i>Sự kiện sắp tới
                        </a>
                    </div>
                    <div class="floating-stats" data-aos="fade-up" data-aos-delay="600">
                        <div class="stat-item">
                            <span class="stat-number counter"><?= number_format($donationStats['totalDonors']) ?></span>
                            <span class="stat-label">Người hiến máu</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number counter"><?= number_format($donationStats['totalUnits']) ?></span>
                            <span class="stat-label">Đơn vị máu đã hiến</span>
                        </div>
                        <div class="stat-item">
                            <span
                                class="stat-number counter"><?= number_format($donationStats['totalDonations'] * 3) ?></span>
                            <span class="stat-label">Người được cứu sống</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 position-relative" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <div class="hero-image-wrapper">
                    <img src="<?= BASE_URL ?>/images/blood-donation-hero.png" alt="Blood Donation" class="hero-image">
                    <div class="hero-floating-element floating-element-1">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="hero-floating-element floating-element-2">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="hero-floating-element floating-element-3">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blood Stats Section with Interactive Elements -->
<section class="blood-stats-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <span class="section-subheading">Nhu cầu hiện tại</span>
            <h2 class="section-title">Tình trạng lượng máu</h2>
            <p class="section-description">Theo dõi tình trạng các nhóm máu để biết những nhu cầu hiến máu cấp thiết
                hiện tại</p>
            <div class="section-divider">
                <span class="divider-icon"><i class="fas fa-tint"></i></span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                <?php $levelA = $bloodLevels['A'] ?? 0; ?>
                <div
                    class="blood-type-card text-center p-4 rounded-lg shadow-hover <?= $levelA < 30 ? 'low-supply' : ($levelA > 70 ? 'sufficient-supply' : 'adequate-supply') ?>">
                    <div class="blood-drop-icon"></div>
                    <h3 class="blood-type">A</h3>
                    <div class="blood-level-indicator">
                        <div class="progress rounded-pill">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: <?= $levelA ?>%;" aria-valuenow="<?= $levelA ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <span class="progress-value"><?= $levelA ?>%</span>
                            </div>
                        </div>
                    </div>
                    <p class="status-text mt-3">
                        <?php if ($levelA < 30): ?>
                            <span class="badge bg-danger animate-pulse"><i class="fas fa-exclamation-triangle me-1"></i> Cần
                                hiến gấp</span>
                        <?php elseif ($levelA < 70): ?>
                            <span class="badge bg-warning"><i class="fas fa-info-circle me-1"></i> Cần bổ sung</span>
                        <?php else: ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Đủ dự trữ</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($levelA < 50): ?>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-sm btn-outline-primary mt-2">Hiến ngay</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="200">
                <?php $levelB = $bloodLevels['B'] ?? 0; ?>
                <div
                    class="blood-type-card text-center p-4 rounded-lg shadow-hover <?= $levelB < 30 ? 'low-supply' : ($levelB > 70 ? 'sufficient-supply' : 'adequate-supply') ?>">
                    <div class="blood-drop-icon"></div>
                    <h3 class="blood-type">B</h3>
                    <div class="blood-level-indicator">
                        <div class="progress rounded-pill">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: <?= $levelB ?>%;" aria-valuenow="<?= $levelB ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <span class="progress-value"><?= $levelB ?>%</span>
                            </div>
                        </div>
                    </div>
                    <p class="status-text mt-3">
                        <?php if ($levelB < 30): ?>
                            <span class="badge bg-danger animate-pulse"><i class="fas fa-exclamation-triangle me-1"></i> Cần
                                hiến gấp</span>
                        <?php elseif ($levelB < 70): ?>
                            <span class="badge bg-warning"><i class="fas fa-info-circle me-1"></i> Cần bổ sung</span>
                        <?php else: ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Đủ dự trữ</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($levelB < 50): ?>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-sm btn-outline-primary mt-2">Hiến ngay</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                <?php $levelO = $bloodLevels['O'] ?? 0; ?>
                <div
                    class="blood-type-card text-center p-4 rounded-lg shadow-hover <?= $levelO < 30 ? 'low-supply' : ($levelO > 70 ? 'sufficient-supply' : 'adequate-supply') ?>">
                    <div class="blood-drop-icon"></div>
                    <h3 class="blood-type">O</h3>
                    <div class="blood-level-indicator">
                        <div class="progress rounded-pill">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: <?= $levelO ?>%;" aria-valuenow="<?= $levelO ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <span class="progress-value"><?= $levelO ?>%</span>
                            </div>
                        </div>
                    </div>
                    <p class="status-text mt-3">
                        <?php if ($levelO < 30): ?>
                            <span class="badge bg-danger animate-pulse"><i class="fas fa-exclamation-triangle me-1"></i> Cần
                                hiến gấp</span>
                        <?php elseif ($levelO < 70): ?>
                            <span class="badge bg-warning"><i class="fas fa-info-circle me-1"></i> Cần bổ sung</span>
                        <?php else: ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Đủ dự trữ</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($levelO < 50): ?>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-sm btn-outline-primary mt-2">Hiến ngay</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                <?php $levelAB = $bloodLevels['AB'] ?? 0; ?>
                <div
                    class="blood-type-card text-center p-4 rounded-lg shadow-hover <?= $levelAB < 30 ? 'low-supply' : ($levelAB > 70 ? 'sufficient-supply' : 'adequate-supply') ?>">
                    <div class="blood-drop-icon"></div>
                    <h3 class="blood-type">AB</h3>
                    <div class="blood-level-indicator">
                        <div class="progress rounded-pill">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: <?= $levelAB ?>%;" aria-valuenow="<?= $levelAB ?>" aria-valuemin="0"
                                aria-valuemax="100">
                                <span class="progress-value"><?= $levelAB ?>%</span>
                            </div>
                        </div>
                    </div>
                    <p class="status-text mt-3">
                        <?php if ($levelAB < 30): ?>
                            <span class="badge bg-danger animate-pulse"><i class="fas fa-exclamation-triangle me-1"></i> Cần
                                hiến gấp</span>
                        <?php elseif ($levelAB < 70): ?>
                            <span class="badge bg-warning"><i class="fas fa-info-circle me-1"></i> Cần bổ sung</span>
                        <?php else: ?>
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Đủ dự trữ</span>
                        <?php endif; ?>
                    </p>
                    <?php if ($levelAB < 50): ?>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-sm btn-outline-primary mt-2">Hiến ngay</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="info-box mt-4 p-4 rounded-lg bg-light shadow-sm" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-3"><i class="fas fa-info-circle text-primary me-2"></i>Bạn biết gì về các nhóm máu?
                    </h4>
                    <p class="mb-0">Nhóm máu O được gọi là "người cho toàn năng" vì có thể hiến cho mọi nhóm máu. Nhóm
                        AB được gọi là "người nhận toàn năng" vì có thể nhận mọi nhóm máu. Mỗi 2 giây lại có một người
                        cần truyền máu. Chỉ 1 đơn vị máu có thể cứu sống tới 3 người!</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="/php-blood-donation-system/?controller=blood_inventory&action=compatibility"
                        class="btn btn-outline-primary rounded-pill">
                        <i class="fas fa-chart-pie me-2"></i>Bảng tương thích nhóm máu
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Section - NEW -->
<section class="impact-section py-5 bg-pattern">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="impact-image-container">
                    <img src="<?= BASE_URL ?>/images/blood-donation-impact.png" alt="Blood Donation Impact"
                        class="img-fluid rounded-lg shadow-lg">
                    <div class="impact-overlay">
                        <div class="impact-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="impact-content ps-lg-4 mt-4 mt-lg-0">
                    <span class="section-subheading">Tác động của bạn</span>
                    <h2 class="section-title mb-4">Mỗi lần hiến máu có thể cứu sống 3 người</h2>
                    <p class="mb-4">Máu được tách thành ba thành phần: hồng cầu, tiểu cầu và huyết tương. Mỗi thành phần
                        này sẽ được sử dụng để điều trị cho những bệnh nhân khác nhau, từ nạn nhân tai nạn, bệnh nhân
                        ung thư, phụ nữ sinh khó đến trẻ sơ sinh.</p>

                    <div class="impact-stats row text-center">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="impact-stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-hospital-user"></i>
                                </div>
                                <div class="stat-number counter-small">4.5<span class="stat-unit">triệu</span></div>
                                <div class="stat-label">Bệnh nhân mỗi năm</div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="impact-stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-number counter-small">3<span class="stat-unit">giây</span></div>
                                <div class="stat-label">Có người cần máu</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="impact-stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <div class="stat-number counter-small">30<span class="stat-unit">phút</span></div>
                                <div class="stat-label">Thời gian hiến máu</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center text-md-start">
                        <a href="/php-blood-donation-system/?controller=faqs&action=index#impact"
                            class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-info-circle me-2"></i>Tìm hiểu thêm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Events with Card Design -->
<section class="events-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <span class="section-subheading">Tham gia cùng chúng tôi</span>
            <h2 class="section-title">Sự kiện sắp diễn ra</h2>
            <p class="section-description">Hãy là một phần trong các chiến dịch hiến máu sắp tới và giúp đỡ cộng đồng
            </p>
            <div class="section-divider">
                <span class="divider-icon"><i class="fas fa-calendar-alt"></i></span>
            </div>
        </div>

        <div class="row events-slider">
            <?php if (empty($upcomingEvents)): ?>
                <div class="col-12 text-center">
                    <div class="empty-state-container" data-aos="fade-up">
                        <div class="empty-state-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h4 class="mt-3">Chưa có sự kiện nào sắp diễn ra</h4>
                        <p class="text-muted">Vui lòng quay lại sau để cập nhật các sự kiện mới nhất</p>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-primary rounded-pill mt-3">
                            <i class="fas fa-calendar-plus me-2"></i>Đặt lịch hẹn cá nhân
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($upcomingEvents as $index => $event): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="event-card h-100">
                            <div class="event-banner" style="background-color: var(--primary-color);">
                                <div class="event-date">
                                    <span class="event-day"><?= date('d', strtotime($event['date'])) ?></span>
                                    <span class="event-month"><?= date('M', strtotime($event['date'])) ?></span>
                                </div>
                            </div>
                            <div class="event-content">
                                <h4 class="event-title"><?= htmlspecialchars($event['name']) ?></h4>
                                <div class="event-details">
                                    <div class="event-detail">
                                        <i class="fas fa-clock"></i>
                                        <span><?= date('H:i', strtotime($event['time'])) ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span><?= htmlspecialchars($event['location']) ?></span>
                                    </div>
                                </div>
                                <div class="event-description">
                                    <p><?= strlen($event['description']) > 100 ? htmlspecialchars(substr($event['description'], 0, 100)) . '...' : htmlspecialchars($event['description']) ?>
                                    </p>
                                </div>
                                <div class="event-actions">
                                    <a href="/php-blood-donation-system/?controller=events&action=view&id=<?= $event['id'] ?>"
                                        class="btn btn-link text-primary">
                                        <i class="fas fa-info-circle"></i> Chi tiết
                                    </a>
                                    <a href="/php-blood-donation-system/?controller=events&action=register&id=<?= $event['id'] ?>"
                                        class="btn btn-primary btn-sm rounded-pill">
                                        <i class="fas fa-hand-holding-heart"></i> Đăng ký tham gia
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/php-blood-donation-system/?controller=events&action=index"
                class="btn btn-outline-primary btn-lg rounded-pill">
                <i class="fas fa-calendar-week me-2"></i>Xem tất cả sự kiện
            </a>
        </div>
    </div>
</section>

<!-- Latest News Section with Modern Card Design -->
<section class="news-section py-5 bg-light">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <span class="section-subheading">Cập nhật mới nhất</span>
            <h2 class="section-title">Tin tức & Hoạt động</h2>
            <p class="section-description">Cập nhật những thông tin mới nhất về hiến máu và sức khỏe cộng đồng</p>
            <div class="section-divider">
                <span class="divider-icon"><i class="fas fa-newspaper"></i></span>
            </div>
        </div>

        <div class="row">
            <?php if (empty($latestNews)): ?>
                <div class="col-12 text-center">
                    <div class="empty-state-container" data-aos="fade-up">
                        <div class="empty-state-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <h4 class="mt-3">Chưa có tin tức nào</h4>
                        <p class="text-muted">Hãy quay lại sau để cập nhật những tin tức mới nhất</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($latestNews as $index => $news): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="news-card h-100">
                            <div class="news-image">
                                <?php if (!empty($news['image'])): ?>
                                    <img src="<?= BASE_URL ?>/images/news/<?= $news['image'] ?>"
                                        alt="<?= htmlspecialchars($news['title']) ?>">
                                <?php else: ?>
                                    <img src="<?= BASE_URL ?>/images/news-placeholder.jpg" alt="News Placeholder">
                                <?php endif; ?>
                                <div class="news-date">
                                    <span class="news-day"><?= date('d', strtotime($news['created_at'])) ?></span>
                                    <span class="news-month"><?= date('M', strtotime($news['created_at'])) ?></span>
                                </div>
                            </div>
                            <div class="news-content">
                                <h4 class="news-title"><?= htmlspecialchars($news['title']) ?></h4>
                                <div class="news-meta">
                                    <span><i class="fas fa-user-edit"></i> Ban truyền thông</span>
                                    <span><i class="fas fa-comments"></i> <?= rand(0, 15) ?> bình luận</span>
                                </div>
                                <div class="news-excerpt">
                                    <p><?= htmlspecialchars($news['summary']) ?></p>
                                </div>
                                <a href="/php-blood-donation-system/?controller=news&action=view&id=<?= $news['id'] ?>"
                                    class="news-read-more">
                                    Đọc thêm <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="/php-blood-donation-system/?controller=news&action=index"
                class="btn btn-outline-primary btn-lg rounded-pill">
                <i class="fas fa-newspaper me-2"></i>Xem tất cả tin tức
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section - NEW -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <span class="section-subheading">Câu chuyện người hiến máu</span>
            <h2 class="section-title">Những trải nghiệm chia sẻ</h2>
            <p class="section-description">Lắng nghe câu chuyện từ những người đã hiến máu và những người được cứu sống
            </p>
            <div class="section-divider">
                <span class="divider-icon"><i class="fas fa-quote-right"></i></span>
            </div>
        </div>

        <div class="testimonial-carousel" data-aos="fade-up">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>Tôi đã hiến máu đều đặn 3 tháng một lần trong 5 năm qua. Mỗi lần hiến máu, tôi đều cảm
                                thấy hạnh phúc vì biết rằng hành động nhỏ của mình có thể cứu sống người khác. Đội ngũ
                                nhân viên ở đây luôn tận tình và chu đáo.</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?= BASE_URL ?>/images/testimonials/user1.jpg" alt="Nguyễn Văn A">
                            </div>
                            <div class="author-info">
                                <h5>Nguyễn Văn A</h5>
                                <span>Người hiến máu thường xuyên</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>Sau tai nạn giao thông nghiêm trọng, tôi đã cần truyền 3 đơn vị máu để cứu sống mạng sống
                                của mình. Tôi biết ơn vô cùng những người hiến máu vô danh đã cho tôi cơ hội được tiếp
                                tục sống. Giờ đây tôi cũng đã trở thành người hiến máu thường xuyên.</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?= BASE_URL ?>/images/testimonials/user2.jpg" alt="Trần Thị B">
                            </div>
                            <div class="author-info">
                                <h5>Trần Thị B</h5>
                                <span>Người nhận máu & Người hiến máu</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <div class="testimonial-content">
                            <p>Là một bác sĩ huyết học, tôi thấy rõ tầm quan trọng của hiến máu mỗi ngày. Nhiều bệnh
                                nhân của chúng tôi - từ trẻ sơ sinh đến người cao tuổi - đều sống sót nhờ người hiến
                                máu. Mỗi đơn vị máu đều mang lại hy vọng và sự sống.</p>
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <img src="<?= BASE_URL ?>/images/testimonials/user3.jpg" alt="Bs. Lê Văn C">
                            </div>
                            <div class="author-info">
                                <h5>Bs. Lê Văn C</h5>
                                <span>Bác sĩ huyết học</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Preview with Interactive Accordion -->
<section class="faq-section py-5 bg-light">
    <div class="container">
        <div class="section-heading text-center mb-5" data-aos="fade-up">
            <span class="section-subheading">Giải đáp thắc mắc</span>
            <h2 class="section-title">Câu hỏi thường gặp</h2>
            <p class="section-description">Một số câu hỏi phổ biến nhất về hiến máu và những giải đáp chi tiết</p>
            <div class="section-divider">
                <span class="divider-icon"><i class="fas fa-question-circle"></i></span>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-container" data-aos="fade-up">
                    <?php if (empty($faqs)): ?>
                        <div class="empty-state-container">
                            <div class="empty-state-icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <h4 class="mt-3">Không có câu hỏi nào</h4>
                            <p class="text-muted">Vui lòng quay lại sau để xem các câu hỏi thường gặp</p>
                        </div>
                    <?php else: ?>
                        <div class="accordion" id="faqAccordion">
                            <?php foreach ($faqs as $index => $faq): ?>
                                <div class="accordion-item rounded-lg overflow-hidden mb-3 shadow-sm" data-aos="fade-up"
                                    data-aos-delay="<?= $index * 100 ?>">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button <?= $index !== 0 ? 'collapsed' : '' ?>" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>"
                                            aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>"
                                            aria-controls="collapse<?= $index ?>">
                                            <i class="fas fa-question-circle me-2 text-primary"></i>
                                            <?= htmlspecialchars($faq['question']) ?>
                                        </button>
                                    </h2>
                                    <div id="collapse<?= $index ?>"
                                        class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                                        aria-labelledby="heading<?= $index ?>" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="faq-answer">
                                                <i class="fas fa-info-circle me-2 text-primary align-self-start mt-1"></i>
                                                <div class="faq-answer-text">
                                                    <?= htmlspecialchars($faq['answer']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="/php-blood-donation-system/?controller=faqs&action=index"
                        class="btn btn-outline-primary btn-lg rounded-pill">
                        <i class="fas fa-question-circle me-2"></i>Xem tất cả câu hỏi
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Call to Action -->
<section class="cta-section py-5 text-white position-relative">
    <div class="cta-particles"></div>
    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center" data-aos="zoom-in">
                <div class="cta-content p-4 p-md-5 rounded-lg">
                    <div class="cta-icon mb-4">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h2 class="display-5 fw-bold mb-4">Hành động ngay hôm nay!</h2>
                    <p class="lead mb-4">Mỗi ngày có hàng nghìn người cần máu để điều trị. Sự sống của họ phụ thuộc vào
                        lòng nhân ái của bạn. Chỉ 30 phút hiến máu của bạn có thể mang lại sự sống cho 3 người.</p>

                    <div class="cta-benefits-row row mt-5 mb-5">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="cta-benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-heart-circle-check"></i>
                                </div>
                                <h5>Kiểm tra sức khỏe miễn phí</h5>
                                <p>Được kiểm tra các chỉ số sức khỏe và nhóm máu miễn phí</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="cta-benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-hand-holding-medical"></i>
                                </div>
                                <h5>Cứu 3 mạng sống</h5>
                                <p>Một đơn vị máu có thể cứu sống tới ba người khác nhau</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="cta-benefit-item">
                                <div class="benefit-icon">
                                    <i class="fas fa-heart-pulse"></i>
                                </div>
                                <h5>Làm mới máu</h5>
                                <p>Cơ thể sản sinh tế bào máu mới tốt hơn sau khi hiến máu</p>
                            </div>
                        </div>
                    </div>

                    <div class="cta-buttons">
                        <a href="/php-blood-donation-system/register"
                            class="btn btn-light btn-lg px-4 py-3 me-md-3 mb-3 mb-md-0 rounded-pill pulse-btn-white">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký hiến máu
                        </a>
                        <a href="/php-blood-donation-system/?controller=appointments&action=create"
                            class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                            <i class="fas fa-calendar-plus me-2"></i>Đặt lịch hẹn ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom CSS for Home Page -->
<style>
    /* General Styling */
    :root {
        --primary-color: #1a365d;
        --primary-hover: #2c5282;
        --primary-light: #bee3f8;
        --secondary-color: #3182ce;
        --secondary-hover: #2b6cb0;
        --accent-color: #f6ad55;
        --text-color: #2d3748;
        --text-muted: #718096;
        --bg-color: #f7fafc;
        --border-color: #e2e8f0;
        --white: #ffffff;
        --success: #48bb78;
        --warning: #ed8936;
        --danger: #e53e3e;
        --border-radius: 0.375rem;
    }

    .section-heading {
        margin-bottom: 3rem;
    }

    .section-subheading {
        display: block;
        color: var(--secondary-color);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
    }

    .section-description {
        color: var(--text-muted);
        max-width: 700px;
        margin: 0 auto;
    }

    .section-divider {
        position: relative;
        height: 20px;
        width: 100%;
        margin: 1.5rem 0;
    }

    .section-divider:before {
        content: '';
        position: absolute;
        height: 2px;
        width: 80px;
        background-color: var(--accent-color);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .divider-icon {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .shadow-hover {
        transition: all 0.3s ease;
    }

    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .rounded-lg {
        border-radius: 1rem !important;
    }

    .empty-state-container {
        padding: 3rem;
        text-align: center;
        border-radius: 1rem;
        background-color: #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .empty-state-icon {
        font-size: 4rem;
        color: var(--primary-light);
        margin-bottom: 1rem;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }

        100% {
            opacity: 1;
        }
    }

    .rounded-pill {
        border-radius: 50rem !important;
    }

    .btn-hover-float:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    /* Hero Section */
    .hero-section {
        padding: 8rem 0 6rem;
        position: relative;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    .animated-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(26, 54, 93, 0.03) 0%, rgba(49, 130, 206, 0.03) 100%);
        z-index: 0;
    }

    .animated-bg:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%231a365d' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        animation: background-move 60s linear infinite;
    }

    @keyframes background-move {
        0% {
            background-position: 0 0;
        }

        100% {
            background-position: 1000px 1000px;
        }
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.2;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
    }

    .hero-title-highlight {
        color: var(--secondary-color);
        position: relative;
        display: inline-block;
    }

    .hero-title-highlight:after {
        content: '';
        position: absolute;
        height: 8px;
        width: 100%;
        background-color: rgba(246, 173, 85, 0.3);
        bottom: 5px;
        left: 0;
        z-index: -1;
    }

    .hero-title-accent {
        color: var(--accent-color);
    }

    .hero-description {
        font-size: 1.1rem;
        color: var(--text-muted);
        max-width: 90%;
    }

    .hero-image-wrapper {
        position: relative;
        z-index: 1;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .hero-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 20px;
        transition: transform 0.5s ease;
    }

    .hero-image-wrapper:hover .hero-image {
        transform: scale(1.05);
    }

    .hero-floating-element {
        position: absolute;
        width: 60px;
        height: 60px;
        background-color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-color);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .floating-element-1 {
        top: 20px;
        right: 20px;
        animation: float 3s ease-in-out infinite;
        color: var(--danger);
    }

    .floating-element-2 {
        bottom: 30px;
        left: 30px;
        animation: float 4s ease-in-out infinite 1s;
        color: var(--secondary-color);
    }

    .floating-element-3 {
        top: 40%;
        left: -20px;
        animation: float 5s ease-in-out infinite 0.5s;
        color: var(--success);
    }

    @keyframes float {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .floating-stats {
        display: flex;
        margin-top: 2rem;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 1rem;
        padding: 1rem;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
    }

    .stat-item {
        flex: 1;
        text-align: center;
        padding: 0.5rem;
        border-right: 1px solid var(--border-color);
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .pulse-btn {
        position: relative;
        overflow: hidden;
    }

    .pulse-btn:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 1;
        }

        80% {
            transform: translate(-50%, -50%) scale(3);
            opacity: 0;
        }

        100% {
            transform: translate(-50%, -50%) scale(3);
            opacity: 0;
        }
    }

    /* Blood Stats Section */
    .blood-stats-section {
        padding: 5rem 0;
        position: relative;
        background-color: #fff;
    }

    .blood-type-card {
        background-color: white;
        transition: all 0.3s ease;
        border-radius: 1rem;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .blood-drop-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 40px;
        background-color: var(--primary-light);
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        opacity: 0.2;
    }

    .low-supply .blood-drop-icon {
        background-color: var(--danger);
    }

    .adequate-supply .blood-drop-icon {
        background-color: var(--warning);
    }

    .sufficient-supply .blood-drop-icon {
        background-color: var(--success);
    }

    .blood-type {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .low-supply .blood-type {
        color: var(--danger);
    }

    .adequate-supply .blood-type {
        color: var(--warning);
    }

    .sufficient-supply .blood-type {
        color: var(--success);
    }

    .blood-level-indicator {
        margin-bottom: 1rem;
    }

    .progress {
        height: 20px;
        border-radius: 30px;
        background-color: #f1f1f1;
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        background-color: var(--primary-color);
        position: relative;
    }

    .low-supply .progress-bar {
        background-color: var(--danger);
    }

    .adequate-supply .progress-bar {
        background-color: var(--warning);
    }

    .sufficient-supply .progress-bar {
        background-color: var(--success);
    }

    .progress-value {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-text {
        margin-top: 0.5rem;
        font-weight: 600;
    }

    .info-box {
        background-color: #f8fafc;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    /* Impact Section */
    .impact-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
        position: relative;
    }

    .bg-pattern {
        position: relative;
    }

    .bg-pattern:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M9 0h2v20H9V0zm25.134.84l1.732 1-10 17.32-1.732-1 10-17.32zm-20 20l1.732 1-10 17.32-1.732-1 10-17.32zM58.16 4.134l1 1.732-17.32 10-1-1.732 17.32-10zm-40 40l1 1.732-17.32 10-1-1.732 17.32-10zM80 9v2H60V9h20zM20 69v2H0v-2h20zm79.32-55l-1 1.732-17.32-10L82 4l17.32 10zm-80 80l-1 1.732-17.32-10L2 84l17.32 10zm96.546-75.84l-1.732 1-10-17.32 1.732-1 10 17.32zm-100 100l-1.732 1-10-17.32 1.732-1 10 17.32zM38.16 24.134l1 1.732-17.32 10-1-1.732 17.32-10zM60 29v2H40v-2h20zm19.32 5l-1 1.732-17.32-10L62 24l17.32 10zm16.546 4.16l-1.732 1-10-17.32 1.732-1 10 17.32zM111 40h-2V20h2v20zm3.134.84l1.732 1-10 17.32-1.732-1 10-17.32zM40 49v2H20v-2h20zm19.32 5l-1 1.732-17.32-10L42 44l17.32 10zm16.546 4.16l-1.732 1-10-17.32 1.732-1 10 17.32zM91 60h-2V40h2v20zm3.134.84l1.732 1-10 17.32-1.732-1 10-17.32zm24.026 3.294l1 1.732-17.32 10-1-1.732 17.32-10zM39.32 74l-1 1.732-17.32-10L22 64l17.32 10zm16.546 4.16l-1.732 1-10-17.32 1.732-1 10 17.32zM71 80h-2V60h2v20zm3.134.84l1.732 1-10 17.32-1.732-1 10-17.32zm24.026 3.294l1 1.732-17.32 10-1-1.732 17.32-10zM120 89v2h-20v-2h20zm-84.134 9.16l-1.732 1-10-17.32 1.732-1 10 17.32zM51 100h-2V80h2v20zm3.134.84l1.732 1-10 17.32-1.732-1 10-17.32zm24.026 3.294l1 1.732-17.32 10-1-1.732 17.32-10zM100 109v2H80v-2h20zm19.32 5l-1 1.732-17.32-10 1-1.732 17.32 10zM31 120h-2v-20h2v20z' fill='%232b6cb0' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        z-index: 0;
    }

    .impact-image-container {
        position: relative;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }

    .impact-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom right, rgba(26, 54, 93, 0.7), rgba(49, 130, 206, 0.4));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .impact-image-container:hover .impact-overlay {
        opacity: 1;
    }

    .impact-icon {
        font-size: 5rem;
        color: var(--white);
        animation: beat 1.5s infinite alternate;
        transform-origin: center;
    }

    @keyframes beat {
        to {
            transform: scale(1.2);
        }
    }

    .impact-content {
        position: relative;
        z-index: 1;
    }

    .impact-stats {
        margin-top: 2rem;
    }

    .impact-stat-item {
        background-color: white;
        border-radius: 1rem;
        padding: 1.5rem 1rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: all 0.3s ease;
    }

    .impact-stat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .counter-small {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
    }

    .stat-unit {
        font-size: 1rem;
        margin-left: 0.25rem;
    }

    /* Events Section */
    .events-section {
        padding: 5rem 0;
        background-color: #fff;
    }

    .event-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        background-color: var(--white);
        transition: all 0.3s ease;
        height: 100%;
    }

    .event-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .event-banner {
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        position: relative;
    }

    .event-date {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: var(--white);
        color: var(--primary-color);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .event-day {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1;
    }

    .event-month {
        font-size: 0.9rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .event-content {
        padding: 2rem 1.5rem 1.5rem;
    }

    .event-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        height: 2.8rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .event-details {
        margin-bottom: 1rem;
    }

    .event-detail {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        color: var(--text-muted);
    }

    .event-detail i {
        width: 20px;
        color: var(--secondary-color);
        margin-right: 0.5rem;
    }

    .event-description {
        color: var(--text-color);
        margin-bottom: 1.5rem;
        height: 4.5rem;
        overflow: hidden;
    }

    .event-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    /* News Section */
    .news-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .news-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        background-color: var(--white);
        transition: all 0.3s ease;
        height: 100%;
    }

    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .news-image {
        height: 200px;
        position: relative;
        overflow: hidden;
    }

    .news-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .news-card:hover .news-image img {
        transform: scale(1.1);
    }

    .news-date {
        position: absolute;
        bottom: -20px;
        right: 20px;
        background-color: var(--primary-color);
        color: var(--white);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .news-day {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .news-month {
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .news-content {
        padding: 2rem 1.5rem 1.5rem;
    }

    .news-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        height: 2.8rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .news-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .news-meta i {
        color: var(--secondary-color);
        margin-right: 0.25rem;
    }

    .news-excerpt {
        color: var(--text-color);
        margin-bottom: 1.5rem;
        height: 4.5rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .news-read-more {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .news-read-more i {
        transition: transform 0.3s ease;
    }

    .news-read-more:hover {
        color: var(--primary-hover);
    }

    .news-read-more:hover i {
        transform: translateX(5px);
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 5rem 0;
        background-color: #fff;
    }

    .testimonial-card {
        background-color: var(--white);
        border-radius: 1rem;
        padding: 2rem;
        position: relative;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: all 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .testimonial-quote {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 2rem;
        color: rgba(49, 130, 206, 0.1);
    }

    .testimonial-content {
        padding: 2rem 0 1.5rem;
        font-style: italic;
        color: var(--text-color);
    }

    .testimonial-author {
        display: flex;
        align-items: center;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 1rem;
        border: 3px solid var(--primary-light);
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-info h5 {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--primary-color);
    }

    .author-info span {
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* FAQ Section */
    .faq-section {
        padding: 5rem 0;
        background-color: #f8f9fa;
    }

    .faq-container {
        background-color: var(--white);
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .accordion-item {
        margin-bottom: 1rem;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .accordion-button {
        font-weight: 600;
        padding: 1.25rem 1.5rem;
        color: var(--primary-color);
        background-color: var(--white);
    }

    .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        background-color: var(--primary-light);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: var(--primary-light);
    }

    .accordion-button::after {
        background-size: 1.2rem;
        transition: all 0.3s ease;
    }

    .faq-answer {
        display: flex;
    }

    .faq-answer-text {
        flex: 1;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        padding: 5rem 0;
        overflow: hidden;
    }

    .cta-particles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .cta-content {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .cta-icon {
        font-size: 3rem;
        color: var(--white);
    }

    .cta-benefits-row {
        margin: 3rem 0;
    }

    .cta-benefit-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: 1rem;
        height: 100%;
        transition: all 0.3s ease;
    }

    .cta-benefit-item:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.2);
    }

    .benefit-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: var(--white);
    }

    .cta-benefit-item h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .pulse-btn-white {
        position: relative;
        overflow: hidden;
    }

    .pulse-btn-white:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        transform: translate(-50%, -50%) scale(0);
        animation: pulse-animation 2s infinite;
    }

    /* Responsive Adjustments */
    @media (max-width: 991.98px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .floating-stats {
            flex-direction: column;
        }

        .stat-item {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
            padding: 0.75rem 0;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .impact-content {
            margin-top: 2rem;
        }
    }

    @media (max-width: 767.98px) {
        .hero-section {
            padding: 4rem 0;
            text-align: center;
        }

        .hero-description {
            max-width: 100%;
        }

        .d-md-flex {
            justify-content: center;
        }

        .hero-image-wrapper {
            margin-top: 2rem;
        }

        .blood-type-card,
        .event-card,
        .news-card {
            margin-bottom: 1.5rem;
        }

        .impact-stat-item {
            margin-bottom: 1rem;
        }

        .cta-buttons {
            display: flex;
            flex-direction: column;
        }

        .cta-buttons .btn {
            margin-right: 0 !important;
            margin-bottom: 1rem;
        }
    }

    /* Animation for counters */
    .counter {
        display: inline-block;
        animation: countUp 2s ease-out forwards;
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<!-- Initialize AOS and Counter.js -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Add smooth scrolling to all links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>

<?php
// Include footer
require_once __DIR__ . '/../layouts/ClientLayout/ClientFooter.php';
?>