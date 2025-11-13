<?php
namespace App\Core;

class Response {
    
    /**
     * ডেটা JSON ফরম্যাটে এনকোড করে ক্লায়েন্টের কাছে পাঠায় এবং HTTP স্ট্যাটাস কোড সেট করে।
     * * @param array $data 
     * @param int $status HTTP স্ট্যাটাস কোড (যেমন: 200, 201, 400)
     * @return void
     */
    public static function json(array $data, int $status = 200): void {
        // ১. Content-Type হেডার সেট করা
        header('Content-Type: application/json');
        
        // ২. HTTP স্ট্যাটাস কোড সেট করা
        http_response_code($status);
        
        // ৩. ডেটা JSON এনকোড করে আউটপুট করা
        echo json_encode($data);
        
        // ৪. এখানেই স্ক্রিপ্ট এক্সিকিউশন বন্ধ করা
        exit(); 
    }
    
    // আপনি চাইলে অন্য রেসপন্স ফরম্যাটের জন্য (যেমন: text(), html()) মেথড যোগ করতে পারেন
}