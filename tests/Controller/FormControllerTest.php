<?php

namespace App\Tests\Controller;

use App\Entity\Form;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FormControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/form/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Form::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Form index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'form[title]' => 'Testing',
            'form[description]' => 'Testing',
            'form[is_active]' => 'Testing',
            'form[level_id]' => 'Testing',
            'form[created_by_user_id]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Form();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setIs_active('My Title');
        $fixture->setLevel_id('My Title');
        $fixture->setCreated_by_user_id('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Form');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Form();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setIs_active('Value');
        $fixture->setLevel_id('Value');
        $fixture->setCreated_by_user_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'form[title]' => 'Something New',
            'form[description]' => 'Something New',
            'form[is_active]' => 'Something New',
            'form[level_id]' => 'Something New',
            'form[created_by_user_id]' => 'Something New',
        ]);

        self::assertResponseRedirects('/form/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getIs_active());
        self::assertSame('Something New', $fixture[0]->getLevel_id());
        self::assertSame('Something New', $fixture[0]->getCreated_by_user_id());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Form();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setIs_active('Value');
        $fixture->setLevel_id('Value');
        $fixture->setCreated_by_user_id('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/form/');
        self::assertSame(0, $this->repository->count([]));
    }
}
