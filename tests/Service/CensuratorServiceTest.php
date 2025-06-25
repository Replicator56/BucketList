<?php

namespace App\Tests\Service;

use App\Service\CensuratorService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CensuratorServiceTest extends KernelTestCase
{
    /**
     * Scénario 1 : Pas de mots à censurer
     * @return void
     */
    public function testPurify_whenNoCensuredWord_thenSentenceIsNotPurified(): void
    {
        // AAA
        // Arrange - Préparation des conditions du test
        $kernel = self::bootKernel();
        $censuratorService = static::getContainer()->get(CensuratorService::class);
        $expectedSentence = "Bonjour, je suis très heureux de vous rencontrer";

        // Act - Lancer la méthode à tester
        $purifiedSentence = $censuratorService->purify($expectedSentence);

        // Assert - Vérifier le bon comportement
         $this->assertEquals($expectedSentence, $purifiedSentence);
    }

    /**
     * Scénario 2 : Un mot à censurer
     * @return void
     */
    public function testPurify_whenOneWordToCensure_thenSentenceIsPurified() {
        // AAA
        // Arrange - Préparation des conditions du test
        $kernel = self::bootKernel();
        $censuratorService = static::getContainer()->get(CensuratorService::class);
        $initialSentence = "You're not beautiful";
        $expectedSentence = "You're not *********";

        // Act - Lancer la méthode à tester
        $purifiedSentence = $censuratorService->purify($initialSentence);

        // Assert - Vérifier le bon comportement
        $this->assertEquals($expectedSentence, $purifiedSentence);
    }
}
