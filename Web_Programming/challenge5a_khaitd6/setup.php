<?php
$uploadDirs = [
    'uploads/avatars',
    'uploads/assignments', 
    'uploads/submissions',
    'uploads/challenges'
];

foreach ($uploadDirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
        echo "Created directory: " . $dir . "<br>";
    } else {
        echo "Directory already exists: " . $dir . "<br>";
    }
}

// Create .htaccess file in uploads directory
$htaccess = "Options -Indexes";
file_put_contents('uploads/.htaccess', $htaccess);
echo "Created .htaccess file in uploads directory<br>";

echo "<br>Setup completed successfully!";
?>
