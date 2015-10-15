<?php namespace Arcanedev\SeoHelper\Tests;

use Arcanedev\SeoHelper\SeoOpenGraph;

/**
 * Class     SeoOpenGraphTest
 *
 * @package  Arcanedev\SeoHelper\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SeoOpenGraphTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var SeoOpenGraph */
    private $seoOpenGraph;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $configs            = $this->getSeoHelperConfig();
        $this->seoOpenGraph = new SeoOpenGraph($configs);
    }

    public function tearDown()
    {
        parent::tearDown();

        unset($this->seoOpenGraph);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\SeoHelper\SeoOpenGraph::class,
            \Arcanedev\SeoHelper\Contracts\SeoOpenGraph::class,
            \Arcanedev\SeoHelper\Contracts\Renderable::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->seoOpenGraph);
        }
    }

    /** @test */
    public function it_can_render_defaults()
    {
        $output       = $this->seoOpenGraph->render();
        $expectations = [
            '<meta property="og:type" content="website">',
            '<meta property="og:title" content="Default Open Graph title">',
            '<meta property="og:description" content="Default Open Graph description">',
        ];

        foreach ($expectations as $expected) {
            $this->assertContains($expected, $output);
        }
    }

    /** @test */
    public function it_can_set_and_render_prefix()
    {
        $this->seoOpenGraph->setPrefix('open-graph:');

        $expectations = [
            '<meta property="open-graph:type" content="website">',
            '<meta property="open-graph:title" content="Default Open Graph title">',
            '<meta property="open-graph:description" content="Default Open Graph description">',
        ];

        $output = $this->seoOpenGraph->render();

        foreach ($expectations as $expected) {
            $this->assertContains($expected, $output);
        }
    }

    /** @test */
    public function it_can_set_and_render_type()
    {
        $types = [
            'article',
            'video',
            'video.movie',
            'video.episode',
        ];

        foreach ($types as $type) {
            $this->seoOpenGraph->setType($type);

            $this->assertContains(
                '<meta property="og:type" content="' . $type . '">',
                $this->seoOpenGraph->render()
            );
        }
    }

    /** @test */
    public function it_can_set_and_render_title()
    {
        $title = 'Hello World';

        $this->seoOpenGraph->setTitle($title);

        $this->assertContains(
            '<meta property="og:title" content="' . $title . '">',
            $this->seoOpenGraph->render()
        );
    }

    /** @test */
    public function it_can_set_and_render_description()
    {
        $description = 'Hello World detailed description.';

        $this->seoOpenGraph->setDescription($description);

        $this->assertContains(
            '<meta property="og:description" content="' . $description . '">',
            $this->seoOpenGraph->render()
        );
    }

    /** @test */
    public function it_can_set_and_render_url()
    {
        $url = 'http://www.imdb.com/title/tt0080339/';

        $this->seoOpenGraph->setUrl($url);

        $this->assertContains(
            '<meta property="og:url" content="' . $url . '">',
            $this->seoOpenGraph->render()
        );
    }

    /** @test */
    public function it_can_set_and_render_image()
    {
        $image = 'http://ia.media-imdb.com/images/M/MV5BNDU2MjE4MTcwNl5BMl5BanBnXkFtZTgwNDExOTMxMDE@._V1_UY1200_CR90,0,630,1200_AL_.jpg';

        $this->seoOpenGraph->setImage($image);

        $this->assertContains(
            '<meta property="og:image" content="' . $image . '">',
            $this->seoOpenGraph->render()
        );
    }

    /** @test */
    public function it_can_add_and_render_property()
    {
        $locales = [
            'ar', 'en', 'en_US', 'es', 'fr', 'fr_FR',
        ];

        foreach ($locales as $locale) {
            $this->seoOpenGraph->addProperty('locale', $locale);

            $this->assertContains(
                '<meta property="og:locale" content="' . $locale . '">',
                $this->seoOpenGraph->render()
            );
        }
    }
}