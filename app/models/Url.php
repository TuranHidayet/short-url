<?php

require_once __DIR__ . '/../core/Database.php';

class Url
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($originalUrl, $shortCode)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO short_links (original_url, short_code) 
             VALUES (:original_url, :short_code)"
        );

        return $stmt->execute([
            'original_url' => $originalUrl,
            'short_code'   => $shortCode
        ]);
    }

    public function findByShortCode($shortCode)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM short_links WHERE short_code = :short_code"
        );

        $stmt->execute(['short_code' => $shortCode]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function incrementClicks($shortCode)
    {
        $stmt = $this->db->prepare(
            "UPDATE short_links 
             SET clicks = clicks + 1 
             WHERE short_code = :short_code"
        );

        return $stmt->execute(['short_code' => $shortCode]);
    }

    public function exists($shortCode)
    {
        $stmt = $this->db->prepare(
            "SELECT id FROM short_links WHERE short_code = :short_code"
        );

        $stmt->execute(['short_code' => $shortCode]);

        return $stmt->fetch() ? true : false;
    }
}