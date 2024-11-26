<?php declare(strict_types=1);

use App\Core\Database;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\TestCase;

#[RequiresPhpExtension('pdo_mysql')]
final class DatabaseTest extends TestCase
{
    protected function setUp(): void
    {
        // TODO: Conditionally skip the test if the environment is CI
        $this->markTestSkipped('Database tests are not supported on CI');
    }
    public function testConnection()
    {
        $connection = Database::connect();
        $this->assertInstanceOf(PDO::class, $connection);
    }

    public function testPrepareAndExecute()
    {
        $query = 'SELECT 1';
        $result = Database::prepareAndExecute($query);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
    }

    public function testPrepareAndExecuteWithParams()
    {
        $query = 'SELECT :value';
        $params = ['value' => 1];
        $result = Database::prepareAndExecute($query, $params);
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0]['1']);
    }
}
