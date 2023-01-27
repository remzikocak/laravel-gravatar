<?php

namespace RKocak\Tests;

use Illuminate\Config\Repository as Config;
use PHPUnit\Framework\TestCase;
use RKocak\Gravatar\Generator;

class GravatarTest extends TestCase
{
    /**
     * @var Generator
     */
    protected Generator $gravatar;

    /**
     * @var string
     */
    protected string $validEmail = 'kocak0068@gmail.com';

    /**
     * @var string
     */
    protected string $invalidEmail = 'remzi0068@yandex.com';

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->gravatar = new Generator($this->getConfigRepository());
    }

    /** @test */
    public function it_can_check_if_an_email_exists_or_not()
    {
        $this->assertTrue($this->gravatar->exists($this->validEmail));
        $this->assertFalse($this->gravatar->exists($this->invalidEmail));
    }

    /** @test */
    public function it_generates_correct_url_with_default_configuration()
    {
        $this->assertSame(
            'https://www.gravatar.com/avatar/85c773c2f457e71a764e7dd05c557a6a?d=mm&r=g&s=200',
            $this->gravatar->for($this->validEmail)->get()
        );
    }

    /** @test */
    public function it_can_generate_with_custom_configuration()
    {
        $this->assertSame(
            'https://www.gravatar.com/avatar/85c773c2f457e71a764e7dd05c557a6a?d=404&r=x&s=500',
            $this->gravatar->for($this->validEmail)
                            ->default('404')
                            ->rating('x')
                            ->size(500)
                            ->get()
        );
    }

    /** @test */
    public function it_can_generate_html_image_tag()
    {
        $this->assertSame(
            '<img src="https://www.gravatar.com/avatar/85c773c2f457e71a764e7dd05c557a6a?d=mm&r=g&s=200" class="rounded w-10 h-10"/>',
            $this->gravatar->img($this->validEmail, [
                'class' => 'rounded w-10 h-10',
            ])
        );
    }

    /**
     * @return Config
     */
    protected function getConfigRepository(): Config
    {
        $config = new Config();
        $config->set([
            'gravatar' => include dirname(__DIR__).'/config/gravatar.php',
        ]);

        return $config;
    }
}
