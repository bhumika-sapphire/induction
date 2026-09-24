<?php
ob_clean();
require_once __DIR__ . '/../lib/Classes/PHPExcel.php';
include_once '../includes/startup.php';
require_once 'authenticate.php';


// Helper functions
function yesNo($v) {
    return $v ? 'Yes' : 'No';
}

function clean($str) {
    return htmlspecialchars(
        str_replace(["\t", "\n", "\r"], ' ', $str),
        ENT_QUOTES,
        'UTF-8'
    );
}


function getUserDocumentsMap($conn, $userId) {
    $userId = (int)$userId;
    $docs = [];
    $sql = "
        SELECT 
            dtm.document_type,
            COUNT(ud.user_id) AS has_doc
        FROM document_type_master dtm
        LEFT JOIN user_documents ud 
            ON dtm.document_type_id = ud.document_type_id
            AND ud.user_id = $userId
        WHERE dtm.is_active = 1
        GROUP BY dtm.document_type_id, dtm.document_type
    ";
    $exec = $conn->Execute($sql);
    while ($row = $exec->FetchRow()) {
        $docs[$row['document_type']] = ($row['has_doc'] > 0) ? 'Yes' : 'No';
    }
    return $docs;
}

// Fetch user data
$sql = "
SELECT 
    um.user_id,
    um.user_login,
    um.first_name,
    um.last_name,
    um.user_phone,
    um.reg_date,
    um.is_active,
    um.it_policy,
    um.leave_policy,
    um.travel_policy,
    um.list_of_holidays_policy,
    um.increment_policy,
    um.productivity_policy,
    um.office_rules_policy,
    ud.dob,
    ud.other_contact_number,
    ud.branch_name,
    ud.son_daughter_wife_of,
    ud.date_of_joining,
    ud.department,
    ud.designation,
    ud.blood_group,
    ud.present_address,
    ud.permanent_address,
    ud.bank_name,
    ud.account_number,
    ud.ifsc_code,
    ud.pan_number,
    ud.aadhar_number,
    ud.passbook_copy
FROM user_master um
LEFT JOIN user_details ud ON um.user_id = ud.user_id
ORDER BY um.reg_date DESC
";

$exec = $conn->Execute($sql);
if (!$exec) {
    die("SQL Error: " . $conn->ErrorMsg());
}
$excel = new PHPExcel();
$sheet = $excel->setActiveSheetIndex(0);
$sheet->setTitle('User Profiles');
$headers = [
    "User Login", "First Name", "Last Name", "Phone", "Other Contact No",
    "Account Create Date", "DOB", "Son Daughter Wife of", "DOJ", "Department",
    "Designation", "Blood Group", "Present Address", "Permanent Address",
    "Bank Name", "Branch Name", "Account Number", "IFSC", "PAN", "Aadhar",
    "Matriculation", "Senior Secondary", "Degree/Diploma", "Master Degree/Diploma",
    "Professional Qualification", "Passbook", "Experience Certificate", "Is Active",
    "IT Policy", "Leave Policy", "Travel Policy", "List of Holidays",
    "Increment Policy", "Productivity Rules & Regulations", "Office Rules"
];

$col = 0;
foreach ($headers as $header) {
    $sheet->setCellValueByColumnAndRow($col++, 1, $header);
}
$sheet->getStyle('A1:AJ1')->getFont()->setBold(true);
$rowNum = 2;

while ($row = $exec->FetchRow()) {

    $documents = getUserDocumentsMap($conn, $row['user_id']);
    $experienceCertificate = isset($documents['Experience Certificate']) ? $documents['Experience Certificate'] : 'No';

    $data = [
        clean($row['user_login']),
        clean($row['first_name']),
        clean($row['last_name']),
        clean($row['user_phone']),
        clean($row['other_contact_number']),
        date("d-m-Y", strtotime($row['reg_date'])),
        clean($row['dob']),
        clean($row['son_daughter_wife_of']),
        clean($row['date_of_joining']),
        clean($row['department']),
        clean($row['designation']),
        clean($row['blood_group']),
        clean($row['present_address']),
        clean($row['permanent_address']),
        clean($row['bank_name']),
        clean($row['branch_name']),
        clean($row['account_number']),
        clean($row['ifsc_code']),
        clean($row['pan_number']),
        clean($row['aadhar_number']),
        isset($documents['Matriculation']) ? $documents['Matriculation'] : 'No',
        isset($documents['Senior Secondary']) ? $documents['Senior Secondary'] : 'No',
        isset($documents['Degree/ Diploma']) ? $documents['Degree/ Diploma'] : 'No',
        isset($documents['Master Degree/Diploma']) ? $documents['Master Degree/Diploma'] : 'No',
        isset($documents['Professional Qualification']) ? $documents['Professional Qualification'] : 'No',
        yesNo($row['passbook_copy']),
        $experienceCertificate,
        yesNo($row['is_active']),
        yesNo($row['it_policy']),
        yesNo($row['leave_policy']),
        yesNo($row['travel_policy']),
        yesNo($row['list_of_holidays_policy']),
        yesNo($row['increment_policy']),
        yesNo($row['productivity_policy']),
        yesNo($row['office_rules_policy'])
    ];

    $col = 0;
    foreach ($data as $value) {
        $sheet->setCellValueByColumnAndRow($col++, $rowNum, $value);
    }
    $rowNum++;
}
foreach (range('A', 'AJ') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="all_user_profiles.xls"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$writer->save('php://output');
exit;




