    public function __construct()
    {
        parent::__construct();

        $host = env('SMTP_HOST');
        $user = env('SMTP_USER');
        $pass = env('SMTP_PASS');

        // Always set a From address
        $this->fromEmail = env('SMTP_FROM') ?: ($user ?: 'noreply@little-doctors-c14.wasmer.app');
        $this->fromName  = 'Little Doctors';
        $this->mailType  = 'html';

        // Optional: use SMTP only if credentials are provided
        if ($host && $user && $pass) {
            $this->protocol    = 'smtp';
            $this->SMTPHost    = $host;
            $this->SMTPUser    = $user;
            $this->SMTPPass    = $pass;
            $this->SMTPPort    = (int) (env('SMTP_PORT') ?: 587);
            $this->SMTPCrypto  = env('SMTP_CRYPTO') ?: 'tls';
            $this->SMTPTimeout = 30;
        }
    }