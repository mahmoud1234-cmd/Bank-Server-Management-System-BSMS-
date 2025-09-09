<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;

// Test file upload
$testFilePath = __DIR__.'/tests/TestFiles/test-avatar.png';

if (!file_exists($testFilePath)) {
    // Create a test image if it doesn't exist
    $im = imagecreatetruecolor(100, 100);
    $white = imagecolorallocate($im, 255, 255, 255);
    $blue = imagecolorallocate($im, 0, 0, 255);
    imagefill($im, 0, 0, $blue);
    imagestring($im, 5, 20, 40, 'Test Image', $white);
    
    if (!is_dir(dirname($testFilePath))) {
        mkdir(dirname($testFilePath), 0777, true);
    }
    
    imagepng($im, $testFilePath);
    imagedestroy($im);
    echo "Created test image at: $testFilePath\n";
}

// Test storage
$testStoragePath = 'test-uploads/test-' . time() . '.png';

try {
    // Test writing to storage
    $contents = file_get_contents($testFilePath);
    Storage::disk('public')->put($testStoragePath, $contents);
    
    // Test if file exists
    $exists = Storage::disk('public')->exists($testStoragePath);
    echo $exists ? "File written successfully to: storage/app/public/$testStoragePath\n" : "Failed to write file\n";
    
    // Test URL generation
    $url = Storage::disk('public')->url($testStoragePath);
    echo "File URL: $url\n";
    
    // Test directory permissions
    $storagePath = storage_path('app/public');
    $isWritable = is_writable($storagePath);
    echo "Storage directory is " . ($isWritable ? 'writable' : 'NOT writable') . "\n";
    
    // List contents of storage directory
    echo "\nContents of storage/app/public:\n";
    $files = Storage::disk('public')->allFiles();
    foreach ($files as $file) {
        $size = Storage::disk('public')->size($file);
        $time = date('Y-m-d H:i:s', Storage::disk('public')->lastModified($file));
        echo "- $file ($size bytes, modified: $time)\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

// Test profile photos directory
$profilePhotosPath = storage_path('app/public/profile-photos');
if (!file_exists($profilePhotosPath)) {
    echo "\nCreating profile photos directory: $profilePhotosPath\n";
    mkdir($profilePhotosPath, 0777, true);
}

echo "\nProfile photos directory exists: " . (file_exists($profilePhotosPath) ? 'Yes' : 'No') . "\n";
echo "Profile photos directory is writable: " . (is_writable($profilePhotosPath) ? 'Yes' : 'No') . "\n";
