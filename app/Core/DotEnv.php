<?php

    class DotEnv {
        protected string $fileName;

        public function __construct(string $fileName) {
            if(!file_exists($fileName)) {
                throw new Exception("File $fileName does not exist");
            }

            $this->fileName = $fileName;
        }

        public function load(): void {
            if(!is_readable($this->fileName)) {
                throw new RuntimeException(sprintf('%s is not readable', $this->fileName));
            }

            $lines = file($this->fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach($lines as $line) {
                if (str_starts_with(trim($line), '#'))  continue;

                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }