
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>How to Generate QR Code in Laravel 9</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Simple QR Code</h2>
        </div>
        <div class="card-body">
            <?php echo QrCode::size(300)->generate('hello world'); ?>

        </div>
    </div>


    <?php echo e(QrCode::geo(37.822214, -122.481769)); ?>


    <div class="card">
        <div class="card-header">
            <h2>Color QR Code</h2>
        </div>
        <div class="card-body">
            <?php echo QrCode::size(300)->backgroundColor(255,90,0)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-9'); ?>

        </div>
    </div>
</div>
</body>
</html>
<?php /**PATH /home/mchdmana/public_html/resources/views/qrcode.blade.php ENDPATH**/ ?>