<?php

final class App {
  public function __construct(PDO $db) {
    $this->db = $db;
  }
  /**
   * Returns all prime numbers
   * @param int $end until which a value to display prime numbers.
   * @return array
   */
  public function calculatePrimeNumbers(int $end) {
    $numbers = [];

    for ($i = 0; $i <= $end; $i++) {
      if ($this->isPrime($i)) {
        $numbers[] = $i;
      }
    }

    if (!empty($numbers)) {
      $this->db
        ->prepare('INSERT INTO prime_numbers (input, output) VALUES (:input, :output)')
        ->execute([':input' => $end, ':output' => json_encode($numbers)]);
    }

    return $numbers;
  }
  /**
   * Checks that the number is prime
   * @param int $number the number which will be checked.
   * @return boolean true if number is prime otherwise false.
   */
  private function isPrime(int $number) {
    if ($number < 2) {
      return false;
    }
    if ($number === 2) {
      return true;
    }

    $max = floor(sqrt($number));

    for ($i = 2; $i <= $max; $i++) {
      if ($number % $i === 0) {
        return false;
      }
    }

    return true;
  }
}