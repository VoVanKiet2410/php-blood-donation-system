<?php
// Define the content function that will be used in the client layout
$title = "Tin Tức & Sự Kiện";
$content = function () use ($news) {
?>
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 mb-3" style="color: var(--primary-color);">Tin Tức & Sự Kiện</h1>
            <p class="lead text-muted">Cập nhật thông tin mới nhất về các hoạt động hiến máu</p>
        </div>
    </div>

    <div class="row">
        <?php if (empty($news)): ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-newspaper fa-3x mb-3" style="color: var(--primary-light);"></i>
                <p>Hiện tại chưa có tin tức nào. Vui lòng quay lại sau.</p>
            </div>
        <?php else: ?>
            <?php foreach ($news as $index => $item): ?>
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="card h-100 shadow-sm hover-card">
                        <?php if (!empty($item->image_url)): ?>
                            <img src="<?= htmlspecialchars($item->image_url) ?>" class="card-img-top" alt="<?= htmlspecialchars($item->title) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="bg-light text-center py-5">
                                <i class="fas fa-newspaper fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <div>
                                <h5 class="card-title"><?= htmlspecialchars($item->title) ?></h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="far fa-calendar-alt me-1"></i> 
                                    <?= date('d/m/Y', strtotime($item->timestamp)) ?>
                                    <?php if (!empty($item->author)): ?>
                                        <span class="ms-2"><i class="far fa-user me-1"></i> <?= htmlspecialchars($item->author) ?></span>
                                    <?php endif; ?>
                                </p>
                                <p class="card-text">
                                    <?= mb_substr(strip_tags($item->content), 0, 120) . (mb_strlen(strip_tags($item->content)) > 120 ? '...' : '') ?>
                                </p>
                            </div>
                            <a href="<?= BASE_URL ?>/public/index.php?controller=News&action=view&id=<?= $item->id ?>" class="btn btn-sm btn-outline-danger mt-auto align-self-start">
                                Đọc thêm <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
<?php
};

// Include the client layout
include_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
?>