<?php
/**
 * Custom Autoloader for the 'App\' Namespace (PSR-4 Style)
 * This file is required once in public/index.php to initialize the class loading mechanism.
 */

// spl_autoload_register ফাংশনটি PHP-কে বলে, যখন কোনো ক্লাস লোড করার দরকার হয়, তখন এই anonoymous ফাংশনটি কল করো।
spl_autoload_register(function ($class) {
    
    // --- ১. নেমস্পেস প্রিফিক্স এবং বেস ডিরেক্টরি সেট করা ---
    
    // আপনার সমস্ত কাস্টম ক্লাস 'App\' নেমস্পেস ব্যবহার করবে।
    $prefix = 'App\\'; 
    
    // আপনার ক্লাসের ফাইলগুলি project-root/app/ ফোল্ডার থেকে শুরু হবে।
    $base_dir = __DIR__ . '/app/';

    // 'App\' নেমস্পেসের দৈর্ঘ্য
    $len = strlen($prefix);

    // --- ২. চেক করা যে এটি আমাদের নেমস্পেস কিনা ---
    
    // যদি ক্লাসের নাম 'App\' দিয়ে শুরু না হয়, তবে এই Autoloader কিছু করবে না।
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // --- ৩. নেমস্পেস প্রিফিক্স বাদ দিয়ে আপেক্ষিক পাথ তৈরি করা ---
    
    // ক্লাসের নাম থেকে 'App\' অংশটি বাদ দেওয়া
    $relative_class = substr($class, $len); // যেমন: 'Controllers\UserController'
    
    // --- ৪. ক্লাসের নামকে ফাইলের পাথে রূপান্তর করা এবং লোড করা ---
    
    // ব্যাকস্ল্যাশ ('\') কে ডিরেক্টরি সেপারেটর ('/') দিয়ে প্রতিস্থাপন করা
    // এবং শেষে '.php' যুক্ত করা
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // ফাইলটি বিদ্যমান থাকলে, তা লোড করা
    if (file_exists($file)) {
        require $file;
    }
});