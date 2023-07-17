<?php
// Include the database connection file
require_once 'connection.php';

// Function to retrieve gender options from the database
function getGenderOptions()
{
    // Query the tbl_gender table to get gender options
    $query = "SELECT id, gender_name FROM tbl_gender";
    // Execute the query
    global $conn;
    $result = $conn->query($query);

    // Store the gender options in an associative array
    $genderOptions = array();
    while ($row = $result->fetch_assoc()) {
        $genderOptions[$row['id']] = $row['gender_name'];
    }

    // Return the gender options
    return $genderOptions;
}

// Function to retrieve service options from the database
function getServiceOptions()
{
    // Query the tbl_services table to get service options
    $query = "SELECT id, service_name FROM tbl_services";
    // Execute the query
    global $conn;
    $result = $conn->query($query);

    // Store the service options in an associative array
    $serviceOptions = array();
    while ($row = $result->fetch_assoc()) {
        $serviceOptions[$row['id']] = $row['service_name'];
    }

    // Return the service options
    return $serviceOptions;
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form inputs
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $service = $_POST['service'];
    $comments = $_POST['comments'];

    // Insert the data into the database
    $query = "INSERT INTO tbl_patient (name, gender_id, date_of_birth, comments) VALUES ('$name', $gender, '$dob', '$comments')";
    // Execute the query
    $conn->query($query);

    // Retrieve the patient ID of the newly inserted record
    $patientId = $conn->insert_id;

    // Insert the patient-service relationship into the database
    $query = "INSERT INTO tbl_appointment_services (patient_id, service_id) VALUES ($patientId, $service)";
    // Execute the query
    $conn->query($query);

    // Redirect the user back to the same page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!-- HTML form -->
<form method="POST" action="">
    <label for="name">Name of Patient:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required><br><br>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <!-- Gender options generated dynamically in PHP -->
        <?php
        // Retrieve gender options from the database
        $genderOptions = getGenderOptions();

        // Generate the dropdown options
        foreach ($genderOptions as $genderId => $genderName) {
            echo "<option value='$genderId'>$genderName</option>";
        }
        ?>
    </select><br><br>

    <label for="service">Type of Service:</label>
    <select id="service" name="service" required>
        <!-- Service options generated dynamically in PHP -->
        <?php
        // Retrieve service options from the database
        $serviceOptions = getServiceOptions();

        // Generate the dropdown options
        foreach ($serviceOptions as $serviceId => $serviceName) {
            echo "<option value='$serviceId'>$serviceName</option>";
        }
        ?>
    </select><br><br>

    <label for="comments">General Comments:</label>
    <textarea id="comments" name="comments"></textarea><br><br>

    <button type="submit">Submit</button>
</form>

<?php
// Retrieve data from the database
$query = "SELECT p.name, p.date_of_birth, g.gender_name, s.service_name, p.comments
          FROM tbl_patient p
          INNER JOIN tbl_gender g ON p.gender_id = g.id
          INNER JOIN tbl_appointment_services a ON p.id = a.patient_id
          INNER JOIN tbl_services s ON a.service_id = s.id";
$result = $conn->query($query);
?>
<!-- Display the entered data in a table -->
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Date Of Birth</th>
            <th>Gender</th>
            <th>Type Of Services</th>
            <th>General comments</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterate through the result set and display the data in table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['name']}</td>";
            echo "<td>" . date("d/m/Y", strtotime($row['date_of_birth'])) . "</td>";
            echo "<td>{$row['gender_name']}</td>";
            echo "<td>{$row['service_name']}</td>";
            echo "<td>{$row['comments']}</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Function to retrieve the patient visit count from the database
function getPatientVisitCount($patientId)
{
    global $conn;
    $query = "SELECT COUNT(*) as visit_count FROM tbl_appointment_services WHERE patient_id = $patientId";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['visit_count'];
}

// Retrieve data from the database
$query = "SELECT p.id, p.name, p.date_of_birth, g.gender_name, s.service_name, p.comments
          FROM tbl_patient p
          INNER JOIN tbl_gender g ON p.gender_id = g.id
          INNER JOIN tbl_appointment_services a ON p.id = a.patient_id
          INNER JOIN tbl_services s ON a.service_id = s.id";
$result = $conn->query($query);

// Create an array to store the visit count for each patient
$patientVisits = array();

// Iterate through the result set and store visit count for each patient
while ($row = $result->fetch_assoc()) {
    $patientId = $row['id'];
    if (!isset($patientVisits[$patientId])) {
        $patientVisits[$patientId] = getPatientVisitCount($patientId);
    }
}

// Sort the patient visits array in descending order
arsort($patientVisits);
?>

<!-- Display the entered data in a table -->
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>
<h1>PATIENTS WITH MOST VISITS:</h1>
<table style="width: 100%;">
    <thead>
        <tr>
            <th>Name</th>
            <th>Date Of Birth</th>
            <th>Gender</th>
            <th>Type Of Services</th>
            <th>General comments</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Iterate through the result set and display the data in table rows
        while ($row = $result->fetch_assoc()) {
            $patientId = $row['id'];
            $highlightClass = ($patientVisits[$patientId] == max($patientVisits)) ? "highlight" : "";
            echo "<tr class='$highlightClass'>";
            echo "<td>{$row['name']}</td>";
            echo "<td>" . date("d/m/Y", strtotime($row['date_of_birth'])) . "</td>";
            echo "<td>{$row['gender_name']}</td>";
            echo "<td>{$row['service_name']}</td>";
            echo "<td>{$row['comments']}</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>