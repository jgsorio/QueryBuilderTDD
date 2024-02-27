<?php

namespace Tests\Unit\Database;

use App\Database\Select;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    private Select $select;

    public function setUp(): void
    {
        parent::setUp();
        $this->select = new Select();
    }

    public function testGetSimpleSelect()
    {
        $query = $this->select->query("select * from users")->get();
        $this->assertEquals("select * from users", $query);
    }

    public function testSimpleSelectWithWhereConditional()
    {
        $query = $this->select->query("select * from users")
            ->where('id', '=', 1)
            ->get();
        $this->assertEquals("select * from users where id = :id", $query);
    }

    public function testSimpleSelectWithMoreThanOneConditional()
    {
        $query = $this->select->query("select * from users")
            ->where("id", '=', 1)
            ->where("name", '=', 'Guilherme')
            ->get();

        $this->assertEquals("select * from users where id = :id and name = :name", $query);
    }

    public function testSimpleSelectWithOrClause()
    {
        $query = $this->select->query("select * from users")
            ->where('id', '=', 1)
            ->orWhere('name', '=', 'Guilherme')
            ->get();

        $this->assertEquals("select * from users where id = :id or name = :name", $query);
    }

    public function testGetBindValues()
    {
        $this->select->query("select * from users")
            ->where('id', '=', 1)
            ->orWhere('email', '=', 'joseguilhermesorio@gmail.com')
            ->get();

        $this->assertEquals(
            ['id' => 1, 'email' => 'joseguilhermesorio@gmail.com'],
            $this->select->getBinds()
        );
    }

    public function testSimpleSelectWithOrderBy()
    {
        $query = $this->select->query("select * from users")
            ->orderBy("id", 'DESC')
            ->get();

        $this->assertEquals("select * from users order by id DESC", $query);
    }
}
