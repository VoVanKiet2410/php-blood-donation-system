<?php
// Define the content function that will be used in the client layout
$title = "Câu Hỏi Thường Gặp";
$content = function () use ($faqs) {
?>
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 mb-3" style="color: var(--primary-color);">Câu Hỏi Thường Gặp</h1>
            <p class="lead text-muted">Những thông tin hữu ích về hiến máu và các vấn đề liên quan</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <?php if (empty($faqs)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-3x mb-3" style="color: var(--primary-light);"></i>
                    <p>Hiện tại chưa có câu hỏi nào được tạo. Vui lòng quay lại sau.</p>
                </div>
            <?php else: ?>
                <div class="accordion" id="faqAccordion">
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="accordion-item border mb-3 rounded shadow-sm" data-aos="fade-up" data-aos-delay="<?= $index * 50 ?>">
                            <h2 class="accordion-header" id="heading<?= $faq->id ?>">
                                <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $faq->id ?>" aria-expanded="false" aria-controls="collapse<?= $faq->id ?>">
                                    <?= htmlspecialchars($faq->title) ?>
                                </button>
                            </h2>
                            <div id="collapse<?= $faq->id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $faq->id ?>"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p><?= nl2br(htmlspecialchars($faq->description)) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Contact section for questions not found -->
            <div class="card mt-5 bg-light border-0 shadow-sm" data-aos="fade-up">
                <div class="card-body p-4">
                    <h3 class="card-title h5 mb-3">Không tìm thấy câu hỏi bạn cần?</h3>
                    <p class="card-text">Nếu bạn có câu hỏi khác không được đề cập ở đây, vui lòng liên hệ với chúng tôi qua:</p>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-envelope me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <h4 class="h6 mb-1">Email</h4>
                            <p class="mb-0">support@giotmauvang.com</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <i class="fas fa-phone-alt me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                        <div>
                            <h4 class="h6 mb-1">Hotline</h4>
                            <p class="mb-0">1900 xxxx</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        background-color: var(--primary-light);
    }
    
    .accordion-button:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(229, 62, 62, 0.25);
    }
</style>
<?php
};

// Include the client layout
include_once __DIR__ . '/../layouts/ClientLayout/ClientLayout.php';
?>