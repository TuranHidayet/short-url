<?php

class HomeController extends Controller
{
    private $urlModel;
    // public $tofiq;

    public function __construct()
    {
        $this->urlModel = new Url();
    }

    public function index()
    {
        $data = [
            'title' => 'Welcome to the Home Page',
            'message' => 'This is the home page of our MVC application.'
        ];

        $this->json($data);
    }

    public function store()
    {
        $url = $_POST['url'] ?? null;

        if (!$url) {
            $this->json(['error' => 'URL is required'], 400);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->json(['error' => 'Invalid URL'], 400);
        }

        do {
            $shortCode = $this->generateCode();
        } while ($this->urlModel->exists($shortCode));

        $this->urlModel->create($url, $shortCode);

        $this->json([
            'short_url' => "http://localhost/$shortCode"
        ]);
    }

    private function generateCode($length = 6)
    {
        return substr(str_shuffle(
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        ), 0, $length);
    }

    public function redirect($shortCode)
    {
        $data = $this->urlModel->findByShortCode($shortCode);

        if (!$data) {
            $this->json(['error' => 'URL not found'], 404);
        }

        $this->urlModel->incrementClicks($shortCode);

        header("Location: " . $data['original_url']);
        exit;
    }

    public function stats($shortCode)
    {
        $data = $this->urlModel->findByShortCode($shortCode);

        if (!$data) {
            $this->json(['error' => 'Not found'], 404);
        }

        $this->json([
            'url' => $data['original_url'],
            'clicks' => $data['clicks']
        ]);
    }
}
