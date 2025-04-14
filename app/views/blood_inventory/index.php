<?php
// Define the content function that will be used in the layout
$content = function () use ($bloodInventories) {

    error_log("Data received: " . $bloodInventories);
?>
    <style>
        :root {
            --accent-purple: #8e44ad;
            --accent-pink: #e84393;
            --blood-red: #e74c3c;
            --blood-dark: #c0392b;
        }

        /* Custom styles for Blood Inventory */
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

        .blood-quantity {
            font-weight: 600;
            color: var(--blood-dark);
        }

        .ant-table th {
            background: #f7f5ff;
            color: var(--accent-purple);
            font-weight: 600;
            padding: 12px 16px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hover-effect {
            transition: all 0.3s ease;
        }

        .hover-effect:hover {
            background-color: #f8f7ff;
            transform: translateY(-1px);
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            margin: 0 3px;
        }

        .edit-btn {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .delete-btn {
            background: rgba(231, 76, 60, 0.1);
            color: #e74c3c;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .edit-btn:hover {
            background: rgba(52, 152, 219, 0.2);
        }

        .delete-btn:hover {
            background: rgba(231, 76, 60, 0.2);
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(120deg, var(--blood-red), var(--blood-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .custom-input {
            border-radius: 20px !important;
            border-color: #e2e8f0 !important;
            padding: 8px 16px !important;
            transition: all 0.3s ease !important;
        }

        .custom-input:hover {
            border-color: var(--accent-purple) !important;
            box-shadow: 0 2px 4px rgba(142, 68, 173, 0.1) !important;
        }

        .custom-input:focus {
            border-color: var(--accent-purple) !important;
            box-shadow: 0 0 0 3px rgba(142, 68, 173, 0.15) !important;
        }

        .search-form {
            position: relative;
            max-width: 300px;
        }

        .search-form-button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--accent-purple);
            cursor: pointer;
        }
    </style>

    <div class="container-fluid px-0">
        <!-- Page Header with gradient background -->
        <div class="ant-page-header mb-4 rounded"
            style="background: linear-gradient(120deg, #e74c3c, #c0392b); padding: 24px; color: white;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-0 text-white">Quản Lý Kho Máu</h4>
                    <p class="mb-0 mt-1 text-white opacity-75">Danh sách lượng máu hiện có trong kho</p>
                </div>
                <a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=create" class="ant-btn"
                    style="background: white; color: #e74c3c; border: none; font-weight: 500; border-radius: 8px; padding: 8px 16px;">
                    <i class="fas fa-plus me-2"></i>Thêm Máu Mới
                </a>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="ant-card" style="border-top: 3px solid #e74c3c; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
            <div class="ant-card-body p-0">
                <!-- Filter and Search -->
                <div class="p-4 border-bottom" style="background: linear-gradient(to right, #fff5f5, #ffebee);">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="d-flex align-items-center">
                                <span class="me-3 text-nowrap" style="color: #e74c3c; font-weight: 500;">
                                    <i class="fas fa-filter me-1"></i>Lọc:
                                </span>
                                <div class="d-flex">
                                    <div class="custom-control custom-radio custom-control-inline me-3">
                                        <input type="radio" id="all-blood" name="filter-blood"
                                            class="custom-control-input blood-filter" value="all" checked>
                                        <label class="custom-control-label" for="all-blood">Tất cả</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline me-3">
                                        <input type="radio" id="a-blood" name="filter-blood"
                                            class="custom-control-input blood-filter" value="A">
                                        <label class="custom-control-label" for="a-blood">Nhóm A</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline me-3">
                                        <input type="radio" id="b-blood" name="filter-blood"
                                            class="custom-control-input blood-filter" value="B">
                                        <label class="custom-control-label" for="b-blood">Nhóm B</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline me-3">
                                        <input type="radio" id="ab-blood" name="filter-blood"
                                            class="custom-control-input blood-filter" value="AB">
                                        <label class="custom-control-label" for="ab-blood">Nhóm AB</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="o-blood" name="filter-blood"
                                            class="custom-control-input blood-filter" value="O">
                                        <label class="custom-control-label" for="o-blood">Nhóm O</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="search-form ms-auto">
                                <input type="text" id="bloodSearch" class="form-control custom-input"
                                    placeholder="Tìm kiếm kho máu...">
                                <button type="button" class="search-form-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="ant-table table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 60px">ID</th>
                                <th>Nhóm Máu</th>
                                <th>Số Lượng</th>
                                <th>Cập Nhật Cuối</th>
                                <th>Ngày Hết Hạn</th>
                                <th style="width: 150px" class="text-end">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bloodInventories)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">
                                                <i class="fas fa-tint"></i>
                                            </div>
                                            <p>Không có dữ liệu kho máu nào.</p>
                                            <a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=create"
                                                class="btn btn-sm" style="background: #e74c3c; color: white;">
                                                <i class="fas fa-plus me-1"></i> Thêm máu mới
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($bloodInventories as $inventory): ?>
                                    <?php
                                    $bloodTypeClass = '';
                                    if (strpos($inventory->bloodType, 'A') !== false && strpos($inventory->bloodType, 'B') !== false) {
                                        $bloodTypeClass = 'blood-type-AB';
                                    } elseif (strpos($inventory->bloodType, 'A') !== false) {
                                        $bloodTypeClass = 'blood-type-A';
                                    } elseif (strpos($inventory->bloodType, 'B') !== false) {
                                        $bloodTypeClass = 'blood-type-B';
                                    } elseif (strpos($inventory->bloodType, 'O') !== false) {
                                        $bloodTypeClass = 'blood-type-O';
                                    }
                                    ?>
                                    <tr class="hover-effect" data-blood-type="<?= htmlspecialchars($inventory->blood_type); ?>">
                                        <td><span class="badge rounded-pill"
                                                style="background: #e74c3c;"><?= htmlspecialchars($inventory->id); ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="blood-type-badge badge text-black <?= $bloodTypeClass ?>">
                                                    <?= htmlspecialchars($inventory->blood_type); ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-flask me-2 text-danger"></i>
                                                <span class="blood-quantity"><?= htmlspecialchars($inventory->quantity); ?> đơn
                                                    vị</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-clock me-2 text-muted"></i>
                                                <?= date('d/m/Y H:i', strtotime($inventory->last_updated)); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar-alt me-2 text-warning"></i>
                                                <?= date('d/m/Y', strtotime($inventory->expiration_date)); ?>
                                                <?php
                                                $daysLeft = (strtotime($inventory->expirationDate) - time()) / (60 * 60 * 24);
                                                if ($daysLeft < 0) {
                                                    echo '<span class="badge bg-danger ms-2">Đã hết hạn</span>';
                                                } elseif ($daysLeft < 7) {
                                                    echo '<span class="badge bg-warning ms-2">Sắp hết hạn</span>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <a href="<?= BASE_URL ?>/index.php?controller=BloodInventory&action=edit&id=<?= $inventory->id; ?>"
                                                    class="action-btn edit-btn" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="action-btn delete-btn" title="Xóa"
                                                    onclick="confirmDelete(<?= $inventory->id; ?>)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Section -->
                <?php if (!empty($bloodInventories)): ?>
                    <div class="p-4 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3" style="color: #e74c3c;">Tổng quan kho máu:</h6>
                                <div class="d-flex flex-wrap">
                                    <?php
                                    $bloodTypes = [];
                                    foreach ($bloodInventories as $inventory) {
                                        if (!isset($bloodTypes[$inventory->bloodType])) {
                                            $bloodTypes[$inventory->bloodType] = 0;
                                        }
                                        $bloodTypes[$inventory->bloodType] += $inventory->quantity;
                                    }

                                    foreach ($bloodTypes as $type => $amount) {
                                        $typeClass = '';
                                        if (strpos($type, 'A') !== false && strpos($type, 'B') !== false) {
                                            $typeClass = 'blood-type-AB';
                                        } elseif (strpos($type, 'A') !== false) {
                                            $typeClass = 'blood-type-A';
                                        } elseif (strpos($type, 'B') !== false) {
                                            $typeClass = 'blood-type-B';
                                        } elseif (strpos($type, 'O') !== false) {
                                            $typeClass = 'blood-type-O';
                                        }

                                        echo '<div class="me-4 mb-2">';
                                        echo '<span class="blood-type-badge badge text-white ' . $typeClass . '">' . $type . '</span>';
                                        echo '<span class="ms-2 blood-quantity">' . $amount . ' đơn vị</span>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                <div class="text-muted">
                                    Tổng số <?= count($bloodInventories) ?> bản ghi kho máu
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('bloodSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    filterItems(searchTerm, null);
                });
            }

            // Blood type filter
            const bloodFilters = document.querySelectorAll('.blood-filter');
            bloodFilters.forEach(filter => {
                filter.addEventListener('change', function() {
                    const bloodType = this.value;
                    filterItems(null, bloodType);
                });
            });

            function filterItems(searchTerm, bloodType) {
                const tableRows = document.querySelectorAll('.ant-table tbody tr');

                tableRows.forEach(row => {
                    if (row.querySelector('td[colspan="6"]')) return; // Skip empty state row

                    let display = true;

                    // Apply search filter
                    if (searchTerm) {
                        const text = row.textContent.toLowerCase();
                        if (!text.includes(searchTerm)) {
                            display = false;
                        }
                    }

                    // Apply blood type filter
                    if (bloodType && bloodType !== 'all') {
                        const rowBloodType = row.getAttribute('data-blood-type');
                        if (!rowBloodType.includes(bloodType)) {
                            display = false;
                        }
                    }

                    row.style.display = display ? '' : 'none';
                });
            }
        });

        // Delete confirmation
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa bản ghi kho máu này?')) {
                window.location.href = `<?= BASE_URL ?>/index.php?controller=BloodInventory&action=delete&id=${id}`;
            }
        }
    </script>
<?php
};

// Include the Admin Layout (blood inventory is typically managed by admins)
include_once __DIR__ . '/../layouts/AdminLayout/AdminLayout.php';
?>