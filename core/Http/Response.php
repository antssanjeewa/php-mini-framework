<?php

namespace Core\Http;

class Response
{
  public function __construct(protected string $content = '', protected int $status = 200, protected array $headers = [])
  {
  }

  public function send()
  {
    foreach ($this->headers as $name => $value) {
      header("$name:$value");
    }

    http_response_code($this->status);

    echo $this->content;
  }
}