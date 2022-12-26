<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ClientControllerTest extends KernelTestCase
{
    public function testSomething(): void
    {
            // (1) boot the Symfony kernel
            $kernel = self::bootKernel();
           /* self::bootKernel([
                'environment' => 'my_test_env',
                'debug'       => false,
                ]);
            */

            // (2) use static::getContainer() to access the service container
            //$container = static::getContainer();

            // (3) run some service & test the result
            //$newsletterGenerator = $container->get(NewsletterGenerator::class);
            //$newsletter = $newsletterGenerator->generateMonthlyNews('');

            //$this->assertEquals('', $newsletter->getContent());
    /*
        // ... same bootstrap as the section above
        $newsRepository = $this->createMock(NewsRepositoryInterface::class);
        $newsRepository->expects(self::once())
            ->method('findNewsFromLastMonth')
            ->willReturn([
                new News('some news'),
                new News('some other news'),
            ])
        ;
    
        // the following line won't work unless the alias is made public
        $container->set(NewsRepositoryInterface::class, $newsRepository);
    
    

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
    */
    }
}
