<?php
// Place this in your admin directory

echo "<h2>Directory Permission Test</h2>";

// Check current directory
echo "<p>Current directory: " . getcwd() . "</p>";
echo "<p>PHP User: " . get_current_user() . "</p>";

// Test target directory
$upload_dir = "img/vehicleimages/";

// Check if directory exists
echo "<p>Does directory exist? " . (file_exists($upload_dir) ? "Yes" : "No") . "</p>";

// If not, try to create it
if (!file_exists($upload_dir)) {
    echo "<p>Attempting to create directory...</p>";
    if (mkdir($upload_dir, 0755, true)) {
        echo "<p>Successfully created directory.</p>";
    } else {
        echo "<p>Failed to create directory.</p>";
    }
}

// Check if directory is writable
echo "<p>Is directory writable? " . (is_writable($upload_dir) ? "Yes" : "No") . "</p>";

// Try to write a test file
$test_file = $upload_dir . "test.txt";
if (file_put_contents($test_file, "This is a test")) {
    echo "<p>Successfully wrote test file.</p>";
    
    // Read the test file
    echo "<p>File contents: " . file_get_contents($test_file) . "</p>";
    
    // Delete the test file
    if (unlink($test_file)) {
        echo "<p>Successfully deleted test file.</p>";
    } else {
        echo "<p>Failed to delete test file.</p>";
    }
} else {
    echo "<p>Failed to write test file.</p>";
}

// List all files in directory
echo "<h3>Files in directory:</h3>";
if (file_exists($upload_dir)) {
    $files = scandir($upload_dir);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file != "." && $file != "..") {
            echo "<li>$file</li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>Cannot list files: Directory does not exist.</p>";
}

// Check if parent directories are writable
$dirs = explode("/", $upload_dir);
$path = "";
echo "<h3>Parent Directory Permissions:</h3>";
echo "<ul>";
foreach ($dirs as $dir) {
    if (!empty($dir)) {
        $path .= $dir . "/";
        echo "<li>$path: " . (is_writable($path) ? "Writable" : "Not Writable") . "</li>";
    }
}
echo "</ul>";
?>