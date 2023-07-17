# Health Records Management System

The Health Records Management System is a web application that allows users to input and manage patient information, appointments, and services provided by a private clinic.

## Deployment Instructions

To deploy the Health Records Management System, follow the steps below:

### Prerequisites

1. Make sure you have a web server with PHP support (e.g., Apache, Nginx) installed and running.
2. Ensure you have a MySQL database server available.

### Installation Steps

1. Clone or download the project repository to your local machine.
2. Create a new MySQL database for the application.
3. Import the database schema by executing the `odidi_private_clinic_normalized.sql` script located in the project's root directory. This will create the necessary tables in the database.
4. Configure the database connection settings by modifying the `connection.php` file. Update the `$hostname`, `$username`, `$password`, `$database`, and `$port` variables with the appropriate values based on your MySQL server configuration.
5. Upload the project files to your web server, making sure they are accessible from the web root directory.
6. Ensure the web server has proper read and write permissions to the project files and directories.
7. Access the application through a web browser by entering the URL corresponding to the uploaded files.

## Usage

1. Open the Health Records Management System in your web browser.
2. Fill in the patient details in the provided form, including the name, date of birth, gender, type of service, and general comments.
3. Click the "Submit" button to save the patient information and associated appointment details.
4. The entered data will be stored in the MySQL database and displayed in the table on the same page.
5. Patients with multiple visits will have their rows highlighted to indicate they have the most visits.

## Troubleshooting

- If you encounter any issues during deployment or usage of the system, please check the following:
  - Ensure the database connection settings in the `connection.php` file are correct.
  - Confirm that the MySQL server is running and accessible from the web server.
  - Check the file permissions for the project files and directories.
  - Verify that the required PHP extensions are installed and enabled on your web server.

