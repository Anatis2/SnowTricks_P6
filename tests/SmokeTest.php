<?php
// tests/Controller/SmokeTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeTest extends WebTestCase
{
	/**
	 * @dataProvider provideUrls
	 */
	public function testPageIsSuccessful($pageName, $url)
	{
		$client = self::createClient();
		$client->catchExceptions(false);
		$client->request('GET', $url);
		$response = $client->getResponse();

		self::assertTrue(
			$response->isSuccessful(),
			sprintf(
				'La page "%s" devrait être accessible, mais le code HTTP est "%s".',
				$pageName,
				$response->getStatusCode()
			)
		);
	}

	public function provideUrls()
	{
		return [
			'accueil' => ['Accueil', '/'],
			// ...
		];
	}
}