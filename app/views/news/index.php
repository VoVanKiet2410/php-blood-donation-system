<?php
// Get current URL for active navigation
$current_url = $_SERVER['REQUEST_URI'];

// Define BASE_URL constant if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', '/php-blood-donation-system');
}

/**
 * Format date to a more readable format
 * @param string $date Date in Y-m-d format
 * @return string Formatted date
 */
function formatNewsDate($date)
{
    if (empty($date)) return 'N/A';

    // Handle different date formats that might come from the database
    if (strpos($date, ':') !== false) {
        // If it includes time (Y-m-d H:i:s)
        $dateObj = new DateTime($date);
    } else {
        // If it's just a date (Y-m-d)
        $dateObj = new DateTime($date);
    }

    // Format to Vietnamese style date
    return $dateObj->format('d/m/Y');
}

/**
 * Truncate text to a specific length with ellipsis
 */
function truncateText($text, $length = 150)
{
    if (strlen($text) <= $length) return $text;

    $truncated = substr($text, 0, $length);
    return $truncated . '...';
}
$content = function () use ($news) {
    // Get current URL for active navigation
    $current_url = $_SERVER['REQUEST_URI'];

    // Define BASE_URL constant if not already defined
    if (!defined('BASE_URL')) {
        define('BASE_URL', '/php-blood-donation-system');
    }
?>

    <div class="container my-5">
        <div class="row">
            <!-- Main content -->
            <div class="col-lg-8">
                <!-- Page header with animated gradient -->
                <div class="page-header mb-4 p-4 rounded"
                    style="background: linear-gradient(45deg, #fff5f5, #fff0f0); border-left: 5px solid #dc3545;">
                    <h1 class="display-5 fw-bold text-danger mb-2">
                        <i class="fas fa-newspaper me-2"></i>Tin Tức & Sự Kiện
                    </h1>
                    <p class="lead mb-0 text-muted">
                        Cập nhật thông tin mới nhất về chiến dịch và hoạt động hiến máu
                    </p>
                </div>

                <!-- News search and filters -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-danger"></i>
                                    </span>
                                    <input type="text" id="newsSearch" class="form-control border-start-0"
                                        placeholder="Tìm kiếm tin tức...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="newsFilter">
                                    <option value="all">Tất cả bài viết</option>
                                    <option value="event">Sự kiện</option>
                                    <option value="news">Tin tức</option>
                                    <option value="featured">Nổi bật</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Featured news - Displayed only if we have featured items -->
                <?php
                $featuredNews = null;
                // Find a featured news article if available
                if (!empty($news)) {
                    foreach ($news as $item) {
                        if (isset($item->is_featured) && $item->is_featured == 1) {
                            $featuredNews = $item;
                            break;
                        }
                    }
                }
                ?>

                <?php if ($featuredNews): ?>
                    <div class="card border-0 shadow-sm mb-4 featured-news" data-category="featured">
                        <div class="position-relative">
                            <?php if (!empty($featuredNews->image_url)): ?>
                                <img src="<?= htmlspecialchars($featuredNews->image_url) ?>" class="card-img-top featured-img"
                                    alt="<?= htmlspecialchars($featuredNews->title) ?>" style="height: 300px; object-fit: cover;">
                            <?php else: ?>
                                <div class="placeholder-img"
                                    style="height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-danger">Nổi bật</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted me-3">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?= formatNewsDate($featuredNews->created_at ?? $featuredNews->timestamp ?? date('Y-m-d')) ?>
                                </small>
                                <small class="text-muted">
                                    <i class="far fa-user me-1"></i>
                                    <?= isset($featuredNews->author) ? htmlspecialchars($featuredNews->author) : 'Admin' ?>
                                </small>
                            </div>
                            <h3 class="card-title"><?= htmlspecialchars($featuredNews->title) ?></h3>
                            <p class="card-text">
                                <?= truncateText(strip_tags($featuredNews->content), 250) ?>
                            </p>
                            <a href="<?= BASE_URL ?>/index.php?controller=News&action=view&id=<?= $featuredNews->id ?>"
                                class="btn btn-outline-danger">
                                <i class="fas fa-arrow-right me-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- News grid -->
                <div class="row g-4" id="newsContainer">
                    <?php if (empty($news)): ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <h4>Chưa có tin tức nào</h4>
                                <p class="mb-0">Các tin tức và sự kiện sẽ được cập nhật trong thời gian tới.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($news as $item): ?>
                            <?php
                            // Skip the featured news as it's already displayed
                            if (isset($featuredNews) && $featuredNews->id === $item->id) continue;

                            // Determine category for filtering
                            $category = "news";
                            if (isset($item->type) && !empty($item->type)) {
                                $category = strtolower($item->type);
                            }
                            ?>
                            <div class="col-md-6 news-item" data-category="<?= $category ?>">
                                <div class="card h-100 border-0 shadow-sm hover-card">
                                    <div class="position-relative">
                                        <?php if (!empty($item->image_url)): ?>
                                            <img src="<?= htmlspecialchars($item->image_url) ?>" class="card-img-top"
                                                alt="<?= htmlspecialchars($item->title) ?>" style="height: 180px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="placeholder-img"
                                                style="height: 180px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-newspaper fa-2x text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <small class="text-muted me-auto">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                <?= formatNewsDate($item->created_at ?? $item->timestamp ?? date('Y-m-d')) ?>
                                            </small>
                                        </div>
                                        <h5 class="card-title"><?= htmlspecialchars($item->title) ?></h5>
                                        <p class="card-text flex-grow-1">
                                            <?= truncateText(strip_tags($item->content), 100) ?>
                                        </p>
                                        <a href="<?= BASE_URL ?>/index.php?controller=News&action=view&id=<?= $item->id ?>"
                                            class="btn btn-sm btn-outline-danger mt-auto align-self-start">
                                            Đọc thêm <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Pagination if needed -->
                <?php if (!empty($news) && count($news) > 10): ?>
                    <nav class="my-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- No results message (hidden by default) -->
                <div class="no-results mt-4 d-none">
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-search fa-2x mb-3"></i>
                        <h4>Không tìm thấy kết quả</h4>
                        <p class="mb-0">Không tìm thấy tin tức phù hợp với từ khóa tìm kiếm của bạn.</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Latest events widget -->
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-day me-2"></i>Sự Kiện Sắp Diễn Ra
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php
                            // Normally we would fetch upcoming events here
                            // For now using placeholder data
                            ?>
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="list-group-item list-group-item-action d-flex gap-3 py-3">
                                <div class="event-date text-center border rounded text-danger" style="width: 50px;">
                                    <div class="fw-bold">15</div>
                                    <small>Th5</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">Hiến máu tại Đại học HUTECH</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i>Cơ sở Q.9, TP.HCM
                                    </p>
                                </div>
                            </a>
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="list-group-item list-group-item-action d-flex gap-3 py-3">
                                <div class="event-date text-center border rounded text-danger" style="width: 50px;">
                                    <div class="fw-bold">20</div>
                                    <small>Th5</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">Hiến máu tình nguyện</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i>Bệnh viện Chợ Rẫy
                                    </p>
                                </div>
                            </a>
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="list-group-item list-group-item-action d-flex gap-3 py-3">
                                <div class="event-date text-center border rounded text-danger" style="width: 50px;">
                                    <div class="fw-bold">25</div>
                                    <small>Th5</small>
                                </div>
                                <div>
                                    <h6 class="mb-1">Ngày hội hiến máu</h6>
                                    <p class="text-muted small mb-0">
                                        <i class="fas fa-map-marker-alt me-1"></i>Nhà văn hóa Thanh Niên
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="card-footer bg-light text-center">
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex"
                                class="btn btn-sm btn-outline-danger">Xem tất cả sự kiện</a>
                        </div>
                    </div>
                </div>

                <!-- Blood info card -->
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-tint me-2"></i>Tình Trạng Máu
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Các nhóm máu đang cần hiến khẩn cấp:</p>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="blood-type-card text-center p-2 border rounded">
                                    <div class="blood-icon bg-danger text-white rounded-circle mx-auto mb-2">A+</div>
                                    <div class="blood-status text-danger">Khẩn cấp</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="blood-type-card text-center p-2 border rounded">
                                    <div class="blood-icon bg-danger text-white rounded-circle mx-auto mb-2">O-</div>
                                    <div class="blood-status text-danger">Khẩn cấp</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="blood-type-card text-center p-2 border rounded">
                                    <div class="blood-icon bg-warning text-white rounded-circle mx-auto mb-2">B+</div>
                                    <div class="blood-status text-warning">Cần thiết</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="blood-type-card text-center p-2 border rounded">
                                    <div class="blood-icon bg-success text-white rounded-circle mx-auto mb-2">AB+</div>
                                    <div class="blood-status text-success">Đủ</div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-2">
                            <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex" class="btn btn-primary">
                                <i class="fas fa-heartbeat me-2"></i>Đăng ký hiến máu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Share widget -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-share-alt me-2"></i>Chia Sẻ
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Chia sẻ trang này đến bạn bè và người thân để lan tỏa tinh thần hiến máu cứu
                            người.</p>
                        <div class="d-flex justify-content-center social-share">
                            <a href="#" class="btn btn-outline-primary mx-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info mx-1">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger mx-1">
                                <i class="fab fa-pinterest"></i>
                            </a>
                            <a href="#" class="btn btn-outline-success mx-1">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Card hover effects */
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        /* Featured news */
        .featured-news {
            overflow: hidden;
        }

        .featured-news .featured-img {
            transition: all 0.5s ease;
        }

        .featured-news:hover .featured-img {
            transform: scale(1.05);
        }

        /* Blood type icons */
        .blood-icon {
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-weight: bold;
        }

        /* Page header animation */
        .page-header {
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(220, 53, 69, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        /* Social share buttons */
        .social-share a {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .social-share a:hover {
            transform: translateY(-3px);
        }

        /* Event date styling */
        .event-date {
            font-size: 0.9rem;
            background-color: #fff;
        }

        /* Search highlight */
        .highlight {
            background-color: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .featured-news .featured-img {
                height: 200px !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('newsSearch');
            const newsItems = document.querySelectorAll('.news-item, .featured-news');
            const newsContainer = document.getElementById('newsContainer');
            const noResultsMessage = document.querySelector('.no-results');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let hasResults = false;

                if (searchTerm === '') {
                    // Reset everything when search is empty
                    newsItems.forEach(item => {
                        item.style.display = '';

                        // Remove highlight
                        const title = item.querySelector('.card-title');
                        const content = item.querySelector('.card-text');

                        if (title) title.innerHTML = title.innerHTML.replace(
                            /<mark class="highlight">(.*?)<\/mark>/g, '$1');
                        if (content) content.innerHTML = content.innerHTML.replace(
                            /<mark class="highlight">(.*?)<\/mark>/g, '$1');
                    });

                    noResultsMessage.classList.add('d-none');
                    return;
                }

                newsItems.forEach(item => {
                    const title = item.querySelector('.card-title');
                    const content = item.querySelector('.card-text');

                    if (!title || !content) return;

                    const titleText = title.textContent.toLowerCase();
                    const contentText = content.textContent.toLowerCase();

                    if (titleText.includes(searchTerm) || contentText.includes(searchTerm)) {
                        item.style.display = '';
                        hasResults = true;

                        // Highlight matching text
                        let titleContent = title.innerHTML;
                        let textContent = content.innerHTML;

                        // Remove existing highlights
                        titleContent = titleContent.replace(/<mark class="highlight">(.*?)<\/mark>/g,
                            '$1');
                        textContent = textContent.replace(/<mark class="highlight">(.*?)<\/mark>/g,
                            '$1');

                        // Add new highlights
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        titleContent = titleContent.replace(regex, '<mark class="highlight">$1</mark>');
                        textContent = textContent.replace(regex, '<mark class="highlight">$1</mark>');

                        title.innerHTML = titleContent;
                        content.innerHTML = textContent;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (!hasResults) {
                    noResultsMessage.classList.remove('d-none');
                } else {
                    noResultsMessage.classList.add('d-none');
                }
            });

            // Filter functionality
            const filterSelect = document.getElementById('newsFilter');

            filterSelect.addEventListener('change', function() {
                const filterValue = this.value;

                newsItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.style.display = '';
                    } else {
                        const itemCategory = item.dataset.category;
                        item.style.display = (itemCategory === filterValue) ? '' : 'none';
                    }
                });

                // Check if we have any visible items
                const hasVisibleItems = Array.from(newsItems).some(item => item.style.display !== 'none');

                if (!hasVisibleItems) {
                    noResultsMessage.classList.remove('d-none');
                } else {
                    noResultsMessage.classList.add('d-none');
                }
            });

            // Initialize Bootstrap tooltips
            if (typeof bootstrap !== 'undefined' && typeof bootstrap.Tooltip !== 'undefined') {
                const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                tooltips.forEach(tooltip => {
                    new bootstrap.Tooltip(tooltip);
                });
            }
        });
    </script>
<?php
}; // End of content function

// Include the admin layout
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>