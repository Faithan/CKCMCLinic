<?php
// Start output buffering to prevent unintended output
ob_start();

require_once '../config/db_connect.php'; // Database connection
require_once '../config/tcpdf/tcpdf.php'; // Include TCPDF library

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch student details
    $query = "SELECT student_id, first_name, middle_name, last_name, extension, email, gender, 
                     birthdate, age, birth_place, marital_status, address, religion, additional_info, 
                     department, year_level, profile_picture, blood_pressure, temperature, pulse_rate, 
                     respiratory_rate, height, weight, eperson1_name, eperson1_phone, eperson1_relationship, 
                     eperson2_name, eperson2_phone, eperson2_relationship, health_record, datetime_recorded
              FROM student_tbl 
              WHERE student_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();

        // Fetch medical records
        $records_query = "SELECT record_date, chief_complaint, treatment 
                          FROM record_tbl 
                          WHERE student_id = ?";
        $records_stmt = $conn->prepare($records_query);
        $records_stmt->bind_param('i', $student_id);
        $records_stmt->execute();
        $records_result = $records_stmt->get_result();
        $records = $records_result->fetch_all(MYSQLI_ASSOC);

        $pdf = new TCPDF('P', 'mm', array(215.9, 330.2)); // 8.5 x 13 inches in mm
        $pdf->setPrintHeader(false); // Remove black horizontal line at the header
        $pdf->setPrintFooter(false); // (Optional) Remove footer if not needed
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Clinic Admin');
        $pdf->SetTitle('Student Medical Records');
        $pdf->SetMargins(15, 10, 15); // Increase top margin
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);
        
        // Function to return 'N/A' if the value is empty
        function checkEmpty($value)
        {
            return empty($value) ? 'N/A' : $value;
        }



        // i want to add a pic here
        $image_path = '../system_images/ckcm_logo.jpg'; // Replace with the actual path to your image                                           
        // Check if the image file exists
        if (file_exists($image_path)) {
            // Set the X and Y coordinates to position the image
            $img_x = 93;  // Adjust X position (horizontal)
            $img_y = $pdf->GetY(); // Adjust Y position (vertical, placing it below the title)
            $img_width = 20; // Set image width (adjust size as needed)
            $img_height = 20; // Set image height (adjust size as needed)

            // Add the image to the PDF
            $pdf->Image($image_path, $img_x, $img_y, $img_width, $img_height, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

            // Move cursor below the image to avoid overlapping with the content
            $pdf->SetY( $img_y + $img_height + 5);
        }



        // Styled HTML content
        $html = '
            <style>
                h1, h2 {
                    text-align: center;
                    font-weight: bold;
                }
                h1 {
                    font-size: 20px;
                    color: #2c3e50;
                
                }
                h2 {
                    font-size: 16px;
                    color: #34495e;
                    margin-bottom: 5px;
                }
                .info-table, .records-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 15px;
                }
                .info-table td, .records-table th, .records-table td {
                    border: 1px solid #ddd;
                    padding: 6px;
                    text-align: left;
                }
                .records-table th {
                    background-color: #f4f4f4;
                }
            </style>
   

            <h1>Christ The King College de Maranding, Inc.</h1>
            <h2>Student Health Records</h2>
';


        // Output title first
        $pdf->writeHTML($html, true, false, true, false, '');

        // **ADD PROFILE IMAGE BETWEEN TITLES**
        if (!empty($student['profile_picture'])) {
            $profile_picture_path = '../student_pic/' . $student['profile_picture'];
            if (file_exists($profile_picture_path)) {
                $img_x = 80;  // Center image (adjust as needed)
                $img_y = $pdf->GetY() + 5; // Place image below "Student Health Records"
                $img_width = 40;
                $img_height = 40;

                $pdf->Image($profile_picture_path, $img_x, $img_y, $img_width, $img_height, '', '', 'T', false, 300, '', false, false, 0, false, false, false);

                // **Set cursor below the image to avoid overlap**
                $pdf->SetY($img_y + $img_height );
            }
        }

        $html = '
            <h2>Student Information</h2>
            <table class="info-table">
                <tr><td><strong>Name:</strong> ' . checkEmpty($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name'] . ' ' . $student['extension']) . '</td>
                    <td><strong>Gender:</strong> ' . checkEmpty($student['gender']) . '</td></tr>
                <tr><td><strong>Email:</strong> ' . checkEmpty($student['email']) . '</td>
                    <td><strong>Birthdate:</strong> ' . checkEmpty(date('F d, Y', strtotime($student['birthdate']))) . '</td></tr>
                <tr><td><strong>Age:</strong> ' . checkEmpty($student['age']) . '</td>
                    <td><strong>Birth Place:</strong> ' . checkEmpty($student['birth_place']) . '</td></tr>
                <tr><td><strong>Marital Status:</strong> ' . checkEmpty($student['marital_status']) . '</td>
                    <td><strong>Religion:</strong> ' . checkEmpty($student['religion']) . '</td></tr>
                <tr><td><strong>Address:</strong> ' . checkEmpty($student['address']) . '</td>
                    <td><strong>Department:</strong> ' . checkEmpty($student['department']) . '</td></tr>
                <tr><td><strong>Year Level:</strong> ' . checkEmpty($student['year_level']) . '</td>
                    <td><strong>Additional Info:</strong> ' . checkEmpty($student['additional_info']) . '</td></tr>
            </table>

            <h2>Health Information</h2>
            <table class="info-table">
                <tr><td><strong>Blood Pressure:</strong> ' . checkEmpty($student['blood_pressure']) . '</td>
                    <td><strong>Temperature:</strong> ' . checkEmpty($student['temperature']) . '°C</td></tr>
                <tr><td><strong>Pulse Rate:</strong> ' . checkEmpty($student['pulse_rate']) . ' bpm</td>
                    <td><strong>Respiratory Rate:</strong> ' . checkEmpty($student['respiratory_rate']) . ' breaths/min</td></tr>
                <tr><td><strong>Height:</strong> ' . checkEmpty($student['height']) . ' cm</td>
                    <td><strong>Weight:</strong> ' . checkEmpty($student['weight']) . ' kg</td></tr>
            </table>

            <h2>Emergency Contacts</h2>
            <table class="info-table">
                <tr><td><strong>Name:</strong> ' . checkEmpty($student['eperson1_name']) . '</td>
                    <td><strong>Phone:</strong> ' . checkEmpty($student['eperson1_phone']) . '</td>
                    <td><strong>Relationship:</strong> ' . checkEmpty($student['eperson1_relationship']) . '</td></tr>
                <tr><td><strong>Name:</strong> ' . checkEmpty($student['eperson2_name']) . '</td>
                    <td><strong>Phone:</strong> ' . checkEmpty($student['eperson2_phone']) . '</td>
                    <td><strong>Relationship:</strong> ' . checkEmpty($student['eperson2_relationship']) . '</td></tr>
            </table>';

        // Add medical records
        if (!empty($records)) {
            $html .= '<h2>School Medical Records</h2>
                      <table class="records-table">
                        <thead>
                            <tr><th>Record Date</th><th>Chief Complaint</th><th>Treatment</th></tr>
                        </thead>
                        <tbody>';
            foreach ($records as $record) {
                $html .= '<tr>
                            <td>' . date('F d, Y', strtotime($record['record_date'])) . '</td>
                            <td>' . checkEmpty($record['chief_complaint']) . '</td>
                            <td>' . checkEmpty($record['treatment']) . '</td>
                          </tr>';
            }
            $html .= '</tbody></table>';
        }

        // Output PDF
        $pdf->writeHTML($html, true, false, true, false, '');
        ob_end_clean();
        $pdf->Output('student_medical_records_' . $student_id . '.pdf', 'I');
    }
}
