<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();
$allowed_ext = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx');

$types = $conn->Execute("SELECT document_type_id, document_type FROM document_type_master WHERE is_active = 1 ORDER BY sort_order")->GetRows();
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dir = UPLOADS_DIR . 'documents/';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $saved = 0;
    foreach ($types as $type) {
        $key = 'document_' . $type['document_type_id'];
        if (empty($_FILES[$key]['name'])) {
            continue;
        }
        $orig_name = basename($_FILES[$key]['name']);
        $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
        if ($_FILES[$key]['error'] != UPLOAD_ERR_OK) {
            $errors[] = $type['document_type'] . ': upload failed.';
            continue;
        }
        if (!in_array($ext, $allowed_ext)) {
            $errors[] = $type['document_type'] . ': only JPG, PNG, PDF or Word files are allowed.';
            continue;
        }
        $file_name = 'document_' . $type['document_type_id'] . '_' . time() . '_' . preg_replace('/[^A-Za-z0-9 ._()-]+/', '_', $orig_name);
        if (move_uploaded_file($_FILES[$key]['tmp_name'], $dir . $file_name)) {
            $conn->AutoExecute(TABLE_PREFIX . 'user_documents', array(
                'document_type_id' => $type['document_type_id'],
                'user_id'          => $user_id,
                'file_name'        => $file_name,
                'orig_name'        => substr($orig_name, 0, 100),
                'upload_date'      => date('Y-m-d H:i:s'),
            ), 'INSERT');
            $saved++;
        }
    }
    if (!$errors) {
        setMsg($saved ? "$saved document(s) uploaded." : 'No new documents selected.', 'success');
        header("location: employee_documents.php");
        exit();
    }
}

$uploaded = array();
$rs = $conn->Execute("SELECT * FROM user_documents WHERE user_id = ? ORDER BY upload_date", array($user_id));
while ($row = $rs->FetchRow()) {
    $uploaded[$row['document_type_id']][] = $row;
}

$success = getMsg('success');
$active_page_id = 8;
$page_title = 'New Employee Documents';
include_once '_header.php';
?>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="induction.php?page_id=1">Onboarding</a></li>
            <li>New Employee Documents</li>
        </ul>
    </div>
</section>
<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <?php include 'includes/onboarding_nav.php'; ?>
            </div>
            <div class="col-md-9">
                <div class="panel-card">
                    <h2 class="page-heading">New Employee Documents</h2>
                    <p>Upload a copy of each qualification you hold. Leave a row empty if it does not apply to you.</p>
                    <?php if ($success) { ?>
                        <div class="alert alert-success"><?php echo h($success); ?></div>
                    <?php } ?>
                    <?php if ($errors) { ?>
                        <div class="alert alert-danger"><?php echo implode('<br>', array_map('h', $errors)); ?></div>
                    <?php } ?>
                    <form method="post" action="employee_documents.php" enctype="multipart/form-data">
                        <?php foreach ($types as $type) { $id = $type['document_type_id']; ?>
                            <div class="form-group">
                                <label for="document_<?php echo $id; ?>"><?php echo h($type['document_type']); ?></label>
                                <input type="file" class="form-control" id="document_<?php echo $id; ?>" name="document_<?php echo $id; ?>" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                                <?php if (!empty($uploaded[$id])) { ?>
                                    <small>
                                        <?php foreach ($uploaded[$id] as $doc) { ?>
                                            <a href="<?php echo UPLOADS_URL . 'documents/' . rawurlencode($doc['file_name']); ?>" target="_blank"><i class="fa fa-paperclip"></i> <?php echo h($doc['orig_name']); ?></a> &nbsp;
                                        <?php } ?>
                                    </small>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <button type="submit" class="btn">Upload</button>
                    </form>
                    <div class="step-nav">
                        <a href="employee_details.php" class="prevButton">Prev</a>
                        <a href="policies.php" class="nextButton">Next</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include '_footer.php'; ?>
