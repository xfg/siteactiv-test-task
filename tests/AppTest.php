<?php

include __DIR__ . '/../tests/db.php';
include __DIR__ . '/../src/App.php';

use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
  private $db;
  private $app;

  public function setUp(): void
  {
    global $db;

    $this->db = new PDO($db['dsn'], $db['user'], $db['password']);

    $this->db->exec('CREATE DATABASE primenum_test');
    $this->db->exec('USE primenum_test');
    $this->db->exec(file_get_contents(__DIR__ . '/../schema.sql'));

    $this->app = new App($this->db);
  }
  public function tearDown(): void
  {
    $this->db->exec('DROP DATABASE primenum_test');
  }
  public function testCanReturnPrimeNumbers(): void
  {
    $this->assertEquals([2, 3, 5, 7, 11], $this->app->calculatePrimeNumbers(12));
  }
  public function testCanSavePrimeNumbersToDatabase(): void
  {
    $this->app->calculatePrimeNumbers(12);

    $this->assertEquals(
      ['id' => 1, 'input' => 12, 'output' => '[2, 3, 5, 7, 11]'],
      $this->db->query('SELECT * FROM prime_numbers')->fetch(PDO::FETCH_ASSOC)
    );
  }
  public function testCannotSavePrimeNumbersToDatabase(): void
  {
    $this->app->calculatePrimeNumbers(1);

    $this->assertEquals(
      false,
      $this->db->query('SELECT * FROM prime_numbers')->fetch(PDO::FETCH_ASSOC)
    );
  }
}