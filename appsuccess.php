<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Submitted</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Application Submitted Successfully</h3>
        </div>
        <div class="card-body">
            <p><strong>Reference ID:</strong> <?php echo htmlspecialchars($_GET['refid']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($_GET['name']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($_GET['date']); ?></p>
        </div>
        <div class="card-footer text-end">
            <a href="index.php" class="btn btn-primary">Home</a>
            <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
        </div>
    </div>
</div>
</body>
</html>