<?php

namespace SocialDataPool\Infrastructure\Repository\Instagram;

use SocialDataPool\Domain\Infrastructure\RedisClientInterface;
use SocialDataPool\Domain\Repository\Instagram\InstagramReaderInterface;

final class RedisInstagramReader implements InstagramReaderInterface
{
    const LIST_OF_INSTAGRAM_POSTS = 'instagram-list';
    const UNIQUE_ID_PREFIX        = 'instagram-post_';

    private $redis_client;

    public function __construct(RedisClientInterface $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function getPost()
    {
        return $this->redis_client->lpop(self::LIST_OF_INSTAGRAM_POSTS);
    }

    public function checkIfPostIdHasBeenAlreadyProcessed($current_post_id)
    {
        if ($this->redis_client->exists(self::UNIQUE_ID_PREFIX . $current_post_id))
        {
            return true;
        }

        return false;
    }
}
