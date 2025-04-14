<?php
// Define the content function that will be used in the client layout
$title = isset($news->title) ? $news->title : "Chi tiết tin tức";
$content = function () use ($news) {
?>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <?php if (!$news): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x mb-3 text-warning"></i>
                        <h3>Không tìm thấy bài viết</h3>
                        <p class="text-muted">Bài viết này không tồn tại hoặc đã bị xóa</p>
                        <a href="<?= BASE_URL ?>/index.php?controller=News&action=index" class="btn btn-outline-primary mt-3">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách tin tức
                        </a>
                    </div>
                <?php else: ?>
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <!-- <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=News&action=index">Trang chủ</a></li> -->
                            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?controller=News&action=index">Tin tức</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($news->title) ?></li>
                        </ol>
                    </nav>

                    <!-- News Title -->
                    <h1 class="mb-3" style="color: white;"><?= htmlspecialchars($news->title) ?></h1>

                    <!-- Meta info -->
                    <div class="d-flex text-muted mb-4">
                        <div class="me-3">
                            <i class="far fa-calendar-alt me-1"></i> <?= date('d/m/Y', strtotime($news->timestamp)) ?>
                        </div>
                        <?php if (!empty($news->author)): ?>
                            <div>
                                <i class="far fa-user me-1"></i> <?= htmlspecialchars($news->author) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Featured Image (if available) -->
                    <?php if (!empty($news->image_url)): ?>
                        <div class="mb-4">
                            <img src="<?= htmlspecialchars($news->image_url) ?>" class="img-fluid rounded shadow-sm" alt="<?= htmlspecialchars($news->title) ?>" style="max-height: 500px; width: 100%; object-fit: cover;" data-aos="zoom-in">
                        </div>
                    <?php endif; ?>

                    <!-- News Content -->
                    <div class="news-content mt-4" data-aos="fade-up">
                        <?= nl2br(htmlspecialchars($news->content)) ?>
                    </div>

                    <!-- Share & Navigation -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">Chia sẻ:</span>
                                    <a href="#" class="social-share-btn me-2" style="background-color: #3b5998;">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-share-btn me-2" style="background-color: #1da1f2;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" class="social-share-btn" style="background-color: #0e76a8;">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <a href="<?= BASE_URL ?>/index.php?controller=News&action=index" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        .news-content {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .social-share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
        }

        .social-share-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }
    </style>
<?php
};

// Include the client layout
include_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
?>