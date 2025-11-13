<?php
namespace App\Core;

class Request {
    
    /**
     * রিকোয়েস্টের JSON বডি থেকে ডেটা আনে।
     * * @return array
     */
    public function json(): array {
        // raw PHP ইনপুট স্ট্রিম থেকে ডেটা নিয়ে JSON ডিকোড করা
        $content = file_get_contents('php://input');
        // অ্যারে আকারে ডেটা ফেরত দেওয়া, যদি ডিকোড না হয় তবে ফাঁকা অ্যারে
        return json_decode($content, true) ?? [];
    }

    /**
     * GET কোয়েরি প্যারামিটার থেকে ডেটা আনে এবং স্যানিটাইজ করে।`
     * * @param string|null $key 
     * @return mixed|array
     */
    public function query(?string $key = null) {
        if ($key) {
            // ইনপুট স্যানিটাইজেশন (XSS সুরক্ষা)
            if (isset($_GET[$key])) {
                // htmlspecialchars ব্যবহার করে ডেটা নিরাপদ করা
                return htmlspecialchars($_GET[$key], ENT_QUOTES, 'UTF-8');
            }
            return null;
        }
        // সব GET প্যারামিটার ফেরত দেওয়া
        return $_GET;
    }
    
    /**
     * রিকোয়েস্ট মেথড (GET, POST, PUT, DELETE) ফেরত দেয়।
     * * @return string
     */
    public function method(): string {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }

    // আপনি চাইলে এখানে header(), file() ইত্যাদি মেথডও যোগ করতে পারেন
}