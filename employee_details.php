<?php
include_once 'includes/startup.php';
include_once 'authenticate.php';

$user_id = current_user_id();

$text_fields = array(
    'son_daughter_wife_of' => "Father's / Husband's name",
    'dob'                  => 'Date of birth',
    'blood_group'          => 'Blood group',
    'contact_number'       => 'Contact number',
    'other_contact_number' => 'Alternate contact number',
    'present_address'      => 'Present address',
    'permanent_address'    => 'Permanent address',
    'pan_number'           => 'PAN number',
    'aadhar_number'        => 'Aadhaar number',
    'bank_name'            => 'Bank name',
    'account_number'       => 'Account number',
    'branch_name'          => 'Branch name',
    'ifsc_code'            => 'IFSC code',
    'designation'          => 'Designation',
    'department'           => 'Department',
    'date_of_joining'      => 'Date of joining',
);
$required = array('son_daughter_wife_of', 'dob', 'contact_number', 'present_address', 'permanent_address', 'designation', 'department', 'date_of_joining');
$file_fields = array(
    'profile_pic'   => 'Profile photo',
    'pan_copy'      => 'PAN card copy',
    'adhar_copy'    => 'Aadhaar card copy',
    'passbook_copy' => 'Bank passbook / cancelled cheque',
    'address_copy'  => 'Address proof',
);
$allowed_ext = array('jpg', 'jpeg', 'png', 'pdf');

$rs = $conn->Execute("SELECT first_name, last_name FROM user_master WHERE user_id = ?", array($user_id));
$user = $rs->FetchRow();
$rs = $conn->Execute("SELECT * FROM user_details WHERE user_id = ?", array($user_id));
$details = $rs->FetchRow();
$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user['first_name'] = str_prepare($_POST['first_name']);
    $user['last_name'] = str_prepare($_POST['last_name']);
    $data = array();
    foreach ($text_fields as $field => $label) {
        $data[$field] = str_prepare(isset($_POST[$field]) ? $_POST[$field] : '');
        if ($data[$field] == '' && in_array($field, $required)) {
            $errors[] = "$label is required.";
        }
        if ($data[$field] == '' && in_array($field, array('dob', 'date_of_joining'))) {
            $data[$field] = null;
        }
    }
    if ($user['first_name'] == '') {
        $errors[] = 'First name is required.';
    }

    $uploads = array();
    foreach ($file_fields as $field => $label) {
        if (empty($_FILES[$field]['name'])) {
            continue;
        }
        $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
        if ($_FILES[$field]['error'] != UPLOAD_ERR_OK) {
            $errors[] = "$label could not be uploaded.";
        } else if (!in_array($ext, $allowed_ext)) {
            $errors[] = "$label must be a JPG, PNG or PDF file.";
        } else {
            $uploads[$field] = $_FILES[$field];
        }
    }

    if (!$errors) {
        $dir = UPLOADS_DIR . 'employeeDetails/';
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        foreach ($uploads as $field => $file) {
            $safe_name = preg_replace('/[^A-Za-z0-9._-]+/', '_', basename($file['name']));
            $file_name = time() . '_' . $field . '_' . $safe_name;
            if (move_uploaded_file($file['tmp_name'], $dir . $file_name)) {
                $data[$field] = $file_name;
            }
        }

        $conn->AutoExecute(TABLE_PREFIX . 'user_master', array('first_name' => $user['first_name'], 'last_name' => $user['last_name']),
            'UPDATE', 'user_id = ' . $user_id);
        if ($details) {
            $conn->AutoExecute(TABLE_PREFIX . 'user_details', $data, 'UPDATE', 'user_id = ' . $user_id);
        } else {
            $data['user_id'] = $user_id;
            $conn->AutoExecute(TABLE_PREFIX . 'user_details', $data, 'INSERT');
        }
        $_SESSION[SESSION_PREFIX . 'FIRST_NAME'] = $user['first_name'];
        setMsg('Your details have been saved.', 'success');
        header("location: employee_documents.php");
        exit();
    }
    $details = array_merge($details ? $details : array(), $data);
}

$active_page_id = 7;
$page_title = 'New Employee Details';
include_once '_header.php';

function detail_value($details, $field)
{
    return h(isset($details[$field]) ? $details[$field] : '');
}
?>
<section class="breadcrumb">
    <div class="container">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="induction.php?page_id=1">Onboarding</a></li>
            <li>New Employee Details</li>
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
                    <h2 class="page-heading">New Employee Details</h2>
                    <?php if ($errors) { ?>
                        <div class="alert alert-danger"><?php echo implode('<br>', array_map('h', $errors)); ?></div>
                    <?php } ?>
                    <form method="post" action="employee_details.php" enctype="multipart/form-data">
                        <h4 class="form-section-title">Personal</h4>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="first_name">First name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo h($user['first_name']); ?>" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="last_name">Last name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo h($user['last_name']); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="son_daughter_wife_of">Father's / Husband's name *</label>
                                <input type="text" class="form-control" id="son_daughter_wife_of" name="son_daughter_wife_of" value="<?php echo detail_value($details, 'son_daughter_wife_of'); ?>" required>
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="dob">Date of birth *</label>
                                <input type="date" class="form-control" id="dob" name="dob" value="<?php echo detail_value($details, 'dob'); ?>" required>
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="blood_group">Blood group</label>
                                <input type="text" class="form-control" id="blood_group" name="blood_group" value="<?php echo detail_value($details, 'blood_group'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="contact_number">Contact number *</label>
                                <input type="tel" class="form-control" id="contact_number" name="contact_number" value="<?php echo detail_value($details, 'contact_number'); ?>" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="other_contact_number">Alternate contact number</label>
                                <input type="tel" class="form-control" id="other_contact_number" name="other_contact_number" value="<?php echo detail_value($details, 'other_contact_number'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="present_address">Present address *</label>
                                <textarea class="form-control" rows="3" id="present_address" name="present_address" required><?php echo detail_value($details, 'present_address'); ?></textarea>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="permanent_address">Permanent address *</label>
                                <textarea class="form-control" rows="3" id="permanent_address" name="permanent_address" required><?php echo detail_value($details, 'permanent_address'); ?></textarea>
                            </div>
                        </div>

                        <h4 class="form-section-title">Job</h4>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <label for="designation">Designation *</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="<?php echo detail_value($details, 'designation'); ?>" required>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="department">Department *</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?php echo detail_value($details, 'department'); ?>" required>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label for="date_of_joining">Date of joining *</label>
                                <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="<?php echo detail_value($details, 'date_of_joining'); ?>" required>
                            </div>
                        </div>

                        <h4 class="form-section-title">Identity &amp; bank</h4>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="pan_number">PAN number</label>
                                <input type="text" class="form-control" id="pan_number" name="pan_number" value="<?php echo detail_value($details, 'pan_number'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="aadhar_number">Aadhaar number</label>
                                <input type="text" class="form-control" id="aadhar_number" name="aadhar_number" value="<?php echo detail_value($details, 'aadhar_number'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="bank_name">Bank name</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo detail_value($details, 'bank_name'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="branch_name">Branch name</label>
                                <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo detail_value($details, 'branch_name'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="account_number">Account number</label>
                                <input type="text" class="form-control" id="account_number" name="account_number" value="<?php echo detail_value($details, 'account_number'); ?>">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="ifsc_code">IFSC code</label>
                                <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="<?php echo detail_value($details, 'ifsc_code'); ?>">
                            </div>
                        </div>

                        <h4 class="form-section-title">Copies (JPG, PNG or PDF)</h4>
                        <div class="row">
                            <?php foreach ($file_fields as $field => $label) { ?>
                                <div class="col-sm-6 form-group">
                                    <label for="<?php echo $field; ?>"><?php echo $label; ?></label>
                                    <input type="file" class="form-control" id="<?php echo $field; ?>" name="<?php echo $field; ?>" accept=".jpg,.jpeg,.png,.pdf">
                                    <?php if (!empty($details[$field])) { ?>
                                        <small><a href="<?php echo UPLOADS_URL . 'employeeDetails/' . rawurlencode($details[$field]); ?>" target="_blank"><i class="fa fa-paperclip"></i> Current file</a></small>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="step-nav">
                            <a href="induction.php?page_id=6" class="prevButton">Prev</a>
                            <button type="submit" class="btn btn-accent pull-right">Save &amp; Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include '_footer.php'; ?>
