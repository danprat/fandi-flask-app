<?php
// Simple test page to verify PHP is working
echo "<h1>Fandi Flask App - PHP Service</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection
try {
    $host = 'mysql';
    $dbname = 'kampuspu_rt';
    $username = 'kampuspu_rt';
    $password = 'dhM3YMtk%ADD]Za-';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = '$dbname'");
    $result = $stmt->fetch();
    echo "<p>Database tables count: " . $result['count'] . "</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>Available Files:</h2>";
echo "<ul>";
$files = glob('*.php');
foreach($files as $file) {
    if($file != 'index.php') {
        echo "<li><a href='$file'>$file</a></li>";
    }
}
echo "</ul>";

echo "<hr>";
echo "<h2>System Info:</h2>";
phpinfo();
?>