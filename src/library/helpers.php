<?php
namespace App\Lib;
function base_url(): string {
  $script = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
  $dir = rtrim(str_replace('index.php','',$script), '/');
  return $dir === '' ? '/' : $dir . '/';
}
function url_to(string $route): string { return base_url().'index.php?r='.$route; }
function view(string $path, array $data=[]): void {
  extract($data);
  $viewPath = __DIR__ . '/../view/' . $path . '.php';
  if ($path === 'auth/login') { include $viewPath; return; }
  include __DIR__ . '/../view/layout/main.php';
}
function redirect(string $route): void { header('Location: '.url_to($route)); exit; }
