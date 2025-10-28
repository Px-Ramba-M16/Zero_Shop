<?php
header('Content-Type: application/json');

// โหลดข้อมูลคีย์
$file = "Keys.json";
if (!file_exists($file)) file_put_contents($file, "{}");

$keys = json_decode(file_get_contents($file), true);

// สร้างคีย์ใหม่ (6 ตัว)
function generateKey($length = 6) {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $key = "";
    for ($i = 0; $i < $length; $i++) {
        $key .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $key;
}

// สร้างคีย์ที่ไม่ซ้ำ
do {
    $newKey = generateKey();
} while (isset($keys[$newKey]));

// เพิ่มคีย์ลงระบบ (24 ชั่วโมง)
$keys[$newKey] = [
    "type" => "24h",
    "expires_at" => time() + 86400, // 24 ชม.
    "hwid" => ""
];

// บันทึกลงไฟล์
file_put_contents($file, json_encode($keys, JSON_PRETTY_PRINT));

// แสดงผล
echo json_encode([
    "success" => true,
    "key" => $newKey,
    "expires_in" => "24 hours",
    "message" => "New 24h key created successfully!"
], JSON_PRETTY_PRINT);
?>