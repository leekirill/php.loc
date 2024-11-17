<?php

    declare(strict_types=1);

    use http\Header;

    require_once 'Status.php';
    require_once 'ContentType.php';

    class Response {
        public function __construct(
            private string $body,
            private Status $status = Status::OK,
            private array  $headers = [],
        ) {
            $this->body = $body;
            $this->status = $status;

            foreach ($headers as $key => $values) {
                if (!is_array($values)) {
                    $values = [$values];
                } else {
                    foreach ($values as $value) {
                        $this->addHeader($key, $value);
                    }
                }
            }
        }

        public function addHeader(string $key, string $value): self {
            $this->headers[$key] ??= new Header($value);
            $this->headers[$key]->add($value);

            return $this;
        }

        public function removeHeader(string $key): self {

            unset($this->headers[$key]);
            return $this;
        }

        public function getBody(): string {
            return $this->body;
        }

        public function getStatus(): Status {
            return $this->status;
        }

        public function getHeaders(): array
        {
            return $this->headers;
        }

        public function getHeader($name): array
        {
            return $this->headers[$name] ??= null;
        }

        public function setStatus(Status $status): self
        {
            $this->status = $status;
            return $this;
        }

        public function setContentType(ContentType $value): self
        {
            $this->removeHeader(ContentType::HEADER)
                ->addHeader(ContentType::HEADER, $value->value);

            return $this;
        }

        public function send(): void {
            ob_start();
            $this->sendHeaders();
            ob_flush();
            $this->sendContent();
            ob_get_clean();
        }

        public function sendHeaders(): void {
            if (headers_sent()) return;

            foreach ($this->resolveHeaders() as $header) {
                header($header);
            }

            http_response_code($this->getStatus()->value);
        }

        public function resolveHeaders(): Generator
        {
            $headers = $this->getHeaders();

            foreach ($headers as $key => $header) {
                foreach ($header->values as $value) {
                    yield "{$key}: {$value}";
                }
            }
        }

        public function sendContent(): void {
            foreach ($this->resolveBody() as $content) {
                echo $content;
                ob_flush();
            }
        }

        public function resolveBody(): Generator {
            $body = $this->getBody();

            if (is_array($body)) {
                yield json_encode($body);
            } else {
                yield $body;
            }
        }
    }