# Telephone Call Reporting Dashboard

This is a simple PHP-based web application for analyzing and reporting on telephone call logs from a MySQL database. It provides a dashboard view with a bar chart, a monthly summary table, and a detailed view of individual calls.

## Features

- **Dashboard:** Displays a yearly overview with a bar chart and a summary table of total calls and costs per month.
- **Monthly Summary:** Drill down from the dashboard to view a summary of calls for a specific month, grouped by extension.
- **Call Details:** View a detailed, paginated list of all calls for a selected extension and month.
- **Dynamic Data:** The application dynamically fetches and displays data for the current year.
- **Secure Configuration:** Uses a `.env` file to store sensitive database credentials, which are ignored by Git to ensure they are not publicly exposed.

## Requirements

- PHP 7.4 or higher
- MySQL database
- A web server (like Apache or Nginx)
- `Chart.js` (included via CDN)

## Setup and Installation

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/tmzamane/bvs.git
    ```

2.  **Database Setup:**
    -   Import your call log data into a MySQL database. The application expects a table named `BVSCalls`.

3.  **Configure Database Connection:**
    -   Create a new file named `.env` in the root of your project directory.
    -   Add your database credentials to the file in this format:

    ```php
    <?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'your_username');
    define('DB_PASS', 'your_password');
    define('DB_NAME', 'your_database_name');
    ?>
    ```
    -   **Important:** Do not commit or push this `.env` file to your Git repository. The `.gitignore` file is already configured to prevent this.

4.  **Run the Application:**
    -   Place the project files in your web server's document root (e.g., `C:\xampp\htdocs`).
    -   Open your web browser and navigate to the project URL (e.g., `http://localhost/bvs`).

## Database Schema

The application uses a single table named `BVSCalls`. The schema is as follows:

| Column Name | Data Type | Description |
|---|---|---|
| `CallFrom` | VARCHAR | The extension that initiated the call. |
| `CallTo` | VARCHAR | The destination number of the call. |
| `CallTime` | DATETIME | The date and time the call was made. |
| `Duration` | INT | The duration of the call in seconds. |
| `Cost` | DECIMAL(10, 2) | The cost of the call in Rands. |

## File Structure

-   `index.php`: The main entry point and routing logic for the application.
-   `templates/`: A folder containing the HTML and PHP code for each page (`page1.php`, `page2.php`, `page3.php`).
-   `includes/db.php`: *(Note: This file is no longer used for credentials. Its function has been replaced by the `.env` file for security reasons.)*
-   `.env`: The secure file for storing database credentials (ignored by Git).
-   `.gitignore`: Tells Git which files to ignore.
-   `README.md`: This file.

## Contributing

Feel free to open issues or submit pull requests.

## License

This project is open-source.
