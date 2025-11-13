<?php
namespace App\Core;

use \PDO;
use \PDOException;

class Database {
    protected $pdo;

    /**
     * ডেটাবেস সংযোগ স্থাপন করে।
     * @param array $config ডেটাবেস কনফিগারেশন সেটিংস (host, name, user, password, charset)
     */
    public function __construct(array $config) {
        // DSN (Data Source Name) তৈরি করা
        $dsn = "mysql:host={$config['host']};dbname={$config['name']};charset={$config['charset']}";
        
        // PDO অপশন সেট করা (নিরাপত্তা এবং ভালো পারফরম্যান্সের জন্য গুরুত্বপূর্ণ)
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // ত্রুটির ক্ষেত্রে ব্যতিক্রম (Exception) নিক্ষেপ করা
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // ডিফল্টভাবে অ্যাসোসিয়েটিভ অ্যারেতে ডেটা আনা
            PDO::ATTR_EMULATE_PREPARES   => false,                // সিকিউরিটি বাড়ানোর জন্য নেটিভ প্রেপারেশন ব্যবহার করা
        ];
        
        try {
            // PDO ইনস্ট্যান্স তৈরি করে ডেটাবেসের সাথে সংযোগ স্থাপন করা
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], $options);
        } catch (PDOException $e) {
            // সংযোগ ব্যর্থ হলে একটি JSON রেসপন্স দিয়ে এক্সিট করা
            // আপনার Response ক্লাস ব্যবহার করে ত্রুটি জানানো হচ্ছে
            Response::json(['error' => 'Database connection failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * একটি SQL স্টেটমেন্ট এক্সিকিউট করে (SELECT, INSERT, UPDATE, DELETE এর জন্য ব্যবহৃত হয়)।
     * * এই মেথডটি SQL Injection থেকে সুরক্ষার জন্য Prepared Statements ব্যবহার করে।
     * @param string $sql এক্সিকিউট করার জন্য SQL কোয়েরি
     * @param array $params প্যারামিটারগুলির একটি অ্যাসোসিয়েটিভ অ্যারে (যেমন: [':name' => 'John'])
     * @return \PDOStatement
     */
    public function execute(string $sql, array $params = []): \PDOStatement {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * ডেটাবেস থেকে ডেটা আনতে ব্যবহৃত হয় (SELECT)।
     * @param string $sql SQL কোয়েরি
     * @param array $params প্যারামিটার
     * @return array প্রাপ্ত সমস্ত রেকর্ড
     */
    public function query(string $sql, array $params = []): array {
        return $this->execute($sql, $params)->fetchAll();
    }
    
    /**
     * একটি নতুন রেকর্ডের সন্নিবেশ আইডি (Last Insert ID) ফেরত দেয়।
     * @return string
     */
    public function lastInsertId(): string {
        return $this->pdo->lastInsertId();
    }
}