
 <html>
<head>
<meta charset="utf-8">
<title>View Documents</title>
</head>
<body>

<?php
$file = 'dummy.pdf';
$filename = 'dummy.pdf';
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($file));
header('Accept-Ranges: bytes');
@readfile($file);
?>

</body>
</html>
