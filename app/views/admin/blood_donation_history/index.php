<?php
// Giao diện lịch sử hiến máu cho admin
if (!isset($donationHistories)) {
    echo '<div class="alert alert-warning">Không có dữ liệu lịch sử hiến máu.</div>';
    return;
}
?>
<div class="container py-4">
    <h2 class="mb-4">Quản lý lịch sử hiến máu</h2>
    <?php if (count($donationHistories) === 0): ?>
        <div class="alert alert-info">Chưa có bản ghi hiến máu nào.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Người hiến</th>
                        <th>Ngày hiến máu</th>
                        <th>Địa điểm</th>
                        <th>Lượng máu (ml)</th>
                        <th>Loại máu</th>
                        <th>Sự kiện</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donationHistories as $history): ?>
                        <tr>
                            <td><?= htmlspecialchars($history->user->userInfo->full_name ?? $history->user->cccd) ?></td>
                            <td><?= date('d/m/Y', strtotime($history->donation_date_time)) ?></td>
                            <td><?= htmlspecialchars($history->appointment->event->donationUnit->name ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($history->quantity) ?></td>
                            <td><?= htmlspecialchars($history->user->userInfo->blood_type ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($history->appointment->event->name ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($history->notes ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>