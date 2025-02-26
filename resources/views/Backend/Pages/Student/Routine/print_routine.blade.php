<!-- <!DOCTYPE html>
<html>
<head>
    <title>Print Class Routine</title>
    <style>
        /* Add some styles to format the print page */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Class Routine </h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1
            @endphp
            @foreach($routines as $routine)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $routine->subject->name }}</td>
                    <td>{{ $routine->teacher->name }}</td>
                    <td>11.30 Am</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> -->



<!DOCTYPE html>
<html>
<head>
    <title>Print Class Routine</title>
    <style>
        /* Basic styling for body and elements */
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        /* School Header Section */
        .school-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .school-header img {
            width: 100px; /* Logo width */
            height: auto;
        }

        .school-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .school-header p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* Table styling */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 16px;
        }

        td {
            font-size: 14px;
        }

        /* Footer Section */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Print Button */
        .print-button {
            text-align: center;
            margin-top: 20px;
        }

        .print-button button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .print-button button:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>

    <!-- School Header Section -->
    <div class="school-header">
        <img src="https://thumbs.dreamstime.com/b/education-purpose-logo-used-school-college-university-sign-symbol-91960150.jpg" alt="School Logo"> 
        <h1>Future Ict School</h1>
        <p>Gouripur, Daudkandi, Cumilla, Bangladesh</p>
        <p>Phone: +880123456789 | Email: info@futureict.com</p>
    </div>

    <!-- Routine Title -->
    <h2 style="text-align: center; text-decoration: underline; margin-bottom: 20px;">Class Routine</h2>

    <!-- Routine Table -->
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Subject</th>
                <th>Teacher</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1
            @endphp
            @foreach($routines as $routine)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $routine->subject->name }}</td>
                    <td>{{ $routine->teacher->name }}</td>
                    <td>11:30 AM</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Section -->
    <div class="footer">
        <p><strong>Principal Signature:</strong> ______________________</p>
        <br>
        <p><strong>Date:</strong> ______________________</p>
    </div>

</body>
</html>
