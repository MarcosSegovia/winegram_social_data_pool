<?php

namespace SocialDataPool\Infrastructure\Repository\Twitter;

use SocialDataPool\Domain\Infrastructure\RedisClientInterface;
use SocialDataPool\Domain\Repository\Twitter\TweetReaderInterface;

class RedisTweetReader implements TweetReaderInterface
{
    const SOCIAL_POOL      = 'social-list';
    const UNIQUE_ID_PREFIX = 'tweet_';

    private $redis_client;

    public function __construct(RedisClientInterface $a_redis_client)
    {
        $this->redis_client = $a_redis_client;
    }

    public function getTweet()
    {
        return $this->redis_client->lpop(self::SOCIAL_POOL);
    }

    public function checkIfTweetIdHasBeenAlreadyProcessed($current_tweet_id)
    {
        if ($this->redis_client->exists(self::UNIQUE_ID_PREFIX . $current_tweet_id))
        {
            return true;
        }

        return false;
    }
}
