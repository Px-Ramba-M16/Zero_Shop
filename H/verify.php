<?php
header('Content-Type: application/json');

// โหลดข้อมูลคีย์
$file = "Keys.json";
if (!file_exists($file)) file_put_contents($file, "{}");

$keys = json_decode(file_get_contents($file), true);

$key = $_GET['key'] ?? '';
$hwid = $_GET['hwid'] ?? '';

if (!$key || !$hwid) {
    echo json_encode(["success" => false, "message" => "Missing key or HWID"]);
    exit;
}

if (!isset($keys[$key])) {
    echo json_encode(["success" => false, "message" => "Invalid key"]);
    exit;
}

$info = $keys[$key];

// ถ้ายังไม่มี HWID → ผูกไว้
if (empty($info['hwid'])) {
    $keys[$key]['hwid'] = $hwid;
    file_put_contents($file, json_encode($keys, JSON_PRETTY_PRINT));
    $info['hwid'] = $hwid;
}

// ถ้า HWID ไม่ตรง
if ($info['hwid'] !== $hwid) {
    echo json_encode(["success" => false, "message" => "HWID mismatch"]);
    exit;
}

// ถ้าคีย์หมดอายุ
if (time() > $info['expires_at']) {
    echo json_encode(["success" => false, "message" => "Key expired (24h passed)"]);
    exit;
}

// ผ่านทุกเงื่อนไข
echo json_encode(["success" => true, "message" => "Key verified"]);
?>