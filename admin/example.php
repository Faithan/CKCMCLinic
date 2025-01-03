<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Checker</title>
</head>
<body>

    <div class="input-container">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <p id="student-id-message"></p> <!-- Message will appear here -->
        <button type="submit" id="save-student" disabled>Save</button>
    </div>

    <script>
        let debounceTimer;

        document.getElementById('student_id').addEventListener('input', function() {
            clearTimeout(debounceTimer);  // Clear any previously set timer

            let studentId = this.value;
            let messageElem = document.getElementById('student-id-message');
            let saveButton = document.getElementById('save-student');

            // If student ID is empty, reset everything
            if (!studentId) {
                messageElem.textContent = '';
                messageElem.style.color = '';
                saveButton.disabled = true;
                return;
            }

            // Set a new timer to call the check function after 500ms of inactivity
            debounceTimer = setTimeout(function() {
                checkStudentIdAvailability(studentId);
            }, 500);  // 500ms delay
        });

        function checkStudentIdAvailability(studentId) {
            let messageElem = document.getElementById('student-id-message');
            let saveButton = document.getElementById('save-student');

            // Create a new XMLHttpRequest to send to the server
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'check_student_id.php?student_id=' + encodeURIComponent(studentId), true);

            // Log the request to ensure it's being sent correctly
            console.log("Sending request to check student ID:", studentId);

            // When the request completes
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = xhr.responseText.trim(); // Get the response from PHP
                    console.log("Server Response:", response);

                    if (response === 'taken') {
                        messageElem.textContent = 'This Student ID is already taken.';
                        messageElem.style.color = 'red';
                        saveButton.disabled = true;
                    } else if (response === 'available') {
                        messageElem.textContent = 'This Student ID is available.';
                        messageElem.style.color = 'green';
                        saveButton.disabled = false;
                    } else {
                        messageElem.textContent = 'Error checking Student ID.';
                        messageElem.style.color = 'orange';
                        saveButton.disabled = true;
                    }
                } else {
                    messageElem.textContent = 'Server error, try again later.';
                    messageElem.style.color = 'orange';
                    saveButton.disabled = true;
                    console.error("Server Error:", xhr.status, xhr.statusText);
                }
            };

            // Handle network errors
            xhr.onerror = function() {
                messageElem.textContent = 'Network error, try again later.';
                messageElem.style.color = 'orange';
                saveButton.disabled = true;
                console.error("Network Error:", xhr.status, xhr.statusText);
            };

            // Send the GET request to the server
            xhr.send();
        }
    </script>

</body>
</html>
