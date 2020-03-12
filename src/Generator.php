<?php


namespace RKocak\Gravatar;

use Illuminate\Contracts\Config\Repository as Config;
use RKocak\Gravatar\Exceptions\GravatarEmailMissingException;
use RKocak\Gravatar\Exceptions\InvalidGravatarDefaultException;
use RKocak\Gravatar\Exceptions\InvalidGravatarRatingException;

class Generator
{

    /**
     * @var string
     */
    const BASE_URL = 'https://www.gravatar.com/avatar/';

    /**
     * @var string|null
     */
    protected ?string $email = null;

    /**
     * @var int
     */
    protected int $size;

    /**
     * @var string
     */
    protected string $rating;

    /**
     * @var string
     */
    protected string $default;

    /**
     * @var array
     */
    protected array $gravatarDefaults = [
        '404', 'mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank',
    ];

    /**
     * @var array
     */
    protected array $gravatarRatings = [
        'g', 'pg', 'r', 'x'
    ];

    /**
     * Generator constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->rating = $config->get('gravatar.rating', 'g');
        $this->size = $config->get('gravatar.size', 200);
        $this->default = $config->get('gravatar.default', 'mm');
    }

    /**
     * @param string $email
     * @return bool
     */
    public function exists(string $email): bool
    {
        $this->default = '404';
        $headers = get_headers($this->url($email) . '?'. $this->getHttpQuery(), 1);

        if($headers[0] == 'HTTP/1.1 404 Not Found')
        {
            return false;
        }

        return true;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function size(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string $default
     * @return $this
     * @throws InvalidGravatarDefaultException
     */
    public function default(string $default): self
    {
        if(!in_array($default, $this->gravatarDefaults) && !filter_var($default, FILTER_VALIDATE_URL))
        {
            throw new InvalidGravatarDefaultException('Gravatar Default should be valid URL or ['.implode(', ', $this->gravatarDefaults).']');
        }

        $this->default = $default;
        return $this;
    }

    /**
     * @param string $rating
     * @return $this
     * @throws InvalidGravatarRatingException
     */
    public function rating(string $rating): self
    {
        if(!in_array($rating, $this->gravatarRatings))
        {
            throw new InvalidGravatarRatingException('Gravatar Default should be one of ['.implode(', ', $this->gravatarDefaults).']');
        }

        $this->rating = $rating;
        return $this;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function for(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     * @throws GravatarEmailMissingException
     */
    public function get(): string
    {
        if(is_null($this->email))
        {
            throw new GravatarEmailMissingException('Please provide an email (use "for" Method first)');
        }

        return $this->url($this->email) . '?' . $this->getHttpQuery();
    }

    /**
     * @param string $email
     * @param array $attributes
     * @return string
     */
    public function img(string $email, array $attributes = []): string
    {
        $url = $this->url($email) . '?' . $this->getHttpQuery();

        $html = "<img src=\"{$url}\"";

        foreach ($attributes as $attr => $value)
        {
            $html .= " {$attr}=\"{$value}\"";
        }

        $html .= '/>';

        return $html;
    }

    /**
     * @param string $hash
     * @return string
     */
    public function url(string $hash): string
    {
        if(filter_var($hash, FILTER_VALIDATE_EMAIL))
        {
            $hash = $this->hashEmail($hash);
        }

        return static::BASE_URL . $hash;
    }

    /**
     * @return string
     */
    protected function getHttpQuery(): string
    {
        return http_build_query([
            'd' => urlencode($this->default),
            'r' => $this->rating,
            's' => $this->size,
        ]);
    }

    /**
     * @param string $email
     * @return string
     */
    protected function hashEmail(string $email): string
    {
        return md5(strtolower(trim($email)));
    }

}