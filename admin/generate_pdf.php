<?php
// Start output buffering to prevent unintended output
ob_start();

require_once '../config/db_connect.php'; // Database connection
require_once '../config/tcpdf/tcpdf.php'; // Include TCPDF library

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch student and their medical records
    $query = "SELECT user_id, student_id, password, first_name, middle_name, last_name, extension, email, gender, 
                     birthdate, age, birth_place, marital_status, address, religion, additional_info, department, 
                     year_level, profile_picture, blood_pressure, temperature, pulse_rate, respiratory_rate, 
                     height, weight, eperson1_name, eperson1_phone, eperson1_relationship, eperson2_name, 
                     eperson2_phone, eperson2_relationship, health_record, datetime_recorded
              FROM student_tbl 
              WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Fetch medical records from record_tbl
        $records_query = "SELECT record_date, chief_complaint, treatment 
                          FROM record_tbl 
                          WHERE student_id = ?";
        $records_stmt = $conn->prepare($records_query);
        $records_stmt->bind_param('i', $student_id);
        $records_stmt->execute();
        $records_result = $records_stmt->get_result();
        $records = $records_result->fetch_all(MYSQLI_ASSOC);

        // Create PDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Clinic Admin');
        $pdf->SetTitle('Student Medical Records');
        $pdf->SetMargins(15, 27, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Function to return 'N/A' if the value is empty
        function checkEmpty($value) {
            return empty($value) ? 'N/A' : $value;
        }

        // Styled HTML content
        $html = '
            <style>
                h1 {
                    text-align: center;
                    color: #2c3e50;
                    font-size: 24px;
                    font-weight: bold;
                }
                h2 {
                    color: #34495e;
                    font-size: 18px;
                    margin-bottom: 10px;
                }
                p {
                    font-size: 14px;
                    line-height: 1.5;
                    margin: 5px 0;
                }
                img {
                    display: block;
                    margin: 10px auto;
                    border-radius: 50%;
                }
                .student-info, .records-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                .student-info td, .records-table th, .records-table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                .records-table th {
                    background-color: #f4f4f4;
                    font-weight: bold;
                }
                .records-table {
                    margin-top: 10px;
                }
            </style>
            <h1>Student Medical Records</h1>
            <img src="../student_pic/' . checkEmpty($student['profile_picture']) . '" style="width: 120px; height: 120px; object-fit: cover;" />
            <h2>Student Information</h2>
            <table class="student-info">
                <tr>
                    <td><strong>Name:</strong> ' . checkEmpty($student['first_name']) . ' ' . checkEmpty($student['middle_name']) . ' ' . checkEmpty($student['last_name']) . ' ' . checkEmpty($student['extension']) . '</td>
                    <td><strong>Gender:</strong> ' . checkEmpty($student['gender']) . '</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong> ' . checkEmpty($student['email']) . '</td>
                    <td><strong>Birthdate:</strong> ' . checkEmpty(date('F d, Y', strtotime($student['birthdate']))) . '</td>
                </tr>
                <tr>
                    <td><strong>Age:</strong> ' . checkEmpty($student['age']) . '</td>
                    <td><strong>Birth Place:</strong> ' . checkEmpty($student['birth_place']) . '</td>
                </tr>
                <tr>
                    <td><strong>Marital Status:</strong> ' . checkEmpty($student['marital_status']) . '</td>
                    <td><strong>Religion:</strong> ' . checkEmpty($student['religion']) . '</td>
                </tr>
                <tr>
                    <td><strong>Address:</strong> ' . checkEmpty($student['address']) . '</td>
                    <td><strong>Department:</strong> ' . checkEmpty($student['department']) . '</td>
                </tr>
                <tr>
                    <td><strong>Year Level:</strong> ' . checkEmpty($student['year_level']) . '</td>
                    <td><strong>Additional Info:</strong> ' . checkEmpty($student['additional_info']) . '</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Health Record:</strong> ' . checkEmpty($student['health_record']) . '</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>Date Recorded:</strong> ' . checkEmpty(date('F d, Y', strtotime($student['datetime_recorded']))) . '</td>
                </tr>
            </table>
            
            <h2>Health Information</h2>
            <table class="student-info">
                <tr>
                    <td><strong>Blood Pressure:</strong> ' . checkEmpty($student['blood_pressure']) . '</td>
                    <td><strong>Temperature:</strong> ' . checkEmpty($student['temperature']) . '°C</td>
                </tr>
                <tr>
                    <td><strong>Pulse Rate:</strong> ' . checkEmpty($student['pulse_rate']) . ' bpm</td>
                    <td><strong>Respiratory Rate:</strong> ' . checkEmpty($student['respiratory_rate']) . ' breaths/min</td>
                </tr>
                <tr>
                    <td><strong>Height:</strong> ' . checkEmpty($student['height']) . ' cm</td>
                    <td><strong>Weight:</strong> ' . checkEmpty($student['weight']) . ' kg</td>
                </tr>
            </table>
            
            <h2>Emergency Contacts</h2>
            <table class="student-info">
                <tr>
                    <td><strong>Name:</strong> ' . checkEmpty($student['eperson1_name']) . '</td>
                    <td><strong>Phone:</strong> ' . checkEmpty($student['eperson1_phone']) . '</td>
                    <td><strong>Relationship:</strong> ' . checkEmpty($student['eperson1_relationship']) . '</td>
                </tr>
                <tr>
                    <td><strong>Name:</strong> ' . checkEmpty($student['eperson2_name']) . '</td>
                    <td><strong>Phone:</strong> ' . checkEmpty($student['eperson2_phone']) . '</td>
                    <td><strong>Relationship:</strong> ' . checkEmpty($student['eperson2_relationship']) . '</td>
                </tr>
            </table>
        ';

        // Add medical records
        if (!empty($records)) {
            $html .= '<h2>Medical Records</h2>
                      <table class="records-table">
                        <thead>
                            <tr>
                                <th>Record Date</th>
                                <th>Chief Complaint</th>
                                <th>Treatment</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($records as $record) {
                $html .= '
                    <tr>
                        <td>' . date('F d, Y', strtotime($record['record_date'])) . '</td>
                        <td>' . checkEmpty($record['chief_complaint']) . '</td>
                        <td>' . checkEmpty($record['treatment']) . '</td>
                    </tr>';
            }
            $html .= '</tbody></table>';
        } else {
            $html .= '<p>No medical records available for this student.</p>';
        }

        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('student_medical_records_' . $student_id . '.pdf', 'I');
    } else {
        ob_end_clean();
        die("No data found for the given student.");
    }
} else {
    ob_end_clean();
    die("Invalid request.");
}
?>
