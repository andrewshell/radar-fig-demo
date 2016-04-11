<?php
namespace Blog\Delivery;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Blog\Domain\Entity\Post as PostEntity;
use PDO;
use Relay\Middleware\ExceptionHandler;
use Relay\Middleware\ResponseSender;
use Zend\Diactoros\Response as Response;

class Config extends ContainerConfig
{
    public function define(Container $di)
    {
        $di->set('blog/domain:postGateway', $di->lazyNew('Blog\Data\Gateway\PostMemory'));
        // $di->set('blog/domain:postGateway', $di->lazyNew('Blog\Data\Gateway\PostSqlite'));
        // $di->set('dbh', $di->lazyNew('PDO'));

        if (!file_exists(__DIR__ . '/../../../data')) {
            mkdir(__DIR__ . '/../../../data');
        }

        $dataDir = realpath(__DIR__ . '/../../../data');
        $di->params['PDO']['dsn'] = 'sqlite:' . $dataDir . '/db.sqlite';
        $di->params['PDO']['username'] = '';
        $di->params['PDO']['passwd'] = '';
        $di->params['PDO']['options'] = [];
        $di->params['Blog\Data\Gateway\PostSqlite']['dbh'] = $di->lazyGet('dbh');

        $di->params['Blog\Delivery\Responder\Html']['viewDir'] = __DIR__ . '/../../../views';

        $di->params['Blog\Domain\Interactor\ListAllPosts']['postGateway'] = $di->lazyGet('blog/domain:postGateway');
        $di->params['Blog\Domain\Interactor\DisplaySinglePost']['postGateway'] = $di->lazyGet('blog/domain:postGateway');
        $di->params['Blog\Domain\Interactor\CreateNewPost']['postGateway'] = $di->lazyGet('blog/domain:postGateway');
    }

    public function modify(Container $di)
    {
        $adr = $di->get('radar/adr:adr');

        /**
         * Middleware
         */
        $adr->middle(new ResponseSender());
        $adr->middle(new ExceptionHandler(new Response()));
        $adr->middle('Radar\Adr\Handler\RoutingHandler');
        $adr->middle('Radar\Adr\Handler\ActionHandler');

        /**
         * Setup
         */
        $adr->input('Blog\Delivery\Input\MergedArray');
        $adr->responder('Blog\Delivery\Responder\Html');

        /**
         * Data
         */
        $postGateway = $di->get('blog/domain:postGateway');
        $postGateway->savePost(new PostEntity('Sample Post 1', 'This is the first sample post.', '', '1'));
        $postGateway->savePost(new PostEntity('Sample Post 2', 'This is the second sample post.', '', '2'));
        $postGateway->savePost(new PostEntity('Sample Post 3', 'This is the third sample post.', '', '3'));

        // $dbh = $di->get('dbh');
        // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /**
         * Routing
         */
        $adr->get('ListAllPosts', '/', 'Blog\Domain\Interactor\ListAllPosts')
            ->input('Blog\Delivery\Input\NoneExpected')
            ->defaults(['_view' => 'listposts.html.php']);

        $adr->get('DisplaySinglePost', '/{id}/', 'Blog\Domain\Interactor\DisplaySinglePost')
            ->input('Blog\Delivery\Input\IdOnly')
            ->defaults(['_view' => 'singlepost.html.php']);

        $adr->post('CreateNewPost', '/', 'Blog\Domain\Interactor\CreateNewPost')
            ->input('Blog\Delivery\Input\CreateNewPost')
            ->responder('Blog\Delivery\Responder\Redirect');
    }
}
