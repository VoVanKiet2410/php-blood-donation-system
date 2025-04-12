<?php
// Define the content function that will be used in the client layout
$content = function () use ($faqs) {
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
                    style="background: linear-gradient(45deg, #e6f2ff, #f0f8ff); border-left: 5px solid #1a365d;">
                    <h1 class="display-5 fw-bold text-primary mb-2">
                        <i class="fas fa-question-circle me-2"></i>Câu Hỏi Thường Gặp
                    </h1>
                    <p class="lead mb-0 text-muted">
                        Tìm hiểu về quy trình và lợi ích của hiến máu qua các câu hỏi thường gặp
                    </p>
                </div>

                <!-- Search box -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" id="faqSearch" class="form-control border-start-0"
                                placeholder="Tìm kiếm câu hỏi...">
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion -->
                <div class="faq-list">
                    <?php if (empty($faqs)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Hiện chưa có câu hỏi thường gặp nào. Vui lòng quay lại sau.
                        </div>
                    <?php else: ?>
                        <?php
                        // Group FAQs by categories
                        $categories = [];
                        foreach ($faqs as $faq) {
                            $category = isset($faq->category) && !empty($faq->category) ? $faq->category : 'Thông tin chung';
                            if (!isset($categories[$category])) {
                                $categories[$category] = [];
                            }
                            $categories[$category][] = $faq;
                        }
                        ?>

                        <?php foreach ($categories as $category => $categoryFaqs): ?>
                            <div class="faq-category mb-4">
                                <h3 class="category-title fw-bold mb-3">
                                    <i class="fas fa-folder me-2 text-primary"></i><?= htmlspecialchars($category) ?>
                                </h3>

                                <div class="accordion accordion-flush" id="accordion-<?= md5($category) ?>">
                                    <?php foreach ($categoryFaqs as $index => $faq): ?>
                                        <div class="accordion-item border mb-3 rounded shadow-sm faq-item" data-category="<?= htmlspecialchars($category) ?>">
                                            <h2 class="accordion-header" id="heading-<?= $faq->id ?>">
                                                <button class="accordion-button collapsed fw-medium" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-<?= $faq->id ?>"
                                                    aria-expanded="false" aria-controls="collapse-<?= $faq->id ?>">
                                                    <i class="fas fa-question-circle me-2 text-primary"></i>
                                                    <?= htmlspecialchars($faq->title) ?>
                                                </button>
                                            </h2>
                                            <div id="collapse-<?= $faq->id ?>" class="accordion-collapse collapse"
                                                aria-labelledby="heading-<?= $faq->id ?>"
                                                data-bs-parent="#accordion-<?= md5($category) ?>">
                                                <div class="accordion-body">
                                                    <div class="faq-answer">
                                                        <?= nl2br(htmlspecialchars($faq->description)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick info card -->
                <div class="card shadow-sm mb-4 border-0 sticky-top" style="top: 20px; z-index: 999;">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Thông Tin Hữu Ích
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-tint text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">Quy Trình Hiến Máu</h6>
                                <p class="small text-muted mb-0">Quy trình hiến máu an toàn và nhanh chóng</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-heart text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">Lợi Ích Hiến Máu</h6>
                                <p class="small text-muted mb-0">Hiến máu có lợi cho cả người hiến và người nhận</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-user-md text-primary"></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1">Điều Kiện Hiến Máu</h6>
                                <p class="small text-muted mb-0">Các điều kiện cần thiết để có thể hiến máu</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="<?= BASE_URL ?>/index.php?controller=Event&action=clientIndex" class="btn btn-primary d-block">
                            <i class="fas fa-calendar-alt me-2"></i>Đăng Ký Hiến Máu
                        </a>
                    </div>
                </div>

                <!-- Contact card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-headset me-2"></i>Hỗ Trợ
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Bạn có câu hỏi khác không được liệt kê ở đây? Vui lòng liên hệ với chúng tôi.</p>
                        <div class="d-grid gap-2">
                            <a href="<?= BASE_URL ?>/index.php?controller=Contact&action=index" class="btn btn-outline-secondary">
                                <i class="fas fa-envelope me-2"></i>Liên Hệ
                            </a>
                            <a href="tel:+84xxxxxxxxx" class="btn btn-outline-secondary">
                                <i class="fas fa-phone me-2"></i>Hotline: 1900-xxxx
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Animation for accordion */
        .accordion-button:not(.collapsed) {
            background-color: #e6f2ff;
            color: #1a365d;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .faq-item {
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            transform: translateY(-3px);
        }

        .category-title {
            position: relative;
            padding-bottom: 0.5rem;
        }

        .category-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #1a365d, #3182ce);
            border-radius: 3px;
        }

        .page-header {
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(49, 130, 206, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        /* Highlight searched text */
        .highlight {
            background-color: #fff3cd;
            padding: 0 2px;
            border-radius: 2px;
        }

        /* No results message */
        .no-results {
            padding: 2rem;
            text-align: center;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('faqSearch');
            const faqItems = document.querySelectorAll('.faq-item');
            const categories = document.querySelectorAll('.faq-category');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let hasResults = false;

                // Create and get no results element
                let noResultsEl = document.querySelector('.no-results');
                if (!noResultsEl) {
                    noResultsEl = document.createElement('div');
                    noResultsEl.className = 'no-results';
                    noResultsEl.innerHTML = '<i class="fas fa-search fa-2x mb-3 text-muted"></i><h4>Không tìm thấy kết quả</h4><p class="text-muted">Vui lòng thử lại với từ khóa khác</p>';
                    document.querySelector('.faq-list').appendChild(noResultsEl);
                }
                noResultsEl.style.display = 'none';

                if (searchTerm === '') {
                    // Reset everything when search is empty
                    faqItems.forEach(item => {
                        item.style.display = '';

                        // Remove highlight
                        const question = item.querySelector('.accordion-button');
                        const answer = item.querySelector('.faq-answer');

                        question.innerHTML = question.innerHTML.replace(/<mark class="highlight">(.*?)<\/mark>/g, '$1');
                        answer.innerHTML = answer.innerHTML.replace(/<mark class="highlight">(.*?)<\/mark>/g, '$1');
                    });

                    categories.forEach(category => {
                        category.style.display = '';
                    });

                    return;
                }

                faqItems.forEach(item => {
                    const question = item.querySelector('.accordion-button');
                    const answer = item.querySelector('.faq-answer');

                    const questionText = question.textContent.toLowerCase();
                    const answerText = answer.textContent.toLowerCase();

                    if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                        item.style.display = '';
                        hasResults = true;

                        // Highlight matching text
                        let questionContent = question.innerHTML;
                        let answerContent = answer.innerHTML;

                        // Remove existing highlights
                        questionContent = questionContent.replace(/<mark class="highlight">(.*?)<\/mark>/g, '$1');
                        answerContent = answerContent.replace(/<mark class="highlight">(.*?)<\/mark>/g, '$1');

                        // Add new highlights
                        const regex = new RegExp(`(${searchTerm})`, 'gi');
                        questionContent = questionContent.replace(regex, '<mark class="highlight">$1</mark>');
                        answerContent = answerContent.replace(regex, '<mark class="highlight">$1</mark>');

                        question.innerHTML = questionContent;
                        answer.innerHTML = answerContent;

                        // Expand the accordion if it contains search results
                        const collapseEl = item.querySelector('.accordion-collapse');
                        if (!collapseEl.classList.contains('show')) {
                            item.querySelector('.accordion-button').click();
                        }
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Hide/show categories based on visible items
                categories.forEach(category => {
                    const visibleItems = category.querySelectorAll('.faq-item[style="display: none;"]').length;
                    const totalItems = category.querySelectorAll('.faq-item').length;

                    if (visibleItems === totalItems) {
                        category.style.display = 'none';
                    } else {
                        category.style.display = '';
                    }
                });

                // Show no results message if needed
                if (!hasResults) {
                    noResultsEl.style.display = 'block';
                }
            });

            // Smooth scroll and focus when URL has hash
            if (window.location.hash) {
                const id = window.location.hash.substring(1);
                const element = document.getElementById(id);

                if (element) {
                    setTimeout(() => {
                        window.scrollTo({
                            top: element.offsetTop - 100,
                            behavior: 'smooth'
                        });

                        // Expand the accordion
                        const accordionButton = element.querySelector('.accordion-button');
                        if (accordionButton && accordionButton.classList.contains('collapsed')) {
                            accordionButton.click();
                        }
                    }, 300);
                }
            }

            // Add smooth transition when showing/hiding accordion content
            const accordionButtons = document.querySelectorAll('.accordion-button');
            accordionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const faqItem = this.closest('.faq-item');
                    if (this.classList.contains('collapsed')) {
                        // Closing
                        faqItem.style.transform = '';
                    } else {
                        // Opening
                        faqItem.style.transform = 'translateY(-3px)';
                    }
                });
            });
        });
    </script>
<?php
};
// Include the client layout
require_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
?>