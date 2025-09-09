<?php

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;

// Test storage directory
$storagePath = storage_path('app/public');
$testFilePath = $storagePath . '/test-file.txt';

// Test writing a file
file_put_contents($testFilePath, 'Test content');

echo "Test file created at: $testFilePath\n";
echo "File exists: " . (file_exists($testFilePath) ? 'Yes' : 'No') . "\n";
echo "File content: " . file_get_contents($testFilePath) . "\n";

// Test Storage facade
$storageTestPath = 'storage-test-' . time() . '.txt';
Storage::disk('public')->put($storageTestPath, 'Storage test content');

echo "Storage test file created\n";
echo "Storage file exists: " . (Storage::disk('public')->exists($storageTestPath) ? 'Yes' : 'No') . "\n";

// List files in storage/app/public
$files = Storage::disk('public')->allFiles();
echo "\nFiles in storage/app/public:\n";
foreach ($files as $file) {
    echo "- $file\n";
}
