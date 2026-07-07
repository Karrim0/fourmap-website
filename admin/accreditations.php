<?php
$page_title = 'إدارة الاعتمادات';
require_once '../includes/db.php';
include 'partials/header.php';

$stmt = $pdo->query("SELECT * FROM accreditations ORDER BY sort_order ASC, id DESC");
$accreditations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-wrapper">
<?php include 'partials/sidebar.php'; ?>

<div class="main-content">
<div class="top-bar">
    <h1 class="page-title">إدارة الاعتمادات</h1>
    <div class="top-bar-actions">
        <a href="accreditation-create.php" class="btn btn-primary">
            إضافة اعتماد
        </a>
    </div>
</div>

<div class="content-wrapper">

<div class="card">
<div class="card-body p-0">
<table class="table table-hover align-middle mb-0">
<thead>
<tr>
<th>#</th>
<th>الصورة</th>
<th>الاسم</th>
<th>الحالة</th>
<th>إجراءات</th>
</tr>
</thead>
<tbody>

<?php foreach ($accreditations as $acc): ?>
<tr>
<td><?php echo $acc['id']; ?></td>
<td>
<img src="<?php echo htmlspecialchars($acc['image']); ?>" style="width:80px;">
</td>
<td><?php echo htmlspecialchars($acc['name']); ?></td>
<td><?php echo $acc['status']; ?></td>
<td>
<a href="accreditation-edit.php?id=<?php echo $acc['id']; ?>" class="btn btn-sm btn-outline-primary">تعديل</a>
</td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>
</div>

</div>
</div>
</div>

<?php include 'partials/footer.php'; ?>
