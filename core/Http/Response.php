<?php

namespace Core\Http;

class Response
{
  public const HTTP_OK = 200;
  public const HTTP_NOT_FOUND = 404;
  public const HTTP_REDIRECT = 302;

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