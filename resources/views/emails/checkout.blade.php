<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Check-Out Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #dc3545;">Check-Out Completed</h2>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Task:</strong> {{ $task }}</p>
        <p><strong>Checked Out At:</strong> {{ $time }}</p>
        <p><strong>Total Time Worked:</strong> {{ $workedHours }}</p>
        <hr>
        <p style="font-size: 12px; color: #666;">This is an automated notification from your dodolog system.</p>
    </div>
</body>
</html>
