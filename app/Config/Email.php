    public function __construct()
    {
        parent::__construct();

        $host = env('SMTP_HOST');
        $user = env('SMTP_USER');
        $pass = env('SMTP_PASS');

        if ($host && $user && $pass) {
            $this->protocol    = 'smtp';
            $this->SMTPHost    = $host;
            $this->SMTPUser    = $user;
            $this->SMTPPass    = $pass;
            $this->SMTPPort    = (int) (env('SMTP_PORT') ?: 587);
            $this->SMTPCrypto  = env('SMTP_CRYPTO') ?: 'tls';
            $this->SMTPTimeout = 30;
            $this->mailType    = 'html';
            $this->fromEmail   = env('SMTP_FROM') ?: $user;
            $this->fromName    = 'Little Doctors';
        }
    }