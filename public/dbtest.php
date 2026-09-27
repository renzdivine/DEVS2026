<?php
// DELETE THIS FILE after fixing login
define('BASE_URL', '');
require_once __DIR__ . '/../config/Database.php';

$db = (new Database())->connect();

// Show every admin row
$result = $db->query("SELECT admin_id, admin_username, admin_password FROM admins");
echo '<h2>Admins table</h2><table border="1" cellpadding="8">';
echo '<tr><th>ID</th><th>Username</th><th>Password hash (stored)</th><th>Is valid bcrypt?</th></tr>';
while ($row = $result->fetch_assoc()) {
    $isBcrypt = str_starts_with($row['admin_password'], '$2y$') ? '<span style="color:green">YES</span>' : '<span style="color:red">NO — plain text, must be hashed</span>';
    echo "<tr>
        <td>{$row['admin_id']}</td>
        <td><strong>{$row['admin_username']}</strong></td>
        <td style='font-size:11px;word-break:break-all'>{$row['admin_password']}</td>
        <td>$isBcrypt</td>
    </tr>";
}
echo '</table>';

// Test password_verify against known passwords
echo '<h2>Password verify test</h2>';
$tests = [
    ['devs',  'devs2026'],
    ['admin', 'devs-admin-2026'],
    ['admin', 'devs2026'],
    ['devs',  'devs-admin-2026'],
];
$result2 = $db->query("SELECT admin_username, admin_password FROM admins");
$rows = $result2->fetch_all(MYSQLI_ASSOC);

foreach ($tests as [$u, $p]) {
    foreach ($rows as $row) {
        if ($row['admin_username'] === $u) {
            $ok = password_verify($p, $row['admin_password']);
            $label = $ok ? '<span style="color:green">✔ MATCH</span>' : '<span style="color:red">✘ no match</span>';
            echo "<p>username=<strong>$u</strong> + password=<strong>$p</strong> → $label</p>";
        }
    }
}

// Fix button — generates correct hash and updates
if (isset($_GET['fix'])) {
    $user = $_GET['u'] ?? 'admin';
    $pass = $_GET['p'] ?? 'devs-admin-2026';
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE admins SET admin_password = ? WHERE admin_username = ?");
    $stmt->bind_param("ss", $hash, $user);
    $stmt->execute();
    echo "<p style='color:green;font-weight:bold'>✔ Password for '$user' updated to '$pass'. <a href='dbtest.php'>Refresh to verify</a></p>";
}

echo '<hr><h2>Fix your password</h2>';
echo '<p><a href="dbtest.php?fix=1&u=admin&p=devs-admin-2026" style="padding:10px 16px;background:#151413;color:#fff;text-decoration:none;border-radius:4px;margin-right:8px">Set admin / devs-admin-2026</a>';
echo '<a href="dbtest.php?fix=1&u=devs&p=devs2026" style="padding:10px 16px;background:#C86142;color:#fff;text-decoration:none;border-radius:4px">Set devs / devs2026</a></p>';
echo '<p style="color:red;font-size:13px">⚠ Delete this file immediately after fixing.</p>';
?>
